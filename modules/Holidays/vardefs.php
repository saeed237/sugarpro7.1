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

$dictionary['Holiday'] = array(
  'table' => 'holidays',
  'favorites' => false,
  'fields' => array (
  'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_ID',
    'required'=>true,
    'type' => 'id',
    'reportable'=>false,
  ),
   'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required'=>true
  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required'=>true,
  ),
    'modified_user_id' =>
  array (
    'name' => 'modified_user_id',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_MODIFIED',
    'type' => 'assigned_user_name',
    'table' => 'modified_user_id_users',
    'isnull' => 'false',
    'dbType' => 'id',
    'required'=> false,
    'len' => 36,
    'reportable'=>true,
  ),
    'created_by' =>
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'created_by',
    'vname' => 'LBL_CREATED',
    'type' => 'assigned_user_name',
    'table' => 'created_by_users',
    'isnull' => 'false',
    'dbType' => 'id',
    'len' => 36,
  ),
   'holiday_date' =>
  array (
    'name' => 'holiday_date',
    'type' => 'date',
    'vname' => 'LBL_HOLIDAY_DATE',
    'required' => true,
    'importable' => 'required',
  ),
   'description' =>
  array (
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
  ),
  'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'reportable'=>false,
  ),
  'person_id' =>
  array (
  	'name' => 'person_id',
    'type' => 'id',
    'vname' => 'LBL_PERSON_ID',
  ),
  'person_type' =>
  array (
  	'name' => 'person_type',
    'type' => 'varchar',
    'vname' => 'LBL_PERSON_TYPE',
  ),
  'related_module' =>
  array (
    'name' => 'related_module',
    'type' => 'varchar',
    'vname' => 'LBL_RELATED_MODULE',
  ),
  'related_module_id' =>
  array (
    'name' => 'related_module_id',
    'type' => 'id',
    'vname' => 'LBL_RELATED_MODULE_ID',
  ),
  'resource_name' =>
  array (
    'name' => 'resource_name',
    'type' => 'varchar',
    'vname' => 'LBL_RESOURCE_NAME',
  ),
),
'acls' => array('SugarACLAdminOnly' => array('adminFor' => 'Users', 'allowUserRead' => true)),
  'indices' =>
  array (
    array('name' =>'holidayspk', 'type' =>'primary', 'fields'=>array('id')),
    array('name' =>'idx_holiday_id_del', 'type' =>'index', 'fields'=>array('id', 'deleted')),
    array('name' =>'idx_holiday_id_rel', 'type' =>'index', 'fields'=>array('related_module_id', 'related_module')),
  )
);

?>
