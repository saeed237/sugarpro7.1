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
$dictionary['ForecastManagerWorksheet'] = array(
    'table' => 'forecast_manager_worksheets',
    'audited' => true,
    'fields' => array(
        'quota' =>
        array(
            'name' => 'quota',
            'vname' => 'LBL_QUOTA',
            'type' => 'currency',
        ),
        'best_case' =>
        array(
            'name' => 'best_case',
            'vname' => 'LBL_BEST',
            'type' => 'currency',
            'audited' => true,
        ),
        'best_case_adjusted' =>
        array(
            'name' => 'best_case_adjusted',
            'vname' => 'LBL_BEST_ADJUSTED',
            'type' => 'currency',
        ),
        'likely_case' =>
        array(
            'name' => 'likely_case',
            'vname' => 'LBL_LIKELY',
            'type' => 'currency',
            'audited' => true,
        ),
        'likely_case_adjusted' =>
        array(
            'name' => 'likely_case_adjusted',
            'vname' => 'LBL_LIKELY_ADJUSTED',
            'type' => 'currency',
        ),
        'worst_case' =>
        array(
            'name' => 'worst_case',
            'vname' => 'LBL_WORST',
            'type' => 'currency',
            'audited' => true,
        ),
        'worst_case_adjusted' =>
        array(
            'name' => 'worst_case_adjusted',
            'vname' => 'LBL_WORST_ADJUSTED',
            'type' => 'currency',
        ),
        'currency_id' =>
        array(
            'name' => 'currency_id',
            'vname' => 'LBL_CURRENCY_ID',
            'type' => 'currency_id',
            'dbType' => 'id',
        ),
        'base_rate' =>
        array(
            'name' => 'base_rate',
            'vname' => 'LBL_BASE_RATE',
            'type' => 'decimal',
            'len' => '26,6',
        ),
        'timeperiod_id' =>
        array(
            'name' => 'timeperiod_id',
            'vname' => 'LBL_FORECAST_TIME_ID',
            'type' => 'id',
        ),
        'draft' =>
        array(
            'name' => 'draft',
            'vname' => 'LBL_DRAFT',
            'type' => 'bool',
        ),
        'isManager' =>
        array(
            'name' => 'isManager',
            'type' => 'bool',
            'source' => 'non-db',
            'comment' => 'needed for commitLog field logic'
        ),
        'user_id' =>
        array(
            'name' => 'user_id',
            'vname' => 'LBL_FS_USER_ID',
            'type' => 'id',
        ),
        'opp_count' =>
        array(
            'name' => 'opp_count',
            'vname' => 'LBL_FORECAST_OPP_COUNT',
            'type' => 'int',
            'len' => '5',
            'comment' => 'Number of opportunities represented by this forecast',
        ),
        'pipeline_opp_count' =>
        array(
            'name' => 'pipeline_opp_count',
            'vname' => 'LBL_FORECAST_OPP_COUNT',
            'type' => 'int',
            'len' => '5',
            'studio' => false,
            'default' => '0',
            'comment' => 'Number of opportunities minus closed won/closed lost represented by this forecast',
        ),
        'pipeline_amount' =>
        array(
            'name' => 'pipeline_amount',
            'vname' => 'LBL_PIPELINE_REVENUE',
            'type' => 'currency',
            'studio' => false,
            'default' => '0',
            'comment' => 'Total of opportunities minus closed won/closed lost represented by this forecast',
        ),
        'closed_amount' =>
        array(
            'name' => 'closed_amount',
            'vname' => 'LBL_CLOSED',
            'type' => 'currency',
            'studio' => false,
            'default' => "0",
            'comment' => 'Total of closed won items in the forecast',
        ),
        'show_history_log' =>
        array(
            'name' => 'show_history_log',
            'type' => 'int',
            'source' => 'non-db'
        ),
        'draft_save_type' =>
        array(
            'name' => 'draft_save_type',
            'type' => 'varchar',
            'source' => 'non-db'
        ),
    ),
    'relationships' => array(// relationships that might be needed: User_id -> users, quota_id -> Quota,
    ),
    'indices' => array(
        array(
            'name' => 'idx_manager_worksheets_user_timestamp_assigned_user',
            'type' => 'index',
            'fields' => array('assigned_user_id', 'user_id', 'timeperiod_id', 'draft', 'deleted')
        )
    )
);

VardefManager::createVardef(
    'ForecastManagerWorksheets',
    'ForecastManagerWorksheet',
    array(
        'default',
        'assignable',
        'team_security',
    )
);
