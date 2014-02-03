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

require_once('include/SearchForm/SugarSpot.php');
require_once('include/api/SugarListApi.php');

class UnifiedSearchApi extends SugarListApi {
    public function registerApiRest() {
        return array(
            'globalSearch' => array(
                'reqType' => 'GET',
                'path' => array('search'),
                'pathVars' => array(''),
                'method' => 'globalSearch',
                'jsonParams' => array('fields'),
                'shortHelp' => 'Globally search records',
                'longHelp' => 'include/api/help/module_get_help.html',
            )
        );
    }

    protected $defaultLimit = 20; // How many records should we show if they don't pass up a limit
    protected $defaultModuleLimit = 20; // How many records should we show if they don't pass up a limit

    /**
     * This function pulls all of the search-related options out of the $args array and returns a fully-populated array with either the defaults or the provided settings
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @return array Many elements containing each setting the search engine uses
     */
    public function parseSearchOptions(ServiceBase $api, array $args)
    {
        $options = array();

        if ( isset($args['module_list']) && count($args['module_list']) == 1 ) {
            // We can create a bean of this type
            $seed = BeanFactory::newBean($args['module_list']);
        } else {
            $seed = null;
        }
        $options = parent::parseArguments($api, $args, $seed);

        $options['query'] = '';
        if ( isset($args['q']) ) {
            $options['query'] = trim($args['q']);
        }

        $options['limitPerModule'] = $this->defaultModuleLimit;
        if ( !empty($args['max_num_module']) ) {
            $options['limitPerModule'] = (int)$args['max_num_module'];
        }

        $options['searchFields'] = array();
        if (!empty($args['search_fields'])) {
            $options['searchFields'] = explode(',', $args['search_fields']);
        }

        $options['selectFields'] = array('id');
        if ( !empty($args['order_by']) ) {
            if ( strpos($args['order_by'],',') !== 0 ) {
                // There is a comma, we are ordering by more than one thing
                $orderBys = explode(',',$args['order_by']);
            } else {
                $orderBys = array($args['order_by']);
            }
            $orderByArray = array();
            foreach ( $orderBys as $order ) {
                if ( strpos($order,':') ) {
                    // It has a :, it's specifying ASC / DESC
                    list($column,$direction) = explode(':',$order);
                    if ( strtolower($direction) == 'desc' ) {
                        $direction = 'DESC';
                    } else {
                        $direction = 'ASC';
                    }
                } else {
                    // No direction specified, let's let it fly free
                    $column = $order;
                    $direction = 'ASC';
                }
/*
  // Need to extend this to do field security on all modules that we are searching by.
                if ( !$api->security->canAccessField($seed,$column,'list') || !isset($seed->field_defs[$column]) ) {
                    throw new SugarApiExceptionNotAuthorized('No access to view field: '.$column.' in module: '.$args['module']);
                }
*/
                // If this field has already been added, don't do it again
                // Common cause of this was the id field, since we always add it
                // by default.
                if (in_array($column, $options['selectFields'])) {
                    // Before busting out of this, ensure we have what we need
                    if (empty($orderByData[$column])) {
                        $orderByData[$column] = ($direction=='ASC'?true:false);
                        if (!in_array("$column $direction", $orderByArray)) {
                            $orderByArray[] = $column.' '.$direction;
                        }
                    }

                    continue;
                }
                $options['selectFields'][] = $column;
                $orderByData[$column] = ($direction=='ASC'?true:false);
                $orderByArray[] = $column.' '.$direction;
            }
            $options['orderBySetByApi'] = true;
            $orderBy = implode(',',$orderByArray);
        } else {
            /*
             * Adding id to the default sort by.  When data has the same date_modified the sort could change with the
             * offset showing the same record on multiple pages
             */
            $orderBy = 'date_modified DESC, id DESC';
            $orderByData['date_modified'] = false;
            $orderByData['id'] = false;
            $options['orderBySetByApi'] = false;
            $options['selectFields'][] = 'date_modified';
        }
        $options['orderByArray'] = $orderByData;
        $options['orderBy'] = $orderBy;

        $options['moduleList'] = array();
        if ( !empty($args['module_list']) ) {
            $options['moduleList'] = explode(',',$args['module_list']);
            // remove any empty moduleList array entries..if someone were to do Contacts, it would not hit elastic because '' is not an elastic module.
            $options['moduleList'] = array_filter($options['moduleList']);
        }
        $options['primaryModule'] = 'Home';
        if ( !empty($args['primary_module']) ) {
            $options['primaryModule']=$args['primary_module'];
        } else if ( isset($options['moduleList'][0]) ) {
            $options['primaryModule'] = $options['moduleList'][0];
        }

        // we want favorites info with records, so that we can flag a favorite out of a recordset
        $options['favorites'] = false;
        if ( !empty($args['favorites']) && $args['favorites'] == true ) {
            // Setting favorites to 1 includes favorites information,
            // setting it to 2 searches for favorite records.
            $options['favorites'] = 2;
        }
        $options['my_items'] = false;
        if ( !empty($args['my_items']) ) {
            // TODO: When the real filters get in, change it so that this is just described as an additional filter.
            $options['my_items'] = $args['my_items'];
        }

        $fieldFilters = array();
        // Sort out the multi-module field filter
        if ( !empty($args['fields']) ) {
            if ( is_array($args['fields']) ) {
                // This one has multiple modules in it we need to split it up among all of the modules
                $fieldFilters = $args['fields'];
            } else  {
                // They want one filter across all modules
                $fieldFilters['_default'] = explode(',',$args['fields']);
            }
        } else {
            $fieldFilters['_default'] = '';
        }
        // Ensure date_modified and id are in the list of fields
        foreach ( $fieldFilters as $key => $fieldArray ) {
            if ( empty($fieldArray) ) {
                // Just allow the defaults to take over
                continue;
            }
            foreach ( array('id','date_modified') as $requiredField ) {
                if ( !in_array($requiredField,$fieldArray) ) {
                    $fieldFilters[$key][] = $requiredField;
                }
            }
        }

        $options['fieldFilters'] = $fieldFilters;


        return $options;
    }

