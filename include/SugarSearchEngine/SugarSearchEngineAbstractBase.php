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

require_once('include/SugarSearchEngine/Interface.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');

/**
 * Base class for search engine drivers
 * @api
 */
abstract class SugarSearchEngineAbstractBase implements SugarSearchEngineInterface
{
    /**
     * @var array
     */
    protected $_documents = array();

    /**
     * The max number of documents to bulk insert at a time
     */
    const MAX_BULK_THRESHOLD = 100;

    /**
     * Logger to use to report problems
     * @var LoggerManager
     */
    public $logger;

    public function __construct()
    {

        $this->logger = $GLOBALS['log'];
    }
    /**
     * Determine if a module is FTS enabled.
     *
     * @param $module
     * @return bool
     */
    protected function isModuleFtsEnabled($module)
    {
        return SugarSearchEngineMetadataHelper::isModuleFtsEnabled($module);

    }

    /**
     * This is needed to prevent unserialize vulnerability
     */
    public function __wakeup()
    {
        // clean all properties
        foreach(get_object_vars($this) as $k => $v) {
            $this->$k = null;
        }
        throw new Exception("Not a serializable object");
    }

    /**
     * Bulk insert any documents that have been marked for bulk insertion.
     */
    public function __destruct()
    {
        if (count($this->_documents) > 0 )
        {
            $this->bulkInsert($this->_documents);
        }

    }

    /**
     * Disable FTS and write to config.
     *
     */
    protected function disableFTS()
    {
        $this->logger->fatal('Full Text Search has been disabled because the system is not able to connect to the search engine.');
        self::markSearchEngineStatus(true);

        // notification
        if(empty($GLOBALS['sugar_config']['fts_disable_notification'])) {
            $cfg = new Configurator();
            $cfg->config['fts_disable_notification'] = true;
            $cfg->handleOverride();
        }
    }

    /**
     * This function adds records to FTS queue.
     *
     * @param $records array of records
     */
    protected function addRecordsToQueue($records)
    {
        $this->logger->info('addRecordsToQueue');
        $db = DBManagerFactory::getInstance('fts');
        $db->resetQueryCount();

        foreach ($records as $rec)
        {
            if (empty($rec['bean_id']) || empty($rec['bean_module']))
            {
                $this->logger->error('Error populating fts_queue. Empty bean_id or bean_module.');
                continue;
            }
            $query = "INSERT INTO fts_queue (bean_id,bean_module) values ('{$rec['bean_id']}', '{$rec['bean_module']}')";
            $db->query($query, true, "Error populating index queue for fts");
        }

        // create a cron job consumer to digest the beans
        require_once('include/SugarSearchEngine/SugarSearchEngineSyncIndexer.php');
        $indexer = new SugarSearchEngineSyncIndexer();
        $indexer->removeExistingFTSSyncConsumer();
        $indexer->createJobQueueConsumer();
    }

    /**
     * This function checks config to see if search engine is down.
     *
     * @return Boolean
     */
    static public function isSearchEngineDown()
    {
        $settings = Administration::getSettings();
        if (!empty($settings->settings['info_fts_down'])) {
            return true;
        }
        return false;
    }

    /**
     * This function marks config to indicate that search engine is up or down.
     *
     * @param Boolean $isDown
     */
    static public function markSearchEngineStatus($isDown = true)
    {
        $admin = BeanFactory::getBean('Administration');
        $admin->saveSetting('info', 'fts_down', $isDown? 1: 0);
    }

    protected function reportException($message, $e)
    {
        $this->logger->fatal("$message: ".get_class($e));
        if($this->logger->wouldLog('error')) {
            $this->logger->error($e->getMessage());
        }
    }
}
