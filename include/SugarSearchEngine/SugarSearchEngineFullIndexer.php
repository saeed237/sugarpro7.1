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


require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
require_once('include/SugarQueue/SugarJobQueue.php');
require_once('modules/SchedulersJobs/SchedulersJob.php');
require_once('include/SugarSearchEngine/SugarSearchEngineIndexerBase.php');

/**
 * Indexer job for Search
 * @api
 */
class SugarSearchEngineFullIndexer extends SugarSearchEngineIndexerBase
{

    /**
     * Name of the scheduler to perform a full index
     * @var string
     */
    public static $schedulerName = "Full Text Search Indexer";

    /**
     * @param SugarSearchEngineAqbstractBase $engine
     */
    public function __construct(SugarSearchEngineAbstractBase $engine = null)
    {
        parent::__construct($engine);
        $this->results = array();
    }

    /**
     * Remove all records that may be currently queued for FTS ingestion
     *
     */
    protected function clearFTSIndexQueue()
    {
        $GLOBALS['log']->debug("Clearing FTS Index Queue");
        $GLOBALS['db']->commit();
        $truncateQuery = $GLOBALS['db']->truncateTableSQL('fts_queue');
        $GLOBALS['db']->query($truncateQuery);
    }

    /**
     * Remove existing FTS Consumers that may have been created by a previous scheduled index.
     *
     */
    protected function removeExistingFTSConsumers()
    {
        $GLOBALS['log']->info("Removing existing FTS Consumers");

        $jobBean = BeanFactory::getBean('SchedulersJobs');

        $res = $GLOBALS['db']->query("SELECT id FROM {$jobBean->table_name} WHERE name like 'FTSConsumer%' AND deleted = 0");
        while($row = $GLOBALS['db']->fetchByAssoc($res))
        {
            $jobBean->mark_deleted($row["id"]);
        }
    }

    /**
     * Initiate the FTS indexer.  Once initiated, all work will be done by the FTS consumers which will be invoked
     * by the job queue system.
     *
     * @param array $modules
     * @return bool
     */
    public function initiateFTSIndexer($modules = array(), $deleteExistingData = TRUE)
    {
        $startTime = microtime(true);
        $GLOBALS['log']->info("Populating Full System Index Queue at $startTime");
        if(! $this->SSEngine instanceof SugarSearchEngineAbstractBase)
        {
            $GLOBALS['log']->info("No FTS engine enabled, not doing anything");
            return false;
        }

        //Create the index on the server side
        $this->SSEngine->createIndex($deleteExistingData);

        //Clear the existing queue
        $this->clearFTSIndexQueue();

        //Remove any consumers that may be set to run
        $this->removeExistingFTSConsumers();

        // clear flag
        $admin = Administration::getSettings();
        if (!empty($admin->settings['info_fts_index_done'])) {
            $admin->saveSetting('info', 'fts_index_done', 0);
        }


        $allModules = !empty($modules) ? $modules : array_keys(SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules());

        $totalCount = 0;
        foreach($allModules as $module)
        {
            $totalCount += $this->populateIndexQueueForModule($module);
        }

        $totalTime = number_format(round(microtime(true) - $startTime, 2), 2);
        $this->results['totalTime'] = $totalTime;
        $GLOBALS['log']->info("Total time to populate full system index queue: $totalTime (s)");
        $avgRecs = ($totalCount != 0 && $totalTime != 0) ? number_format(round(($totalCount / $totalTime), 2), 2) : 0;
        $GLOBALS['log']->info("Total number of modules queued: $totalCount , modules per sec. $avgRecs");

        return true;

    }

    /**
     * Populate the index queue with all records from a particular module
     *
     * @param $module
     */
    public function populateIndexQueueForModule($module)
    {
        $GLOBALS['log']->info("Going to populate index queue for module {$module} ");
        $db = DBManagerFactory::getInstance('fts');
        $obj = BeanFactory::getBean($module, null);
        if (!($obj instanceOf SugarBean)) {
            $GLOBALS['log']->error("Full indexer: Failed to get bean for module: $module");
            return 0;
        }
        $beanName = BeanFactory::getBeanName($module);
        $tableName = self::QUEUE_TABLE;
        $query = "INSERT INTO {$tableName} (bean_id,bean_module) SELECT id, '{$beanName}' FROM {$obj->table_name}";
        $db->query($query, true, "Error populating index queue for fts");
        //For each module we populate the fts queue with, create a consumer to digest the beans as well.
        $this->createJobQueueConsumerForModule($module);
        return 1;
    }