    /**
     * This function is the global search
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @return array result set
     */
    public function globalSearch(ServiceBase $api, array $args) {
        $api->action = 'list';
        require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');

        // This is required to keep the loadFromRow() function in the bean from making our day harder than it already is.
        $GLOBALS['disable_date_format'] = true;

        $options = $this->parseSearchOptions($api,$args);

        // determine the correct serach engine, don't pass any configs and fallback to the default search engine if the determiend one is down
        $searchEngine = SugarSearchEngineFactory::getInstance($this->determineSugarSearchEngine($api, $args, $options), array(), false);

        if ( $searchEngine instanceOf SugarSearchEngine) {
            $options['resortResults'] = true;
            $recordSet = $this->globalSearchSpot($api,$args,$searchEngine,$options);
            $sortByDateModified = true;
        } else {
            $recordSet = $this->globalSearchFullText($api,$args,$searchEngine,$options);
            $sortByDateModified = false;
        }


        $subscriptions = Subscription::checkSubscriptionList($api->user, $recordSet['records']);
        foreach ($recordSet['records'] as &$record) {
            $record['following'] = !empty($subscriptions[$record['id']]);
        }

        return $recordSet;
    }

    /**
     * This function is used to determine the search engine to use
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @param $options array An array of options to pass through to the search engine, they get translated to the $searchOptions array so you can see exactly what gets passed through
     * @return string name of the Search Engine
     */
    protected function determineSugarSearchEngine(ServiceBase $api, array $args, array $options)
    {
        require_once('include/SugarSearchEngine/SugarSearchEngineMetadataHelper.php');
        /*
            How to determine which Elastic Search
            1 - Not Portal
            2 - All Modules are full_text_search = true
            4 - not order by
        */

        /*
         * If a module isn't FTS switch to spot search.  Global Search should be done with either the enabled modules
         * Using the new ServerInfo endpoint OR passing in a blank module list.
         */
        if(!empty($options['moduleList']))
        {
            foreach($options['moduleList'] AS $module)
            {
                if(!SugarSearchEngineMetadataHelper::isModuleFtsEnabled($module))
                {
                    return 'SugarSearchEngine';
                }
            }
        }

        /*
         * Currently we cannot do an order by in FTS.  Thus any ordering must be done using the Spot Search
         */
        if(isset($options['orderBySetByApi']) && $options['orderBySetByApi'] == true) {
            return 'SugarSearchEngine';
        }

        // if the query is empty no reason to pass through FTS they want a normal list view.
        if(empty($args['q'])) {
            return 'SugarSearchEngine';
        }

        $fts = SugarSearchEngineFactory::getFTSEngineNameFromConfig();
        //everything is groovy for FTS, get the FTS Engine Name from the conig
        if(!empty($fts)) {
            return $fts;
        }
        return 'SugarSearchEngine';
    }

