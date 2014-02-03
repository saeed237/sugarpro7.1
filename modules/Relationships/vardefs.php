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

$dictionary['Relationship'] =

	array('table' => 'relationships'
         ,'fields' => array (
  			'id' =>
  			array (
    			'name' => 'id',
    			'vname' => 'LBL_ID',
    			'type' => 'id',
    			'required'=>true,
  			),

  			'relationship_name' =>
  			array (
    			'name' => 'relationship_name',
    			'vname' => 'LBL_RELATIONSHIP_NAME',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 150,
    			'importable' => 'required',
  			),
  			'lhs_module' =>
  			array (
    			'name' => 'lhs_module',
    			'vname' => 'LBL_LHS_MODULE',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 100
  			),
  			'lhs_table' =>
  			array (
    			'name' => 'lhs_table',
    			'vname' => 'LBL_LHS_TABLE',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 64
  			),
  			'lhs_key' =>
  			array (
    			'name' => 'lhs_key',
    			'vname' => 'LBL_LHS_KEY',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 64
  			),
  			'rhs_module' =>
  			array (
    			'name' => 'rhs_module',
    			'vname' => 'LBL_RHS_MODULE',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 100
  			),
  			'rhs_table' =>
  			array (
    			'name' => 'rhs_table',
    			'vname' => 'LBL_RHS_TABLE',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 64
  			),
  			'rhs_key' =>
  			array (
    			'name' => 'rhs_key',
    			'vname' => 'LBL_RHS_KEY',
    			'type' => 'varchar',
    			'required'=>true,
    			'len' => 64
  			),
  			'join_table' =>
  			array (
    			'name' => 'join_table',
    			'vname' => 'LBL_JOIN_TABLE',
    			'type' => 'varchar',
    			'len' => 64
  			),
  			'join_key_lhs' =>
  			array (
    			'name' => 'join_key_lhs',
    			'vname' => 'LBL_JOIN_KEY_LHS',
    			'type' => 'varchar',
    			'len' => 64
  			),
  			'join_key_rhs' =>
  			array (
    			'name' => 'join_key_rhs',
    			'vname' => 'LBL_JOIN_KEY_RHS',
    			'type' => 'varchar',
    			'len' => 64
  			),
  			'relationship_type' =>
  			array (
    			'name' => 'relationship_type',
    			'vname' => 'LBL_RELATIONSHIP_TYPE',
    			'type' => 'varchar',
    			'len' => 64
  			),
  			'relationship_role_column' =>
  			array (
    			'name' => 'relationship_role_column',
    			'vname' => 'LBL_RELATIONSHIP_ROLE_COLUMN',
    			'type' => 'varchar',
    			'len' => 64
  			),
  			'relationship_role_column_value' =>
  			array (
    			'name' => 'relationship_role_column_value',
    			'vname' => 'LBL_RELATIONSHIP_ROLE_COLUMN_VALUE',
    			'type' => 'varchar',
    			'len' => 50
  			),
  			'reverse' =>
  			array (
    			'name' => 'reverse',
    			'vname' => 'LBL_REVERSE',
    			'type' => 'bool',
    			'default' => '0'
  			),
  		 	'deleted' =>
  			array (
    			'name' => 'deleted',
    			'vname' => 'LBL_DELETED',
    			'type' => 'bool',
    			'reportable'=>false,
    			'default' => '0'
  			),

	)
	, 'indices' => array (
       array('name' =>'relationshippk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_rel_name', 'type' =>'index', 'fields'=>array('relationship_name')),
    )
);


?>
