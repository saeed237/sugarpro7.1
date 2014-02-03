<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('clients/base/api/ModuleApi.php');

class ForecastsModuleApi extends ModuleApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('Forecasts'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_new_help.html',
            ),
        );
    }

    public function createRecord(ServiceBase $api, array $args)
    {
        if (!SugarACL::checkAccess('Forecasts', 'edit')) {
            throw new SugarApiExceptionNotAuthorized('No access to edit records for module: Forecasts');
        }

        $obj = $this->getClass($args);
        return $obj->save();
    }

    /**
     * Get the Committed Class
     *
     * @param array $args
     * @return SugarForecasting_Committed
     */
    protected function getClass($args)
    {
        // base file and class name
        $file = 'include/SugarForecasting/Committed.php';
        $klass = 'SugarForecasting_Committed';

        // check for a custom file exists
        SugarAutoLoader::requireWithCustom($file);
        $klass = SugarAutoLoader::customClass($klass);
        // create the class

        /* @var $obj SugarForecasting_AbstractForecast */
        $obj = new $klass($args);

        return $obj;
    }
}