    /**
     * This function is used to hand off the global search to the FTS Search Emgine
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @param $searchEngine SugarSearchEngine The SugarSpot search engine created using the Factory in the caller
     * @param $options array An array of options to pass through to the search engine, they get translated to the $searchOptions array so you can see exactly what gets passed through
     * @return array Two elements, 'records' the list of returned records formatted through FormatBean, and 'next_offset' which will indicate to the user if there are additional records to be returned.
     */
    protected function globalSearchFullText(ServiceBase $api, array $args, SugarSearchEngineAbstractBase $searchEngine, array $options)
    {
        $options['append_wildcard'] = 1;
        if(empty($options['moduleList']))
        {
            require_once('modules/ACL/ACLController.php');
            $moduleList = SugarSearchEngineMetadataHelper::getSystemEnabledFTSModules();
            // filter based on User Access if Blank
            $ACL = new ACLController();
            // moduleList is passed by reference
            $ACL->filterModuleList($moduleList);

            $options['moduleList'] = $moduleList;
        }

        if (!empty($options['searchFields'])) {
            $customWhere = array();
            foreach ($options['moduleList'] as $module) {
                $seed = BeanFactory::getBean($module);
                $fields = array_keys($seed->field_defs);
                $existingfields = array_intersect($fields, $options['searchFields']);
                if (!empty($existingfields)) {
                    foreach ($existingfields as $field) {
                        if (empty($seed->field_defs[$field]['full_text_search'])) {
                            continue;
                        }
                        $prefix = $seed->module_name;
                        if (!isset($seed->field_defs[$field]['source']) || $seed->field_defs[$field]['source'] != 'non-db') {
                            $customWhere[] = "{$prefix}.{$field}";
                        }
                    }
                }
            }
            $options['searchFields'] = $customWhere;
        }

        $options['moduleFilter'] = $options['moduleList'];

        $results = $searchEngine->search($options['query'], $options['offset'], $options['limit'], $options);

        $returnedRecords = array();

        $total = 0;

        $api->action = 'list';

        if(is_object($results)) {
            foreach ( $results as $result ) {
                $record = BeanFactory::getBean($result->getModule(), $result->getId());

                // if we cant' get the bean skip it
                if($record === false)
                {
                    continue;
                }
                $module = $record->module_dir;
                // Need to override the filter arg so that it looks like something formatBean expects
                if ( !empty($options['fieldFilters'][$module]) ) {
                    $moduleFields = $options['fieldFilters'][$module];
                } else if ( !empty($options['fieldFilters']['_default']) ) {
                    $moduleFields = $options['fieldFilters']['_default'];
                } else {
                    $moduleFields = array();
                }
                $moduleArgs['fields'] = implode(',',$moduleFields);
                $formattedRecord = $this->formatBean($api,$moduleArgs,$record);
                $formattedRecord['_module'] = $module;
                // The SQL based search engine doesn't know how to score records, so set it to 1
                $formattedRecord['_search']['score'] = $result->getScore();

                //Add highlighted text
                $formattedRecord['_search']['highlighted'] = $result->getHighlightedHitText();

                $returnedRecords[] = $formattedRecord;
            }

            $total = $results->getTotalHits();

        }


        if ( $total > ($options['limit'] + $options['offset']))
        {
            $nextOffset = $options['offset']+$options['limit'];
        }
        else
        {
            $nextOffset = -1;
        }



        return array('next_offset'=>$nextOffset,'records'=>$returnedRecords);
    }

