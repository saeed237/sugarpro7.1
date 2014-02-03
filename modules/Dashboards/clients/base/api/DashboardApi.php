<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

class DashboardApi extends SugarApi
{
    /**
     * Rest Api Registration Method
     *
     * @return array
     */
    public function registerApiRest()
    {
        $dashboardApi = array(
            'createDashboardForModule' => array(
                'reqType' => 'POST',
                'path' => array('Dashboards', '<module>'),
                'pathVars' => array('', 'module'),
                'method' => 'createDashboard',
                'shortHelp' => 'Create a new dashboard for a module',
                'longHelp' => 'include/api/help/create_dashboard.html',
            ),
            'createDashboardForHome' => array(
                'reqType' => 'POST',
                'path' => array('Dashboards'),
                'pathVars' => array(''),
                'method' => 'createDashboard',
                'shortHelp' => 'Create a new dashboard for home',
                'longHelp' => 'include/api/help/create_dashboard.html',
            ),
        );
        return $dashboardApi;
    }

    /**
     * Create a new dashboard
     *
     * @param ServiceBase $api      The Api Class
     * @param array $args           Service Call Arguments
     * @return mixed
     */
    public function createDashboard($api, $args) {
        $args['dashboard_module'] = empty($args['module']) ? 'Home' : $args['module'];
        $bean = BeanFactory::newBean('Dashboards');
        
        if (!$bean->ACLAccess('save')) {
            // No create access so we construct an error message and throw the exception
            $failed_module_strings = return_module_language($GLOBALS['current_language'], 'Dashboards');
            $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
            $args = null;
            if(!empty($moduleName)){
                $args = array('moduleName' => $moduleName);
            }
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_CREATE_MODULE_NOT_AUTHORIZED', $args);
        }

        $id = $this->updateBean($bean, $api, $args);
        $args['record'] = $id;
        $args['module'] = 'Dashboards';
        $bean = $this->loadBean($api, $args, 'view');
        $data = $this->formatBean($api, $args, $bean);
        return $data;
    }
}
