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

$dictionary['systems'] = array (
	'table' => 'systems',
    'fields' => array (
		array(
			'name' =>'system_id',
			'type' =>'int',
			'auto_increment'=>true,
			'required'=>true
		),
		array(
			'name' =>'system_key',
			'type' =>'varchar',
			'len'=>'36'
		),
		array(
			'name' =>'user_id',
			'type' =>'id'
		),
		array(
			'name' =>'last_connect_date',
			'type' => 'datetime'
		),
		array(
			'name' =>'disabled',
			'type' =>'bool',
			'len'=>'1', 
			'default'=>'0',
		),
		array (
			'name' => 'date_entered',
			'type' => 'datetime'
		),
	),
	'indices' => array(
		array(
			'name' =>'systems_pk',
			'type' =>'primary',
			'fields'=> array('system_id')
		),
	),
);
?>
