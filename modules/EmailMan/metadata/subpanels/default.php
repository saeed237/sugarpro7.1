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
	),

	'where' => '',


	'list_fields' => array(
		'recipient_name'=>array(
			'vname' => 'LBL_LIST_RECIPIENT_NAME',
			'width' => '10%',
			'sortable'=>false,			
		),
		'recipient_email'=>array(
			'vname' => 'LBL_LIST_RECIPIENT_EMAIL',
			'width' => '10%',
			'sortable'=>false,			
		),		
		'message_name' => array(
			'vname' => 'LBL_MARKETING_ID',
			'width' => '10%',
			'sortable'=>false,
		),
		'send_date_time' => array(
			'vname' => 'LBL_LIST_SEND_DATE_TIME',
			'width' => '10%',
			'sortable'=>false,			
		),
		'related_id'=>array(
			'usage'=>'query_only',
		),
		'related_type'=>array(
			'usage'=>'query_only',			
		),
		'marketing_id' => array(
			'usage'=>'query_only',			
		),
	),
);		
?>