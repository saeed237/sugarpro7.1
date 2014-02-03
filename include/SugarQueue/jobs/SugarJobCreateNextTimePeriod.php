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
 * SugarJobCreateNextTimePeriod.php
 *
 * This class implements RunnableSchedulerJob and provides the support for automating the creation of timeperiod
 * entries.
 *
 */
class SugarJobCreateNextTimePeriod implements RunnableSchedulerJob
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
        global $app_strings, $language;
        $app_strings = return_application_language($language);

        $admin = BeanFactory::getBean('Administration');
        $config = $admin->getConfigForModule('Forecasts', 'base');

        $timeperiodInterval = $config['timeperiod_interval'];
        $timeperiodLeafInterval = $config['timeperiod_leaf_interval'];

        $parentTimePeriod = TimePeriod::getLatest($timeperiodInterval);
        $latestTimePeriod = TimePeriod::getLatest($timeperiodLeafInterval);
        $currentTimePeriod = TimePeriod::getCurrentTimePeriod($timeperiodLeafInterval);

        if(empty($latestTimePeriod))
        {
            $GLOBALS['log']->error(string_format($app_strings['ERR_TIMEPERIOD_TYPE_DOES_NOT_EXIST'], array($timeperiodLeafInterval)) . '[latest]');
            return false;
        } else if(empty($currentTimePeriod)) {
            $GLOBALS['log']->error(string_format($app_strings['ERR_TIMEPERIOD_TYPE_DOES_NOT_EXIST'], array($timeperiodLeafInterval)) . ' [current]');
            return false;
        } else if(empty($parentTimePeriod)) {
            $GLOBALS['log']->error(string_format($app_strings['ERR_TIMEPERIOD_TYPE_DOES_NOT_EXIST'], array($timeperiodLeafInterval)) . ' [parent]');
            return false;
        }

        $timedate = TimeDate::getInstance();

        //We run the rebuild command if the latest TimePeriod is less than the specified configuration interval from the current TimePeriod
        $correctStartDate = $timedate->fromDbDate($currentTimePeriod->start_date);
        $latestStartDate = $timedate->fromDbDate($latestTimePeriod->start_date);

        $shownForward = $config['timeperiod_shown_forward'];
        //Move the current start date forward by the leaf period amounts
        for($x=0; $x < $shownForward; $x++) {
            $correctStartDate->modify($parentTimePeriod->next_date_modifier);
        }

        $leafCycle = $latestTimePeriod->leaf_cycle;
    
        //If the current start data that was modified according to the shown forward period is past the latest leaf period we need to build more timeperiods
        while($correctStartDate > $latestStartDate)
        {
           //We need to keep creating leaf periods until we are in sync.
           //If the leaf period we need to create is the start of the leaf cycle
           //then we should also create the parent TimePeriod record.
           $startDate = $latestStartDate->modify($latestTimePeriod->next_date_modifier);

           $leafCycle = ($leafCycle == $parentTimePeriod->leaf_periods) ? 1 : $leafCycle + 1;

           if($leafCycle == 1) {
              $parentTimePeriod = TimePeriod::getByType($timeperiodInterval);
              $parentTimePeriod->setStartDate($startDate->asDbDate());
              $year = $startDate->format('Y');
              $parentTimePeriod->name = $parentTimePeriod->getTimePeriodName($leafCycle);
              $parentTimePeriod->save();
           }

           $leafTimePeriod = TimePeriod::getByType($timeperiodLeafInterval);
           $leafTimePeriod->setStartDate($startDate->asDbDate());
           $leafTimePeriod->name = $leafTimePeriod->getTimePeriodName($leafCycle);
           $leafTimePeriod->leaf_cycle = $leafCycle;
           $leafTimePeriod->parent_id = $parentTimePeriod->id;
           $leafTimePeriod->save();
        }

        $this->job->succeedJob();
        return true;
    }

}