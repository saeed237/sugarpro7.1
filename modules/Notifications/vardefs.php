<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$dictionary['Notifications'] = array(
    'table' => 'notifications',
    'audited' => true,
    'fields' => array(
        'is_read' => array(
            'required' => false,
            'name' => 'is_read',
            'vname' => 'LBL_IS_READ',
            'type' => 'bool',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => 0,
            'default' => 0,
            'reportable' => 1,
        ),
        'severity' => array(
            'len' => 15,
            'name' => 'severity',
            'options' => 'notifications_severity_list',
            'required' => true,
            'type' => 'enum',
            'vname' => 'LBL_SEVERITY',
        ),
    ),
    'relationships' => array(),
    'optimistic_lock' => true,
);

require_once 'include/SugarObjects/VardefManager.php';
VardefManager::createVardef('Notifications', 'Notifications', array('basic', 'assignable'));
