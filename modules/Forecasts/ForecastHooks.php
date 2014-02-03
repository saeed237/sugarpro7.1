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

require_once('modules/Forecasts/AbstractForecastHooks.php');
class ForecastHooks extends AbstractForecastHooks
{
    /**
     * This method, just set the date_modified to the value from the db, vs the user formatted value that sugarbean sets
     * after it has been retrieved
     *
     * @param Forecast $forecast
     * @param string $event
     * @param array $params
     */
    public static function fixDateModified(Forecast $forecast, $event, $params = array())
    {
        $forecast->date_modified = $forecast->fetched_row['date_modified'];
    }
}
