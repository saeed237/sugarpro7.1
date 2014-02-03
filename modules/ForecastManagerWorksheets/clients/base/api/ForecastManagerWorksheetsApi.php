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

class ForecastManagerWorksheetsApi extends SugarApi
{
    public function registerApiRest()
    {
        //Extend with test method
        return array(
            'forecastManagerWorksheetAssignQuota' => array(
                'reqType' => 'POST',
                'path' => array('ForecastManagerWorksheets', 'assignQuota'),
                'pathVars' => array('module', 'action'),
                'method' => 'assignQuota',
                'shortHelp' => 'Assign the Quota for Users with out actually committing',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastWorksheetManagerAssignQuota.html',
            )
        );
    }

    /**
     * Run the assign Quota Code.
     *
     * @param ServiceBase $api          API Service
     * @param array $args               Args from the XHR Call
     * @return array
     */
    public function assignQuota(ServiceBase $api, $args = array())
    {
        /* @var $mgr_worksheet ForecastManagerWorksheet */
        $mgr_worksheet = BeanFactory::getBean($args['module']);
        $ret = $mgr_worksheet->assignQuota($args['user_id'], $args['timeperiod_id']);
        return array('success' => $ret);
    }
}
