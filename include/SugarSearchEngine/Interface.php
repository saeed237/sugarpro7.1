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




/**
 * Generic interface all sublcasses must implement in order to be pluggable with FTS.
 * @api
 */
interface SugarSearchEngineInterface{

    /**
     *
     * Perform a search against the Full Text Search Engine
     *
     * @abstract
     * @param $query
     * @param int $offset
     * @param int $limit
     * @return void
     */
    public function search($query, $offset = 0, $limit = 20);

    /**
     * Pass in a bean and go through the list of fields to pass to the engine
     *
     * @abstract
     * @param $bean
     * @return void
     */
    public function indexBean($bean, $batched = TRUE);

    /**
     *
     * Delete a bean from the Full Text Search Engine
     *
     * @abstract
     * @param $bean
     * @return void
     */
    public function delete(SugarBean $bean);


    /**
     * Perform bulk inserts on serveral documents to mitigate performance issues.
     *
     * @abstract
     *
     */
    public function bulkInsert(array $docs);

    /**
     * Create the index document that will be sent to the IR System.
     *
     * @abstract
     * @param SugarBean}stdClass $bean
     * @param array|null $searchFields
     */
    public function createIndexDocument($bean, $searchFields = null);

    /**
     * Return info about the server status.
     *
     * @abstract
     * @return array valid: indicates if the connection was successful. status: text to display to the end user
     */
    public function getServerStatus();

    /**
     * Create the index
     *
     * @abstract
     * @param boolean $recreate OPTIONAL Deletes index first if already exists (default = false)
     *
     */
    public function createIndex($recreate = false);
}

/**
 *  Interface to access results from a FTS search.  Is composed of zero or more SugarSearchEngineResult objects.
 */
interface SugarSearchEngineResultSet extends Iterator, Countable
{
    /**
     * Get the total hits found by the search criteria.
     *
     * @abstract
     * @return int
     */
    public function getTotalHits();

    /**
     * Get the total amount of time the search took to complete.
     *
     * @abstract
     * @return int
     */
    public function getTotalTime();

    /**
     * Return facets associated with this search.
     *
     * @return array
     */
    public function getFacets();

    /**
     * Return the facet results for the modules used in the search.
     *
     * @abstract
     */
    public function getModuleFacet();

}

/**
 * Interface for a single FTS result.
 */
interface SugarSearchEngineResult
{
    /**
     * Get the id of the result
     *
     * @abstract
     * @return String The id of the result, typically a SugarBean id.
     */
    public function getId();

    /**
     * Get the module name of the result
     *
     * @abstract
     * @return String
     *
     */
    public function getModule();

    /**
     * Get the translated module name of the result
     * @abstract
     * @return String
     */
    public function getModuleName();

    /**
     * Get the summary text of the result
     * @abstract
     * @return String
     */
    public function getSummaryText();


    /**
     * Return the highlighted text of a hit with the field name as the key
     *
     * @abstract
     *
     */
    public function getHighlightedHitText();


    /**
     * Never called within the view but helpful for debugging purposes.
     *
     * @abstract
     *
     */
    public function __toString();


}