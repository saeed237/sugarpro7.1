<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (\“MSA\”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$viewdefs['Quotes']['base']['view']['subpanel-list'] = array(
    'panels' =>
    array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'label' => 'LBL_LIST_QUOTE_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'name',
                    'link' => true,
                ),
                array(
                    'target_record_key' => 'account_id',
                    'target_module' => 'Accounts',
                    'label' => 'LBL_LIST_ACCOUNT_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'account_name',
                    'sortable' => false,
                ),
                array(
                    'label' => 'LBL_LIST_AMOUNT_USDOLLAR',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'total_usdollar',
                ),
                array(
                    'name' => 'date_quote_expected_closed',
                    'label' => 'LBL_LIST_DATE_QUOTE_EXPECTED_CLOSED',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'target_record_key' => 'assigned_user_id',
                    'target_module' => 'Employees',
                    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                ),
            ),
        ),
    ),
);
