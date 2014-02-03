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


$dictionary['WorkFlowActionShell'] = array('table' => 'workflow_actionshells'
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
  'action_type' => 
  array (
    'name' => 'action_type',
    'vname' => 'LBL_ACTION_TYPE',
    'type' => 'enum',
    'required' => true,
    'options' => 'wflow_action_type_dom',
    'len' => 100,
  ),
   'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
  ),
     'parameters' => 
  array (
    'name' => 'parameters',
    'vname' => 'LBL_EXT1',
    'type' => 'varchar',
    'len' => '255',
    'required' => false,
  ),  
    'rel_module' => 
  array (
    'name' => 'rel_module',
    'vname' => 'LBL_REL_MODULE',
    'type' => 'varchar',
    'len' => '50',
  ),
    'rel_module_type' => 
  array (
    'name' => 'rel_module_type',
    'vname' => 'LBL_RELATED_TYPE',
    'type' => 'enum',
    'options' => 'wflow_rel_type_dom',
    'len'=>10,
  ),
  	'action_module' => 
  array (
    'name' => 'action_module',
    'vname' => 'LBL_ACTION_MODULE',
    'type' => 'varchar',
    'len' => '255',
  ),
     'actions' => 
  array (
  	'name' => 'actions',
    'type' => 'link',
    'relationship' => 'actions',
    'module'=>'WorkFlowActions',
    'bean_name'=>'WorkFlowAction',
    'source'=>'non-db',
  ),
     'action_bridge' => 
  array (
  	'name' => 'action_bridge',
    'type' => 'link',
    'relationship' => 'action_bridge',
    'module'=>'WorkFlows',
    'bean_name'=>'WorkFlow',
    'source'=>'non-db',
  ),  
     'rel1_action_fil' => 
  array (
  	'name' => 'rel1_action_fil',
    'type' => 'link',
    'relationship' => 'rel1_action_fil',
    'module'=>'Expressions',
    'bean_name'=>'Expression',
    'source'=>'non-db',
  ),
  'parent_base_module' => 
  array (
  	'name' => 'base_module',
    'vname' => 'LBL_BASE_MODULE',
    'type' => 'varchar',
    'source'=>'non-db',
  ),
  'parent_type' => 
  array (
    'name' => 'parent_type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'options' => 'wflow_type_dom',
    'source'=>'non-db',
  ),
)
                                                      , 'indices' => array (
       array('name' =>'actionshell_k', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_actionshell', 'type'=>'index', 'fields'=>array('deleted')),
                                                      )
, 'relationships' => array (
		'actions' => array('lhs_module'=> 'WorkFlowActionShells', 'lhs_table'=> 'workflow_actionshells', 'lhs_key' => 'id',
							  'rhs_module'=> 'WorkFlowActions', 'rhs_table'=> 'workflow_actions', 'rhs_key' => 'parent_id',	
								'relationship_type'=>'one-to-many'),
		'action_bridge' => array('lhs_module'=> 'WorkFlowActionShells', 'lhs_table'=> 'workflow_actionshells', 'lhs_key' => 'id',
							  'rhs_module'=> 'WorkFlow', 'rhs_table'=> 'workflow', 'rhs_key' => 'parent_id',	
								'relationship_type'=>'one-to-many'),								
		'rel1_action_fil' => array('lhs_module'=> 'WorkFlowActionShells', 'lhs_table'=> 'workflow_actionshells', 'lhs_key' => 'id',
							  'rhs_module'=> 'Expressions', 'rhs_table'=> 'expressions', 'rhs_key' => 'parent_id',	
							  'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'rel1_action_fil', 'relationship_type'=>'one-to-many')							  							  	
  )                                                      
 );
?>
