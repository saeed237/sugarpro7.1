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

$viewdefs['Forecasts']['base']['view']['forecastsConfigVariables'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_FORECASTS_CONFIG_BREADCRUMB_VARIABLES',
            'fields' => array(
                array(
                    'name' => 'sales_stage_lost',
                    'label' => 'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_LOST_STAGE',
                    'type' => 'enum',
                    'multi' => true,
                    'options' => 'sales_stage_dom',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsFilter',
                ),
                array(
                    'name' => 'sales_stage_won',
                    'label' => 'LBL_FORECASTS_CONFIG_VARIABLES_CLOSED_WON_STAGE',
                    'type' => 'enum',
                    'multi' => true,
                    'options' => 'sales_stage_dom',
                    'default' => false,
                    'enabled' => true,
                    'view' => 'forecastsFilter',
                ),
            ),
        ),
    ),
);
