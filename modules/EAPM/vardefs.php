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

$dictionary['EAPM'] = array(
	'table'=>'eapm',
	'audited'=>false,
	'fields'=>array (
  'password' =>
  array (
    'required' => true,
    'name' => 'password',
    'vname' => 'LBL_PASSWORD',
    'type' => 'encrypt',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => false,
    'len' => '255',
    'size' => '20',
  ),
  'url' =>
  array (
    'required' => true,
    'name' => 'url',
    'vname' => 'LBL_URL',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
  ),
  'application' =>
  array (
    'required' => true,
    'name' => 'application',
    'vname' => 'LBL_APPLICATION',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'function' => 'getEAPMExternalApiDropDown',
    'studio' => 'visible',
    'default' => 'webex',
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'full_text_search' => array('boost' => 3),
    'importable' => 'required',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'size' => '20',
  ),
	  'api_data' =>
	  array (
	    'name' => 'api_data',
	    'vname' => 'LBL_API_DATA',
	    'type' => 'text',
	    'comment' => 'Any API data that the external API may wish to store on a per-user basis',
	    'rows' => 6,
	    'cols' => 80,
	  ),
	  'consumer_key' => array(
	  	'name' => 'consumer_key',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_CONSKEY',
//        'required' => true,
        'importable' => 'required',
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
        'studio' => 'hidden',
	  ),
	  'consumer_secret' => array(
	  	'name' => 'consumer_secret',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_CONSSECRET',
//        'required' => true,
        'importable' => 'required',
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
        'studio' => 'hidden',
	  ),
	  'oauth_token' => array(
	  	'name' => 'oauth_token',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_OAUTHTOKEN',
        'importable' => false,
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
    	'required' => false,
        'studio' => 'hidden',
	  ),
	  'oauth_secret' => array(
	  	'name' => 'oauth_secret',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_OAUTHSECRET',
        'importable' => false,
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
    	'required' => false,
        'studio' => 'hidden',
	  ),
	  'validated' => array(
        'required' => false,
        'name' => 'validated',
        'vname' => 'LBL_VALIDATED',
        'type' => 'bool',
	    'default' => false,
	  ),
      'note' => array(
          'name' => 'note',
          'vname' => 'LBL_NOTE',
          'required' => false,
          'reportable' => false,
          'importable' => false,
          'massupdate' => false,
          'studio' => 'hidden',
          'type' => 'varchar',
          'source' => 'non-db',
      ),

),
	'relationships'=>array (
    ),
    'indices' => array(
        array(
                'name' => 'idx_app_active',
                'type' => 'index',
                'fields'=> array('assigned_user_id', 'application', 'validated'),
        ),
),
	'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('EAPM','EAPM', array('basic','assignable'));
