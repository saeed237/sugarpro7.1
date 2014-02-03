<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


require_once('include/api/ApiHelper.php');

abstract class SugarApi {
    /**
     * Handles validation of required arguments for a request
     *
     * @param array $args
     * @param array $requiredFields
     * @throws SugarApiExceptionMissingParameter
     */
    public function requireArgs(&$args,$requiredFields = array()) {
        foreach ( $requiredFields as $fieldName ) {
            if ( !array_key_exists($fieldName, $args) ) {
                throw new SugarApiExceptionMissingParameter('Missing parameter: '.$fieldName);
            }
        }
    }

    /**
     * Fetches data from the $args array and formats the bean with those parameters
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the formatted data is returned
     * @param $args array The arguments array passed in from the API, will check this for the 'fields' argument to only return the requested fields
     * @param $bean SugarBean The fully loaded bean to format
     * @return array An array version of the SugarBean with only the requested fields (also filtered by ACL)
     */
    protected function formatBean(ServiceBase $api, $args, SugarBean $bean) {

        if ( !empty($args['fields']) ) {
            $fieldList = explode(',',$args['fields']);
            if ( ! in_array('date_modified',$fieldList ) ) {
                $fieldList[] = 'date_modified';
            }
            if ( ! in_array('id',$fieldList ) ) {
                $fieldList[] = 'id';
            }
        } else {
            $fieldList = array();
        }

        $options = array();
        $options['action'] = $api->action;
        $options['args'] = $args;

        $data = ApiHelper::getHelper($api,$bean)->formatForApi($bean,$fieldList, $options);

        // Should we log this as a recently viewed item?
        if ( !empty($data) && isset($args['viewed']) && $args['viewed'] == true ) {
            if ( !isset($this->action) ) {
                $this->action = 'view';
            }
            if ( !isset($this->api) ) {
                $this->api = $api;
            }
            $this->trackAction($bean);
        }

        // Support returning whether the current user is following the record.
        $sub = Subscription::checkSubscription($api->user, $bean);
        $data['following'] = !empty($sub);

        if (!empty($bean->module_name)) {
            $data['_module'] = $bean->module_name;
        }

        return $data;
    }

    protected function formatBeans(ServiceBase $api, $args, $beans)
    {
        $ret = array();
        foreach ($beans as $bean) {
            if (!is_subclass_of($bean, 'SugarBean')) {
                continue;
            }
            $ret[] = $this->formatBean($api, $args, $bean);
        }

        $subscriptions = Subscription::checkSubscriptionList($api->user, $ret);
        foreach ($ret as &$record) {
            $record['following'] = !empty($subscriptions[$record['id']]);
        }

        return $ret;
    }
    /**
     * Recursively runs html entity decode for the reply
     * @param $data array The bean the API is returning
     */
    protected function htmlDecodeReturn(&$data) {
        foreach($data AS $key => $value) {
            if((is_object($value) || is_array($value)) && !empty($value)) {
                if (is_array($data)) {
                    $this->htmlDecodeReturn($data[$key]);
                } else {
                    $this->htmlDecodeReturn($data->$key);
                }
            }
            // htmldecode screws up bools..returns '1' for true
            elseif(!is_bool($value) && (!empty($data) && !empty($value))) {
                // USE ENT_QUOTES TO REMOVE BOTH SINGLE AND DOUBLE QUOTES, WITHOUT THIS IT WILL NOT CONVERT THEM
                $data[$key] = html_entity_decode($value, ENT_COMPAT|ENT_QUOTES, 'UTF-8');
            }
            else {
                $data[$key] = $value;
            }
        }
    }

    /**
     * Fetches data from the $args array and updates the bean with that data
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the bean is retrieved
     * @param $args array The arguments array passed in from the API
     * @param $aclToCheck string What kind of ACL to verify when loading a bean. Supports: view,edit,create,import,export
     * @param $options Options array to pass to the retrieveBean method
     * @return SugarBean The loaded bean
     */
    protected function loadBean(ServiceBase $api, $args, $aclToCheck = 'read', $options = array()) {
        $this->requireArgs($args, array('module','record'));

        $bean = BeanFactory::retrieveBean($args['module'],$args['record'], $options);

        if ( $bean == FALSE || $bean->deleted == 1) {
            // Couldn't load the bean
            throw new SugarApiExceptionNotFound('Could not find record: '.$args['record'].' in module: '.$args['module']);
        }

        if ($aclToCheck != 'view' && !$bean->ACLAccess($aclToCheck)) {
            throw new SugarApiExceptionNotAuthorized('SUGAR_API_EXCEPTION_RECORD_NOT_AUTHORIZED',array($aclToCheck));
        }

        return $bean;
    }

