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
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Accounts'),
	),

	'where' => '',

	'fill_in_additional_fields'=>true,

	'list_fields' => array(
		'name'=>array(
	 		'vname' => 'LBL_LIST_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
			'width' => '28%',
			'sort_by'=>'products.name'
		),					
		'status'=>array(
	 		'vname' => 'LBL_LIST_STATUS',
			'width' => '8%',
		),
		'contact_name'=>array(
	 		'vname' => 'LBL_LIST_CONTACT_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
 		 	'target_record_key' => 'contact_id',
 		 	'target_module' => 'Contacts',
	 		'module' => 'Contacts',
			'width' => '15%',
			 'sortable'=>false,	
		),
		'date_purchased'=>array(
	 		'vname' => 'LBL_LIST_DATE_PURCHASED',
			'width' => '10%',
		),
		'discount_price'=>array(
	 		'vname' => 'LBL_LIST_DISCOUNT_PRICE',
			'width' => '10%',
		),					
		'date_support_expires'=>array(
	 		'vname' => 'LBL_LIST_SUPPORT_EXPIRES',
			'width' => '10%',
		),					
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
			'module' => 'Products',
		 	'width' => '4%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Products',
	 		'width' => '4%',
		),
		'discount_usdollar'=>array(
	 		 		'usage' => 'query_only',
				),	
	),
);

?>