    /**
     * Create a job queue FTS consumer for a specific module
     *
     * @param $module
     * @return String Id of newly created job
     */
    public function createJobQueueConsumerForModule($module)
    {
        $GLOBALS['log']->info("Creating FTS Job queue consumer for: {$module} ");
        $job = BeanFactory::getBean('SchedulersJobs');
        $job->data = $module;
        $job->name = "FTSConsumer {$module}";
        $job->target = "class::SugarSearchEngineFullIndexer";
        $job->assigned_user_id =1;
        $queue = new SugarJobQueue();
        $queue->submitJob($job);

        return $job->id;
    }

    /**
     * Index the entire system. This should only be called from a worker process as this is a time intensive process and
     * does not take advantage of the job queue system.  Currently this call is only used when populating demo data and should be used
     * sparingly.
     */
    public function performFullSystemIndex($modules = array(), $clearExistingData = TRUE)
    {
        //Do nothing if no FTS has been setup.
        if(! $this->SSEngine instanceof SugarSearchEngineAbstractBase)
        {
            $GLOBALS['log']->info("No FTS engine enabled, not doing anything");
            return false;
        }
        if(!$this->initiateFTSIndexer($modules, $clearExistingData)) {
            $GLOBALS['log']->info("FTS index was not initiated");
            return false;
        }
        require_once 'include/SugarQueue/SugarCronJobs.php';
        $jobq = new SugarCronJobs();
        $jobq->runCycle();
        return true;
    }

    /**
     * Index records into search engine
     *
     * @param String module
     * @param array fieldDefinitions
     * @return integer number of indexed records, -1 if fails
     */
    public function indexRecords($module, $fieldDefinitions)
    {
        $beanName = BeanFactory::getBeanName($module);
        $queuTableName = self::QUEUE_TABLE;
        $count = 0;
        $processedBeans = array();
        $docs = array();
        if( $this->shouldIndexViaBean($module) )
        {
            $GLOBALS['log']->info("SugarFullIndexer will use bean to index records");
            $selectAllQuery = "SELECT bean_id FROM {$queuTableName} WHERE bean_module='{$beanName}' AND processed = 0";
            $result = $this->db->limitQuery($selectAllQuery,0, self::MAX_BULK_THRESHOLD, true, "Unable to retrieve records from FTS queue");
        }
        else
        {
            $GLOBALS['log']->info("SugarFullIndexer will use db to index records");
            $sql = $this->generateFTSQuery($module, $fieldDefinitions);
            $result = $this->db->limitQuery($sql,0, self::MAX_BULK_QUERY_THRESHOLD, true, "Unable to retrieve records from FTS queue");
        }


        while ($row = $this->db->fetchByAssoc($result, FALSE) )
        {
            if( $this->shouldIndexViaBean($module) )
            {
                $beanID = $row['bean_id'];
                $bean = BeanFactory::getBean($module, $beanID);
            }
            else
            {
                $beanID = $row['id'];
                $row['module_dir'] = $module;
                $bean = (object) $row;
            }

            if($bean !== FALSE)
            {
                $GLOBALS['log']->debug("About to index bean: $beanID $module");
                $docs[] = $this->SSEngine->createIndexDocument($bean, $fieldDefinitions);
                $processedBeans[] = $beanID;
                $count++;
            }

            if($count != 0 && $count % self::MAX_BULK_THRESHOLD == 0)
            {
                $ok = $this->SSEngine->bulkInsert($docs);
                if ($ok) {
                    $this->markBeansProcessed($processedBeans);
                } else {
                    return -1;
                }
                $docs = $processedBeans = array();
                SugarCache::instance()->flush();
                if( function_exists('gc_collect_cycles') )
                    gc_collect_cycles();

                $lastMemoryUsage = isset($lastMemoryUsage) ? $lastMemoryUsage : 0;
                $currentMemUsage = memory_get_usage();
                $totalMemUsage = $currentMemUsage - $lastMemoryUsage;
                $GLOBALS['log']->info("Flushing records, count: $count mem. usage:" .  memory_get_usage() . " , mem. delta: " . $totalMemUsage);
                $lastMemoryUsage = $currentMemUsage;
            }
        }

        if(count($docs) > 0)
        {
            $ok = $this->SSEngine->bulkInsert($docs);
            if (!$ok) {
                return -1;
            }
        }

        $this->markBeansProcessed($processedBeans);

        return $count;
    }


