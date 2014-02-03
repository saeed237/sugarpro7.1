<?php
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

$vardefs =array(
'fields'=> array(
'salutation' =>
		array (
			'name' => 'salutation',
			'vname' => 'LBL_SALUTATION',
			'type' => 'enum',
			'options' => 'salutation_dom',
			'massupdate' => false,
			'len' => '255',
            'duplicate_on_record_copy' => 'always',
			'comment' => 'Contact salutation (e.g., Mr, Ms)'
		),
'first_name' =>
		array (
			'name' => 'first_name',
			'vname' => 'LBL_FIRST_NAME',
			'type' => 'varchar',
			'len' => '100',
			'unified_search' => true,
			'full_text_search' => array('boost' => 3),
            'duplicate_on_record_copy' => 'always',
			'comment' => 'First name of the contact',
            'merge_filter' => 'selected',

		),
	'last_name' =>
		array (
			'name' => 'last_name',
			'vname' => 'LBL_LAST_NAME',
			'type' => 'varchar',
			'len' => '100',
			'unified_search' => true,
			'full_text_search' => array('boost' => 3),
            'duplicate_on_record_copy' => 'always',
			'comment' => 'Last name of the contact',
            'merge_filter' => 'selected',
            'required'=>true,
            'importable' => 'required',
		),
	'name' =>
		array (
			'name' => 'name',
			'rname' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'fullname',
			'link' => true, // bug 39288
			'fields' => array('first_name', 'last_name', 'salutation', 'title'),
			'sort_on' => 'last_name',
			'source' => 'non-db',
			'group'=>'last_name',
			'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),
            'importable' => 'false',
            'duplicate_on_record_copy' => 'always',
		),
	'full_name' =>
		array (
			'name' => 'full_name',
			'rname' => 'full_name',
			'vname' => 'LBL_NAME',
			'type' => 'fullname',
		    'link' => true, // bug 39288
			'fields' => array('first_name', 'last_name', 'salutation', 'title'),
			'sort_on' => 'last_name',
			'source' => 'non-db',
			'group'=>'last_name',
			'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),
			'studio' => array('listview' => false),
            'duplicate_on_record_copy' => 'always',
		),
	'title' =>
		array (
			'name' => 'title',
			'vname' => 'LBL_TITLE',
			'type' => 'varchar',
			'len' => '100',
            'duplicate_on_record_copy' => 'always',
			'comment' => 'The title of the contact'
		),
    'linkedin' =>
   		array (
   			'name' => 'linkedin',
   			'vname' => 'LBL_LINKEDIN',
   			'type' => 'varchar',
   			'len' => '100',
            'duplicate_on_record_copy' => 'always',
   			'comment' => 'The linkedin name of the user'
   		),
    'facebook' =>
    array (
        'name' => 'facebook',
        'vname' => 'LBL_FACEBOOK',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The facebook name of the user'
    ),
    'twitter' =>
    array (
        'name' => 'twitter',
        'vname' => 'LBL_TWITTER',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The twitter name of the user'
    ),
    'googleplus' =>
    array (
        'name' => 'googleplus',
        'vname' => 'LBL_GOOGLEPLUS',
        'type' => 'varchar',
        'len' => '100',
        'duplicate_on_record_copy' => 'always',
        'comment' => 'The google plus id of the user'
    ),
	'department' =>
		array (
			'name' => 'department',
			'vname' => 'LBL_DEPARTMENT',
			'type' => 'varchar',
			'len' => '255',
            'duplicate_on_record_copy' => 'always',
			'comment' => 'The department of the contact',
            'merge_filter' => 'enabled',
		),
		'do_not_call' =>
		array (
			'name' => 'do_not_call',
			'vname' => 'LBL_DO_NOT_CALL',
			'type' => 'bool',
			'default' => '0',
			'audited'=>true,
            'duplicate_on_record_copy' => 'always',
			'comment' => 'An indicator of whether contact can be called'
		),
	'phone_home' =>
		array (
			'name' => 'phone_home',
			'vname' => 'LBL_HOME_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
            'duplicate_on_record_copy' => 'always',
			'comment' => 'Home phone number of the contact',
            'merge_filter' => 'enabled',
		),
		//bug 42902
		'email'=> array(
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
            'duplicate_on_record_copy' => 'always',
            'len' => 100
		),
	'phone_mobile' =>
		array (
			'name' => 'phone_mobile',
			'vname' => 'LBL_MOBILE_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
			'comment' => 'Mobile phone number of the contact',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'phone_work' =>
		array (
			'name' => 'phone_work',
			'vname' => 'LBL_OFFICE_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'audited'=>true,
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
			'comment' => 'Work phone number of the contact',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'phone_other' =>
		array (
			'name' => 'phone_other',
			'vname' => 'LBL_OTHER_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
			'comment' => 'Other phone number for the contact',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'phone_fax' =>
		array (
			'name' => 'phone_fax',
			'vname' => 'LBL_FAX_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
			'comment' => 'Contact fax number',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'email1' =>
		array(
			'name'		=> 'email1',
			'vname'		=> 'LBL_EMAIL_ADDRESS',
			'type'		=> 'varchar',
			'function'	=> array(
				'name'		=> 'getEmailAddressWidget',
				'returns'	=> 'html'),
			'source'	=> 'non-db',
			'group'=>'email1',
            'merge_filter' => 'enabled',
		    'studio' => array('editview' => true, 'editField' => true, 'searchview' => false, 'popupsearch' => false), // bug 46859
		    'full_text_search' => array('index' => 'not_analyzed'), //bug 54567
            'duplicate_on_record_copy' => 'always',
		),
	'email2' =>
		array(
			'name'		=> 'email2',
			'vname'		=> 'LBL_OTHER_EMAIL_ADDRESS',
			'type'		=> 'varchar',
			'function'	=> array(
				'name'		=> 'getEmailAddressWidget',
				'returns'	=> 'html'),
			'source'	=> 'non-db',
			'group'=>'email2',
            'merge_filter' => 'enabled',
		    'studio' => 'false',
            'duplicate_on_record_copy' => 'always',
		),
    'invalid_email' =>
		array(
			'name'		=> 'invalid_email',
			'vname'     => 'LBL_INVALID_EMAIL',
			'source'	=> 'non-db',
			'type'		=> 'bool',
		    'massupdate' => false,
		    'studio' => 'false',
            'duplicate_on_record_copy' => 'always',
		),
    'email_opt_out' =>
		array(
			'name'		=> 'email_opt_out',
			'vname'     => 'LBL_EMAIL_OPT_OUT',
			'source'	=> 'non-db',
			'type'		=> 'bool',
		    'massupdate' => false,
			'studio'=>'false',
            'duplicate_on_record_copy' => 'always',
		),

	'primary_address_street' =>
		array (
			'name' => 'primary_address_street',
			'vname' => 'LBL_PRIMARY_ADDRESS_STREET',
			'type' => 'varchar',
			'len' => '150',
			'group'=>'primary_address',
			'comment' => 'Street address for primary address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'primary_address_street_2' =>
		array (
			'name' => 'primary_address_street_2',
			'vname' => 'LBL_PRIMARY_ADDRESS_STREET_2',
			'type' => 'varchar',
			'len' => '150',
			'source' => 'non-db',
            'duplicate_on_record_copy' => 'always',
		),
	'primary_address_street_3' =>
		array (
			'name' => 'primary_address_street_3',
			'vname' => 'LBL_PRIMARY_ADDRESS_STREET_3',
			'type' => 'varchar',
			'len' => '150',
			'source' => 'non-db',
            'duplicate_on_record_copy' => 'always',
		),
	'primary_address_city' =>
		array (
			'name' => 'primary_address_city',
			'vname' => 'LBL_PRIMARY_ADDRESS_CITY',
			'type' => 'varchar',
			'len' => '100',
			'group'=>'primary_address',
			'comment' => 'City for primary address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'primary_address_state' =>
		array (
			'name' => 'primary_address_state',
			'vname' => 'LBL_PRIMARY_ADDRESS_STATE',
			'type' => 'varchar',
			'len' => '100',
			'group'=>'primary_address',
			'comment' => 'State for primary address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'primary_address_postalcode' =>
		array (
			'name' => 'primary_address_postalcode',
			'vname' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
			'type' => 'varchar',
			'len' => '20',
			'group'=>'primary_address',
			'comment' => 'Postal code for primary address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',

		),
	'primary_address_country' =>
		array (
			'name' => 'primary_address_country',
			'vname' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
			'type' => 'varchar',
			'group'=>'primary_address',
			'comment' => 'Country for primary address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_street' =>
		array (
			'name' => 'alt_address_street',
			'vname' => 'LBL_ALT_ADDRESS_STREET',
			'type' => 'varchar',
			'len' => '150',
			'group'=>'alt_address',
			'comment' => 'Street address for alternate address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_street_2' =>
		array (
			'name' => 'alt_address_street_2',
			'vname' => 'LBL_ALT_ADDRESS_STREET_2',
			'type' => 'varchar',
			'len' => '150',
			'source' => 'non-db',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_street_3' =>
		array (
			'name' => 'alt_address_street_3',
			'vname' => 'LBL_ALT_ADDRESS_STREET_3',
			'type' => 'varchar',
			'len' => '150',
			'source' => 'non-db',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_city' =>
		array (
			'name' => 'alt_address_city',
			'vname' => 'LBL_ALT_ADDRESS_CITY',
			'type' => 'varchar',
			'len' => '100',
			'group'=>'alt_address',
			'comment' => 'City for alternate address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_state' =>
		array (
			'name' => 'alt_address_state',
			'vname' => 'LBL_ALT_ADDRESS_STATE',
			'type' => 'varchar',
			'len' => '100',
			'group'=>'alt_address',
			'comment' => 'State for alternate address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_postalcode' =>
		array (
			'name' => 'alt_address_postalcode',
			'vname' => 'LBL_ALT_ADDRESS_POSTALCODE',
			'type' => 'varchar',
			'len' => '20',
			'group'=>'alt_address',
			'comment' => 'Postal code for alternate address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'alt_address_country' =>
		array (
			'name' => 'alt_address_country',
			'vname' => 'LBL_ALT_ADDRESS_COUNTRY',
			'type' => 'varchar',
			'group'=>'alt_address',
			'comment' => 'Country for alternate address',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
		'assistant' =>
		array (
			'name' => 'assistant',
			'vname' => 'LBL_ASSISTANT',
			'type' => 'varchar',
			'len' => '75',
			'unified_search' => true,
			'full_text_search' => array('boost' => 2),
			'comment' => 'Name of the assistant of the contact',
            'merge_filter' => 'enabled',
            'duplicate_on_record_copy' => 'always',
		),
	'assistant_phone' =>
		array (
			'name' => 'assistant_phone',
			'vname' => 'LBL_ASSISTANT_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'len' => 100,
			'group'=>'assistant',
			'unified_search' => true,
			'full_text_search' => array('boost' => 1),
			'comment' => 'Phone number of the assistant of the contact',
            'merge_filter' => 'enabled',
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
	'picture' =>
		array(
			'name' => 'picture',
			'vname' => 'LBL_PICTURE_FILE',
			'type' => 'image',
			'dbtype' => 'varchar',
		    'massupdate' => false,
		    'reportable' => false,
			'comment' => 'Avatar',
            'len' => '255',
            'width' => '42',
            'height' => '42',
            'border' => '',
            'duplicate_on_record_copy' => 'always',
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
'acls'=>array('SugarACLEmailAddress'=>true),
);
