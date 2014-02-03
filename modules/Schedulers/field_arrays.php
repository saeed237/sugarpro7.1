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

$fields_array['Scheduler'] = array (
	'column_fields' => array(
		'id',
		'deleted',
		'date_entered',
		'date_modified',
		'modified_user_id',
		'created_by',
		'name',
		'job',
		'date_time_start',
		'date_time_end',
		'job_interval',
		'time_from',
		'time_to',
		'last_run',
		'status',
		'catch_up',
	),
	'list_fields' => array(
		'id',
		'name',
		'list_order',
		'status'
	),
	'required_fields' => array(
		'name' => 1,
		'list_order' => 1,
		'status' => 1
	),
);

$fields_array['Job'] = array (
	'column_fields' => array (
		'id',
		'deleted',
		'date_entered',
		'date_modified',
		'job_id',
		'execute_time',
		'status',
	),
	'list_fields' => array (
		'id',
		'job_id',
		'execute_time'
	),
	'required_fields' => array (
		'job_id' => 1,
		'execute_time' => 1
	)
);
?>
