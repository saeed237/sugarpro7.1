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



$layout_defs['Leads'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
		'calls' => array(
			'order' => 10,
			'module' => 'Calls',
			'get_subpanel_data' => 'calls',
			'title_key' => 'LBL_CALLS_SUBPANEL_TITLE',
			'canLink' => false,
		),
		'meetings' => array(
			'order' => 20,
			'module' => 'Meetings',
			'get_subpanel_data' => 'meetings',
			'title_key' => 'LBL_MEETINGS_SUBPANEL_TITLE',		
			'canLink' => false,
		),
		'tasks' => array(
			'order' => 30,
			'module' => 'Tasks',
			'get_subpanel_data' => 'tasks',
			'title_key' => 'LBL_TASKS_SUBPANEL_TITLE',		
			'canLink' => false,
		),
		'notes' => array(
			'order' => 40,
			'module' => 'Notes',
			'get_subpanel_data' => 'notes',
			'title_key' => 'LBL_NOTES_SUBPANEL_TITLE',
			'canLink' => false,
		),
	),
);
?>