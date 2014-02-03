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





require_once('include/Dashlets/DashletGenericChart.php');

class CampaignROIChartDashlet extends DashletGenericChart 
{
    public $campaign_id;
    
    /**
     * @see DashletGenericChart::$_seedName
     */
    protected $_seedName = 'Campaigns';
    
    /**
     * @see DashletGenericChart::displayOptions()
     */
    public function displayOptions() 
    {
        $this->getSeedBean()->disable_row_level_security = false;

        $campaigns = $this->getSeedBean()->get_full_list("","");
    	if ( $campaigns != null )
            foreach ($campaigns as $c)
                $this->_searchFields['campaign_id']['options'][$c->id] = $c->name;
    	else 
            $this->_searchFields['campaign_id']['options'] = array();
            
        return parent::displayOptions();
    }   
    
    /**
     * @see DashletGenericChart::display()
     */
    public function display()
    {
        require_once('modules/Campaigns/Charts.php');

        $roi_chart = new campaign_charts();
        $chartStr = $roi_chart->campaign_response_roi(
            $GLOBALS['app_list_strings']['roi_type_dom'],
            $GLOBALS['app_list_strings']['roi_type_dom'],
            $this->campaign_id[0],null,true,true,true,$this->id);
        
		$returnStr = $chartStr;
		
        return $this->getTitle('<div align="center"></div>') . '<div align="center">' . $returnStr . '</div>'. $this->processAutoRefresh();
    }
}