<?php
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

require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
require_once('include/SugarSearchEngine/Elastic/SugarSearchEngineElasticResultSet.php');
require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');
require_once('include/SugarSearchEngine/SugarSearchEngineHighlighter.php');

/**
 * Engine implementation for ElasticSearch
 */
class SugarSearchEngineElastic extends SugarSearchEngineAbstractBase
{
    private $_config = array();
    private $_client = null;
    private $_indexName = "";

    const DEFAULT_INDEX_TYPE = 'SugarBean';
    const WILDCARD_CHAR = '*';

    private $_indexType = 'SugarBean';

    public function __construct($params = array())
    {
        $this->_config = $params;
        if (!empty($GLOBALS['sugar_config']['unique_key'])) {
            $this->_indexName = strtolower($GLOBALS['sugar_config']['unique_key']);
        } else {
            //Fix a notice error during install when we verify the Elastic Search settings
            $this->_indexName = '';
        }

        //Elastica client uses own auto-load schema similar to ZF.
        SugarAutoLoader::addPrefixDirectory('Elastica', 'vendor/');
        if (empty($this->_config['timeout'])) {
            $this->_config['timeout'] = 15;
        }
        $this->_client = new Elastica_Client($this->_config);
        parent::__construct();
    }

    /**
     * Check if this is an Elastic client exception, disable FTS if it is
     * @param $e Exception
     * @return boolean tru if it's an Elastic client exception, false otherwise
     */
    protected function checkException($e)
    {
        if ($e instanceof Elastica_Exception_Client) {
            $error = $e->getError();
            switch ($error) {
                case CURLE_UNSUPPORTED_PROTOCOL:
                case CURLE_FAILED_INIT:
                case CURLE_URL_MALFORMAT:
                case CURLE_COULDNT_RESOLVE_PROXY:
                case CURLE_COULDNT_RESOLVE_HOST:
                case CURLE_COULDNT_CONNECT:
                case CURLE_OPERATION_TIMEOUTED:
                    $this->disableFTS();
                    return true;
            }
        }
        return false;
    }

    /**
     * Either index single bean or add the record to be indexed into _documents for later batch indexing,
     * depending on the $batch parameter
     *
     * @param $bean SugarBean object to be indexed
     * @param $batch boolean whether to do batch index
     */
    public function indexBean($bean, $batch = true)
    {
        if (!$this->isModuleFtsEnabled($bean->module_dir) ) {
            return;
        }

        if (!$batch) {
            if (self::isSearchEngineDown()) {
                $this->addRecordsToQueue(array('bean_id'=>$bean->id, 'bean_module'=>get_class($bean)));
                return;
            }
            $this->indexSingleBean($bean);
        } else {
            $this->logger->info("Adding bean to doc list with id: {$bean->id}");

            //Create and store our document index which will be bulk inserted later, do not store beans as they are heavy.
            $this->_documents[] = $this->createIndexDocument($bean);
        }
    }

    /**
     *
     * Return the 'type' for the index.  By using the bean type we can specify mappings on a per bean basis if we need
     * to in the future.
     *
     * @param $bean
     * @return string
     */
    protected function getIndexType($bean)
    {
        if (!empty($bean->module_dir)) {
            return $bean->module_dir;
        } else {
            return self::DEFAULT_INDEX_TYPE;
        }
    }

    /**
     *
     * @param SugarBean $bean
     * @return String owner, or null if no owner found
     */
    protected function getOwnerField($bean)
    {
        // when running full indexing, $bean may be a stdClass and not a SugarBean
        if ($bean instanceof SugarBean) {
            return $bean->getOwnerField();
        } else if (isset($bean->assigned_user_id)) {
            return $bean->assigned_user_id;
        } else if (isset($bean->created_by)) {
            return $bean->created_by;
        }
        return null;
    }