    /**
     * Fetches data from the $args array and updates the bean with that data
     * @param $bean SugarBean The bean to be updated
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return id Bean id
     */
    protected function updateBean(SugarBean $bean, ServiceBase $api, $args) {

        $options = array();
        if(!empty($args['_headers']['X_TIMESTAMP'])) {
            $options['optimistic_lock'] = $args['_headers']['X_TIMESTAMP'];
        }
        try {
            $errors = ApiHelper::getHelper($api,$bean)->populateFromApi($bean,$args, $options);
        } catch(SugarApiExceptionEditConflict $conflict) {
            $api->action = 'view';
            $data = $this->formatBean($api, $args, $bean);
            // put current state of the record on the exception
            $conflict->setExtraData("record", $data);
            throw $conflict;
        }

        if ( $errors !== true ) {
            // There were validation errors.
            throw new SugarApiExceptionInvalidParameter('There were validation errors on the submitted data. Record was not saved.');
        }

        // This code replicates the behavior in Sugar_Controller::pre_save()
        $check_notify = TRUE;
        // check update
        // if Notifications are disabled for this module set check notify to false
        if(!empty($GLOBALS['sugar_config']['exclude_notifications'][$bean->module_dir]) && $GLOBALS['sugar_config']['exclude_notifications'][$bean->module_dir] == true) {
            $check_notify = FALSE;
        } else {
            // some modules, like Users don't have an assigned_user_id
            if(isset($bean->assigned_user_id)) {
                // if the assigned user hasn't changed, set check notify to false
                if(!empty($bean->fetched_row['assigned_user_id']) && $bean->fetched_row['assigned_user_id'] == $bean->assigned_user_id) {
                    $check_notify = FALSE;
                    // if its the same user, don't send
                } elseif($bean->assigned_user_id == $GLOBALS['current_user']->id) {
                    $check_notify = FALSE;
                }
            }
        }

        $bean->save($check_notify);

        /*
         * Refresh the bean with the latest data.
         * This is necessary due to BeanFactory caching.
         * Calling retrieve causes a cache refresh to occur.
         */

        $id = $bean->id;

        if(isset($args['my_favorite'])) {
            $this->toggleFavorites($bean, $args['my_favorite']);
        }

        $bean->retrieve($id);
        /*
         * Even though the bean is refreshed above, return only the id
         * This allows loadBean to be run to handle formatting and ACL
         */
        return $id;
    }



    /**
     * Toggle Favorites
     * @param SugarBean $module
     * @param type $favorite
     * @return bool
     */

    protected function toggleFavorites($bean, $favorite)
    {

        $reindexBean = false;

        $favorite = (bool) $favorite;

        $module = $bean->module_dir;
        $record = $bean->id;

        $fav_id = SugarFavorites::generateGUID($module,$record);

        // get it even if its deleted
        $fav = BeanFactory::getBean('SugarFavorites', $fav_id, array("deleted" => false));

        // already exists
        if(!empty($fav->id)) {
            $deleted = ($favorite) ? 0 : 1;
            $fav->toggleExistingFavorite($fav_id, $deleted);
            $reindexBean = true;
        }

        elseif($favorite && empty($fav->id)) {
            $fav = BeanFactory::getBean('SugarFavorites');
            $fav->id = $fav_id;
            $fav->new_with_id = true;
            $fav->module = $module;
            $fav->record_id = $record;
            $fav->created_by = $GLOBALS['current_user']->id;
            $fav->assigned_user_id = $GLOBALS['current_user']->id;
            $fav->deleted = 0;
            $fav->save();
            $reindexBean = true;
        }

        $bean->my_favorite = $favorite;

        // Bug59888 - If a Favorite is toggled, we need to reindex the bean for FTS engines so that the document will be updated with this change
        if($reindexBean === true) {
            $searchEngine = SugarSearchEngineFactory::getInstance(SugarSearchEngineFactory::getFTSEngineNameFromConfig());

            if($searchEngine instanceof SugarSearchEngineAbstractBase) {
                $searchEngine->indexSingleBean($bean);
            }
        }

        return true;

    }



    /**
     * Verifies field level access for a bean and field for the logged in user
     *
     * @param SugarBean $bean The bean to check on
     * @param string $field The field to check on
     * @param string $action The action to check permission on
     * @param array $context ACL context
     * @throws SugarApiExceptionNotAuthorized
     */
    protected function verifyFieldAccess(SugarBean $bean, $field, $action = 'access', $context = array()) {
        if (!$bean->ACLFieldAccess($field, $action, $context)) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionNotAuthorized('Not allowed to ' . $action . ' ' . $field . ' field in ' . $bean->object_name . ' module.');
        }
    }

    /**
     * Adds an entry in the tracker table noting that this record was touched
     *
     * @param SugarBean $bean The bean to record in the tracker table
     */
    public function trackAction(SugarBean $bean)
    {
        $manager = $this->getTrackerManager();
        $monitor = $manager->getMonitor('tracker');

        if ( ! $monitor ) {
            // This tracker is disabled.
            return;
        }
        if ( empty($bean->id) || (isset($bean->new_with_id) && $bean->new_with_id) ) {
            // It's a new bean, don't record it.
            // Tracking bean saves/creates happens in the SugarBean so it is always recorded
            return;
        }

        $monitor->setValue('team_id', $this->api->user->getPrivateTeamID());
        $monitor->setValue('action', $this->action);
        $monitor->setValue('user_id', $this->api->user->id);
        $monitor->setValue('module_name', $bean->module_dir);
        $monitor->setValue('date_modified', TimeDate::getInstance()->nowDb());
        $monitor->setValue('visible', 1);
        $monitor->setValue('item_id', $bean->id);
        $monitor->setValue('item_summary', $bean->get_summary_text());

        $manager->saveMonitor($monitor, true, true);
    }

    /**
     * Helper until we have dependency injection to grab a tracker manager
     * @return TrackerManager An instance of the tracker manager
     */
    public function getTrackerManager()
    {
        return TrackerManager::getInstance();
    }
}
