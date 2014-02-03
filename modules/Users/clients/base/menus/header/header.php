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

$moduleName = 'Users';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
            )
        ),
        'label' => 'LNK_NEW_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => '',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
                'usertype'=>'group',
                'return_module' => $moduleName,
                'return_action' => 'DetailView',
            )
        ),
        'label' => 'LNK_NEW_GROUP_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => '',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'EditView',
                'usertype'=>'portal',
                'return_module' => $moduleName,
                'return_action' => 'DetailView',
            )
        ),
        'label' => 'LNK_NEW_PORTAL_USER',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => '',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $moduleName,
                'action' => 'reassignUserRecords',
            )
        ),
        'label' => 'LNK_REASSIGN_RECORDS',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => '',
    ),
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => 'Import',
                'action' => 'Step1',
                'import_module' => $moduleName,
                'return_module' => $moduleName,
                'return_action' => 'index',
            )
        ),
        'label' => 'LNK_IMPORT_USERS',
        'acl_action' => 'admin',
        'acl_module' => $moduleName,
        'icon' => 'icon-upload',
    ),
);
