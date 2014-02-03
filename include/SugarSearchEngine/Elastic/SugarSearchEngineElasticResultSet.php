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


require_once("include/SugarSearchEngine/Interface.php");
require_once('include/SugarSearchEngine/Elastic/SugarSeachEngineElasticResult.php');

/**
 * Adapter class to Elastica Result Set
 */
class SugarSeachEngineElasticResultSet implements SugarSearchEngineResultSet
{

    /**
     * @var \Elastica_ResultSet
     */
    private $elasticaResultSet;

    /**
     * @param Elastica_ResultSet $rs
     */
    public function __construct(Elastica_ResultSet $rs)
    {
        $this->elasticaResultSet = $rs;
    }

    /**
     * Return the total number of hits found from our search
     *
     * @return int
     */
    public function getTotalHits()
    {
        return $this->elasticaResultSet->getTotalHits();
    }

    /**
     * Return facets associated with this search.
     *
     * @return array
     */
    public function getFacets()
    {
        return $this->elasticaResultSet->getFacets();
    }

    /**
     * Return the facet results for the modules used in the search.
     *
     * @return array|bool
     */
    public function getModuleFacet()
    {
        $rs = $this->elasticaResultSet->getFacets();
        $results = array();
        if( !isset($rs['_type'] ) || !isset($rs['_type']['terms']) )
        {
            return FALSE;
        }
        else
        {
            foreach( $rs['_type']['terms'] as $entry)
            {
                $results[$entry['term']] = $entry['count'];
            }

            return $results;
        }
    }
    /**
     * Get the total amount of time the search took to complete.
     *
     * @return int
     */
    public function getTotalTime()
    {
        return $this->elasticaResultSet->getTotalTime();
    }

    public function current()
    {
        return new SugarSeachEngineElasticResult($this->elasticaResultSet->current());
    }

    public function key()
    {
        return $this->elasticaResultSet->key();
    }

    public function next()
    {
        $this->elasticaResultSet->next();
    }

    public function rewind()
    {
        $this->elasticaResultSet->rewind();
    }

    public function valid()
    {
        return $this->elasticaResultSet->valid();
    }

    /**
     * Return the count of hits returned, may not necessarily equal total hits.
     *
     * @return int
     */
    public function count()
    {
        return $this->elasticaResultSet->count();
    }
}