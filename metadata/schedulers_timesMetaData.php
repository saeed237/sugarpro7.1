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


$dictionary['SchedulersTimes'] = array('table' => 'schedulers_times',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_NAME',
			'type' => 'id',
			'len' => '36',
			'required' => true,
			'reportable'=>false,
		),
		'deleted' => array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => false,
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
		'scheduler_id' => array (
			'name' => 'scheduler_id',
			'vname' => 'LBL_SCHEDULER_ID',
			'type' => 'id',
			'dbType' => 'id',
		    'len' => '36',
			'required' => true,
		    'isnull' => false,
			'reportable' => false,
		),
		'execute_time' => array (
			'name' => 'execute_time',
			'vname' => 'LBL_EXECUTE_TIME',
			'type' => 'datetime',
			'required' => true,
			'reportable' => true,
		),
		'status' => array (
			'name' => 'status',
			'vname' => 'LBL_STATUS',
			'type' => 'varchar',
			'len' => '25',
			'required' => true,
			'reportable' => true,
			'default' => 'ready',
		),
	),
	'indices' => array (
		array(
			'name' =>'schedulers_timespk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
		'name' =>'idx_scheduler_id',
		'type'=>'index',
		'fields' => array(
			'scheduler_id',
			'execute_time',
			)
		),
	),
);


?>
