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

$dictionary['Currency'] = array('table' => 'currencies',
	'comment' => 'Currencies allow Sugar to store and display monetary values in various denominations'
                               ,'fields' => array (
  'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
    'comment' => 'Unique identifer'
    ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'type' => 'varchar',
    'len' => '36',
    'required' => true,
    'comment' => 'Name of the currency',
    'importable' => 'required',
  ),
  'symbol' =>
  array (
    'name' => 'symbol',
    'vname' => 'LBL_LIST_SYMBOL',
    'type' => 'varchar',
    'len' => '36',
     'required' => true,
     'comment' => 'Symbol representing the currency',
     'importable' => 'required',
  ),
  'iso4217' =>
  array (
    'name' => 'iso4217',
    'vname' => 'LBL_LIST_ISO4217',
    'type' => 'varchar',
    'len' => '3',
     'comment' => '3-letter identifier specified by ISO 4217 (ex: USD)',
  ),
  'conversion_rate' =>
  array (
    'name' => 'conversion_rate',
    'vname' => 'LBL_LIST_RATE',
    'type' => 'decimal',
    'default' => '0',
    'len' => '26,6',
     'required' => true,
	 'comment' => 'Conversion rate factor (relative to stored value)',
	 'importable' => 'required',
  ),
  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'dbType'=>'varchar',
    'options' => 'currency_status_dom',
    'len' => 100,
    'comment' => 'Currency status',
    'importable' => 'required',
  ),
  'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required' => false,
    'reportable'=>false,
    'comment' => 'Record deletion indicator'
  ),
  'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
     'required' => true,
    'comment' => 'Date record created'

  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
     'required' => true,
    'comment' => 'Date record last modified'
  ),
  'created_by' =>
  array (
    'name' => 'created_by',
    'reportable' => false,
    'vname' => 'LBL_CREATED_BY',
    'type' => 'id',
    'len'  => '36',
    'required' => true,
  	'comment' => 'User ID who created record'
  ),
),
'acls' => array('SugarACLAdminOnly' => array('allowUserRead' => true)),
'indices' => array (
   array('name' =>'currenciespk', 'type' =>'primary', 'fields'=>array('id')),
   array('name' =>'idx_currency_name', 'type' =>'index', 'fields'=>array('name','deleted'))
                                                      )

                            );
?>
