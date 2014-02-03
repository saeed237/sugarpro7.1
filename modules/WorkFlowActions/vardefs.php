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


$dictionary['WorkFlowAction'] = array('table' => 'workflow_actions'
                               ,'fields' => array (
  'id' => 
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
  ),
   'deleted' => 
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required' => false,
    'default' => '0',
    'reportable'=>false,
  ),
   'date_entered' => 
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required' => true,
  ),
  'date_modified' => 
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required' => true,
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
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id'
  ),
  'field' => 
  array (
    'name' => 'field',
    'vname' => 'LBL_FIELD',
    'type' => 'varchar',
    'len' => '50',
  ),
    'value' => 
  array (
    'name' => 'value',
    'vname' => 'LBL_VALUE',
    'type' => 'text',
  ),
  'set_type' => 
  array (
    'name' => 'set_type',
    'vname' => 'LBL_SET_TYPE',
    'type' => 'enum',
    'required' => true,
    'options' => 'wflow_set_type_dom',
    'len'=>10,
  ),
    'adv_type' => 
  array (
    'name' => 'adv_type',
    'vname' => 'LBL_ADV_TYPE',
    'type' => 'enum',
    'options' => 'wflow_adv_type_dom',
    'len'=>10,
  ),
    'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
  ),
    'ext1' => 
  array (
    'name' => 'ext1',
    'vname' => 'LBL_OPTION',
    'type' => 'varchar',
    'len' => '50',
  ),
    'ext2' => 
  array (
    'name' => 'ext2',
    'vname' => 'LBL_OPTION',
    'type' => 'varchar',
    'len' => '50',
  ),
    'ext3' => 
  array (
    'name' => 'ext3',
    'vname' => 'LBL_OPTION',
    'type' => 'varchar',
    'len' => '50',
  ),    
)
                                                      , 'indices' => array (
       array('name' =>'action_k', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_action', 'type'=>'index', 'fields'=>array('deleted')),
                                                      )
 );
?>
