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


$dictionary['KBTag'] = array('table' => 'kbtags'
                               ,'fields' => array (
  'id' => 
  array (
    'name' => 'id',
    'vname' => 'LBL_TAG_NAME',
    'type' => 'varchar',
    'len' => '36',
    'required'=>true,
    'reportable'=>false,
  ),  
  'parent_tag_id' => 
  array (
    'name' => 'parent_tag_id',
    'vname' => 'LBL_PARENT_TAG_ID',
    'type' => 'varchar',
    'len' => '36',
    'required'=>false,
    'reportable'=>false,
  ),
  'tag_name' => 
  array (
    'name' => 'tag_name',
    'vname' => 'LBL_NAME',
    'type' => 'varchar',
    'required'=>true
  ),
   'root_tag' => 
  array (
    'name' => 'root_tag',
    'vname' => 'LBL_ROOT_TAG',
    'type' => 'bool',
    'default' => 0,
    'reportable'=>false,
  ), 
   'date_entered' => 
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
  ),
  'created_by' => 
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_CREATED',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'source'=>'db',
  ),    
  'revision'=>
  array (
    'name' => 'revision',
    'vname' => 'LBL_REVISION',
    'type' => 'varchar',
    'len' => 100,
  ),    
  'deleted' => 
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'default' => 0,
    'reportable'=>false,
  ),
  'date_modified' => 
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
  ),
//'created_by_link' =>
//  array (
//    'name' => 'created_by_link',
//    'type' => 'link',
//    'relationship' => 'revisions_created_by',
//    'vname' => 'LBL_CREATED_BY_USER',
//    'link_type' => 'one',
//    'module'=>'Users',
//    'bean_name'=>'User',
//    'source'=>'non-db',
//  ),  
'created_by_name' => 
  array (
    'name' => 'created_by_name',
    'rname' => 'user_name',
    'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),    
    'id_name' => 'created_by',
    'vname' => 'LBL_CREATED_BY_NAME',
    'type' => 'relate',
    'table' => 'users',
    'isnull' => 'true',
    'module' => 'Users',
    'dbType' => 'varchar',
    'link'=>'created_by_link',
    'len' => '255',
    'source'=>'non-db',
  ),  
), 
'indices' => array (
       array('name' =>'kbtagspk', 'type' =>'primary', 'fields'=>array('id'))
),



'relationships' => array (
 
   )


);

VardefManager::createVardef('KBTags','KBTag', array(
'team_security',
));
?>
