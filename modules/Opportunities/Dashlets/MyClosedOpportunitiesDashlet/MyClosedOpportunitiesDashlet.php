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

class MyClosedOpportunitiesDashlet extends Dashlet 
{ 
	protected $total_opportunities;
	protected $total_opportunities_won;
	
	/**
	 * @see Dashlet::Dashlet()
	 */
	public function __construct($id, $def = null) 
	{
        global $current_user, $app_strings;
        parent::Dashlet($id);
        $this->isConfigurable = true;
        $this->isRefreshable = true;        

        if(empty($def['title'])) { 
            $this->title = translate('LBL_MY_CLOSED_OPPORTUNITIES', 'Opportunities'); 
        } 
        else {
            $this->title = $def['title'];
        }
        
        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];
        
        $this->seedBean = BeanFactory::getBean('Opportunities');      

        $qry = "SELECT * from opportunities WHERE assigned_user_id = '" . $current_user->id . "' AND deleted=0";
		$result = $this->seedBean->db->query($this->seedBean->create_list_count_query($qry));	
		$row = $this->seedBean->db->fetchByAssoc($result);

		$this->total_opportunities = $row['c'];
        $qry = "SELECT * from opportunities WHERE assigned_user_id = '" . $current_user->id . "' AND sales_stage = '".Opportunity::STAGE_CLOSED_WON."' AND deleted=0";
		$result = $this->seedBean->db->query($this->seedBean->create_list_count_query($qry));	
		$row = $this->seedBean->db->fetchByAssoc($result);

		$this->total_opportunities_won = $row['c'];
    }
    
    /**
	 * @see Dashlet::display()
	 */
	public function display()
    {	
    	$ss = new Sugar_Smarty();
    	$ss->assign('lblTotalOpportunities', translate('LBL_TOTAL_OPPORTUNITIES', 'Opportunities'));
    	$ss->assign('lblClosedWonOpportunities', translate('LBL_CLOSED_WON_OPPORTUNITIES', 'Opportunities'));    	
    	
    	$ss->assign('total_opportunities', $this->total_opportunities);
    	$ss->assign('total_opportunities_won', $this->total_opportunities_won);    	
    	
    	return parent::display() . $ss->fetch('modules/Opportunities/Dashlets/MyClosedOpportunitiesDashlet/MyClosedOpportunitiesDashlet.tpl');
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
