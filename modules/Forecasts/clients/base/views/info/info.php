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

$viewdefs['Forecasts']['base']['view']['info'] = array(
    'type' => 'info',
    'timeperiod' => array(
        array(
            'name' => 'selectedTimePeriod',
            'label' => 'LBL_TIMEPERIOD_NAME',
            'type' => 'enum',
            'css_class' => 'forecastsTimeperiod',
            'dropdown_class' => 'topline-timeperiod-dropdown',
            'dropdown_width' => 'auto',
            'view' => 'edit',
            // options are set dynamically in the view
            'default' => true,
            'enabled' => true,
        ),
    ),
    'last_commit' => array(
        array(
            'name' => 'lastCommitDate',
            'type' => 'lastcommit',
            'datapoints' => array(
                'worst_case',
                'likely_case',
                'best_case'
            )
        )
    ),
    'commitlog' => array(
        array(
            'name' => 'commitLog',
            'type' => 'commitlog',
        )
    ),
    'datapoints' => array(
        array(
            'name' => 'quota',
            'label' => 'LBL_QUOTA',
            'type' => 'quotapoint'
        ),
        array(
            'name' => 'worst_case',
            'label' => 'LBL_WORST',
            'type' => 'datapoint'
        ),
        array(
            'name' => 'likely_case',
            'label' => 'LBL_LIKELY',
            'type' => 'datapoint'
        ),
        array(
            'name' => 'best_case',
            'label' => 'LBL_BEST',
            'type' => 'datapoint'
        )
    ),
);
