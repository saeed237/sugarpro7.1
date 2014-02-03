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

$moduleName = 'Accounts';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'label' =>'LNK_NEW_ACCOUNT',
        'acl_action'=>'create',
        'acl_module'=>$moduleName,
        'icon' => 'icon-plus',
        'route'=>'#'.$moduleName.'/create',
    ),
    array(
        'route'=>'#'.$moduleName,
        'label' =>'LNK_ACCOUNT_LIST',
        'acl_action'=>'list',
        'acl_module'=>$moduleName,
        'icon' => 'icon-reorder',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Reports',
                'action' => 'index',
                'view' => $moduleName,
                'query' => 'true',
                'report_module' => $moduleName,
            )
        ),
        'label' =>'LNK_ACCOUNT_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$moduleName,
        'icon' => 'icon-bar-chart',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Import',
                'action' => 'Step1',
                'import_module' => $moduleName,
            )
        ),
        'label' =>'LNK_IMPORT_ACCOUNTS',
        'acl_action'=>'import',
        'acl_module'=>$moduleName,
        'icon' => 'icon-upload',
    ),
);
