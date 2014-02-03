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
require_once('include/SugarFields/SugarFieldHandler.php');
require_once('include/api/SugarApi.php');

class RegisterLeadApi extends SugarApi {
    public function registerApiRest() {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('Leads','register'),
                'pathVars' => array('module'),
                'method' => 'createLeadRecord',
                'shortHelp' => 'This method registers leads',
                'longHelp' => 'include/api/help/leads_register_post_help.html',
                'noLoginRequired' => true,
            ),
        );
    }

    /**
     * Fetches data from the $args array and updates the bean with that data
     * @param $bean SugarBean The bean to be updated
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return id Bean id
     */
    protected function updateBean(SugarBean $bean,ServiceBase $api, $args) {

        // Bug 54515: Set modified by and created by users to assigned to user. If not set default to admin.
        $bean->update_modified_by = false;
        $bean->set_created_by = false;
        $admin = Administration::getSettings();
        if (isset($admin->settings['supportPortal_RegCreatedBy']) && !empty($admin->settings['supportPortal_RegCreatedBy'])) {
            $bean->created_by = $admin->settings['supportPortal_RegCreatedBy'];
            $bean->modified_user_id = $admin->settings['supportPortal_RegCreatedBy'];
        } else {
            $bean->created_by = '1';
            $bean->modified_user_id = '1';
        }

        // Bug 54516 users not getting notified on new record creation
        $bean->save(true);

        return parent::updateBean($bean, $api, $args);

    }

    /**
     * Creates lead records
     * @param $apiServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return array properties on lead bean formatted for display
     */
    public function createLeadRecord($api, $args) {


        // Bug 54647 Lead registration can create empty leads
        if (!isset($args['last_name'])) {
            throw new SugarApiExceptionMissingParameter();
        }

        /**
         *
         * Bug56194: This API can be hit without logging into Sugar, but the creation of a Lead SugarBean
         * uses messages that require the use of the app strings.
         *
         **/
        global $app_list_strings;
        global $current_language;
        if(!isset($app_list_strings)){
            $app_list_strings = return_app_list_strings_language($current_language);
        }

        $bean = BeanFactory::newBean('Leads');
        // we force team and teamset because there is no current user to get them from
        $fields = array(
            'team_set_id' => '1',
            'team_id' => '1',
            'lead_source' => 'Support Portal User Registration',
        );

        $admin = Administration::getSettings();

        if (isset($admin->settings['portal_defaultUser']) && !empty($admin->settings['portal_defaultUser'])) {
            $fields['assigned_user_id'] = json_decode(html_entity_decode($admin->settings['portal_defaultUser']));
        }

        $fieldList = array('first_name', 'last_name', 'phone_work', 'email', 'primary_address_country', 'primary_address_state', 'account_name', 'title', 'preferred_language');
        foreach ($fieldList as $fieldName) {
            if (isset($args[$fieldName])) {
                $fields[$fieldName] = $args[$fieldName];
            }
        }

        $id = $this->updateBean($bean, $api, $fields);
        return $id;
    }


}
