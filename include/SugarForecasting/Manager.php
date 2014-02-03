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


// This class is used for the Manager Views
require_once('include/SugarForecasting/AbstractForecast.php');
require_once('include/SugarForecasting/Exception.php');
class SugarForecasting_Manager extends SugarForecasting_AbstractForecast implements SugarForecasting_ForecastSaveInterface
{

    /**
     * Class Constructor
     *
     * @param array $args       Service Arguments
     */
    public function __construct($args)
    {
        // set the isManager Flag just incase we need it
        $this->isManager = true;

        parent::__construct($args);

        // set the default data timeperiod to the set timeperiod
        $this->defaultData['timeperiod_id'] = $this->getArg('timeperiod_id');
    }

    /**
     * Run all the tasks we need to process get the data back
     *
     * @deprecated @see ForecastManagerWorksheetsFilterApi
     * @return array
     */
    public function process()
    {
        return array();
    }

    /**
     * Save the Manager Worksheet, This method is deprecated and should be done though use of
     * the ForecastManagerWorksheet bean
     *
     * @deprecated
     * @return string
     */
    public function save()
    {
        return '';
    }
}
