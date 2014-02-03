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

$dictionary['OAuthToken'] = array(
    'table' => 'oauth_tokens',
    'favorites' => false,
    'comment' => 'OAuth tokens',
    'audited' => false,
    'fields' => array (
      'id' =>
      array (
        'name' => 'id',
        'vname' => 'LBL_ID',
        'type' => 'id',
        'required' => true,
        'reportable' => true,
        'comment' => 'Unique identifier'
      ),
      'secret' =>
      array (
            'name' => 'secret',
            'type' => 'varchar',
            'len' => 32,
            'required' => true,
            'comment' => 'Secret key',
      ),
      'tstate' =>
      array (
            'name' => 'tstate',
            'type' => 'enum',
            'len' => 1,
            'options' => 'token_status',
            'required' => true,
            'comment' => 'Token state',

      ),
      'consumer' =>
      array (
            'name' => 'consumer',
            'type' => 'id',
            'required' => true,
            'comment' => 'Token related to the consumer',
      ),
      'token_ts' =>
      array (
            'name' => 'token_ts',
            'type' => 'long',
            'required' => true,
            'comment' => 'Token timestamp',
            'function' => array('name' => 'displayDateFromTs', 'returns' => 'html', 'onListView' => true)
      ),
      'expire_ts' =>
      array (
            'name' => 'expire_ts',
            'type' => 'long',
            'required' => true,
            'default' => -1,
            'comment' => 'Token expiration, defaults to -1 for no expiration date',
            'function' => array('name' => 'displayDateFromTs', 'returns' => 'html', 'onListView' => true)
      ),
      'verify' =>
      array (
            'name' => 'verify',
            'type' => 'varchar',
            'len' => 32,
            'comment' => 'Token verification info',
      ),
      'download_token' =>
      array (
            'name' => 'download_token',
            'type' => 'varchar',
            'len' => 36,
            'comment' => 'A token used to download images and files.',
      ),
//      'authdata' =>
//      array (
//            'name' => 'verify',
//            'type' => 'text',
//            'comment' => 'Token auth data',
//      ),
	  'deleted' =>
	  array (
	    'name' => 'deleted',
	    'vname' => 'LBL_DELETED',
	    'type' => 'bool',
	    'default' => '0',
	    'reportable'=>false,
	    'required' => true,
	  	'isnull' => false,
	    'comment' => 'Record deletion indicator'
	  ),
	'callback_url' =>
      array (
            'name' => 'callback_url',
            'type' => 'url',
            'len' => 255,
            'required' => false,
            'comment' => 'Callback URL for Authorization',
      ),
      'consumer_link' =>
      array (
        'name' => 'consumer_link',
        'type' => 'link',
        'relationship' => 'consumer_tokens',
        'vname' => 'LBL_CONSUMER',
        'link_type' => 'one',
        'module'=>'OAuthKeys',
        'bean_name'=>'OAuthKey',
        'source'=>'non-db',
      ),
      'consumer_name' =>
	  array (
		    'name' => 'consumer_name',
		    'link'=>'consumer_link' ,
		    'vname' => 'LBL_CONSUMER',
		    'rname' => 'name',
		    'type' => 'relate',
		    'reportable'=>false,
		    'source'=>'non-db',
		    'table' => 'oauth_consumer',
		    'id_name' => 'consumer',
		    'module'=>'OAuthKeys',
		    'duplicate_merge'=>'disabled'
	  ),
      'contact_id'=>
      array(
          'name'=>'contact_id',
          'vname'=>'LBL_CONTACTS',
          'type'=>'id',
          'required'=>false,
          'reportable'=>false,
          'comment' => 'Contact ID this oauth token is associated with (via portal)'
      ),
      'contact_name'=>
      array(
          'name'=>'contact_name',
          'rname'=>'name',
          'id_name'=>'contact_id',
          'vname'=>'LBL_CONTACTS',
          'table'=>'contacts',
          'type'=>'relate',
          'link'=>'contacts',
          'join_name'=>'contacts',
          'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),
          'isnull'=>'true',
          'module'=>'Contacts',
          'bean_name'=>'Contact',
          'source'=>'non-db',
      ),
          
	 'assigned_user_id' =>
		array (
			'name' => 'assigned_user_id',
			'rname' => 'user_name',
			'id_name' => 'assigned_user_id',
			'vname' => 'LBL_ASSIGNED_TO_ID',
			'group'=>'assigned_user_name',
			'type' => 'relate',
			'table' => 'users',
			'module' => 'Users',
			'reportable'=>true,
			'isnull' => 'false',
			'dbType' => 'id',
			'audited'=>true,
			'comment' => 'User ID assigned to record',
            'duplicate_merge'=>'disabled'
		),
	 'assigned_user_name' =>
	 array (
		    'name' => 'assigned_user_name',
		    'link'=>'assigned_user_link' ,
		    'vname' => 'LBL_ASSIGNED_TO_NAME',
		    'rname' => 'user_name',
		    'type' => 'relate',
		    'reportable'=>false,
		    'source'=>'non-db',
		    'table' => 'users',
		    'id_name' => 'assigned_user_id',
		    'module'=>'Users',
		    'duplicate_merge'=>'disabled'
	 ),
	 'assigned_user_link' =>
      array (
        'name' => 'assigned_user_link',
        'type' => 'link',
        'relationship' => 'oauthtokens_assigned_user',
        'vname' => 'LBL_ASSIGNED_TO_USER',
        'link_type' => 'one',
        'module'=>'Users',
        'bean_name'=>'User',
        'source'=>'non-db',
        'duplicate_merge'=>'enabled',
        'rname' => 'user_name',
        'id_name' => 'assigned_user_id',
        'table' => 'users',
  ),
  'contacts' =>
  array (
    'name' => 'contacts',
    'type' => 'link',
    'relationship' => 'contacts_oauthtokens',
    'vname' => 'LBL_CONTACTS',
    'source'=>'non-db',
  ),

  ),
    'indices' => array (
       'id'=>array('name' =>'oauthtokenpk', 'type' =>'primary', 'fields'=>array('id', 'deleted')),
       'state_ts'=>array('name' =>"oauth_state_ts", 'type' =>'index', 'fields'=>array('tstate','token_ts')),
       'consumer'=>array('name' =>"constoken_key", 'type' =>'index', 'fields'=>array('consumer')),
    ),
   'relationships'=>array(
        'consumer_tokens' =>
           array('lhs_module'=> 'OAuthKeys', 'lhs_table'=> 'oauth_consumer', 'lhs_key' => 'id',
   				'rhs_module'=> 'OAuthTokens', 'rhs_table'=> 'oauth_tokens', 'rhs_key' => 'consumer',
   				'relationship_type'=>'one-to-many'),
	  'oauthtokens_assigned_user' =>
           array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
           'rhs_module'=> 'OAuthTokens' , 'rhs_table'=> 'oauth_tokens', 'rhs_key' => 'assigned_user_id',
                 'relationship_type'=>'one-to-many'),
        'contacts_oauthtokens' => array('lhs_module' => 'Contacts',
                                 'lhs_table' => 'contacts',
                                 'lhs_key' => 'id',
                                 'rhs_module' => 'OAuthTokens',
                                 'rhs_table' => 'oauth_tokens',
                                 'rhs_key' => 'contact_id',
                                 'relationship_type' => 'one-to-many'),

           )
);
