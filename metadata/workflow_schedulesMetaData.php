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

$dictionary['WorkFlowSchedule'] = array('table' => 'workflow_schedules'
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
  'date_expired' => 
  array (
    'name' => 'date_expired',
    'vname' => 'LBL_DATE_EXPIRED',
    'type' => 'datetime',
    'required' => true,
  ),
  'workflow_id' => 
  array (
    'name' => 'workflow_id',
    'type' => 'id',
    'required'=>false,
    'reportable'=>false,
  ),  
    'target_module' => 
  array (
    'name' => 'target_module',
    'vname' => 'LBL_TARGET_MODULE',
    'type' => 'varchar',
    'len' => '50',
  ),
    'bean_id' => 
  array (
    'name' => 'bean_id',
    'type' => 'id',
    'required'=>false,
    'reportable'=>false,
  ),  
      'parameters' => 
  array (
    'name' => 'parameters',
    'vname' => 'LBL_PARAMETERS',
    'type' => 'varchar',
    'len' => '255',
    'required' => false,
  ),       
)
                                                      , 'indices' => array (
       array('name' =>'schedule_k', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_wkfl_schedule', 'type'=>'index', 'fields'=>array('workflow_id','deleted')),
                                                      )
                            );
?>
