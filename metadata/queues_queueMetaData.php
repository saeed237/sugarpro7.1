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

$dictionary['queues_queue'] = array ('table' => 'queues_queue',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_QUEUES_QUEUE_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
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
		'parent_id' => array (
			'name' => 'parent_id',
			'vname' => 'LBL_PARENT_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
	),
	'indices' => array (
		array(
			'name' => 'queues_queuepk',
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
		'name' =>'idx_parent_id',
		'type'=>'index',
		'fields' => array(
			'parent_id'
			)
		),
		array(
		'name' => 'compidx_queue_id_parent_id',
		'type' => 'alternate_key',
		'fields' => array (
			'queue_id',
			'parent_id'
			),
		),
	), /* end indices */
	'relationships' => array (
		'child_queues_rel'	=> array(
			'lhs_module'		=> 'Queues',
			'lhs_table'			=> 'queues',
			'lhs_key'			=> 'id',
			'rhs_module'		=> 'Queues',
			'rhs_table'			=> 'queues',
			'rhs_key'			=> 'id',
			'relationship_type' => 'many-to-many',
			'join_table'		=> 'queues_queue', 
			'join_key_lhs'		=> 'queue_id', 
			'join_key_rhs'		=> 'parent_id'
		),
		'parent_queues_rel' => array(
			'lhs_module'		=> 'Queues',
			'lhs_table'			=> 'queues',
			'lhs_key' 			=> 'id',
			'rhs_module'		=> 'Queues',
			'rhs_table'			=> 'queues',
			'rhs_key' 			=> 'id',
			'relationship_type' => 'many-to-many',
			'join_table'		=> 'queues_queue', 
			'join_key_rhs'		=> 'queue_id', 
			'join_key_lhs'		=> 'parent_id'			
		),
	), /* end relationships */
);

?>
