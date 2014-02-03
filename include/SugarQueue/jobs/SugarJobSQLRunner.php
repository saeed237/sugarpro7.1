<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('modules/SchedulersJobs/SchedulersJob.php');

/**
 * SugarJobSQLRunner.php
 *
 * sometimes you have thousands of SQL queries to run, and you
 * have to schedule them in batches. that is what SQLRunner is for.
 * SQLRunner is a very simple SQL query running scheduler job. It loops
 * over SQL statements supplied by the $data and executes them.
 * not a lot of validation goes on here, so construct queries carefully.
 * one failed query will stop the whole process.
 *
 * be sure you split your queries into manageable batches and feed them to
 * separate jobs, ie. don't overwhelm one job with thousands of queries.
 *
 */
class SugarJobSQLRunner implements RunnableSchedulerJob
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
        $data = unserialize($data);
        if (!is_array($data)) {
            // data must be array of arrays
            $this->job->failJob('invalid query data');
            return false;
        }
        /* @var $db DBManager */
        $db = DBManagerFactory::getInstance();

        foreach ($data as $query) {
            if (!is_string($query) || empty($query)) {
                // bad format? we're done
                $this->job->failJob('invalid query: ' . $query);
                return false;
            }
            $result = $db->query($query);
            if (!$result) {
                $this->job->failJob('query failed: ' . $query);
                return false;
            }
        }

        $this->job->succeedJob();
        return true;
    }

}
