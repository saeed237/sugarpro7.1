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


require_once('modules/SchedulersJobs/SchedulersJob.php');

/**
 * SugarJobUpdateOpportunities.php
 *
 * Class to run a job which should upgrade every old opp with commit stage, date_closed_timestamp,
 * best/worst cases and related product
 */
class SugarJobUpdateOpportunities implements RunnableSchedulerJob {

    /**
     * @var SchedulersJob
     */
    protected $job;

    /**
     * @param SchedulersJob $job
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * @param $data
     * @return bool
     */
    public function run($data)
    {
        $this->job->runnable_ran = true;
        $this->job->runnable_data = $data;

        $keys = json_decode(html_entity_decode($data), true);

        foreach ($keys as $key) {
            /* @var $opp Opportunity */
            $opp = BeanFactory::getBean('Opportunities');
            $opp->retrieve($key);
            $opp->save(false);
        }

        $this->job->succeedJob();
        return true;
    }
}
