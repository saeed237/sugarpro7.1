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
 * CurrencyRateSchedulerJob.php
 *
 * This class implements RunnableSchedulerJob and provides the support for
 * updating currency rates per module.
 *
 */
class SugarJobUpdateCurrencyRates implements RunnableSchedulerJob
{

    /**
     * @var $job the job object
     */
    protected $job;

    /**
     * This method implements setJob from RunnableSchedulerJob and sets the SchedulersJob instance for the class
     *
     * @param SchedulersJob $job the SchedulersJob instance set by the job queue
     *
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * This method implements the run function of RunnableSchedulerJob and handles processing a SchedulersJob
     *
     * @param Mixed $data parameter passed in from the job_queue.data column when a SchedulerJob is run
     * @return bool true on success, false on error
     */
    public function run($data)
    {
        // Searches across modules for rate update scheduler jobs and executes them.
        // Each module that has currency rates in its model(s) *must* have a scheduler
        // job defined in order to update its rates when a currency rate is updated.
        $globPaths = array(
            'custom/modules/*/jobs/Custom*CurrencyRateUpdate.php',
            'modules/*/jobs/*CurrencyRateUpdate.php'
        );
        foreach ($globPaths as $entry)
        {
            $jobFiles = glob($entry, GLOB_NOSORT);

            if(!empty($jobFiles))
            {
                foreach($jobFiles as $jobFile)
                {
                    $jobClass = basename($jobFile,'.php');
                    require_once($jobFile);
                    if(!class_exists($jobClass)) {
                        $GLOBALS['log']->error(string_format($GLOBALS['app_strings']['ERR_DB_QUERY'],array(get_class($this),'uknown class: '.$jobClass)));
                        continue;
                    }
                    $jobObject = new $jobClass;
                    $data = $this->job->data;
                    $jobObject->run($data);
                }
            }
        }

        $this->job->succeedJob();
        return true;
    }

}