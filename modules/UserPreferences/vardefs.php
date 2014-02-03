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


$GLOBALS['dictionary']['UserPreference'] = array('table' => 'user_preferences',
'fields' => array (
  'id' => 
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required'=>true,
    'reportable'=>false,
  ),
  'category' => 
  array (
    'name' => 'category',
    'type' => 'varchar',
    'len' => 50,
  ),
  'deleted' => 
  array (
    'name' => 'deleted',
    'type' => 'bool',
    'default' => '0',
    'required'=>false,
  ),
  'date_entered' => 
  array (
    'name' => 'date_entered',
    'type' => 'datetime',
    'required' => true,
  ),
  'date_modified' => 
  array (
    'name' => 'date_modified',
    'type' => 'datetime',
    'required' => true,
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'rname' => 'user_name',
    'id_name' => 'assigned_user_id',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'required' => true,
    'dbType' => 'id',
  ),
  'assigned_user_name' => 
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'type' => 'varchar',
    'reportable'=>false,
    'massupdate' => false,
    'source'=>'non-db',
    'table' => 'users',
  ),
  'contents' => 
  array (
    'name' => 'contents',
    'type' => 'longtext',
    'vname' => 'LBL_DESCRIPTION',
    'isnull' => true,
  ),
),
 

'indices' => array (
       array('name' =>'userpreferencespk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_userprefnamecat', 'type'=>'index', 'fields'=>array('assigned_user_id','category')),
      )
);

// cn: bug 12036 - $dictionary['x'] for SugarBean::createRelationshipMeta() from upgrades
$dictionary['UserPreference'] = $GLOBALS['dictionary']['UserPreference'];