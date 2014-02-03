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

/**
 * Base class of full text search Indexer
 * @api
 */
abstract class SugarSearchEngineIndexerBase implements RunnableSchedulerJob
{

    /**
     * @var SchedulersJob
     */
    protected $schedulerJob;

    /**
     * @var \SugarSearchEngineAbstractBase
     */
    protected $SSEngine;

    /**
     * The max number of beans we process before starting to bulk insert so we dont hit memory issues.
     */
    const MAX_BULK_THRESHOLD = 5000;

    /**
     * The max number of beans we process before starting to bulk insert so we dont hit memory issues.
     */
    const MAX_BULK_QUERY_THRESHOLD = 15000;

    /**
     * The max number of beans we delete at a time
     */
    const MAX_BULK_DELETE_THRESHOLD = 3000;

    /**
     * Number of time to postpone a job by so it's not executed twice during the same request.
     */
    const POSTPONE_JOB_TIME = 20;

    /**
     * The name of the queue table
     */
    const QUEUE_TABLE = 'fts_queue';

    /**
     * @var DBManager
     */
    protected $db;

    /**
     * @var table_name
     */
    protected $table_name;

    /**
     * @param SugarSearchEngineAqbstractBase $engine
     */
    public function __construct(SugarSearchEngineAbstractBase $engine = null)
    {
        if($engine != null)
            $this->SSEngine = $engine;
        else
            $this->SSEngine = SugarSearchEngineFactory::getInstance();

        $this->db = DBManagerFactory::getInstance('fts');

        $this->table_name = self::QUEUE_TABLE;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Set the scheduler job that initiated the run call.
     *
     * @param SchedulersJob $job
     */
    public function setJob(SchedulersJob $job)
    {
        $this->schedulerJob = $job;
    }


    /**
     * Generate the query necessary to retrieve FTS enabled fields for a bean.
     *
     * @param $module
     * @param $fieldDefinitions
     * @return string
     */
    protected function generateFTSQuery($module, $fieldDefinitions)
    {
        $queuTableName = self::QUEUE_TABLE;
        $bean = BeanFactory::getBean($module, null);
        $id = isset($fieldDefinitions['email1']) ? $bean->table_name.'.id' : 'id';

        $selectFields = array($id);
        if (isset($bean->field_defs['team_id'])) {
            $selectFields += array('team_id', 'team_set_id');
        }

        $ownerField = $bean->getOwnerField(true);
        if (!empty($ownerField))
        {
            $selectFields[] = $ownerField;
        }

        foreach($fieldDefinitions as $value)
        {
            if(isset($value['name'])) {
                if ($value['name'] == 'email1')
                    continue;
                $selectFields[] = $value['name'];
            }
        }

        $ret_array['select'] = " SELECT " . implode(",", $selectFields);
        $ret_array['from'] = " FROM {$bean->table_name} ";
        $custom_join = $bean->getCustomJoin();
        $ret_array['select'] .= $custom_join['select'];

        $ret_array['from'] .= $custom_join['join'];

        $ret_array['from'] .= " INNER JOIN {$queuTableName} on {$queuTableName}.bean_id = {$bean->table_name}.id AND {$queuTableName}.processed = 0 ";
        $ret_array['where'] = "WHERE {$bean->table_name}.deleted = 0";

        if(isset($fieldDefinitions['email1'])) {
            $ret_array['select'].= ", email_addresses.email_address email1";
            $ret_array['from'].= " LEFT JOIN email_addr_bean_rel on {$bean->table_name}.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module='{$module}' and email_addr_bean_rel.deleted=0 and email_addr_bean_rel.primary_address=1 LEFT JOIN email_addresses on email_addresses.id=email_addr_bean_rel.email_address_id ";
        }

        return  $ret_array['select'] . $ret_array['from'] . $ret_array['where'];
    }

    /**
     * Main function that handles the indexing of a bean and is called by the job queue system.
     * Subclasses should implement their own logic.
     *
     * @param $data
     */
    public function run($data)
    {
        return true;
    }

    /**
     * Given a set of bean ids processed from the queue table, mark them as being processed.  We will
     * throttle the update query as there is a limit on the size of records that can be passed to an in clause yet
     * we don't want to update them individually for performance reasons.
     *
     * @param $beanIDs array of bean ids to delete
     */
    protected function markBeansProcessed($beanIDs)
    {
        $count = 0;
        $deleteIDs = array();
        foreach ($beanIDs as $beanID)
        {
            $deleteIDs[] = $beanID;
            $count++;
            if($count != 0 && $count % self::MAX_BULK_DELETE_THRESHOLD == 0)
            {
                $this->setBeanIDsProcessed($deleteIDs);
                $deleteIDs = array();
            }
        }

        if( count($deleteIDs) > 0)
            $this->setBeanIDsProcessed($deleteIDs);
    }

    /**
     * Internal function to mark records within queue table as processed.
     *
     * @param $deleteIDs
     */
    private function setBeanIDsProcessed($deleteIDs)
    {
        $tableName = self::QUEUE_TABLE;
        $inClause = implode("','", $deleteIDs);
        $query = "UPDATE $tableName SET processed = 1 WHERE bean_id in ('{$inClause}')";
        $GLOBALS['log']->debug("MARK BEAN QUERY IS: $query");
        $this->db->query($query);
    }

}