    /**
     *
     * @param SugarBean $bean
     * @param $searchFields
     * @return Elastica_Document|null
     */
    public function createIndexDocument($bean, $searchFields = null)
    {
        if ($searchFields == null) {
            $searchFields = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($bean);
        }

        if (!empty($searchFields['email1']) && empty($bean->email1)) {
            $emailAddress = BeanFactory::getBean('EmailAddresses');
            $bean->email1 = $emailAddress->getPrimaryAddress($bean);
        }

        $keyValues = array();
        foreach ($searchFields as $fieldName => $fieldDef) {
            //All fields have already been formatted to db values at this point so no further processing necessary
            if (!empty($bean->$fieldName)) {
                // 1. elasticsearch does not handle multiple types in a query very well
                // so let's use only strings so it won't be indexed as other types
                // 2. for some reason, bean fields are encoded, decode them first
                // We are handling date range search for Meetings which is type datetimecombo
                if (!isset($fieldDef['type']) || $fieldDef['type'] != 'datetimecombo') {
                    $keyValues[$fieldName] = strval(html_entity_decode($bean->$fieldName, ENT_QUOTES));
                } elseif (isset($fieldDef['type']) && $fieldDef['type'] == 'datetimecombo') {
                    // dates have to be in ISO-8601 without the : in the TZ
                    global $timedate;

                    $date = $timedate->fromUser($bean->$fieldName);
                    if (empty($date)) {
                        $date = $timedate->fromDb($bean->$fieldName);
                    }

                    if ($date instanceof SugarDateTime) {
                        $keyValues[$fieldName] = $timedate->asIso($date, null, array('stripTZColon' => true));
                    } else {
                        $GLOBALS['log']->error("TimeDate Conversion Failed for " . get_class($bean) . "->{$fieldName}");
                    }
                } else {
                    $keyValues[$fieldName] = $bean->$fieldName;
                }
            }
        }

        //Always add our module
        $keyValues['module'] = $bean->module_dir;

        if (isset($bean->team_set_id)) {
            $keyValues['team_set_id'] = $this->formatGuidFields($bean->team_set_id);
        }

        $user_ids = SugarFavorites::getUserIdsForFavoriteRecordByModuleRecord($bean->module_dir, $bean->id);
        $keyValues['user_favorites'] = array();

        foreach ($user_ids as $user_id) {
            // need to replace -'s for elastic search, same as team_set_ids
            $keyValues['user_favorites'][] = $this->formatGuidFields($user_id);
        }

        // to index owner
        $ownerField = $this->getOwnerField($bean);
        if ($ownerField) {
            $keyValues['doc_owner'] = $this->formatGuidFields($ownerField);
        }

        if (empty($keyValues)) {
            return null;
        } else {
            return new Elastica_Document($bean->id, $keyValues, $this->getIndexType($bean));
        }
    }

    /**
     * In our current implementation we need to strip the -'s from our guids to be searchable correctly
     * @param string $field_value
     * @return string
     */
    public function formatGuidFields($field_value)
    {
        return str_replace('-', '', strval($field_value));
    }

