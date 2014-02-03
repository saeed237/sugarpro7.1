<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
class TimePeriodsCurrentApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'currentTimeperiod' => array(
                'reqType' => 'GET',
                'path' => array('TimePeriods', 'current'),
                'pathVars' => array('module', ''),
                'method' => 'getCurrentTimePeriod',
                'jsonParams' => array(),
                'shortHelp' => 'Return the Current Timeperiod',
                'longHelp' => 'modules/TimePeriods/clients/base/api/help/TimePeriodsCurrentApi.html',
            ),
            'getTimePeriodByDate' => array(
                'reqType' => 'GET',
                'path' => array('TimePeriods', '?'),
                'pathVars' => array('module', 'date'),
                'method' => 'getTimePeriodByDate',
                'jsonParams' => array(),
                'shortHelp' => 'Return a Timeperiod by a given date',
                'longHelp' => 'modules/TimePeriods/clients/base/api/help/TimePeriodsGetByDateApi.html',
            ),
        );
    }

    public function getCurrentTimePeriod(ServiceBase $api, $args)
    {
        $tp = TimePeriod::getCurrentTimePeriod();

        if(is_null($tp)) {
            // return a 404
            throw new SugarApiExceptionNotFound();
        }

        return $tp->toArray();
    }

    public function getTimePeriodByDate(ServiceBase $api, $args)
    {
        if(!isset($args["date"]) || $args["date"] == 'undefined') {
            // return a 404
            throw new SugarApiExceptionNotFound();
        }

        $tp = TimePeriod::retrieveFromDate($args["date"]);

        return ($tp) ? $tp->toArray() : $tp;
    }
}
