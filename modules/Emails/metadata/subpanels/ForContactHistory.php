<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Subpanel Layout definition for Emails.
 *
 */
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
	'top_buttons' => array(),
	'where'				=> "",
	'fill_in_additional_fields'	=> true,
	'list_fields' => array(
		'object_image'=>array(
			'widget_class'			=> 'SubPanelIcon',
 		 	'width'					=> '2%',
		),
		'name' => array(
			 'vname'				=> 'LBL_LIST_SUBJECT',
			 'widget_class'			=> 'SubPanelDetailViewLink',
			 'width'				=> '30%',
             'parent_info'          => true
		),
		'status' => array(
			 'vname'				=> 'LBL_LIST_STATUS',
			 'width'				=> '15%',
		),
		'reply_to_status' => array(
			 'usage'				=> 'query_only',
             'force_exists'			=> true,
		),
		'date_entered' => array(
			'width'					=> '10%',
		    'vname'					=> 'LBL_DATE_CREATED',
		),
		'date_modified' => array(
			'width'					=> '10%',
		    'vname'					=> 'LBL_DATE_MODIFIED',
		),
		'assigned_user_name' => array (
			'name' => 'assigned_user_name',
			'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'target_record_key' => 'assigned_user_id',
			'target_module' => 'Employees',
		),
		'edit_button' => array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class'			=> 'SubPanelEditButton',
			 'width'				=> '2%',
		),
		'filename' => array(
			'usage'					=> 'query_only',
			'force_exists'			=> true
		),
	), // end list_fields
);
?>
