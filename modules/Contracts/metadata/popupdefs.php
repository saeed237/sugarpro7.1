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




$popupMeta = array (
	'moduleMain' => 'Contract',
	'varName' => 'CONTRACT',
	'className' => 'Contract',
	'orderBy' => 'contracts.name',
	'whereClauses' => array (
		'name' => 'contracts.name', 
		'reference_code' => 'contracts.reference_code',
		'status' => 'contracts.status',
		'account_id' => 'contracts.account_id',
	),
	'searchInputs' => array('account_id','account_name','name','reference_code','status'),
	'selectDoms' => array('STATUS_OPTIONS' => 
								array('dom' => 'contract_status_dom', 'searchInput' => 'status'),
	),
	'listviewdefs' => array(
		'NAME' => array(
	        'width' => '40', 
	        'label' => 'LBL_LIST_CONTRACT_NAME', 
	        'link' => true,
	        'default' => true),
	    'REFERENCE_CODE' => array(
	        'width' => '10', 
	        'label' => 'LBL_REFERENCE_CODE', 
	        'link' => false,
	        'default' => true),
	    'STATUS' => array(
	        'width' => '10', 
	        'label' => 'LBL_STATUS', 
	        'link' => false,
	        'default' => true),
	    'START_DATE' => array(
	        'width' => '15', 
	        'label' => 'LBL_LIST_START_DATE', 
	        'link' => false,
	        'default' => true),
	    'END_DATE' => array(
	        'width' => '15', 
	        'label' => 'LBL_LIST_END_DATE', 
	        'link' => false,
	        'default' => true),
		'ASSIGNED_USER_NAME' => array(
			'width' => '10', 
			'label' => 'LBL_LIST_ASSIGNED_USER',
	        'link' => false,
	        'default' => true        
	        ),
		),
	'searchdefs'   => array(
	 	'name', 
		'reference_code', 
		'status',
		'start_date',
		'end_date',
		array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
	  )
);
?>
