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




$layout_defs['Activities'] = array( // the key to the layout_defs must be the name of the module dir
	'default_subpanel_define' => array(
		'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
		'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateTaskButton'),
			array('widget_class' => 'SubPanelTopScheduleMeetingButton'),
			array('widget_class' => 'SubPanelTopScheduleCallButton'),
			array('widget_class' => 'SubPanelTopComposeEmailButton'),
		),
		'list_fields' => array(
			'Meetings' => array(
				'columns' => array(
					array(
//TODO remove name=nothing and make it safe
//TODO update layout editor to match new file structure
					
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelIcon',
			 		 	'module' => 'Meetings',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'name',
			 		 	'vname' => 'LBL_LIST_SUBJECT',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'width' => '30%',
					),
					array(
			 		 	'name' => 'status',
						'widget_class' => 'SubPanelActivitiesStatusField',
			 		 	'vname' => 'LBL_LIST_STATUS',
			 		 	'width' => '15%',
					),
					array(
			 		 	'name' => 'contact_name',
			 		 	'module' => 'Contacts',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'target_record_key' => 'contact_id',
			 		 	'target_module' => 'Contacts',
			 		 	'vname' => 'LBL_LIST_CONTACT',
			 		 	'width' => '11%',
					),
					array(
			 		 	'name' => 'parent_name',
			 		 	'module' => 'Meetings',
			 		 	'vname' => 'LBL_LIST_RELATED_TO',
			 		 	'width' => '22%',
					),
					array(
			 		 	'name' => 'date_start',
			 		 	//'db_alias_to' => 'the_date',
			 		 	'vname' => 'LBL_LIST_DUE_DATE',
			 		 	'width' => '10%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelCloseButton',
			 		 	'module' => 'Meetings',
			 		 	'vname' => 'LBL_LIST_CLOSE',
			 		 	'width' => '6%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelEditButton',
			 		 	'module' => 'Meetings',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelRemoveButton',
						'linked_field' => 'meetings',
			 		 	'module' => 'Meetings',
			 		 	'width' => '2%',
					),
				),
				'where' => "(meetings.status='Planned')",
				'order_by' => 'meetings.date_start',
			),
			'Tasks' => array(
				'columns' => array(
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelIcon',
			 		 	'module' => 'Tasks',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelCloseButton',
			 		 	'module' => 'Tasks',
			 		 	'vname' => 'LBL_LIST_CLOSE',
			 		 	'width' => '6%',
					),
					array(
			 		 	'name' => 'name',
			 		 	'vname' => 'LBL_LIST_SUBJECT',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'width' => '30%',
					),
					array(
			 		 	'name' => 'status',
						'widget_class' => 'SubPanelActivitiesStatusField',
			 		 	'vname' => 'LBL_LIST_STATUS',
			 		 	'width' => '15%',
					),
					array(
			 		 	'name' => 'contact_name',
			 		 	'module' => 'Contacts',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'target_record_key' => 'contact_id',
			 		 	'target_module' => 'Contacts',
			 		 	'vname' => 'LBL_LIST_CONTACT',
			 		 	'width' => '11%',
					),
					array(
			 		 	'name' => 'parent_name',
			 		 	'module' => 'Tasks',
			 		 	'vname' => 'LBL_LIST_RELATED_TO',
			 		 	'width' => '22%',
					),
					array(
			 		 	'name' => 'date_start',
			 		 	//'db_alias_to' => 'the_date',
			 		 	'vname' => 'LBL_LIST_DUE_DATE',
			 		 	'width' => '10%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelEditButton',
			 		 	'module' => 'Tasks',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelRemoveButton',
						'linked_field' => 'tasks',
			 		 	'module' => 'Tasks',
			 		 	'width' => '2%',
					),
				),
				'where' => "(tasks.status='Not Started' OR tasks.status='In Progress' OR tasks.status='Pending Input')",
				'order_by' => 'tasks.date_start',
			),
			'Calls' => array(
				'columns' => array(
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelIcon',
			 		 	'module' => 'Calls',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelCloseButton',
			 		 	'module' => 'Calls',
			 		 	'vname' => 'LBL_LIST_CLOSE',
			 		 	'width' => '6%',
					),
					array(
			 		 	'name' => 'name',
			 		 	'vname' => 'LBL_LIST_SUBJECT',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'width' => '30%',
					),
					array(
			 		 	'name' => 'status',
						'widget_class' => 'SubPanelActivitiesStatusField',
			 		 	'vname' => 'LBL_LIST_STATUS',
			 		 	'width' => '15%',
					),
					array(
			 		 	'name' => 'contact_name',
			 		 	'module' => 'Contacts',
						'widget_class' => 'SubPanelDetailViewLink',
			 		 	'target_record_key' => 'contact_id',
			 		 	'target_module' => 'Contacts',
			 		 	'vname' => 'LBL_LIST_CONTACT',
			 		 	'width' => '11%',
					),
					array(
			 		 	'name' => 'parent_name',
			 		 	'module' => 'Calls',
			 		 	'vname' => 'LBL_LIST_RELATED_TO',
			 		 	'width' => '20%',
					),
					array(
			 		 	'name' => 'date_start',
			 		 	//'db_alias_to' => 'the_date',
			 		 	'vname'=>'LBL_LIST_DUE_DATE',
			 		 	'width' => '22%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelEditButton',
			 		 	'module' => 'Calls',
			 		 	'width' => '2%',
					),
					array(
			 		 	'name' => 'nothing',
						'widget_class' => 'SubPanelRemoveButton',
						'linked_field' => 'calls',
			 		 	'module' => 'Calls',
			 		 	'width' => '2%',
					),
				),
				'where' => "(calls.status='Planned')",
				'order_by' => 'calls.date_start',
			),
		),
	),
);
?>