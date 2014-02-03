<?php
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


require_once('include/SugarForecasting/Export/AbstractExport.php');
require_once('include/SugarForecasting/Individual.php');
class SugarForecasting_Export_Individual extends SugarForecasting_Export_AbstractExport
{
    /**
     * Constructor
     *
     * @param array $args
     */
    public function __construct($args)
    {
        parent::__construct($args);
    }


    public function process()
    {
        // fetch the data from the filter end point
        $file = 'modules/ForecastWorksheets/clients/base/api/ForecastWorksheetsFilterApi.php';
        $klass = 'ForecastWorksheetsFilterApi';
        SugarAutoLoader::requireWithCustom('include/api/RestService.php');
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);

        /* @var $obj ForecastWorksheetsFilterApi */
        $obj = new $klass();

        $api = new RestService();
        $api->user = $GLOBALS['current_user'];
        $data = $obj->forecastWorksheetsGet(
            $api,
            array(
                'module' => 'ForecastWorksheets',
                'timeperiod_id' => $this->getArg('timeperiod_id'),
                'user_id' => $this->getArg('user_id')
            )
        );

        $fields_array = array(
            'date_closed' => 'date_closed',
            'sales_stage' => 'sales_stage',
            'name' => 'name',
            'commit_stage' => 'commit_stage',
            'probability' => 'probability',
        );

        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts');

        if ($settings['show_worksheet_best']) {
            $fields_array['best_case'] = 'best_case';
        }

        if ($settings['show_worksheet_likely']) {
            $fields_array['likely_case'] = 'likely_case';
        }

        if ($settings['show_worksheet_worst']) {
            $fields_array['worst_case'] = 'worst_case';
        }

        $seed = BeanFactory::getBean('ForecastWorksheets');

        return $this->getContent($data['records'], $seed, $fields_array);
    }


    /**
     * getFilename
     *
     * @return string name of the filename to export contents into
     */
    public function getFilename()
    {
        return sprintf("%s_rep_forecast.csv", parent::getFilename());
    }

}
