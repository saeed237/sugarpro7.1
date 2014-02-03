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




global $current_user;

$dashletData['MyQuotesDashlet']['searchFields'] = array('quote_stage'             => array('default' => ''),
                                                       'name'             => array('default' => ''),
												       'date_quote_expected_closed'             => array('default' => ''),
                                                       //'date_modified'    => array('default' => ''),
                                                       'team_id'          => array('default' => '', 'label' => 'LBL_TEAMS'),
                                                       'assigned_user_id' => array('type'    => 'assigned_user_name',
																				   'label'   => 'LBL_ASSIGNED_TO',
                                                                                   'default' => $current_user->name));
$dashletData['MyQuotesDashlet']['columns'] = array('quote_num' => array(
		'width' => '10',  
		'label' => 'LBL_LIST_QUOTE_NUM', 
		'link' => false,
        'default' => true),
	'name' => array(
		'width' => '25', 
		'label' => 'LBL_LIST_QUOTE_NAME', 
		'link' => true,
        'default' => true),
	'billing_account_name' => array(
		'width' => '20',  
		'label' => 'LBL_LIST_ACCOUNT_NAME',
        'id' => 'ACCOUNT_ID',
        'module'  => 'Accounts',        
        'link' => true,
        'default' => true), 
	'quote_stage' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_QUOTE_STAGE', 
        'link' => false,
        'default' => true        
	),
	'total_usdollar' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_AMOUNT_USDOLLAR',
        'link' => false,
        'default' => true,
        'currency_format' => true,
        'align' => 'right'
    ),
	'date_quote_expected_closed' => array(
		'width' => '15', 
		'label' => 'LBL_LIST_DATE_QUOTE_EXPECTED_CLOSED',
        'link' => false,
        'default' => true        
        ),
    'quote_type' => array(
		'width' => '15', 
		'label' => 'LBL_QUOTE_TYPE',
        'link' => false,      
        ),
     'order_stage' => array(
		'width' => '15', 
		'label' => 'LBL_ORDER_STAGE',
        'link' => false,       
        ),
  'billing_address_street' =>
  array (
    'width' => '20', 
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'link' => false, 
  ),
  'billing_address_city' =>
  array (
     'width' => '20',
    'label' => 'LBL_BILLING_ADDRESS_CITY',
   'link' => false, 
  ),
  'billing_address_state' =>
  array (
     'width' => '20',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'link' => false, 
  ),
  'billing_address_postalcode' =>
  array (
     'width' => '20',
    'label' => 'LBL_BILLING_ADDRESS_POSTAL_CODE',
    'link' => false, 
  ),
  'billing_address_country' =>
  array (
     'width' => '20',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'link' => false, 
  ),
  'shipping_address_street' =>
  array (
    'width' => '20',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'link' => false, 
  ),
  'shipping_address_city' =>
  array (
     'width' => '20',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'link' => false, 
  ),
  'shipping_address_state' =>
  array (
    'width' => '20',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'link' => false, 
  ),
  'shipping_address_postalcode' =>
  array (
    'width' => '20',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTAL_CODE',
   'link' => false, 
  ),
  'shipping_address_country' =>
  array (
     'width' => '20',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
   'link' => false, 
  ),
);
?>
