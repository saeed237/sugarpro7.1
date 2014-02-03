<?php

/**
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

$moduleName = 'ACLRoles';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => "#bwc/index.php?module=$moduleName&action=EditView",
        'label' => 'LBL_CREATE_ROLE',
        'acl_module' => $moduleName,
        'acl_action' => 'edit',
        'icon' => 'icon-plus',
    ),
    array(
        'route' => "#bwc/index.php?module=$moduleName&action=index",
        'label' => 'LIST_ROLES',
        'acl_module' => $moduleName,
        'acl_action' => 'list',
        'icon' => 'icon-reorder',
    ),
    array(
        'route' => "#bwc/index.php?module=$moduleName&action=ListUsers",
        'label' => 'LIST_ROLES_BY_USER',
        'acl_module' => $moduleName,
        'acl_action' => 'list',
        'icon' => 'icon-reorder',
    ),
);
