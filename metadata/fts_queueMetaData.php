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


$dictionary['fts_queue'] = array('table' => 'fts_queue',
	'fields' => array(
		array(
			'name'		=> 'bean_id',
			'dbType'	=> 'id',
			'type'		=> 'varchar',
			'len'		=> '36',
			'comment' 	=> 'FK to various beans\'s tables',
		),
		array(
			'name'		=> 'bean_module',
			'type'		=> 'varchar',
			'len'		=> '100',
			'comment' 	=> 'bean\'s Module',
		),
		array(
			'name'		=> 'date_modified',
			'type'		=>	'datetime'
		),
		array(
			'name'		=> 'processed',
			'type'		=> 'bool',
			'len'		=> '1',
			'default'	=> '0',
			'required'	=> false
		)
	),
	'indices' => array(
		array(
			'name'		=> 'idx_beans_bean_id',
			'type'		=> 'index',
			'fields'	=> array('bean_module','bean_id')
		),
	),
	'relationships' => array()
);