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
require_once('include/SearchForm/SugarSpot.php');

/**
 * This class is an adapter to the existing SugarSpot/UnifiedSearch capabilities and is the default
 * search engine if no other external engines have been configured.
 * @api
 */
class SugarSearchEngine implements SugarSearchEngineInterface{


    public function search($query, $offset = 0, $limit = 20, $options = array() )
    {
        $sugarSpot = new SugarSpot();
        return $sugarSpot->search($query, $offset, $limit, $options);

    }

    /**
     * No-op
     *
     * @param $bean
     */
    public function indexBean($bean, $batched = TRUE) {}

    /**
     * No-op
     *
     * @param $bean
     */
    public function delete(SugarBean $bean) {}


    /**
     * No-op
     */
    public function bulkInsert(array $docs) {}

    /**
     * No-op
     */
    public function createIndexDocument($bean, $searchFields = null) {}

    /**
     * No-op
     */
    public function getServerStatus() {}

    /**
     * No-op
     */
    public function createIndex($recreate = false){}

}