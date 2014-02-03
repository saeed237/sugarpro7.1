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


$dictionary['queues_beans'] = array('table' => 'queues_beans', 
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
		'deleted' => array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => true,
			'default' => '0',
			'reportable'=>false,
		),
		'date_entered' => array (
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'required' => true,
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'required' => true,
		),
		'queue_id' => array (
			'name' => 'queue_id',
			'vname' => 'LBL_QUEUE_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
		'module_dir' => array (
			'name' => 'module_dir',
			'vname' => 'LBL_MODULE_DIR',
			'type' => 'varchar',
			'len'	=> '30',
			'required' => true,
			'reportable'=>false,
		),
		'object_id' => array (
			'name' => 'object_id',
			'vname' => 'LBL_OBJECT_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
	),
	'relationships' => array (
		'queues_emails_rel' => array(
			'lhs_module'					=> 'Queues',
			'lhs_table'						=> 'queues',
			'lhs_key' 						=> 'id',
			'rhs_module'					=> 'Emails',
			'rhs_table'						=> 'emails',
			'rhs_key' 						=> 'id',
			'relationship_type' 			=> 'many-to-many',
			'join_table'					=> 'queues_beans', 
			'join_key_rhs'					=> 'object_id', 
			'join_key_lhs'					=> 'queue_id',
			'relationship_role_column'		=> 'module_dir',
			'relationship_role_column_value'=> 'Emails'		
		),
	), /* end relationship definitions */
	'indices' => array (
		array(
			'name' => 'queues_itemspk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
		'name' =>'idx_queue_id',
		'type'=>'index',
		'fields' => array(
			'queue_id'
			)
		),
		array(
		'name' =>'idx_object_id',
		'type'=>'index',
		'fields' => array(
			'object_id'
			)
		),
	), /* end indices */
);

?>
