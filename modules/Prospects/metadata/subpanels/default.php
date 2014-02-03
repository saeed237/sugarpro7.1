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
      		array('widget_class'=>'SubPanelTopCreateButton'),
			array('widget_class'=>'SubPanelTopSelectButton'),
		),

	'where' => '',


    'list_fields'=> array(
    	'first_name' => array(
		 	'usage' => 'query_only',
    	),
    	'last_name' => array(
		 	'usage' => 'query_only',
    	),
        'full_name'=>array(
		 	'vname' => 'LBL_LIST_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
			'width' => '40%',
            'sort_by' => 'last_name',
		),
		'title'=>array(
		 	'vname' => 'LBL_LIST_TITLE',
			'width' => '25%',
		),
		'email1'=>array(
		 	'vname' => 'LBL_LIST_EMAIL_ADDRESS',
			'width' => '15%',
			'widget_class' => 'SubPanelEmailLink',
			'sortable' => false,
		),
		'phone_work'=>array(
		 	'vname' => 'LBL_LIST_PHONE',
			'width' => '10%',
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'Contacts',
			'width' => '5%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Contacts',
			'width' => '5%',
		),		
	),
);

?>