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


global $mod_strings;

$popupMeta = array(
	'moduleMain' => 'Account',
	'varName' => 'ACCOUNT',
	'orderBy' => 'name',
	'whereClauses' => array(
		'name' => 'accounts.name',
		'billing_address_city' => 'accounts.billing_address_city',
		'phone_office' => 'accounts.phone_office'
	),
	'searchInputs' => array('name', 'billing_address_city', 'phone_office'),
	'create' => array(
		'formBase' => 'AccountFormBase.php',
		'formBaseClass' => 'AccountFormBase',
		'getFormBodyParams' => array('','','AccountSave'),
		'createButton' => 'LNK_NEW_ACCOUNT'
	),
	'listviewdefs' => array(
		'NAME' => array(
			'width' => '40', 
			'label' => 'LBL_LIST_ACCOUNT_NAME', 
			'link' => true,	
			'default' => true,								        
		),
	    'BILLING_ADDRESS_STREET' => array(
			'width' => '10', 
			'label' => 'LBL_BILLING_ADDRESS_STREET',
			'default' => false,										        
		),		
		'BILLING_ADDRESS_CITY' => array(
			'width' => '10', 
			'label' => 'LBL_LIST_CITY',
			'default' => true,										        
		),
		'BILLING_ADDRESS_STATE' => array(
        	'width' => '7', 
        	'label' => 'LBL_STATE',
        	'default' => true,									        	
		),
        'BILLING_ADDRESS_COUNTRY' => array(
	        'width' => '10', 
	        'label' => 'LBL_COUNTRY',
	        'default' => true,
		),
	    'BILLING_ADDRESS_POSTALCODE' => array(
			'width' => '10', 
			'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
			'default' => false,										        
		),	
	    'SHIPPING_ADDRESS_STREET' => array(
			'width' => '10', 
			'label' => 'LBL_SHIPPING_ADDRESS_STREET',
			'default' => false,										        
		),		
		'SHIPPING_ADDRESS_CITY' => array(
			'width' => '10', 
			'label' => 'LBL_LIST_CITY',
			'default' => false,										        
		),
		'SHIPPING_ADDRESS_STATE' => array(
        	'width' => '7', 
        	'label' => 'LBL_STATE',
        	'default' => false,									        	
		),
        'SHIPPING_ADDRESS_COUNTRY' => array(
	        'width' => '10', 
	        'label' => 'LBL_COUNTRY',
	        'default' => false,
		),
	    'SHIPPING_ADDRESS_POSTALCODE' => array(
			'width' => '10', 
			'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
			'default' => false,										        
		),			
		'ASSIGNED_USER_NAME' => array(
	        'width' => '2', 
	        'label' => 'LBL_LIST_ASSIGNED_USER',
	        'default' => true,
		),
	    'PHONE_OFFICE' => array(
		    'width' => '10', 
			'label' => 'LBL_LIST_PHONE',
		    'default' => false
		),		
	),
	'searchdefs'   => array(
	 	'name', 
		'billing_address_city', 
		'billing_address_state',
		'billing_address_country',
		'email',
		array(
			'name' => 'assigned_user_id', 
			'label'=>'LBL_ASSIGNED_TO', 
			'type' => 'enum', 
			'function' => array('name' => 'get_user_array', 'params' => array(false))
		),
	)
);
?>
