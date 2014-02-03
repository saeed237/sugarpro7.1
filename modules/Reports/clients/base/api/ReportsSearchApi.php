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


require_once('clients/base/api/PersonFilterApi.php');
require_once('modules/Reports/SavedReport.php');

class ReportsSearchApi extends PersonFilterApi
{
    public function registerApiRest()
    {
        return array(
            'ReportSearch' => array(
                'reqType' => 'GET',
                'path' => array('Reports'),
                'pathVars' => array('module_list'),
                'method' => 'globalSearch',
                'shortHelp' => 'Search Reports',
                'longHelp' => 'include/api/help/getListModule.html',
            ),
        );
    }

    /**
     * Gets the proper query where clause to use to prevent special user types from
     * being returned in the result
     *
     * @param string $module The name of the module we are looking for
     * @param SugarQuery|null
     * @return string
     */
    protected function getCustomWhereForModule($module, $query = null)
    {
        $ACLUnAllowedModules = getACLDisAllowedModules();

        if ($query instanceof SugarQuery) {
            foreach ($ACLUnAllowedModules as $module => $class_name) {
                $query->where()->notEquals('saved_reports.module', $module);
            }
            return;
        }

        $where_clauses = array();
        foreach ($ACLUnAllowedModules as $module => $class_name) {
            array_push($where_clauses, "saved_reports.module != '$module'");
        }

        return implode(' AND ', $where_clauses);
    }
}
