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
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Contracts','mode'=>'MultiSelect'),
	),

	'where' => '',
	
	

	'list_fields' => array(
		'name'=>array(
			'name'=>'name',		
			'vname' => 'LBL_LIST_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'module' => 'Contacts',
			'width' => '23%',
		),
		'account_name'=>array(
			'name'=>'account_name',
		 	'module' => 'Accounts',
		 	'target_record_key' => 'account_id',
		 	'target_module' => 'Accounts',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'vname' => 'LBL_LIST_ACCOUNT_NAME',
			'width' => '22%',
			'sortable'=>false,
		),
		'start_date'=>array(
			'name'=>'start_date',		
			'vname' => 'LBL_LIST_START_DATE',
			'width' => '10%',
		),
		'end_date'=>array(
			'name'=>'end_date',		
			'vname' => 'LBL_LIST_END_DATE',
			'width' => '10%',
		),
		'status'=>array(
			'name'=>'status',		
			'vname' => 'LBL_LIST_STATUS',
			'width' => '10%',
		),
		'total_contract_value'=>array (
			'name'=>'total_contract_value',		
			'vname' => 'LBL_LIST_CONTRACT_VALUE',
			'width' => '15%',
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'Contracts',
			'width' => '5%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Contracts',
			'width' => '5%',
		),
	),
);		
?>
