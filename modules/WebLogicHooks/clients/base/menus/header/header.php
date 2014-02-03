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
$module_name = 'WebLogicHooks';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route' => '#'.$module_name.'/create',
        'label' => 'LNK_NEW_LOGIC_HOOK',
        'acl_action' => 'create',
        'acl_module' => $module_name,
        'icon' => 'icon-plus',
    ),
    array(
        'route' => '#'.$module_name,
        'label' => 'LNK_LOGIC_HOOK_LIST',
        'acl_action' => 'list',
        'acl_module' => $module_name,
        'icon' => 'icon-reorder',
    ),
);
