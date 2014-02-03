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

 $dictionary['Quota'] =
 	array(
		'table' => 'quotas',
 		'fields' => array(

	'id' =>
	array (
	  'name' => 'id',
	  'vname' => 'LBL_NAME',
	  'type' => 'id',
	  'required' => true,
	  'reportable' => false,
	),

	'user_id' =>
	array (
	  'name' => 'user_id',
	  'rname' => 'user_name',
	  'vname' => 'LBL_USER_ID',
	  'type' => 'assigned_user_name',
	  'table' => 'users',
	  'required' => false,
	  'isnull' => false,
	  'reportable' => false,
	  'dbType' => 'id',
	  'importable' => 'required',
	),

	'assigned_user_id' =>
	array (
	  'name' => 'user_id',
	  'rname' => 'user_name',
	  'vname' => 'LBL_ASSIGNED_USER_ID',
	  'type' => 'assigned_user_name',
	  'table' => 'users',
	  'required' => true,
	  'reportable' => false,
	  'source' => 'non-db',
	),

	'user_name' =>
	array (
		'name' => 'user_name',
		'vname' => 'LBL_USER_NAME',
		'type' => 'varchar',
		'reportable' => false,
		'source' => 'non-db',
		'table' => 'users',
	),

	'user_full_name' =>
	array (
		'name' => 'user_full_name',
		'vname' => 'LBL_USER_FULL_NAME',
		'type' => 'varchar',
		'reportable' => false,
		'source' => 'non-db',
		'table' => 'users',
	),

    'timeperiod_id' =>
        array (
         'name' => 'timeperiod_id',
         'vname' => 'LBL_TIMEPERIOD_ID',
         'type' => 'enum',
         'dbType' => 'id',
         'function' => 'getTimePeriodsDropDownForQuotas',
         'reportable' => true,
        ),

  	'quota_type' =>
 	 array (
    	'name' => 'quota_type',
    	'vname' => 'LBL_QUOTA_TYPE',
    	'type' => 'enum',
    	'len' => 100,
    	'massupdate' => false,
    	'options' => 'forecast_type_dom',
        'reportable'=>false,
  ),

	'amount' =>
	array (
	  'name' => 'amount',
	  'vname' => 'LBL_AMOUNT',
	  'type' => 'currency',
	  'required' => true,
	  'reportable' => true,
	  'importable' => 'required',
	),

	'amount_base_currency' =>
	array (
	  'name' => 'amount_base_currency',
	  'vname' => 'LBL_AMOUNT_BASE_CURRENCY',
	  'type' => 'currency',
	  'required' => true,
	  'reportable' => false,
	),

	'currency_id' =>
	array (
	  'name' => 'currency_id',
	  'vname' => 'LBL_CURRENCY',
	  'type' => 'currency_id',
	  'dbType' => 'id',
	  'required' => true,
	  'reportable' => false,
	  'importable' => 'required',
      'default'=>'-99',
	),
    'base_rate' =>
    array (
         'name' => 'base_rate',
         'vname' => 'LBL_BASE_RATE',
         'type' => 'decimal',
         'len' => '26,6',
    ),
    'currency_symbol' =>
  	array (
    	'name' => 'currency_symbol',
    	'vname' => 'LBL_LIST_SYMBOL',
    	'type' => 'varchar',
    	'len' => '36',
    	'source' => 'non-db',
		'table' => 'currency',
     	'required' => true,
  ),

	'committed' =>
	array (
	  'name' => 'committed',
	  'vname' => 'LBL_COMMITTED',
	  'type' => 'bool',
	  'default' => '0',
	  'required' => false,
	  'reportable' => false,
	),

    'modified_user_id' =>
  	array (
    	'name' => 'modified_user_id',
    	'rname' => 'user_name',
    	'id_name' => 'modified_user_id',
    	'vname' => 'LBL_ASSIGNED_TO',
    	'type' => 'assigned_user_name',
    	'table' => 'users',
    	'isnull' => 'false',
    	'dbType' => 'id',
    	'reportable'=>true,
  	),
  	'created_by' =>
  	array (
    	'name' => 'created_by',
    	'vname' => 'LBL_CREATED_BY',
    	'type' => 'varchar',
    	'len' => '36',
        'reportable'=>false,
  	),
  	'date_entered' =>
  	array (
    	'name' => 'date_entered',
    	'vname' => 'LBL_DATE_ENTERED',
    	'type' => 'datetime',
        'reportable'=>false,
  	),
	'date_modified' =>
  	array (
    	'name' => 'date_modified',
    	'vname' => 'LBL_DATE_MODIFIED',
    	'type' => 'datetime',
        'reportable'=>false,
  	),
	'deleted' =>
  	array (
	    'name' => 'deleted',
    	'vname' => 'LBL_DELETED',
    	'type' => 'bool',
    	'reportable'=>false,
  	),
    'name' =>
    array (
       'name' => 'name',
       'type' => 'id',
       'source'=>'non-db',
    ),


    		),	//ends "fields" array

	'indices' => array(
       	  array('name' =>'quotaspk', 'type' =>'primary', 'fields'=>array('id')),
       	  array('name' =>'idx_quota_user_tp', 'type' =>'index', 'fields'=>array('user_id', 'timeperiod_id')),
	),
);

?>
