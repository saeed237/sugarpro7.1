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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


require_once('include/Dashlets/DashletGenericChart.php');

class MyTeamModulesUsedChartDashlet extends DashletGenericChart
{
    /**
     * @see Dashlet::$isConfigurable
     */
    public $isConfigurable = true;
    
    /**
     * @see DashletGenericChart::$_seedName
     */
    protected $_seedName = 'Trackers';
    
    /**
     * @see Dashlet::$isConfigPanelClearShown
     */
    public $isConfigPanelClearShown = false;
    
    /**
     * @see DashletGenericChart::display()
     */
    public function display() 
    {
        global $db;

        require("modules/Charts/chartdefs.php");
        $chartDef = $chartDefs['my_team_modules_used_last_30_days'];

        require_once('include/SugarCharts/SugarChartFactory.php');
        $sugarChart = SugarChartFactory::getInstance();
        $sugarChart->forceHideDataGroupLink = true;
        $sugarChart->setProperties('', $chartDef['chartUnits'], $chartDef['chartType']);
        $sugarChart->group_by = $chartDef['groupBy'];
        $sugarChart->url_params = array();

        $result = $db->query($this->constructQuery());
        $dataset = array();
        while(($row = $db->fetchByAssoc($result)))
            $dataset[] = array('user_name'=>$row['user_name'], 'module_name'=>$row['module_name'], 'total'=>$row['count']);

        $sugarChart->setData($dataset);

        $xmlFile = $sugarChart->getXMLFileName($this->id);
        $sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML());
	
        return $this->getTitle('<div align="center"></div>') . 
            '<div align="center">' . $sugarChart->display($this->id, $xmlFile, '100%', '480', false) . '</div>'. $this->processAutoRefresh();
	}

    /**
     * @see Dashlet::hasAccess()
     */
    public function hasAccess()
    {
    	return ACLController::checkAccess('Trackers', 'view', false, 'Tracker');
    }	
	
    /**
     * @see DashletGenericChart::constructQuery()
     */
    protected function constructQuery() 
    {
		return "SELECT l1.user_name, tracker.module_name, count(*) count " .
                    "FROM tracker INNER JOIN users l1 ON l1.id = tracker.user_id and l1.deleted = 0 " .
                    "WHERE tracker.deleted = 0 AND tracker.date_modified > ".db_convert("'".$GLOBALS['timedate']->getNow()->modify("-30 days")->asDb()."'" ,"datetime")." " .
                        "AND tracker.user_id in (Select id from users where reports_to_id = '{$GLOBALS['current_user']->id}') " .
                    "GROUP BY l1.user_name, tracker.module_name " .
                    "ORDER BY l1.user_name ASC";
	}
}