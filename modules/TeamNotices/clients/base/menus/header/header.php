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

$moduleName = 'TeamNotices';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => "#bwc/index.php?module=Teams&action=EditView&return_module=Teams&return_action=index",
        'label' => 'LNK_NEW_TEAM',
        'acl_action' => 'create',
        'acl_module' => 'Teams',
        'icon' => 'icon-plus',
    ),
    array(
        'route' => '#Teams',
        'label' => 'LNK_LIST_TEAM',
        'acl_action' => 'list',
        'acl_module' => 'Teams',
        'icon' => 'icon-reorder',
    ),
    array(
        'route' => "#bwc/index.php?module=$moduleName&action=EditView",
        'label' => 'LNK_NEW_TEAM_NOTICE',
        'acl_action' => 'create',
        'acl_module' => 'TeamNotices',
        'icon' => 'icon-plus',
    ),
    array(
        'route' => "#bwc/index.php?module=$moduleName&action=index",
        'label' => 'LNK_LIST_TEAMNOTICE',
        'acl_action' => '',
        'acl_module' => '',
        'icon' => 'icon-reorder',
    ),
);
