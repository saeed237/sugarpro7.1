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
$viewdefs['Forecasts']['base']['view']['forecasts-chart'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_DASHLET_FORECASTS_CHART',
            'description' => 'LBL_DASHLET_FORECASTS_DESC',
            'config' => array(),
            'preview' => array(),
            'filter' => array(
                'module' => array(
                    'Forecasts'
                )
            )
        )
    ),
    'chart' => array(
        'name' => 'paretoChart',
        'label' => 'Pareto Chart',
        'type' => 'forecast-pareto-chart',
    ),
    'timeperiod' => array(
        array(
            'name' => 'selectedTimePeriod',
            'label' => 'TimePeriod',
            'type' => 'enum',
            'default' => true,
            'enabled' => true,
            'view' => 'edit',
        ),
    ),
    'group_by' => array(
        'name' => 'group_by',
        'label' => 'LBL_DASHLET_FORECASTS_GROUPBY',
        'type' => 'enum',
        'searchBarThreshold' => 5,
        'default' => true,
        'enabled' => true,
        'view' => 'edit',
        'options' => 'forecasts_chart_options_group'
    ),
    'dataset' => array(
        'name' => 'dataset',
        'label' => 'LBL_DASHLET_FORECASTS_DATASET',
        'type' => 'enum',
        'searchBarThreshold' => 5,
        'default' => true,
        'enabled' => true,
        'view' => 'edit',
        'options' => 'forecasts_options_dataset'
    )
);
