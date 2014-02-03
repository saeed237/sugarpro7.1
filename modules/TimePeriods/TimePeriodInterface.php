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


/**
 * TimePeriodInterface.php
 *
 * interface definition for TimePeriod subclasses used by the forecasting components
 */
interface TimePeriodInterface
{
    public function getLengthInDays();

    public function getNextTimePeriod();

    public function getPreviousTimePeriod();

    public function setStartDate($start_date=null);

    /**
     * Returns the formatted chart labels for the chart data supplied
     *
     * @see include/SugarForecasting/Chart/Individual.php
     * @param $chartData Array of chart data based on the incoming parameters sent
     * @return mixed Array of formatted chart data with the corresponding time intervals
     */
    public function getChartLabels($chartData);

    /**
     * Returns the chart label key for the data set given the closed date of a record
     *
     * @see include/SugarForecasting/Chart/Individual.php
     * @param $dateClosed Database date format (2012-01-01) of date closed
     * @return String of the key used for the data set
     */
    public function getChartLabelsKey($dateClosed);
}
?>