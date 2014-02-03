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


require_once("include/SugarForecasting/Progress/AbstractProgress.php");
class SugarForecasting_Progress_Individual extends SugarForecasting_Progress_AbstractProgress
{
    /**
     * Process the code to return the values that we need
     *
     * @return array
     */
    public function process()
    {
        return $this->getIndividualProgress();
    }

    /**
     * Get the Numbers for the Individual (Sales Rep) View, this number comes from the quota right now
     *
     * @return array
     */
    protected function getIndividualProgress()
    {
        //get the quota data for user
        /* @var $quota Quota */
        $quota = BeanFactory::getBean('Quotas');
        $quotaData = $quota->getRollupQuota($this->getArg('timeperiod_id'), $this->getArg('user_id'));

        $progressData = array(
            "quota_amount"      => isset($quotaData["amount"]) ? $quotaData["amount"] : 0
        );

        // get what we are forecasting on
        /* @var $admin Administration */
        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts');

        $forecast_by = $settings['forecast_by'];

        $user_id = $this->getArg('user_id');
        $timeperiod_id = $this->getArg('timeperiod_id');

        /* @var $worksheet ForecastWorksheet */
        $worksheet = BeanFactory::getBean('ForecastWorksheets');
        $totals = $worksheet->worksheetTotals($timeperiod_id, $user_id,  $forecast_by);

        $acl = new SugarACLForecastWorksheets();

        $bestAccess = $acl->checkAccess(
            'ForecastWorksheets',
            'field',
            array('field' => 'best_case', 'action' => 'read')
        );

        $worstAccess = $acl->checkAccess(
            'ForecastWorksheets',
            'field',
            array('field' => 'worst_case', 'action' => 'read')
        );

        // if the user doesn't have access to best field, remove the value from totals
        if (!$bestAccess) {
            unset($totals['best_case']);
        }

        // if the user doesn't have access to worst field, remove the value from totals
        if (!$worstAccess) {
            unset($totals['worst_case']);
        }

        $totals['user_id'] = $user_id;
        $totals['timeperiod_id'] = $timeperiod_id;

        // unset some vars that come from the worksheet to avoid confusion with correct data
        // coming from this endpoint for progress
        unset($totals['pipeline_opp_count'], $totals['pipeline_amount']);

        // combine totals in with other progress data
        $progressData = array_merge($progressData, $totals);

        return $progressData;
    }
}
