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


require_once('include/api/SugarApi.php');

class ForecastsChartApi extends SugarApi
{
    /**
     * Rest Api Registration Method
     *
     * @return array
     */
    public function registerApiRest()
    {
        $parentApi = array(
            'forecasts_chart' => array(
                'reqType' => 'GET',
                'path' => array('Forecasts', '?', '?', 'chart', '?'),
                'pathVars' => array('', 'timeperiod_id', 'user_id', '', 'display_manager'),
                'method' => 'chart',
                'shortHelp' => 'Retrieve the Chart data for the given data in the Forecast Module',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastChartApi.html',
            ),
        );
        return $parentApi;
    }

    /**
     * Build out the chart for the sales rep view in the forecast module
     *
     * @param ServiceBase $api      The Api Class
     * @param array $args           Service Call Arguments
     * @return mixed
     */
    public function chart($api, $args)
    {
        $args['timeperiod_id'] = clean_string($args['timeperiod_id']);
        $args['user_id'] = clean_string($args['user_id']);
        $args['group_by'] = !isset($args['group_by']) ? "forecast" : $args['group_by'];

        // default to the Individual Code
        $file = 'include/SugarForecasting/Chart/Individual.php';
        $klass = 'SugarForecasting_Chart_Individual';

        // test to see if we need to display the manager
        if((bool)$args['display_manager'] && User::isManager($api->user->id)) {
            // we have a manager view, pull in the manager classes
            $file = 'include/SugarForecasting/Chart/Manager.php';
            $klass = 'SugarForecasting_Chart_Manager';
        }

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_Chart_AbstractChart */
        $obj = new $klass($args);
        return $obj->process();
    }
}
