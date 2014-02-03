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


$popupMeta = array(
	'moduleMain' => 'Case',
	'varName' => 'CASE',
	'className' => 'aCase',
	'orderBy' => 'name',
	'whereClauses' => 
		array('name' => 'cases.name', 
				'case_number' => 'cases.case_number',
				'account_name' => 'accounts.name'),
	'listviewdefs' => array(
		'CASE_NUMBER' => array(
			'width' => '5', 
			'label' => 'LBL_LIST_NUMBER',
	        'default' => true), 
		'NAME' => array(
			'width' => '35', 
			'label' => 'LBL_LIST_SUBJECT', 
			'link' => true,
	        'default' => true), 
		'ACCOUNT_NAME' => array(
			'width' => '25', 
			'label' => 'LBL_LIST_ACCOUNT_NAME', 
			'module' => 'Accounts',
			'id' => 'ACCOUNT_ID',
			'link' => true,
	        'default' => true,
	        'ACLTag' => 'ACCOUNT',
	        'related_fields' => array('account_id')),
		'PRIORITY' => array(
			'width' => '8', 
			'label' => 'LBL_LIST_PRIORITY',
	        'default' => true),  
		'STATUS' => array(
			'width' => '8', 
			'label' => 'LBL_LIST_STATUS',
	        'default' => true),
	    'ASSIGNED_USER_NAME' => array(
	        'width' => '2', 
	        'label' => 'LBL_LIST_ASSIGNED_USER',
	        'default' => true,
	       ),
		),
	'searchdefs'   => array(
	 	'case_number', 
		'name',
		array('name' => 'account_name', 'displayParams' => array('hideButtons'=>'true', 'size'=>30, 'class'=>'sqsEnabled sqsNoAutofill')),
		'priority',
		'status',
		array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
	  )
);
