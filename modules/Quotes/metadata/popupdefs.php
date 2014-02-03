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
	'moduleMain' => 'Quote',
	'varName' => 'QUOTE',
	'orderBy' => 'name',
	'whereClauses' => array (
		'name' => 'quotes.name',
		'account_name' => 'accounts.name', 
		'date_quote_expected_closed' => 'quotes.date_quote_expected_closed',
	),
	'searchInputs' => array('name', 'account_name'),
	'listviewdefs' => array(
											'QUOTE_NUM' => array(
												'width' => '10',  
												'label' => 'LBL_LIST_QUOTE_NUM', 
												'link' => false,
										        'default' => true),
											'NAME' => array(
												'width' => '25', 
												'label' => 'LBL_LIST_QUOTE_NAME',
												'link' => true, 
										        'default' => true),
										    'BILLING_ACCOUNT_NAME' => array(
												'width' => '20',  
												'label' => 'LBL_LIST_ACCOUNT_NAME',
										        'id' => 'ACCOUNT_ID',
										        'module'  => 'Accounts',  
												'link' => true,      
										        'default' => true), 
											'QUOTE_STAGE' => array(
												'width' => '10', 
												'label' => 'LBL_LIST_QUOTE_STAGE', 
										        'link' => false,
										        'default' => true        
											),
											'PURCHASE_ORDER_NUM' => array(
												'width' => '25', 
												'label' => 'LBL_PURCHASE_ORDER_NUM', 
										        'default' => true),
											'ASSIGNED_USER_NAME' => array(
												'width' => '10', 
												'label' => 'LBL_LIST_ASSIGNED_USER',
										        'link' => false,
										        'default' => true        
										        ),
											),
						'searchdefs'   => array(
										 	'quote_num', 
											'name', 
											array('name' => 'billing_account_name', 'displayParams' => array('hideButtons'=>'true', 'size'=>30, 'class'=>'sqsEnabled sqsNoAutofill')),
											'quote_stage',
											'purchase_order_num',
											array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
										  )
);

?>