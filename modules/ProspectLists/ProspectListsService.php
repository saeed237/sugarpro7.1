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

class ProspectListsService
{
    /**
     * Add records to a specific prospect list
     *
     * @param $moduleName         the module name for the records that will be associated to the prospect list
     * @param $prospectListId the id of the prospect list
     * @param $recordIds      Array of record ids to be added to the prospect list
     * @return $results       Associative array containing status for each record.
     */
    public function addRecordsToProspectList($moduleName, $prospectListId, $recordIds)
    {
        $prospectList = BeanFactory::getBean("ProspectLists", $prospectListId, array('strict_retrieve' => true));

        if(empty($prospectList)) {
            return false;
        }

        $bean = BeanFactory::newBean($moduleName);
        $results = array();
        $relationship = '';

        foreach ($bean->get_linked_fields() as $field => $def) {
            if ($bean->load_relationship($field)) {
                if ($bean->$field->getRelatedModuleName() == 'ProspectLists') {
                    $relationship = $field;
                    break;
                }
            }
        }

        if ($relationship != '') {
            foreach ($recordIds as $id) {
                $retrieveResult = $bean->retrieve($id);
                if ($retrieveResult === null) {
                    $results[$id] = false;
                } else {
                    $bean->load_relationship($relationship);
                    $bean->prospect_lists->add($prospectListId);
                    $results[$id] = true;
                }
            }
        }

        return $results;
    }
}