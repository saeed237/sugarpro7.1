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
$viewdefs['Emails']['base']['view']['compose-addressbook-list'] = array(
    'template'   => 'list',
    'selection'  => array(
        'type'                     => 'multi',
        'actions'                  => array(),
        'disable_select_all_alert' => true,
    ),
    'panels'     => array(
        array(
            'fields' => array(
                array(
                    'name'    => 'name',
                    'label'   => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name'     => 'email',
                    'label'    => 'LBL_LIST_EMAIL',
                    'type'     => 'email',
                    'sortable' => true,
                    'enabled'  => true,
                    'default'  => true,
                ),
                array(
                    'name'     => '_module',
                    'label'    => 'LBL_MODULE',
                    'sortable' => false,
                    'enabled'  => true,
                    'default'  => true,
                ),
            ),
        ),
    ),
    'rowactions' => array(
        'css_class' => 'pull-right',
        'actions'   => array(
            array(
                'type'       => 'rowaction',
                'css_class'  => 'btn',
                'tooltip'    => 'LBL_PREVIEW',
                'event'      => 'list:preview:fire',
                'icon'       => 'icon-eye-open',
                'acl_action' => 'view',
            ),
        ),
    ),
);
