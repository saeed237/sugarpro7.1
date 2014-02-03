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
 * Queueing class for after_save hooks
 * @api
 */
class SugarSearchEngineQueueManager
{

    /**
     * @param $bean
     * @param $event
     * @param $args
     */
    function populateIndexQueue($bean, $event, $args)
    {
        $GLOBALS['log']->info("Adding the following bean to the populate queue- module: {$bean->object_name} , id: {$bean->id}");
        require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
        $searchEngine = SugarSearchEngineFactory::getInstance();
        /**
         * Due to the inability to update a documents fields when the field type is array
         * we need to reindex the entire bean.
         */
        if($bean instanceof SugarFavorites) {
            $new_bean = BeanFactory::getBean($bean->module, $bean->record_id);
            $searchEngine->indexBean($new_bean, FALSE);
        }
        else {
            $searchEngine->indexBean($bean, FALSE);
        }
    }
}