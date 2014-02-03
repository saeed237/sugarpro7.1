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




require_once('include/Dashlets/Dashlet.php');

class TopCampaignsDashlet extends Dashlet 
{ 
	protected $top_campaigns = array();
	
	/**
	 * Constructor
	 *
	 * @see Dashlet::Dashlet()
	 */
	public function __construct($id, $def = null) 
	{
        global $current_user, $app_strings;
        parent::Dashlet($id);
        $this->isConfigurable = true;
        $this->isRefreshable = true;        

        if(empty($def['title'])) { 
            $this->title = translate('LBL_TOP_CAMPAIGNS', 'Campaigns');
        } 
        else {
            $this->title = $def['title'];
        }
        
        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];
        
        $this->seedBean = BeanFactory::getBean('Opportunities');      

       	$qry = "SELECT C.name AS campaign_name, SUM(O.amount) AS revenue, C.id as campaign_id " .
			   "FROM campaigns C, opportunities O " .
			   "WHERE C.id = O.campaign_id " . 
			   "AND O.sales_stage = '".Opportunity::STAGE_CLOSED_WON."' " .
               "AND O.deleted = 0 " .
			   "GROUP BY C.name,C.id ORDER BY revenue desc";

		$result = $this->seedBean->db->limitQuery($qry, 0, 10);
		$row = $this->seedBean->db->fetchByAssoc($result);

		while ($row != null){
			array_push($this->top_campaigns, $row);
			$row = $this->seedBean->db->fetchByAssoc($result);			
		}
    }
    
    /**
	 * @see Dashlet::display()
	 */
	public function display()
	{
    	$ss = new Sugar_Smarty();
    	$ss->assign('lbl_campaign_name', translate('LBL_TOP_CAMPAIGNS_NAME', 'Campaigns'));
    	$ss->assign('lbl_revenue', translate('LBL_TOP_CAMPAIGNS_REVENUE', 'Campaigns'));    	
    	$ss->assign('top_campaigns', $this->top_campaigns);
    	
    	return parent::display() . $ss->fetch('modules/Campaigns/Dashlets/TopCampaignsDashlet/TopCampaignsDashlet.tpl');
    }
    
    /**
	 * @see Dashlet::displayOptions()
	 */
	public function displayOptions() 
    {
        $ss = new Sugar_Smarty();
        $ss->assign('titleLBL', translate('LBL_DASHLET_OPT_TITLE', 'Home'));
        $ss->assign('title', $this->title);
        $ss->assign('id', $this->id);
        $ss->assign('saveLBL', $GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']);
        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
        
		return $ss->fetch('modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashletConfigure.tpl');        
    }

    /**
	 * @see Dashlet::saveOptions()
	 */
	public function saveOptions($req) 
    {
        $options = array();
        
        if ( isset($req['title']) ) {
            $options['title'] = $req['title'];
        }
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        
        return $options;
    }
}