    /**
     * This function is used to hand off the global search to the built-in SugarSearchEngine (aka SugarSpot)
     * @param $api ServiceBase The API class of the request
     * @param $args array The arguments array passed in from the API
     * @param $searchEngine SugarSearchEngine The SugarSpot search engine created using the Factory in the caller
     * @param $options array An array of options to pass through to the search engine, they get translated to the $searchOptions array so you can see exactly what gets passed through
     * @return array Two elements, 'records' the list of returned records formatted through FormatBean, and 'next_offset' which will indicate to the user if there are additional records to be returned.
     */
    public function globalSearchSpot(ServiceBase $api, array $args, $searchEngine, array $options)
    {
        require_once('modules/Home/UnifiedSearchAdvanced.php');


        $searchOptions = array(
            'modules'=>$options['moduleList'],
            'current_module'=>$options['primaryModule'],
            'return_beans'=>true,
            'my_items'=>$options['my_items'],
            'favorites'=>$options['favorites'],
            'orderBy'=>$options['orderBy'],
            'fields'=>$options['fieldFilters'],
            'selectFields'=>$options['selectFields'],
            'limitPerModule'=>$options['limitPerModule'],
            'allowEmptySearch'=>true,
            'distinct'=>'DISTINCT', // Needed until we get a query builder
            'return_beans'=>true,
            );

        $multiModule = false;
        if ( empty($options['moduleList']) || count($options['moduleList']) == 0 || count($options['moduleList']) > 1 ) {
            $multiModule = true;
        }

        if(empty($options['moduleList']))
        {
            require_once('modules/ACL/ACLController.php');
            $usa = new UnifiedSearchAdvanced();
            $moduleList = $usa->getUnifiedSearchModules();

            // get the module names [array keys]
            $moduleList = array_keys($moduleList);
            // filter based on User Access if Blank
            $ACL = new ACLController();
            // moduleList is passed by reference
            $ACL->filterModuleList($moduleList);
            $searchOptions['modules'] = $options['moduleList'] = $moduleList;
        }

        if (!empty($options['searchFields'])) {
            $customWhere = array();
            foreach ($options['moduleList'] as $module) {
                $seed = BeanFactory::getBean($module);
                $fields = array_keys($seed->field_defs);
                $existingfields = array_intersect($fields, $options['searchFields']);
                if (!empty($existingfields)) {
                    $customTable = $seed->get_custom_table_name();
                    $table = $seed->table_name;
                    foreach ($existingfields as $field) {
                        if (!isset($seed->field_defs[$field]['unified_search']) || $seed->field_defs[$field]['unified_search'] !== true) {
                            continue;
                        }
                        $prefix = $table;
                        if (isset($GLOBALS['dictionary'][$seed->object_name]['custom_fields'][$field])) {
                            $prefix = $customTable;
                        }
                        if (!isset($seed->field_defs[$field]['source']) || $seed->field_defs[$field]['source'] != 'non-db') {
                            $customWhere[$module][] = "{$prefix}.{$field} LIKE '{$options['query']}%'";
                        }
                    }
                    if (isset($customWhere[$module])) {
                        $searchOptions['custom_where_module'][$module] = '(' . implode(' OR ', $customWhere[$module]) . ')';
                    }
                }
            }
        }

        $offset = $options['offset'];
        // One for luck.
        // Well, actually it's so that we know that there are additional results
        $limit = $options['limit']+1;
        if ( $multiModule && $options['offset'] != 0 ) {
            // With more than one module, there is no way to do offsets for real, so we have to fake it.
            $limit = $limit+$offset;
            $offset = 0;
        }

        if ( !$multiModule ) {
            // It's not multi-module, the per-module limit should be the same as the master limit
            $searchOptions['limitPerModule'] = $limit;
        }

        if(isset($options['custom_select'])) {
            $searchOptions['custom_select'] = $options['custom_select'];
        }

        if(isset($options['custom_from'])) {
            $searchOptions['custom_from'] = $options['custom_from'];
        }

        if(isset($options['custom_where'])) {
            $searchOptions['custom_where'] = $options['custom_where'];
        }


        $results = $searchEngine->search($options['query'],$offset, $limit, $searchOptions);

        $returnedRecords = array();

        $api->action = 'list';

        foreach ( $results as $module => $moduleResults ) {
            if ( !is_array($moduleResults['data']) ) {
                continue;
            }
            $moduleArgs = $args;
            // Need to override the filter arg so that it looks like something formatBean expects
            if ( !empty($options['fieldFilters'][$module]) ) {
                $moduleFields = $options['fieldFilters'][$module];
            } else if ( !empty($options['fieldFilters']['_default']) ) {
                $moduleFields = $options['fieldFilters']['_default'];
            } else {
                $moduleFields = array();
            }
            $moduleArgs['fields'] = implode(',',$moduleFields);
            foreach ( $moduleResults['data'] as $record ) {
                $formattedRecord = $this->formatBean($api,$moduleArgs,$record);
                $formattedRecord['_module'] = $module;
                // The SQL based search engine doesn't know how to score records, so set it to 1
                $formattedRecord['_search']['score'] = 1.0;
                $returnedRecords[] = $formattedRecord;
            }
        }

        if ( $multiModule ) {
            // Need to re-sort the results because the DB search engine clumps them together per-module
            $this->resultSetSortData = $options['orderByArray'];
            usort($returnedRecords,array($this,'resultSetSort'));
        }

        if ( $multiModule && $options['offset'] != 0 ) {
            // The merged module mess leaves us in a bit of a pickle with offsets and limits
            if ( count($returnedRecords) > ($options['offset']+$options['limit']) ) {
                $nextOffset = $options['offset']+$options['limit'];
            } else {
                $nextOffset = -1;
            }
            $returnedRecords = array_slice($returnedRecords,$options['offset'],$options['limit']);
        } else {
            // Otherwise, offsets and limits should work.
            if ( count($returnedRecords) > $options['limit'] ) {
                $nextOffset = $options['offset']+$options['limit'];
            } else {
                $nextOffset = -1;
            }
            $returnedRecords = array_slice($returnedRecords,0,$options['limit']);
        }

        if ( $options['offset'] === 'end' ) {
            $nextOffset = -1;
        }

        return array('next_offset'=>$nextOffset,'records'=>$returnedRecords);
    }

    protected $resultSetSortData;
    /**
     * This function is used to resort the results that come out of SpotSearch, they are clumped per module and we need them sorted by potentially multiple columns.
     * For reference on how this function reacts, look at the PHP manual for usort()
     */
    public function resultSetSort($left, $right) {
        $greaterThan = 0;
        foreach ( $this->resultSetSortData as $key => $isAscending ) {
            $greaterThan = 0;
            if ( isset($left[$key]) != isset($right[$key]) ) {
                // One of them is set, the other one isn't
                // If the left one is set, then it is greater than the right one
                $greaterThan = (isset($left[$key])?1:-1);
            } else if ( !isset($left[$key]) ) {
                // Since the isset matches, and the left one isn't set, neither of them are set
                $greaterThan = 0;
            } else if ( $left[$key] == $right[$key] ) {
                $greaterThan = 0;
            } else {
                $greaterThan = ($left[$key]>$right[$key]?1:-1);
            }

            // Figured out if the left is greater than the right, now time to act
            if ( $greaterThan != 0 ) {
                if ( $isAscending ) {
                    return $greaterThan;
                } else {
                    return -$greaterThan;
                }
            }
        }
    }
}
