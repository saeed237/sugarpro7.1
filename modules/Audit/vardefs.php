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

$dictionary['Audit'] = array('fields' =>
array(
    'parent_id' => array(
        'name' => 'parent_id',
        'type' => 'id',
        'source' => 'non-db',
    ),
    'date_created' => array(
        'name' => 'date_created',
        'type' => 'datetime',
        'source' => 'non-db',
    ),
    'created_by' => array(
        'name' => 'created_by',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'created_by_username' => array(
        'name' => 'created_by_username',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'field_name' => array(
        'name' => 'field_name',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'data_type' => array(
        'name' => 'data_type',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'before_value_string' => array(
        'name' => 'before_value_string',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'after_value_string' => array(
        'name' => 'after_value_string',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'before' => array(
        'name' => 'before',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'after' => array(
        'name' => 'after',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
    'data_type' => array(
        'name' => 'data_type',
        'type' => 'varchar',
        'source' => 'non-db',
    ),
));
