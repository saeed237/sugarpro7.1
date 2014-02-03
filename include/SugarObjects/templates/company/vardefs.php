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

$vardefs= array (  
'fields' => array (
   'name' => 
  array (
    'name' => 'name',
    'type' => 'name',
    'link' => true,
    'dbType' => 'varchar',
    'vname' => 'LBL_NAME',
    'len' => 150,
    'comment' => 'Name of the Company',
    'unified_search' => true,
    'full_text_search' => array('boost' => 3),
    'audited' => true,
	'required'=>true,
    'importable' => 'required',
    'duplicate_on_record_copy' => 'always',
    'merge_filter' => 'selected',  //field will be enabled for merge and will be a part of the default search criteria..other valid values for this property are enabled and disabled, default value is disabled.
                            //property value is case insensitive.
  ),
    'linkedin' =>
    array (
        'name' => 'linkedin',
        'vname' => 'LBL_LINKEDIN',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The linkedin name of the company'
    ),
    'facebook' =>
    array (
        'name' => 'facebook',
        'vname' => 'LBL_FACEBOOK',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The facebook name of the company'
    ),
    'twitter' =>
    array (
        'name' => 'twitter',
        'vname' => 'LBL_TWITTER',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The twitter name of the company'
    ),
    'googleplus' =>
    array (
        'name' => 'googleplus',
        'vname' => 'LBL_GOOGLEPLUS',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The Google Plus name of the company'
    ),
   strtolower($object_name).'_type' => 
  array (
    'name' => strtolower($object_name).'_type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'options' => strtolower($object_name).'_type_dom',
    'len'=>50,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The Company is of this type',
  ),  
'industry' => 
  array (
    'name' => 'industry',
    'vname' => 'LBL_INDUSTRY',
    'type' => 'enum',
    'options' => 'industry_dom',
    'len'=>50,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The company belongs in this industry',
    'merge_filter' => 'enabled',
  ),
    'annual_revenue' => 
  array (
    'name' => 'annual_revenue',
    'vname' => 'LBL_ANNUAL_REVENUE',
    'type' => 'varchar',
    'len' => 100,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'Annual revenue for this company',
    'merge_filter' => 'enabled',
  ),
  'phone_fax' => 
  array (
    'name' => 'phone_fax',
    'vname' => 'LBL_FAX',
    'type' => 'phone',
    'dbType' => 'varchar',
    'len' => 100,
    'unified_search' => true,
    'full_text_search' => array('boost' => 1),
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The fax phone number of this company',
  ), 
  
  'billing_address_street' => 
  array (
    'name' => 'billing_address_street',
    'vname' => 'LBL_BILLING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => '150',
    'comment' => 'The street address used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_street_2' => 
  array (
    'name' => 'billing_address_street_2',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_2',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_street_3' => 
  array (
    'name' => 'billing_address_street_3',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_3',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_street_4' => 
  array (
    'name' => 'billing_address_street_4',
    'vname' => 'LBL_BILLING_ADDRESS_STREET_4',
    'type' => 'varchar',
    'len' => '150',
    'source'=>'non-db',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_city' => 
  array (
    'name' => 'billing_address_city',
    'vname' => 'LBL_BILLING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => '100',
    'comment' => 'The city used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_state' => 
  array (
    'name' => 'billing_address_state',
    'vname' => 'LBL_BILLING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => '100',
    'group'=>'billing_address',
    'comment' => 'The state used for billing address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_postalcode' => 
  array (
    'name' => 'billing_address_postalcode',
    'vname' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => '20',
    'group'=>'billing_address',
    'comment' => 'The postal code used for billing address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
  ),
  'billing_address_country' => 
  array (
    'name' => 'billing_address_country',
    'vname' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'billing_address',
    'comment' => 'The country used for the billing address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
  ),
   'rating' => 
  array (
    'name' => 'rating',
    'vname' => 'LBL_RATING',
    'type' => 'varchar',
    'len' => 100,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'An arbitrary rating for this company for use in comparisons with others',
  ),
    'phone_office' => 
  array (
    'name' => 'phone_office',
    'vname' => 'LBL_PHONE_OFFICE',
    'type' => 'phone',
    'dbType' => 'varchar',
    'len' => 100,
    'audited'=>true,         
    'unified_search' => true,  
    'full_text_search' => array('boost' => 1),
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The office phone number',
    'merge_filter' => 'enabled',
  ),
    'phone_alternate' => 
  array (
    'name' => 'phone_alternate',
    'vname' => 'LBL_PHONE_ALT',
    'type' => 'phone',
    'group'=>'phone_office',
    'dbType' => 'varchar',
    'len' => 100,
    'unified_search' => true,
    'full_text_search' => array('boost' => 1),
    'duplicate_on_record_copy' => 'always',
    'comment' => 'An alternate phone number',
    'merge_filter' => 'enabled',
  ),
   'website' => 
  array (
    'name' => 'website',
    'vname' => 'LBL_WEBSITE',
    'type' => 'url',
    'dbType' => 'varchar',
    'len' => 255,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'URL of website for the company',
  ),
   'ownership' => 
  array (
    'name' => 'ownership',
    'vname' => 'LBL_OWNERSHIP',
    'type' => 'varchar',
    'len' => 100,
    'duplicate_on_record_copy' => 'always',
    'comment' => '',
  ),
   'employees' => 
  array (
    'name' => 'employees',
    'vname' => 'LBL_EMPLOYEES',
    'type' => 'varchar',
    'len' => 10,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'Number of employees, varchar to accomodate for both number (100) or range (50-100)',
  ),
  'ticker_symbol' => 
  array (
    'name' => 'ticker_symbol',
    'vname' => 'LBL_TICKER_SYMBOL',
    'type' => 'varchar',
    'len' => 10,
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The stock trading (ticker) symbol for the company',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_street' => 
  array (
    'name' => 'shipping_address_street',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => 150,
    'group'=>'shipping_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The street address used for for shipping purposes',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_street_2' => 
  array (
    'name' => 'shipping_address_street_2',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_2',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source'=>'non-db',
  ),
  'shipping_address_street_3' => 
  array (
    'name' => 'shipping_address_street_3',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_3',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source'=>'non-db',
  ),
  'shipping_address_street_4' => 
  array (
    'name' => 'shipping_address_street_4',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET_4',
    'type' => 'varchar',
    'len' => 150,
    'duplicate_on_record_copy' => 'always',
    'source'=>'non-db',
  ),    
  'shipping_address_city' => 
  array (
    'name' => 'shipping_address_city',
    'vname' => 'LBL_SHIPPING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The city used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_state' => 
  array (
    'name' => 'shipping_address_state',
    'vname' => 'LBL_SHIPPING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The state used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_postalcode' => 
  array (
    'name' => 'shipping_address_postalcode',
    'vname' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => 20,
    'group'=>'shipping_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The zip code used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_country' => 
  array (
    'name' => 'shipping_address_country',
    'vname' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'shipping_address',
    'duplicate_on_record_copy' => 'always',
    'comment' => 'The country used for the shipping address',
    'merge_filter' => 'enabled',
  ),

//Bug 62521
'email'=>
  array(
    'name' => 'email',
    'type' => 'email',
    'query_type' => 'default',
    'source' => 'non-db',
    'operator' => 'subquery',
    'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
    'db_field' => array(
        'id',
    ),
    'vname' =>'LBL_ANY_EMAIL',
    'studio' => array('visible'=>false, 'searchview'=>true),
),
'email1' =>
  array(
    'name'    => 'email1',
    'vname'   => 'LBL_EMAIL_ADDRESS',
    'type'    => 'varchar',
    'function'  => array(
        'name'    => 'getEmailAddressWidget',
        'returns' => 'html'),
    'source'  => 'non-db',
    'group'=>'email1',
    'merge_filter' => 'enabled',
    'studio' => array('editview' => true, 'editField' => true, 'searchview' => false, 'popupsearch' => false), // bug 46859
    'full_text_search' => array('index' => 'not_analyzed'), //bug 54567
    'duplicate_on_record_copy' => 'always',
),

  'email_addresses_primary' => 
  array (
    'name' => 'email_addresses_primary',
    'type' => 'link',
    'relationship' => strtolower($object_name).'_email_addresses_primary',
    'source' => 'non-db',
    'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
    'duplicate_merge' => 'disabled',
  ),
  
  'email_addresses' =>
    array (
        'name' => 'email_addresses',
        'type' => 'link',
        'relationship' => strtolower($object_name).'_email_addresses',
        'source' => 'non-db',
        'vname' => 'LBL_EMAIL_ADDRESSES',
        'reportable'=>false,
        'unified_search' => true,
        'rel_fields' => array('primary_address' => array('type'=>'bool')),
    ),
),
'relationships'=>array(
    strtolower($module).'_email_addresses' => 
    array(
        'lhs_module'=> $module, 'lhs_table'=> strtolower($module), 'lhs_key' => 'id',
        'rhs_module'=> 'EmailAddresses', 'rhs_table'=> 'email_addresses', 'rhs_key' => 'id',
        'relationship_type'=>'many-to-many',
        'join_table'=> 'email_addr_bean_rel', 'join_key_lhs'=>'bean_id', 'join_key_rhs'=>'email_address_id', 
        'relationship_role_column'=>'bean_module',
        'relationship_role_column_value'=>$module
    ),
    strtolower($module).'_email_addresses_primary' => 
    array('lhs_module'=> $module, 'lhs_table'=> strtolower($module), 'lhs_key' => 'id',
        'rhs_module'=> 'EmailAddresses', 'rhs_table'=> 'email_addresses', 'rhs_key' => 'id',
        'relationship_type'=>'many-to-many',
        'join_table'=> 'email_addr_bean_rel', 'join_key_lhs'=>'bean_id', 'join_key_rhs'=>'email_address_id', 
        'relationship_role_column'=>'primary_address', 
        'relationship_role_column_value'=>'1'
    ),
),
'acls' => array('SugarACLEmailAddress'=>true),
);
