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
$dictionary['WebLogicHook'] = array(
    'table' => 'weblogichooks',
    'favorites'=>false,
    'comment' => 'Web Logic Hooks',
    'audited' => false,
    'activity_enabled'=>false,
    'unified_search' => false,
    'unified_search_default_enabled' => false,
    'full_text_search' => false,
    'optimistic_locking' => true,
    'fields' => array(
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => '255',
            'comment' => 'Hook name',
            'required' => true,
        ),
        'module_name' => array(
            'name' => 'module_name',
            'vname' => 'LBL_TARGET_NAME',
            'type' => 'enum',
            'options' => 'moduleList',
            'required' => true,
        ),
        'request_method' => array(
            'name' => 'request_method',
            'vname' => 'LBL_REQUEST_METHOD',
            'type' => 'enum',
            'options' => 'web_hook_request_method_list',
            'default' => 'POST',
            'required' => true,
        ),
        'url' => array(
            'name' => 'url',
            'vname' => 'LBL_URL',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'URL of website for the company',
            'required' => true,
        ),
        'trigger_event' => array(
            'name' => 'trigger_event',
            'vname' => 'LBL_TRIGGER_EVENT',
            'type' => 'enum',
            'options' => 'webLogicHookList',
            'required' => true,
        ),
    ),
    'acls' => array(
        'SugarACLAdminOnly' => array(
            'adminFor' => 'Users',
        ),
    ),
);

VardefManager::createVardef(
    'WebLogicHooks',
    'WebLogicHook',
    array(
        'default',
        'basic',
    )
);
