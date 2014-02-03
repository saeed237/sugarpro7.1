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

$moduleFilters = array(
	'Accounts' => array(
		'display_default' => false,
		'fields' => array(
			'account_type' => array(
				'display_name' => 'Account Type',
				'name' => 'account_type',
				'vname' => 'LBL_TYPE',
				'dbname' => 'account_type',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['account_type_dom'],
			),
		),
	),
	'Bugs' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '5',
				'dropdown' => $app_list_strings['bug_status_dom'],
			),
		),
	),
	'Calls' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['call_status_dom'],
			),
		),
	),
	
	'Cases' => array(
		'display_default' => false,
		'fields' => array(
			'priority' => array(
				'display_name' => 'Priority',
				'name' => 'priority',
				'vname' => 'LBL_PRIORITY',
				'dbname' => 'priority',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['case_priority_dom'],
			),
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['case_status_dom'],
			),
		),
	),
	
	'Opportunities' => array(
		'display_default' => false,
		'fields' => array(
			'sales_stage' => array(
				'display_name' => 'Sales Stage',
				'name' => 'sales_stage',
				'vname' => 'LBL_SALES_STAGE',
				'dbname' => 'sales_stage',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['sales_stage_dom'],
			),
			'opportunity_type' => array(
				'display_name' => 'Opportunity Type',
				'name' => 'opportunity_type',
				'vname' => 'LBL_TYPE',
				'dbname' => 'opportunity_type',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['opportunity_type_dom'],
			),
		),
	),
	'Tasks' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '5',
				'dropdown' => $app_list_strings['task_status_dom'],
			),
		),
	),
);

?>
