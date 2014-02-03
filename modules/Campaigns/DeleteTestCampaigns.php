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
 * DeleteTestCampaigns.php
 *
 * This is a class to encapsulate deleting test campaigns
 * @author Collin Lee
 */
class DeleteTestCampaigns {

/**
 * deleteTestRecords
 *
 * This method deletes the test records for a given Campaign instance
 * @param Campaign $focus The Campaign instance
 */
function deleteTestRecords($focus)
{
    if(empty($focus) || empty($focus->id))
    {
        return;
    }

    $res = $focus->db->query("SELECT DISTINCT campaign_log.related_id emailid, prospect_lists.id as listid FROM campaign_log
            JOIN prospect_lists on campaign_log.list_id = prospect_lists.id
            WHERE campaign_log.campaign_id = '{$focus->id}' AND prospect_lists.list_type='test'");
    $test_ids = array();
    $test_list_ids = array();
    while($row = $focus->db->fetchByAssoc($res)) {
       $test_ids[] = $row['emailid'];
       $test_list_ids[$row['listid']] = true;
    }
    $test_list_ids = array_keys($test_list_ids);
    unset($res);
    if(!empty($test_ids)) {
        $focus->db->query("UPDATE emails SET deleted=1 WHERE id IN ('".join("','", $test_ids)."')");
    }

    if(!empty($test_list_ids)) {
        $query = "DELETE FROM emailman WHERE campaign_id = '{$focus->id}' AND list_id IN ('".join("','", $test_list_ids)."')";
        $focus->db->query($query);

        $query = "UPDATE campaign_log SET deleted=1 WHERE campaign_id = '{$focus->id}' AND list_id IN ('".join("','", $test_list_ids)."')";

        $focus->db->query($query);
    }
}

}