<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

class SugarJobAddActivitySubscriptions implements RunnableSchedulerJob
{
    protected $job;

    /**
     * This method implements setJob from RunnableSchedulerJob. It sets the
     * SchedulersJob instance for the class.
     *
     * @param SchedulersJob $job the SchedulersJob instance set by the job queue
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * Executes a job to add activity subscriptions.
     * @param $data
     * @return bool
     */
    public function run($data)
    {
        try {
            $data                  = unserialize($data);
            $subscriptionsBeanName = BeanFactory::getBeanName('Subscriptions');
            $subscriptionsBeanName::addActivitySubscriptions($data);
            $this->job->succeedJob();
            return true;
        } catch (Exception $e) {
            $this->job->failJob($e->getMessage());
            return false;
        }
    }
}
