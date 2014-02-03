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

$viewdefs['Forecasts']['base']['view']['forecastsConfigForecastBy'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_WORKSHEET_LAYOUT',
            'fields' => array(
                array(
                    'name' =>'forecast_by',
                    'type' => 'radioenum',
                    'label' => '',
                    'view' => 'edit',
                    'options' => 'forecasts_config_worksheet_layout_forecast_by_options_dom',
                    'default' => false,
                    'enabled' => true,
                ),
            ),
        ),
    ),
);
