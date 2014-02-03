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


$dictionary['activities_users'] = array(
    'table' => 'activities_users',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
            'len' => 36,
            'required' => true,
        ),

        'activity_id' => array(
            'name' => 'activity_id',
            'type' => 'id',
            'len' => 36,
            'required' => true,
        ),

        'parent_type' => array(
            'name' => 'parent_type',
            'type' => 'varchar',
            'len'  => 100,
        ),

        'parent_id' => array(
            'name'     => 'parent_id',
            'type'     => 'id',
            'len'      => 36,
        ),

        'fields' => array(
            'name' => 'fields',
            'type' => 'json',
            'dbType' => 'longtext',
            'required' => true,
        ),

        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),

        'deleted' => array (
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'default' => '0',
        ),
    ),
    'indices' => array(
        array(
            'name' => 'activities_users_pk',
            'type' => 'primary',
            'fields' => array('id'),
        ),
        array(
            'name' => 'activities_records',
            'type' => 'index',
            'fields' => array('parent_type', 'parent_id'),
        ),
        array(
            'name' => 'activities_users_parent',
            'type' => 'index',
            'fields' => array('activity_id', 'parent_id', 'parent_type'),
        ),
    ),

    'relationships' => array(
        'activities_users' => array(
            'lhs_module' => 'Activities',
            'lhs_table' => 'activities',
            'lhs_key' => 'id',
            'rhs_module' => 'Users',
            'rhs_table' => 'users',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'activities_users',
            'join_key_lhs' => 'activity_id',
            'join_key_rhs' => 'parent_id',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Users'
        ),
        'activities_teams' => array(
            'lhs_module' => 'Activities',
            'lhs_table' => 'activities',
            'lhs_key' => 'id',
            'rhs_module' => 'Teams',
            'rhs_table' => 'teams',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'activities_users',
            'join_key_lhs' => 'activity_id',
            'join_key_rhs' => 'parent_id',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'Teams'
        ),
    )
);
