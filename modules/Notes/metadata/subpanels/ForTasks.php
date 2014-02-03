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

	'where' => '',


	'list_fields' => array(
		'object_image'=>array(
			'vname' => 'LBL_OBJECT_IMAGE',
			'widget_class' => 'SubPanelIcon',
 		 	'width' => '2%',
 		 	'image2'=>'attachment',
 		 	'image2_url_field'=>'file_url'
		),
		'name'=>array(
			 'vname' => 'LBL_LIST_SUBJECT',
			 'widget_class' => 'SubPanelDetailViewLink',
			 'width' => '30%',
		),
		'reply_to_status' => array(
			 'usage'				=> 'query_only',
             'force_exists'			=> true,
			 'force_default'		=> 0,
		),
		'contact_name'=>array(
			 'widget_class'			=> 'SubPanelDetailViewLink',
			 'target_record_key'	=> 'contact_id',
			 'target_module'		=> 'Contacts',
			 'module'				=> 'Contacts',
			 'vname'				=> 'LBL_LIST_CONTACT',
			 'width'				=> '11%',
			 'sortable'=>false,
		),
		'parent_id'=>array(
            'usage'=>'query_only',
			'force_exists'=>true
        ),
		'parent_type'=>array(
            'usage'=>'query_only',
			'force_exists'=>true
        ),

		'date_modified'=>array(
			 'vname' => 'LBL_LIST_DATE_MODIFIED',
			 'width' => '10%',
		),
		'date_entered'=>array(
			'vname' => 'LBL_LIST_DATE_ENTERED',
			'width' => '10%',
		),
		'assigned_user_name' => array (
			'name' => 'assigned_user_name',
			'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'target_record_key' => 'assigned_user_id',
			'target_module' => 'Employees',
			'width' => '10%',			
		),
		'assigned_user_owner' => array (
			 'force_exists'=>true, //this will create a fake field since this field is not defined
			'usage'=>'query_only'
		),
		'assigned_user_mod' => array (
			 'force_exists'=>true, //this will create a fake field since this field is not defined
			'usage'=>'query_only'
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			 'widget_class' => 'SubPanelEditButton',
			 'width' => '2%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			 'widget_class' => 'SubPanelRemoveButton',
			 'width' => '2%',
		),
		'file_url'=>array(
			'usage'=>'query_only'
			),
		'filename'=>array(
			'usage'=>'query_only'
			),

	),
);
?>
