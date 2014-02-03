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



$subpanel_layout = array(
	//Removed button because this layout def is a component of
	//the activities sub-panel.

	'where' => "(tasks.status != 'Completed' AND tasks.status != 'Deferred')",
			
	'list_fields' => array(
		'object_image'=>array(
			'vname' => 'LBL_OBJECT_IMAGE',
			'widget_class' => 'SubPanelIcon',
 		 	'width' => '2%',
		),		
		'name'=>array(
			 'vname' => 'LBL_LIST_SUBJECT',
			 'widget_class' => 'SubPanelDetailViewLink',
			 'width' => '30%',
		),
		'status'=>array(
			 'widget_class' => 'SubPanelActivitiesStatusField',
			 'vname' => 'LBL_LIST_STATUS',
			 'width' => '15%',
		),
		'contact_name'=>array(
			 'widget_class' => 'SubPanelDetailViewLink',
			 'target_record_key' => 'contact_id',
			 'target_module' => 'Contacts',
			 'module' => 'Contacts',
			 'vname' => 'LBL_LIST_CONTACT',
			 'width' => '11%',
		),
		'date_due'=>array(
			 'vname' => 'LBL_LIST_DUE_DATE',
			 'width' => '10%',
			 'alias' => 'date_start',
			 'sort_by' => 'date_start',
		),
		'assigned_user_name' => array (
			'name' => 'assigned_user_name',
			'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'target_record_key' => 'assigned_user_id',
			'target_module' => 'Employees',
			'width' => '22%',			
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			 'widget_class' => 'SubPanelEditButton',
			 'width' => '2%',
			 
		),
		'close_button'=>array(
			'widget_class' => 'SubPanelCloseButton',
			'vname' => 'LBL_LIST_CLOSE',
			'width' => '6%',
			'sortable'=>false,
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			 'widget_class' => 'SubPanelRemoveButton',
			 'width' => '2%',
		),
		'time_due'=>array(
			'usage'=>'query_only',
			 'alias' => 'time_start'	
		)	,
		
	),
);		
?>
