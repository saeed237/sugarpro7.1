<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/

// PRO/CORP only fields
$fields = array(
    // Default enabled columns
    array(
        'name' => 'commit_stage',
        'label' => 'LBL_FORECASTS_CONFIG_TITLE_RANGES',
        'locked' => true
    ),
    array(
        'name' => 'parent_name',
        'label' => 'LBL_NAME',
        'label_module' => 'Opportunities',
        'locked' => true
    ),
    array(
        'name' => 'account_name',
        'label' => 'LBL_LIST_ACCOUNT_NAME',
        'label_module' => 'RevenueLineItems'
    ),
    array(
        'name' => 'date_closed',
        'label' => 'LBL_DATE_CLOSED',
        'label_module' => 'RevenueLineItems'
    ),
    array(
        'name' => 'sales_stage',
        'label' => 'LBL_SALES_STAGE',
        'label_module' => 'Products'
    ),
    array(
        'name' => 'probability',
        'label' => 'LBL_OW_PROBABILITY',
    ),
    array(
        'name' => 'worst_case',
        'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST',
        'locked' => true
    ),
    array(
        'name' => 'likely_case',
        'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY',
        'locked' => true
    ),
    array(
        'name' => 'best_case',
        'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST',
        'locked' => true
    ),

    // Non-default-enabled columns
    array(
        'name' => 'product_type',
        'label' => 'LBL_TYPE',
        'label_module' => 'RevenueLineItems'
    ),
    array(
        'name' => 'lead_source',
        'label' => 'LBL_LEAD_SOURCE',
        'label_module' => 'Contacts'
    ),
    array(
        'name' => 'campaign_name',
        'label' => 'LBL_CAMPAIGN'
    ),
    array(
        'name' => 'assigned_user_name',
        'label' => 'LBL_ASSIGNED_TO_NAME',
    ),
    array(
        'name' => 'team_name',
        'label' => 'LBL_TEAMS'
    ),
    array(
        'name' => 'next_step',
        'label' => 'LBL_NEXT_STEP',
        'label_module' => 'RevenueLineItems'
    ),
    array(
        'name' => 'description',
        'label' => 'LBL_DESCRIPTION',
        'label_module' => 'RevenueLineItems'
    ),
);



$viewdefs['Forecasts']['base']['view']['forecastsConfigWorksheetColumns'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_RANGES',
            'fields' => $fields,
        )
    )
);
