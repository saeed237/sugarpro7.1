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

$moduleName = 'Calls';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
            )
        ),
        'label' => 'LNK_NEW_CALL',
        'acl_action' => 'create',
        'acl_module' => $moduleName,
        'icon' => 'icon-plus',
    ),
    array(
        'route' => '#' . $moduleName,
        'label' => 'LNK_CALL_LIST',
        'acl_action' => 'list',
        'acl_module' => $moduleName,
        'icon' => 'icon-reorder',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Import',
                'action' => 'Step1',
                'import_module' => $moduleName,
                'query' => 'true',
                'report_module' => $moduleName,
            )
        ),
        'label' => 'LNK_IMPORT_CALLS',
        'acl_action' => 'import',
        'acl_module' => $moduleName,
        'icon' => 'icon-upload',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Reports',
                'action' => 'index',
                'view' => $moduleName,
            )
        ),
        'label' => 'LBL_ACTIVITIES_REPORTS',
        'acl_action' => 'list',
        'acl_module' => 'Reports',
        'icon' => 'icon-bar-chart',
    ),
);