    /**
     * This indexes one single bean to Elastic Search engine
     * @param SugarBean $bean
     */
    public function indexSingleBean($bean)
    {
        $this->logger->info("Preforming single bean index");
        try {
            $index = new Elastica_Index($this->_client, $this->_indexName);
            $type = new Elastica_Type($index, $this->getIndexType($bean));
            $doc = $this->createIndexDocument($bean);
            if ($doc != null) {
                $type->addDocument($doc);
            }
        } catch (Exception $e) {
            $this->reportException("Unable to index bean", $e);
            if ($this->checkException($e)) {
                $recordsToBeQueued = $this->getRecordsFromDocs(array($doc));
                $this->addRecordsToQueue($recordsToBeQueued);
            }
        }

    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineInterface::delete()
     */
    public function delete(SugarBean $bean)
    {
        if (self::isSearchEngineDown()) {
            return;
        }
        if (empty($bean->id)) {
            return;
        }

        try {
            $this->logger->info("Going to delete {$bean->id}");
            $index = new Elastica_Index($this->_client, $this->_indexName);
            $type = new Elastica_Type($index, $this->getIndexType($bean));
            $type->deleteById($bean->id);
        } catch (Exception $e) {
            $this->reportException("Unable to delete index", $e);
            $this->checkException($e);
        }
    }

    /**
     * (non-PHPdoc)
     * @see SugarSearchEngineInterface::bulkInsert()
     */
    public function bulkInsert(array $docs)
    {
        if (self::isSearchEngineDown()) {
            $recordsToBeQueued = $this->getRecordsFromDocs($docs);
            $this->addRecordsToQueue($recordsToBeQueued);
            return false;
        }

        try {
            $index = new Elastica_Index($this->_client, $this->_indexName);
            $batchedDocs = array();
            $x = 0;
            foreach ($docs as $singleDoc) {
                if ($x != 0 && $x % self::MAX_BULK_THRESHOLD == 0) {
                    $index->addDocuments($batchedDocs);
                    $batchedDocs = array();
                } else {
                    $batchedDocs[] = $singleDoc;
                }

                $x++;
            }

            //Commit the stragglers
            if (count($batchedDocs) > 0) {
                $index->addDocuments($batchedDocs);
            }
        } catch (Exception $e) {
            $this->reportException("Error performing bulk update operation", $e);
            if ($this->checkException($e)) {
                $recordsToBeQueued = $this->getRecordsFromDocs($batchedDocs);
                $this->addRecordsToQueue($recordsToBeQueued);
            }
            return false;
        }

        return true;
    }

    /**
     * Given an array of documents, this constructs an array of records that can be saved to FTS queue.
     * @param SugarBean $bean
     * @return array
     */
    protected function getRecordsFromDocs($docs)
    {
        $records = array();
        $i = 0;
        foreach ($docs as $doc) {
            $records[$i]['bean_id'] = $doc->getId();
            $records[$i]['bean_module'] = BeanFactory::getBeanName($doc->getType());
            $i++;
        }
        return $records;
    }

    /**
     * Check the server status
     */
    public function getServerStatus()
    {
        $isValid = false;
        $displayText = "";
        $timeOutValue = $this->_client->getConfig('timeout');
        try {
            $this->_client->setConfigValue('timeout', 5);
            $results = $this->_client->getStatus()->getServerStatus();
            if (!empty($results['ok']) ) {
                $isValid = true;
                if (!empty($GLOBALS['app_strings'])) {
                    $displayText = $GLOBALS['app_strings']['LBL_EMAIL_SUCCESS'];
                } else {
                    //Fix a notice error during install when we verify the Elastic Search settings
                    $displayText = 'Success';
                }
            } else {
                $displayText = $results;
            }
        } catch (Exception $e) {
            $this->reportException("Unable to get server status", $e);
            $displayText = $e->getMessage();
        }
        //Reset previous timeout value.
        $this->_client->setConfigValue('timeout', $timeOutValue);
        return array('valid' => $isValid, 'status' => $displayText);
    }

    /**
     * This function returns an array of fields that can be passed to search engine.
     * @param Array $options
     * @return Array array of fields
     */
    protected function getSearchFields($options)
    {
        $fields = array();
        if (!empty($options['moduleFilter'])) {
            foreach ($options['moduleFilter'] as $mod) {
                $fieldDef = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsPerModule($mod);
                foreach ($fieldDef as $fieldName => $def) {
                    // we are currently using datetimecombo which breaks field based search in Elastic, we don't want to include datetimecombo in searches
                    if (!in_array($fieldName, $fields) && $def['type'] != 'datetimecombo') {
                        if (isset($options['addSearchBoosts']) && $options['addSearchBoosts'] == true && isset($def['full_text_search']['boost'])) {
                            $fieldName .= '^' . $def['full_text_search']['boost'];
                            $fieldName = $mod . '.' . $fieldName;
                        }

                        $fields[] = $fieldName;
                    }
                }
            }
        } else {
            $allFieldDef = SugarSearchEngineMetadataHelper::retrieveFtsEnabledFieldsForAllModules();
            foreach ($allFieldDef as $module => $fieldDef) {
                foreach ($fieldDef as $fieldName => $def) {
                    // we are currently using datetimecombo which breaks field based search in Elastic, we don't want to include datetimecombo in searches
                    if (!in_array($fieldName, $fields) && $def['type'] != 'datetimecombo') {
                        if (isset($options['addSearchBoosts']) && $options['addSearchBoosts'] == true && isset($def['full_text_search']['boost'])) {
                            $fieldName .= '^' . $def['full_text_search']['boost'];
                            $fieldName = $mod . '.' . $fieldName;
                        }
                        $fields[] = $fieldName;
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * Given fields and options, this function constructs and returns a highlight array that can be passed to
     * search engine.
     * @param SugarBean $bean
     * @param $searchFields
     * @return Elastica_Document|null
     */
    protected function constructHighlightArray($fields, $options)
    {
        if (isset($options['preTags'])) {
            $preTags = $options['preTags'];
        } else {
            $preTags = SugarSearchEngineHighlighter::$preTag;
        }

        if (isset($options['postTags'])) {
            $postTags = $options['postTags'];
        } else {
            $postTags = SugarSearchEngineHighlighter::$postTag;
        }

        $fieldArray = array();
        $highlightProperties = new stdClass();
        if (isset($options['fragmentSize'])) {
            $highlightProperties->fragment_size = $options['fragmentSize'] + strlen($preTags) + strlen($postTags);
        } else {
            $highlightProperties->fragment_size = SugarSearchEngineHighlighter::$fragmentSize + strlen($preTags) + strlen($postTags);
        }

        if (isset($options['fragmentNumber'])) {
            $highlightProperties->number_of_fragments = $options['fragmentNumber'];
        } else {
            $highlightProperties->number_of_fragments = SugarSearchEngineHighlighter::$fragmentNumber;
        }

        foreach ($fields as $field) {
            $fieldArray[$field] = $highlightProperties;
        }

        $highlighArray = array('fields'=>$fieldArray,
            'order'=>'score',
            'pre_tags'=>array($preTags),
            'post_tags'=>array($postTags));

        return $highlighArray;
    }

    /**
     * This function determines whether we should append wildcard to search string.
     *
     * @param String $queryString
     * @return Boolean
     */
    protected function canAppendWildcard($queryString)
    {
        $queryString = trim(html_entity_decode($queryString, ENT_QUOTES));
        if (substr($queryString, -1) ===  self::WILDCARD_CHAR) {
            return false;
        }

        // for fuzzy search, do not append wildcard
        if (strpos($queryString, '~') !==  false) {
            return false;
        }

        // for range searches, do not append wildcard
        if (preg_match('/\[.*TO.*\]/', $queryString) || preg_match('/{.*TO.*}/', $queryString)) {
            return false;
        }

        // for group searches, do not append wildcard
        if (preg_match('/\(.*\)/', $queryString)) {
            return false;
        }

        // when using double quotes, do not append wildcard
        if (strpos($queryString, '"') !==  false) {
            return false;
        }

        return true;
    }

    /*
     * A sample team filter looks like this:
       {"or": [
         {"term":{"team_set_id":"1"}},
         {"term":{"team_set_id":"46ca01386366bc910d074fb2f8200f03"}},
         {"term":{"team_set_id":"East"}},
         {"term":{"team_set_id":"West"}}]
       }
    */
    /**
     * This function constructs and returns team filter for elasticsearch query.
     *
     * @return Elastica_Filter_Or
     */
    protected function constructTeamFilter()
    {
        $teamIDS = TeamSet::getTeamSetIdsForUser($GLOBALS['current_user']->id);

        //TODO: Determine why term filters aren't working with the hyphen present.
        //Term filters dont' work for terms with '-' present so we need to clean
        $teamIDS = array_map(array($this,'cleanTeamSetID'), $teamIDS);

        $termFilter = new Elastica_Filter_Terms('team_set_id', $teamIDS);

        return $termFilter;
    }

    /**
     * This function constructs and returns type term filter for elasticsearch query.
     *
     * @return Elastica_Filter_Term
     */
    protected function getTypeTermFilter($module)
    {
        $typeTermFilter = new Elastica_Filter_Term();
        $typeTermFilter->setTerm('_type', $module);

        return $typeTermFilter;
    }

    /**
     * This function constructs and returns owner term filter for elasticsearch query.
     *
     * @return Elastica_Filter_Term
     */
    protected function getOwnerTermFilter()
    {
        $ownerTermFilter = new Elastica_Filter_Term();
        $ownerTermFilter->setTerm('doc_owner', $this->formatGuidFields($GLOBALS['current_user']->id));

        return $ownerTermFilter;
    }

    /**
     * This function constructs and returns module level filter for elasticsearch query.
     *
     * @return Elastica_Filter_And
     */
    protected function constructModuleLevelFilter($module)
    {
        $requireOwner = ACLController::requireOwner($module, 'list');

        $seed = BeanFactory::newBean($module);

        $hasAdminAccess = $GLOBALS['current_user']->isAdminForModule($seed->getACLCategory());

        $moduleFilter = new Elastica_Filter_And();

        if ($hasAdminAccess) {
            $typeTermFilter = $this->getTypeTermFilter($module);
            $moduleFilter->addFilter($typeTermFilter);
            // user has admin access for this module, skip team filter
            if ($requireOwner) {
                // owner term filter
                $ownerTermFilter = $this->getOwnerTermFilter();
                $moduleFilter->addFilter($ownerTermFilter);
            }
        } else {

            // team filter
            $teamFilter = $this->constructTeamFilter();
            $moduleFilter->addFilter($teamFilter);

            // type term filter
            $typeTermFilter = $this->getTypeTermFilter($module);
            $moduleFilter->addFilter($typeTermFilter);

            if ($requireOwner) {
                // need to be document owner to view, owner term filter
                $ownerTermFilter = $this->getOwnerTermFilter();
                $moduleFilter->addFilter($ownerTermFilter);
            }
        }
        return $moduleFilter;
    }

    /**
     * This function constructs and returns main filter for elasticsearch query.
     *
     * @return Elastica_Filter_Or
     */
    protected function constructMainFilter($finalTypes, $options = array())
    {
        $mainFilter = new Elastica_Filter_Or();
        foreach ($finalTypes as $module) {
            $moduleFilter = $this->constructModuleLevelFilter($module);
            // if we want myitems add more to the module filter
            if (isset($options['my_items']) && $options['my_items'] !== false) {
                $moduleFilter = $this->myItemsSearch($moduleFilter);
            }
            if (isset($options['filter']) && $options['filter']['type'] == 'range') {
                $moduleFilter = $this->constructRangeFilter($moduleFilter, $options['filter']);
            }

            // we only want JUST favorites if the option is 2
            // if the option is 1 that means we want all including favorites,
            // which in FTS is a normal search parameter
            if (isset($options['favorites']) && $options['favorites'] == 2) {
                $favoritesFilter = $this->constructMyFavoritesFilter();
                $moduleFilter->addFilter($favoritesFilter);
            }

            $mainFilter->addFilter($moduleFilter);

        }

        return $mainFilter;
    }



    /**
     * Construct a favorites filter
     * @param object $moduleFilter
     * @return object $moduleFilter
     */

    protected function constructMyFavoritesFilter()
    {
        $ownerTermFilter = new Elastica_Filter_Term();
        // same bug as team set id, looking into a fix in elastic search to allow -'s without tokenizing

        $ownerTermFilter->setTerm('user_favorites', $this->formatGuidFields($GLOBALS['current_user']->id));

        return $ownerTermFilter;
    }

    /**
     * Construct a Range Filter to
     * @param object $moduleFilter
     * @param array $filter
     * @return object $moduleFilter
     */
    protected function constructRangeFilter($moduleFilter, $filter)
    {
        $filter = new Elastica_Filter_Range($filter['fieldname'], $filter['range']);
        $moduleFilter->addFilter($filter);
        return $moduleFilter;
    }

    /**
     * Add a Owner Filter For MyItems to the current module
     * @param object $moduleFilter
     * @return object
     */
    public function myItemsSearch($moduleFilter)
    {
        $ownerTermFilter = $this->getOwnerTermFilter();
        $moduleFilter->addFilter($ownerTermFilter);
        return $moduleFilter;
    }

    /**
     * @param $queryString
     * @param int $offset
     * @param int $limit
     * @return null|SugarSeachEngineElasticResultSet
     */
    public function search($queryString, $offset = 0, $limit = 20, $options = array())
    {
        if (self::isSearchEngineDown()) {
            return null;
        }

        $appendWildcard = false;
        if (!empty($options['append_wildcard']) && $this->canAppendWildcard($queryString)) {
            $appendWildcard = true;
        }
        $queryString = self::WILDCARD_CHAR . sql_like_string($queryString, self::WILDCARD_CHAR, self::WILDCARD_CHAR, $appendWildcard);

        $this->logger->info("Going to search with query $queryString");
        $results = null;
        try {
            // trying to match everything, make a MatchAll query
            if ($queryString == '*') {
                $queryObj = new Elastica_Query_MatchAll();

            } else {
                $qString = html_entity_decode($queryString, ENT_QUOTES);
                $queryObj = new Elastica_Query_QueryString($qString);
                $queryObj->setAnalyzeWildcard(true);
                $queryObj->setAutoGeneratePhraseQueries(false);

                // set query string fields
                $options['addSearchBoosts'] = true;
                $fields = $this->getSearchFields($options);
                $options['addSearchBoosts'] = false;
                if (!empty($options['searchFields'])) {
                    $queryObj->setFields($options['searchFields']);
                } else {
                    $queryObj->setFields($fields);
                }
            }
            $s = new Elastica_Search($this->_client);
            //Only search across our index.
            $index = new Elastica_Index($this->_client, $this->_indexName);
            $s->addIndex($index);

            $finalTypes = array();
            if (!empty($options['moduleFilter'])) {
                foreach ($options['moduleFilter'] as $moduleName) {
                    $seed = BeanFactory::newBean($moduleName);
                    // only add the module to the list if it can be viewed
                    if ($seed->ACLAccess('ListView')) {
                        $finalTypes[] = $moduleName;
                    }
                }
                if (!empty($finalTypes)) {
                    $s->addTypes($finalTypes);
                }
            }


            // main filter
            $mainFilter = $this->constructMainFilter($finalTypes, $options);

            $query = new Elastica_Query($queryObj);
            $query->setFilter($mainFilter);

            if (isset($options['sort']) && is_array($options['sort'])) {
                foreach ($options['sort'] as $sort) {
                    $query->addSort($sort);
                }
            }

            $query->setParam('from', $offset);

            // set query highlight
            $fields = $this->getSearchFields($options);
            $highlighArray = $this->constructHighlightArray($fields, $options);
            $query->setHighlight($highlighArray);

            //Add a type facet so we can see how our results are grouped.
            if (!empty($options['apply_module_facet'])) {
                $typeFacet = new Elastica_Facet_Terms('_type');
                $typeFacet->setField('_type');
                // need to add filter for facet too
                if (isset($mainFilter)) {
                    $typeFacet->setFilter($mainFilter);
                }
                $query->addFacet($typeFacet);
            }

            $esResultSet = $s->search($query, $limit);
            $results = new SugarSeachEngineElasticResultSet($esResultSet);
        } catch (Exception $e) {
            $this->reportException("Unable to perform search", $e);
            $this->checkException($e);
            return null;
        }
        return $results;
    }

    /**
     * Remove the '-' from our team sets.
     *
     * @param $teamSetID
     * @return mixed
     */
    protected function cleanTeamSetID($teamSetID)
    {
        return str_replace("-", "", strtolower($teamSetID));
    }

    /**
     * Create the index and mapping.
     *
     * @param boolean $recreate OPTIONAL Deletes index first if already exists (default = false)
     *
     */
    public function createIndex($recreate = false)
    {
        if (self::isSearchEngineDown()) {
            return;
        }

        try {
            // create an elastic index
            $index = new Elastica_Index($this->_client, $this->_indexName);
            $index->create(array(), $recreate);

             // create field mappings
            require_once('include/SugarSearchEngine/Elastic/SugarSearchEngineElasticMapping.php');
            $elasticMapping = new SugarSearchEngineElasticMapping($this);
            $elasticMapping->setFullMapping();
        } catch (Exception $e) {
            // ignore the IndexAlreadyExistsException exception
            if (strpos($e->getMessage(), 'IndexAlreadyExistsException') === false) {
                $this->reportException("Unable to create index", $e);
                $this->checkException($e);
            }
        }

    }

    /**
     * Get Elastica client
     * @return Elastica_Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Get the name of the index
     * @return string
     */
    public function getIndexName()
    {
        return $this->_indexName;
    }
}
