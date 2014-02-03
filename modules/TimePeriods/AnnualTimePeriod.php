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


require_once('modules/TimePeriods/TimePeriodInterface.php');
/**
 * Implements the annual representation of a time period
 * @api
 */
class AnnualTimePeriod extends TimePeriod implements TimePeriodInterface {

    public function __construct() {
        $this->module_name = 'AnnualTimePeriods';

        parent::__construct();

        //The time period type
        $this->type = TimePeriod::ANNUAL_TYPE;

        //The leaf period type
        $this->leaf_period_type = TimePeriod::QUARTER_TYPE;

        //The number of leaf periods
        $this->leaf_periods = 4;

        $this->periods_in_year = 1;

        //Fiscal is 52-week based, chronological is year based
        $this->is_fiscal = false;

        $this->is_fiscal_year = true;

        //The next period modifier
        $this->next_date_modifier = $this->is_fiscal ? '52 week' : '1 year';

        //The previous period modifier
        $this->previous_date_modifier = $this->is_fiscal ? '-52 week' : '-1 year';

        global $app_strings;
        //The name template
        $this->name_template = $app_strings['LBL_ANNUAL_TIMEPERIOD_FORMAT'];

        //The leaf name template
        $this->leaf_name_template = $app_strings['LBL_QUARTER_TIMEPERIOD_FORMAT'];
    }


    /**
     * getTimePeriodName
     *
     * Returns the timeperiod name.  The TimePeriod base implementation simply returns the $count argument passed
     * in from the code
     *
     * @param $count The timeperiod series count
     * @return string The formatted name of the timeperiod
     */
    public function getTimePeriodName($count)
    {
        $timedate = TimeDate::getInstance();
        return string_format($this->name_template, array($timedate->fromDbDate($this->start_date)->format('Y')));
    }


    /**
     * Returns the formatted chart label data for the timeperiod
     *
     * @param $chartData Array of chart data values
     * @return formatted Array of chart data values where the labels are broken down by the timeperiod's increments
     */
    public function getChartLabels($chartData) {
        $months = array();

        $start = strtotime($this->start_date);
        $end = strtotime($this->end_date);

        while ($start < $end) {
            $val = $chartData;
            $val['label'] = date('Y', $start);
            $months[date('Y', $start)] = $val;
            $start = strtotime('+1 year', $start);
        }

        return $months;
    }


    /**
     * Returns the key for the chart label data for the date closed value
     *
     * @param String The date_closed value in db date format
     * @return String value of the key to use to map to the chart labels
     */
    public function getChartLabelsKey($dateClosed) {
        return date('Y', strtotime($dateClosed));
    }

}