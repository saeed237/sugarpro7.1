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

// adding user-to-holiday relationship
$dictionary['users_holidays'] = array (
    'table' => 'users_holidays',
    'fields' => array (
        array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'user_id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'holiday_id', 'type' => 'varchar', 'len' => '36'),
        array('name' => 'date_modified', 'type' => 'datetime'),
        array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
    ),
    'indices' => array (
        array('name' => 'users_holidays_pk', 'type' =>'primary', 'fields'=>array('id')),
        array('name' => 'idx_user_holi_user', 'type' =>'index', 'fields'=>array('user_id')),
        array('name' => 'idx_user_holi_holi', 'type' =>'index', 'fields'=>array('holiday_id')),
        array('name' => 'users_quotes_alt', 'type'=>'alternate_key', 'fields'=>array('user_id','holiday_id')),
    ),
    'relationships' => array (
        'users_holidays' => array(
			'lhs_module' => 'Users', 
			'lhs_table' => 'users', 
			'lhs_key' => 'id',
			'rhs_module' => 'Holidays', 
			'rhs_table' => 'holidays', 
			'rhs_key' => 'person_id',
			'relationship_type' => 'one-to-many', 
			'relationship_role_column' => 'related_module', 
			'relationship_role_column_value' => NULL,
		),
    ),
);

?>
