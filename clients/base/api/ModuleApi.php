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


require_once('data/BeanFactory.php');
require_once('include/api/SugarApi.php');

class ModuleApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('<module>'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
            ),
            'retrieve' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'retrieveRecord',
                'shortHelp' => 'Returns a single record',
                'longHelp' => 'include/api/help/module_record_get_help.html',
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
            'delete' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','?'),
                'pathVars' => array('module','record'),
                'method' => 'deleteRecord',
                'shortHelp' => 'This method deletes a record of the specified type',
                'longHelp' => 'include/api/help/module_record_delete_help.html',
            ),
            'favorite' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?', 'favorite'),
                'pathVars' => array('module','record', 'favorite'),
                'method' => 'setFavorite',
                'shortHelp' => 'This method sets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_put_help.html',
            ),
            'deleteFavorite' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','?', 'favorite'),
                'pathVars' => array('module','record', 'favorite'),
                'method' => 'unsetFavorite',
                'shortHelp' => 'This method unsets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_delete_help.html',
            ),
            'unfavorite' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','?', 'unfavorite'),
                'pathVars' => array('module','record', 'unfavorite'),
                'method' => 'unsetFavorite',
                'shortHelp' => 'This method unsets a record of the specified type as a favorite',
                'longHelp' => 'include/api/help/module_record_favorite_delete_help.html',
            ),
            'enum' => array(
                'reqType' => 'GET',
                'path' => array('<module>','enum','?'),
                'pathVars' => array('module', 'enum', 'field'),
                'method' => 'getEnumValues',
                'shortHelp' => 'This method returns enum values for a specified field',
                'longHelp' => 'include/api/help/module_enum_get_help.html',
            ),
        );
    }

    /**
     * This method returns the dropdown options of a given field
     * @param array $api
     * @param array $args
     * @return array
     */
    public function getEnumValues($api, $args) {
        $this->requireArgs($args, array('module','field'));

        $bean = BeanFactory::newBean($args['module']);

        if(!isset($bean->field_defs[$args['field']])) {
           throw new SugarApiExceptionNotFound('field not found');
        }

        $vardef = $bean->field_defs[$args['field']];

        $value = null;
        $cache_age = 0;

        if(isset($vardef['function'])) {
            if ( isset($vardef['function']['returns']) && $vardef['function']['returns'] == 'html' ) {
                throw new SugarApiExceptionError('html dropdowns are not supported');
            }

            $funcName = $vardef['function'];
            $includeFile = '';
            if ( isset($vardef['function_include']) ) {
                $includeFile = $vardef['function']['include'];
            }

            if(!empty($includeFile)) {
                require_once($includeFile);
            }
            $value = $funcName();
            $cache_age = 60;
        }
        else {
            if(!isset($GLOBALS['app_list_strings'][$vardef['options']])) {
                throw new SugarApiExceptionNotFound('options not found');
            }
            $value =  $GLOBALS['app_list_strings'][$vardef['options']];
            $cache_age = 3600;
        }
        // If a particular field has an option list that is expensive to calculate and/or rarely changes,
        // set the cache_setting property on the vardef to the age in seconds you want browsers to wait before refreshing
        if(isset($vardef['cache_setting'])) {
            $cache_age = $vardef['cache_setting'];
        }
        generateEtagHeader(md5(serialize($value)), $cache_age);
        return $value;
    }

    public function createRecord($api, $args) {
        $this->requireArgs($args,array('module'));

        $bean = BeanFactory::newBean($args['module']);

        // TODO: When the create ACL goes in to effect, add it here.
        if (!$bean->ACLAccess('save')) {
            // No create access so we construct an error message and throw the exception
            $moduleName = null;
            if(isset($args['module'])){
                $failed_module_strings = return_module_language($GLOBALS['current_language'], $args['module']);
                $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            }
            $args = null;
            if(!empty($moduleName)){
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_CREATE_MODULE_NOT_AUTHORIZED', $args);
        }

        if (!empty($args['id'])) {
            // Check if record already exists
            if (BeanFactory::getBean($args['module'],$args['id'], array('strict_retrieve'=>true))) {
                throw new SugarApiExceptionInvalidParameter('Record already exists: '.$args['id'].' in module: '.$args['module']);
            }

            // Don't create a new id if passed in
            $bean->new_with_id = true;
        }

        $id = $this->updateBean($bean, $api, $args);

        $args['record'] = $id;

        return $this->getLoadedAndFormattedBean($api, $args, $bean);
    }

    public function updateRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'save');

        $this->updateBean($bean, $api, $args);

        return $this->getLoadedAndFormattedBean($api, $args, $bean);
    }

    public function retrieveRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'view');
        
        // formatBean is soft on view so that creates without view access will still work
        if (!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('SUGAR_API_EXCEPTION_RECORD_NOT_AUTHORIZED',array('view'));
        }

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);

        return $data;

    }

    public function deleteRecord($api, $args) {
        $this->requireArgs($args,array('module','record'));

        $bean = $this->loadBean($api, $args, 'delete');
        $bean->mark_deleted($args['record']);

        return array('id'=>$bean->id);
    }

    public function setFavorite($api, $args) {
        $this->requireArgs($args, array('module', 'record'));
        $bean = $this->loadBean($api, $args, 'view');
        $this->toggleFavorites($bean, true);
        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);
        return $data;
    }

    public function unsetFavorite($api, $args) {
        $this->requireArgs($args, array('module', 'record'));
        $bean = $this->loadBean($api, $args, 'view');
        $this->toggleFavorites($bean, false);
        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);
        return $data;
    }

    /**
     * Shared method from create and update process that handles records that 
     * might not pass visibility checks. This method assumes the API has validated
     * the authorization to create/edit records prior to this point.
     * 
     * @param ServiceBase $api The service object
     * @param array $args Request arguments
     * @param SugarBean $bean The bean for this process
     * @return array Array of formatted fields
     */
    protected function getLoadedAndFormattedBean($api, $args, SugarBean $bean)
    {
        // Load the bean fresh to ensure the cache entry from the create process
        // doesn't get in the way of visibility checks
        try {
            $bean = $this->loadBean($api, $args, 'view', array('use_cache' => false));
        } catch (SugarApiExceptionNotAuthorized $e) {
            // If there was an exception thrown from the load process then strip
            // the field list down and return only id and date_modified. This will
            // happen on new records created with visibility rules that conflict 
            // with the current user or from edits made to records that do the same
            // thing.
            $args['fields'] = 'id,date_modified';
        }

        $api->action = 'view';
        $data = $this->formatBean($api, $args, $bean);

        return $data;
    }
}
