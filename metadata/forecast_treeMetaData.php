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


$dictionary['forecast_tree'] = array(
	'table' => 'forecast_tree',
	'fields' => array(
		array(
			'name'			=> 'id',
			'type'			=> 'id',
			'required'		=> true,
		),
		array(
			'name'			=> 'name',
			'type'			=> 'varchar',
			'len'			=> 50,
			'required'		=> true,
		),
		array(
			'name'			=> 'hierarchy_type',
			'type'			=> 'varchar',
			'len'			=> 25,
			'required'      => true,
		),
		array(
			'name'			=> 'user_id',
			'type'			=> 'id',
            'default'       => NULL,
			'required'		=> false,
		),
        array(
      	    'name'			=> 'parent_id',
      		'type'			=> 'id',
            'default'       => NULL,
      		'required'		=> false,
      		),
	),
	'indices' => array(
		array(
			'name'			=> 'forecast_tree_pk',
			'type'			=> 'primary',
			'fields'		=> array('id')
		),
		array(
			'name'			=> 'forecast_tree_idx_user_id',
			'type'			=> 'index',
			'fields'		=> array('user_id')
		),
	),
);