    /**
     * TODO: For the 6.5.1 release this logic will need to be updted as we support additional field types
     *
     * Determine if a particular module should be indexed via its bean or if we can build a direct query.
     * Indexing a module by going through SugarBean can introduce performance problems
     *
     * @return bool
     */
    protected function shouldIndexViaBean($module)
    {
        return FALSE;
    }
    /**
     * Main function that handles the indexing of a bean and is called by the job queue system.
     *
     * @param $data
     */
    public function run($module)
    {
        if (SugarSearchEngineAbstractBase::isSearchEngineDown())
        {
            $GLOBALS['log']->fatal('FTS Server is down, postponing the job for full index.');
            $this->schedulerJob->postponeJob('FTS down', self::POSTPONE_JOB_TIME);
            return true;
        }

        $GLOBALS['log']->info("Going to index all records in module {$module} ");
        $startTime = microtime(true);
        $fieldDefinitions = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($module);

        $count = $this->indexRecords($module, $fieldDefinitions);
        if ($count == -1) {
            $GLOBALS['log']->fatal('FTS failed to index records, postponing job for next cron');
            $this->schedulerJob->postponeJob('FTS failed to index', self::POSTPONE_JOB_TIME);
            return true;
        }
        $totalTime = number_format(round(microtime(true) - $startTime, 2), 2);

        $messagePacket = unserialize(from_html($this->schedulerJob->message));
        if($messagePacket === FALSE)
            $messagePacket = array('count' => 0, 'time' => 0);

        $messagePacket['count'] += $count;
        $messagePacket['time'] += $totalTime;

        //Keep track of how many we've done
        $this->schedulerJob->message = serialize($messagePacket);

        $avgRecs = ($count != 0 && $totalTime != 0) ? number_format(round(($count / $totalTime), 2), 2) : 0;
        $GLOBALS['log']->info("FTS Consumer {$this->schedulerJob->name} processed {$count} record(s) in $totalTime (s), records per sec: $avgRecs");

        //If no items were processed we've exhausted the list and can therefore succeed job.
        if( $count == 0)
        {
            $this->schedulerJob->succeedJob();
        }
        else
        {
            //Mark the job that as pending so we can be invoked later.
            $this->schedulerJob->postponeJob('FTS indexing not completed', self::POSTPONE_JOB_TIME);
        }

        if(self::isFTSIndexScheduleCompleted())
        {
            $stats = self::getStatistics();
            // indexing completed, set flag to 1
            $settings = Administration::getSettings('proxy');
            if (empty($settings->settings['info_fts_index_done'])) {
                $settings->saveSetting('info', 'fts_index_done', 1);
            }

            $GLOBALS['log']->info("FTS Indexing completed with the following statistics: " . var_export($stats, TRUE));
        }

        return TRUE;

    }

    /**

     * Return statistics about how many records per module were indexed.
     *
     * @return array
     */
    public function getStatistics()
    {
        $results = array();
        $jobBean = BeanFactory::getBean('SchedulersJobs');
        $totalCount = 0;
        $totalTime = 0;
        $res = $GLOBALS['db']->query("SELECT id FROM {$jobBean->table_name} WHERE name like 'FTSConsumer%' AND deleted = 0");
        while($row = $GLOBALS['db']->fetchByAssoc($res))
        {
            $tmpBean = BeanFactory::getBean('SchedulersJobs', $row["id"]);
            $messagePacket = from_html($tmpBean->message);
            $results[$tmpBean->data] = unserialize($messagePacket);
            $totalTime += $messagePacket['time'];
            $totalCount += $messagePacket['count'];
        }

        $results['time'] = $totalTime;
        $results['count'] = $totalCount;

        return $results;
    }


    /**
     * TODO: Need to update
     * Determine if a pre-existing scheduler for fts exists.  If so return the id, else false.
     *
     * @static
     * @return mixed
     */
    public static function isFTSIndexScheduled()
    {
        $sched = BeanFactory::getBean('Schedulers');
        $sched = $sched->retrieve_by_string_fields(array('name'=> self::$schedulerName));

        if($sched == NULL)
            return FALSE;
        else
            return $sched->id;

    }

    /**
     * Determine if a system has been indexed
     *
     * @static
     * @return bool
     */
    public static function isFTSIndexScheduleCompleted()
    {
        $completed = FALSE;
        $jobBean = BeanFactory::getBean('SchedulersJobs');

        $res = $GLOBALS['db']->query("SELECT id FROM {$jobBean->table_name} WHERE name like 'FTSConsumer%' AND deleted = 0");
        while($row = $GLOBALS['db']->fetchByAssoc($res))
        {
            $completed = TRUE;//At least one job must have been executed
            $jobBean->retrieve($row["id"]);
            if($jobBean->status != SchedulersJob::JOB_STATUS_DONE)
               return FALSE;
        }

        return $completed;
    }
}
