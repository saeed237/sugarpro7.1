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

$viewdefs['Forecasts']['base']['view']['forecastsConfigScenarios'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_SCENARIOS',
            'fields' => array(
                array(
                    'name' => 'show_worksheet_likely',
                    'type' => 'bool',
                    'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_LIKELY',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'detail',
                ),
                array(
                    'name' => 'show_worksheet_best',
                    'type' => 'bool',
                    'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_BEST',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsWorksheet',
                ),
                array(
                    'name' => 'show_worksheet_worst',
                    'type' => 'bool',
                    'label' => 'LBL_FORECASTS_CONFIG_WORKSHEET_SCENARIOS_WORST',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsWorksheet',
                ),
            ),
        ),
        //TODO-sfa - this will be revisited in a future sprint and determined whether it should go in 6.7, 6.8 or later
    ),
);
