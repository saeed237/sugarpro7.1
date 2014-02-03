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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Forecasts']['base']['view']['tutorial'] = array(
    'records' => array(
        'intro' =>'LBL_TOUR_FORECAST_INTRO',
        'version' =>1,
        'content' => array(
            array(
                'name' => '.topline [for="date_filter"]',
                'text' => 'LBL_TOUR_FORECASTS_TIMEPERIODS',
                'full' => true,
                'horizAdj'=> -15,
                'vertAdj'=> -15,
            ),
            array(
                'name' => '.topline .last-commit',
                'text' => 'LBL_TOUR_FORECASTS_COMMITS',
                'full' => true,
                'horizAdj'=> -20,
                'vertAdj'=> -20,
            ),
            array(
                'name' => '.editableColumn',
                'text' => 'LBL_TOUR_FORECASTS_INLINEEDIT',
                'full' => true,
            ),
            array(
                'name' => '.dashlets .forecast-details',
                'text' => 'LBL_TOUR_FORECASTS_PROGRESS',
                'full' => true,
                'horizAdj'=> -1,
                'vertAdj'=> -5,
            ),
            array(
                'name' => '.dashlets .forecasts-chart-wrapper',
                'text' => 'LBL_TOUR_FORECASTS_CHART',
                'full' => true,
                'horizAdj'=> -1,
                'vertAdj'=> -5,
            ),
        )
    ),
);
