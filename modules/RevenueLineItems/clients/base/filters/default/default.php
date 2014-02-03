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
$viewdefs['RevenueLineItems']['base']['filter']['default'] = array(
    'default_filter' => 'all_records',
    'fields' => array(
        'name' => array(),
        'opportunity_name' => array(
            'dbFields' => array(
                'opportunities.name',
            ),
            'type' => 'text',
            'vname' => 'LBL_OPPORTUNITY_NAME',
        ),
        'account_name' => array(
            'dbFields' => array(
                'account_link.name',
            ),
            'type' => 'text',
            'vname' => 'LBL_ACCOUNT_NAME',
        ),
        'sales_stage' => array(),
        'probability' => array(),
        'date_closed' => array(),
        'commit_stage' => array(),
        'product_template_name' => array(
            'dbFields' => array(
                'revenuelineitem_templates_link.name'
            ),
            'type' => 'text',
            'vname' => 'LBL_PRODUCT'
        ),
        'category_name' => array(
            'dbFields' => array(
                'revenuelineitem_categories_link.name'
            ),
            'type' => 'text',
            'vname' => 'LBL_CATEGORY_NAME'
        ),
        'worst_case' => array(),
        'likely_case' => array(),
        'best_case' => array(),
        'date_entered' => array(),
        'date_modified' => array(),
        '$owner' => array(
            'predefined_filter' => true,
            'vname' => 'LBL_CURRENT_USER_FILTER',
        ),
        'assigned_user_name' => array(),
        '$favorite' => array(
            'predefined_filter' => true,
            'vname' => 'LBL_FAVORITES_FILTER',
        ),

    ),
);
