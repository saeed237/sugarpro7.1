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

require_once('include/api/SugarApi.php');

class ForecastWorksheetsApi extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'forecastWorksheetSave' => array(
                'reqType' => 'PUT',
                'path' => array('ForecastWorksheets', '?'),
                'pathVars' => array('module', 'record'),
                'method' => 'forecastWorksheetSave',
                'shortHelp' => 'Updates a ForecastWorksheet model',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastWorksheetPut.html',
            ),
            'commitstage' => array(
                'reqType' => 'GET',
                'path' => array('ForecastWorksheets', 'enum', 'commit_stage'),
                'pathVars' => array('', '', ''),
                'method' => 'commitStage',
                'shortHelp' => 'Returns commit stages array per config settings',
                'longHelp' => 'modules/ForecastWorksheets/clients/base/api/help/ForecastWorksheetsApiCommitStage.html',
            ),
        );
    }

    /**
     * Retrieves the commit_stage dropdown items based on the setting in the forecasts config
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return array
     */
    public function commitStage($api, $args)
    {
        global $app_list_strings;

        $adminBean = BeanFactory::getBean('Administration');
        $config = $adminBean->getConfigForModule('Forecasts', $api->platform);
        return $app_list_strings[$config['buckets_dom']];
    }

    /**
     * This method handles saving data for the /ForecastsWorksheet REST endpoint
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return Array of worksheet data entries
     * @throws SugarApiExceptionNotAuthorized
     */
    public function forecastWorksheetSave($api, $args)
    {
        $obj = $this->getClass($args);
        $bean = $obj->save();

        return $this->formatBean($api, $args, $bean);
    }


    /**
     * @param $args
     * @return SugarForecasting_Individual
     */
    protected function getClass($args)
    {
        // base file and class name
        $file = 'include/SugarForecasting/Individual.php';
        $klass = 'SugarForecasting_Individual';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);

        return $obj;
    }
}
