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

/**
 * Create a job for updating time periods
 */
class SugarUpgradeCreateTimeperiodJob extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if (!version_compare($this->from_version, '6.7.0', '<'))
        {
            // only for upgrades from below 6.7
            return;
        }
        // add class::SugarJobCreateNextTimePeriod job if not there
        $job = new Scheduler();
        $job->retrieve_by_string_fields(array("job" => 'class::SugarJobCreateNextTimePeriod'));
        if(empty($job->id)) {
                $job->name               = translate('LBL_OOTB_CREATE_NEXT_TIMEPERIOD', 'Schedulers');
                $job->job                = 'class::SugarJobCreateNextTimePeriod';
                $job->date_time_start    = '2013-01-01 00:00:01';
                $job->date_time_end      = '2030-12-31 23:59:59';
                $job->job_interval       = '0::23::*::*::*';
                $job->status             = 'Active';
                $job->created_by         = '1';
                $job->modified_user_id   = '1';
                $job->catch_up           = '0';
                $job->save();
        }
    }
}
