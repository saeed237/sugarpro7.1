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
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateButton'),
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Cases'),
	),

	'where' => '',
	
	

	'list_fields' => array(
		'case_number'=>array(
	 		'vname' => 'LBL_LIST_NUMBER',
			'width' => '6%',
		),
		
		'name'=>array(
	 		'vname' => 'LBL_LIST_SUBJECT',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'width' => '50%',
		),
		'status'=>array(
	 		'vname' => 'LBL_LIST_STATUS',
			'width' => '10%',
		),
		'priority'=>array(
	 		'vname' => 'LBL_LIST_PRIORITY',
			'width' => '10%',
		),
		'date_entered'=>array(
	 		'vname' => 'LBL_LIST_DATE_CREATED',
			'width' => '15%',
		),
		'assigned_user_name' => array (
			'name' => 'assigned_user_name',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'target_record_key' => 'assigned_user_id',
			'target_module' => 'Employees',
			'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'Cases',
			'width' => '4%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Cases',
			'width' => '5%',
		),
	),
);

?>