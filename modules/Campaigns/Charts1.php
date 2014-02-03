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

/*********************************************************************************

* Description:  Includes the functions for Customer module specific charts.
********************************************************************************/
//todo: experimental class for chart data handling..not used in the application at this time.



require_once('include/charts/Charts.php');




class charts {

    /* @function:
     *
     * @param array targets: translated list of all activity types, targeted, bounced etc..
     * @param string campaign_id: chart for this campaign.
     */
    function campaign_response_chart($targets,$campaign_id) {

        $focus = BeanFactory::getBean('Campaigns');
        $leadSourceArr = array();

        $query = "SELECT activity_type,target_type, count(*) hits ";
        $query.= " FROM campaign_log ";
        $query.= " WHERE campaign_id = '$campaign_id' AND archived=0 AND deleted=0";
        $query.= " GROUP BY  activity_type, target_type";
        $query.= " ORDER BY  activity_type, target_type";

        $result = $focus->db->query($query);
        while($row = $focus->db->fetchByAssoc($result, false)) {

            if (isset($leadSourceArr[$row['activity_type']]['value'])) {
                $leadSourceArr[$row['activity_type']]['value']=0;
            }

            $leadSourceArr[$row['activity_type']]['value']=  $leadSourceArr[$row['activity_type']]['value'] + $row['hits'];

            if (!empty($row['target_type'])) {
                $leadSourceArr[$row['activity_type']]['bars'][$row['target_type']]['value']=$row['hits'];
            }
        }

        foreach ($targets as $key=>$value) {
            if (!isset($leadSourceArr[$key])) {
                $leadSourceArr[$key]['value']=0;
            }
        }

        //use the new template.
        $xtpl=new XTemplate ('modules/Campaigns/chart.tpl');
        $xtpl->assign("GRAPHTITLE",'Campaign Response by Recipient Activity');
        $xtpl->assign("Y_DEFAULT_ALT_TEXT",'Rollover a bar to view details.');

        //process rows
        foreach ($leadSourceArr as $key=>$values) {
            if (isset($values['bars'])) {
                foreach ($values['bars'] as $bar_id=>$bar_value) {
                    $xtpl->assign("Y_BAR_ID",$bar_id);
                }
            }

        }
    }
    }// end charts class
?>
