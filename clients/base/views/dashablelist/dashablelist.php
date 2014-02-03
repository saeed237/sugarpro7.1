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
$viewdefs['base']['view']['dashablelist'] = array(
    'template' => 'list',
    'dashlets' => array(
        array(
            'name'        => 'LBL_DASHLET_LISTVIEW_NAME',
            'description' => 'LBL_DASHLET_LISTVIEW_DESCRIPTION',
            'config'      => array(),
            'preview' => array(
                'module'          => 'Accounts',
                'label'           => 'LBL_MODULE_NAME',
                'display_columns' => array(
                    'name',
                    'phone_office',
                    'billing_address_country',
                ),
                // my_items is defaulted '1' which may result in no records being found
                // so make it '0' for preview to nearly guarantee that records will be shown in the sample
                'my_items'        => '0',
            ),
        ),
    ),
    'panels'   => array(
        array(
            'name'         => 'dashlet_settings',
            'columns'      => 2,
            'labelsOnTop'  => true,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'name'    => 'module',
                    'label'   => 'LBL_MODULE',
                    'type'    => 'enum',
                    'span'    => 12,
                ),
                array(
                    'name'          => 'display_columns',
                    'label'         => 'LBL_COLUMNS',
                    'type'          => 'enum',
                    'isMultiSelect' => true,
                    'ordered'       => true,
                    'span'          => 12,
                    'hasBlank'      => true,
                    'options'       => array('' => ''),
                ),
                array(
                    'name'    => 'limit',
                    'label'   => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                    'type'    => 'enum',
                    'options' => 'dashlet_limit_options',
                ),
                array(
                    'name'    => 'auto_refresh',
                    'label'   => 'Auto Refresh',
                    'type'    => 'enum',
                    'options' => 'sugar7_dashlet_auto_refresh_options',
                ),
                array(
                    'name'    => 'my_items',
                    'label'   => 'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY',
                    'type'    => 'enum',
                    'options' => 'list_visibility_options',
                ),
                array(
                    'name'    => 'favorites',
                    'label'   => 'LBL_DASHLET_CONFIGURE_MY_FAVORITES_ONLY',
                    'type'    => 'enum',
                    'options' => 'list_visibility_options',
                ),
            ),
        ),
    ),
);
