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


require_once('clients/base/api/FilterApi.php');
require_once('clients/base/api/UnifiedSearchApi.php');

class PersonFilterApi extends FilterApi {
    public function registerApiRest() {
        return array(
            'UserSearch' => array(
                'reqType' => 'GET',
                'path' => array('Users'),
                'pathVars' => array('module_list'),
                'method' => 'filterList',
                'shortHelp' => 'Search User records',
                'longHelp' => 'include/api/help/module_get_help.html',
            ),
            'EmployeeSearch' => array(
                'reqType' => 'GET',
                'path' => array('Employees'),
                'pathVars' => array('module_list'),
                'method' => 'filterList',
                'shortHelp' => 'Search Employee records',
                'longHelp' => 'include/api/help/module_get_help.html',
            ),
        );
    }

    public function filterList(ServiceBase $api, array $args)
    {
        if (!empty($args['q'])) {
            return $this->globalSearch($api, $args);
        }

        $args['module'] = $args['module_list'];

        list($args, $q, $options, $seed) = $this->filterListSetup($api, $args);
        $api->action = 'list';

        $this->getCustomWhereForModule($args['module_list'], $q);

        return $this->runQuery($api, $args, $q, $options, $seed);
    }

    /**
     * This function is the global search
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @return array result set
     */
    public function globalSearch(ServiceBase $api, array $args) {
        $api->action = 'list';
        // This is required to keep the loadFromRow() function in the bean from making our day harder than it already is.
        $GLOBALS['disable_date_format'] = true;
        $search = new UnifiedSearchApi();
        $options = $search->parseSearchOptions($api,$args);
        $options['custom_where'] = $this->getCustomWhereForModule($args['module_list']);

        $searchEngine = new SugarSpot();
        $options['resortResults'] = true;
        $recordSet = $search->globalSearchSpot($api,$args,$searchEngine,$options);
        
        return $recordSet;
    }

    /**
     * Gets the proper query where clause to use to prevent special user types from
     * being returned in the result
     * 
     * @param string $module The name of the module we are looking for
     * @return string
     */
    protected function getCustomWhereForModule($module, $query = null) {
        if ($query instanceof SugarQuery) {
            if ($module == 'Employees') {
                $query->where()->equals('employee_status', 'Active')->equals('show_on_employees','1');
                return;
            }
            $query->where()->equals('status', 'Active')->equals('portal_only', '0');
            return;
        }

        if ($module == 'Employees') {
            return "users.employee_status = 'Active' AND users.show_on_employees = 1";
        }
        
        return "users.status = 'Active' AND users.portal_only = 0";
    }
}
