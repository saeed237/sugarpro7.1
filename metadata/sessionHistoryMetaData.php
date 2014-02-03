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

$dictionary['session_history'] = array(
	'table' => 'session_history',
	'fields' => array (
		'id' => array(
			'name' => 'id', 
			'type' => 'id',
		),
		'session_id' => array(
			'name' => 'session_id',
			'type' => 'varchar',
			'len' => '100',
		),
		'date_entered' => array(
			'name' => 'date_entered',
			'type' => 'datetime',
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'type' => 'datetime',
		),
		'last_request_time' => array(
			'name' => 'last_request_time',
			'type' => 'datetime',
		),
		'session_type' => array(
			'name' => 'session_type',
			'type' => 'varchar',
			'len' => '100',
		),
		'is_violation' => array(
			'name' => 'is_violation',
			'type' => 'bool',
			'len' => '1',
			'default'  => '0',
		),
		'num_active_sessions' => array(
			'name' => 'num_active_sessions',
			'type' => 'int',
			'default' => '0',
		),
		'deleted' => array(
			'name' => 'deleted',
			'type' => 'bool',
			'len' => '1',
			'default' => '0',
			'required' => false,
		)
	),
	'indices' => array(
		array(
			'name' => 'session_historypk',
			'type' => 'primary',
			'fields' => array('id'),
		),
	)
)

?>
