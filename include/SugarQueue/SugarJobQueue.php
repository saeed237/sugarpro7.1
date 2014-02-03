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


require_once 'modules/SchedulersJobs/SchedulersJob.php';

/**
 * Job queue driver
 * @api
 */
class SugarJobQueue
{
    /**
     * Max number of failures for job
     * @var int
     */
    public $jobTries = 5;
    /**
     * Job running timeout - longer than that, job is failed by force
     * @var int
     */
    public $timeout = 86400; // 24 hours

    /**
     * Table in the DB that stores jobs
     * @var string
     */
    protected $job_queue_table;

    /**
     * DB connection
     * @var DBManager
     */
    public $db;

    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance();
        $job = BeanFactory::getBean('SchedulersJobs');
        $this->job_queue_table = $job->table_name;
        if(!empty($GLOBALS['sugar_config']['jobs']['max_retries'])) {
            $this->jobTries = $GLOBALS['sugar_config']['jobs']['max_retries'];
        }
        if(!empty($GLOBALS['sugar_config']['jobs']['timeout'])) {
            $this->timeout = $GLOBALS['sugar_config']['jobs']['timeout'];
        }
    }

    /**
     * Submit a new job to the queue
     * @param SugarJob $job
     * @param User $user User to run the job under
     */
    public function submitJob($job)
    {
        $job->id = create_guid();
        $job->new_with_id = true;
        $job->status = SchedulersJob::JOB_STATUS_QUEUED;
        $job->resolution = SchedulersJob::JOB_PENDING;
        if(empty($job->execute_time)) {
            $job->execute_time = $GLOBALS['timedate']->nowDb();
        }
        if(empty($job->assigned_user_id)) {
            $job->assigned_user_id = $GLOBALS['current_user']->id;
        }
        $job->save();

        return $job->id;
    }

    /**
     * Get Job object by ID
     * @param string $jobId
     * @return SugarJob
     */
    protected function getJob($jobId)
    {
        $job = BeanFactory::getBean('SchedulersJobs', $jobId);
        if(empty($job->id)) {
            $GLOBALS['log']->info("Job $jobId not found!");
            return null;
        }
        return $job;
    }

    /**
     * Resolve job as success or failure
     * @param string $jobId
     * @param string $resolution One of JOB_ constants that define job status
     * @param string $message
     * @return bool
     */
    public function resolveJob($jobId, $resolution, $message = null)
    {
        $job = $this->getJob($jobId);
        if(empty($job)) return false;
        return $job->resolveJob($resolution, $message);
    }

    /**
     * Rerun this job again
     * @param string $jobId
     * @param string $message
     * @param string $delay how long to delay (default is job's delay)
     * @return bool
     */
    public function postponeJob($jobId, $message = null, $delay = null)
    {
        $job = $this->getJob($jobId);
        if(empty($job)) return false;
        return $job->postponeJob($message, $delay);
    }

    /**
     * Delete a job
     * @param string $jobId
     */
    public function deleteJob($jobId)
    {
        return BeanFactory::deleteBean('SchedulersJobs', $jobId);
    }

    /**
     * Remove old jobs that still are marked as running
     * @return bool true if no failed job discovered, false if some job were failed
     */
    public function cleanup()
    {
        // fail jobs that are too old
        $ret = true;
        // bsitnikovski@sugarcrm.com bugfix #56144: Scheduler Bug
        $date = $this->db->convert($this->db->quoted($GLOBALS['timedate']->getNow()->modify("-{$this->timeout} seconds")->asDb()), 'datetime');
        $res = $this->db->query("SELECT id FROM {$this->job_queue_table} WHERE status='".SchedulersJob::JOB_STATUS_RUNNING."' AND date_modified <= $date");
        while($row = $this->db->fetchByAssoc($res)) {
            $this->resolveJob($row["id"], SchedulersJob::JOB_FAILURE, translate('ERR_TIMEOUT', 'SchedulersJobs'));
            $ret = false;
        }
        // TODO: soft-delete old done jobs?
        return $ret;
    }

    /**
     * Nuke all jobs from the queue
     */
    public function cleanQueue()
    {
        $this->db->query("DELETE FROM {$this->job_queue_table}");
    }

    /**
     * Fetch the next job in the queue and mark it running
     * @param string $clientID ID of the client requesting the job
     * @return SugarJob
     */
    public function nextJob($clientID)
    {
        $now = $this->db->now();
        $queued = SchedulersJob::JOB_STATUS_QUEUED;
        $try = $this->jobTries;
        while($try--) {
            // TODO: tranaction start?
            $id = $this->db->getOne("SELECT id FROM {$this->job_queue_table} WHERE execute_time <= $now AND status = '$queued' ORDER BY date_entered ASC");
            if(empty($id)) {
                return null;
            }
            $job = BeanFactory::getBean('SchedulersJobs', $id);
            if(empty($job->id)) {
                return null;
            }
            $job->status = SchedulersJob::JOB_STATUS_RUNNING;
            $job->client = $clientID;
            $client = $this->db->quote($clientID);
            // using direct query here to be able to fetch affected count
            // if count is 0 this means somebody changed the job status and we have to try again
            $res = $this->db->query("UPDATE {$this->job_queue_table} SET status='{$job->status}', date_modified=$now, client='$client' WHERE id='{$job->id}' AND status='$queued'");
            if($this->db->getAffectedRowCount($res) == 0) {
                // somebody stole our job, try again
                continue;
            } else {
                // to update dates & possible hooks
                $job->save();
                break;
            }
            // TODO: commit/check?
        }
        return $job;
    }

    /**
     * Run schedulers to instantiate scheduled jobs
     */
    public function runSchedulers()
    {
        $sched = BeanFactory::getBean('Schedulers');
        $sched->checkPendingJobs($this);
    }
}
