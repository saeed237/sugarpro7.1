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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/SugarWireless/SugarWirelessView.php');

/**
 * ViewWirelessmodule extends SugarWirelessView and is the view for the wireless
 * module page.
 * 
 */
class ViewWirelessmodule extends SugarWirelessView
{
	private function oppPipelineBySalesStage()
    {
		require_once('modules/Charts/Dashlets/MyPipelineBySalesStageDashlet/MyPipelineBySalesStageDashlet.php');
        
        $myplbss = new MyPipelineBySalesStageDashlet('',array());
        $q_array = $myplbss->querySetup();
        $query = $myplbss->constructQuery($q_array['datax'], $q_array['start_date'], $q_array['end_date'], $q_array['ids']);

        $rs = $GLOBALS['db']->query($query);
        
        $max = 0;
        $pipeline_data = array();

        $row = $GLOBALS['db']->fetchByAssoc($rs);
        $total = $row['total'];
        while ($row != null){
            array_push($pipeline_data, $row);
            $row = $GLOBALS['db']->fetchByAssoc($rs);
            if ($row['total'] > $max){
            	$max = $row['total'];
            }
            $total += $row['total'];
        }

        foreach($pipeline_data as $key=>$data){
            $pipeline_data[$key]['width'] = number_format(($data['total']/$max)*85);
        }
        $this->ss->assign('wl_myplbss_dashlet', true);
        $this->ss->assign('pipeline_data', $pipeline_data);
        $this->ss->assign('total', $total);
    }
 	
 	
 	/**
 	 * Public function that handles the display of the module view
 	 */
 	public function display()
    {
        global $current_user;
        
        $current_user->setPreference('wireless_last_module', $this->module);
        
 		// print the header
		$this->wl_header();
		// print the select list
		$this->wl_select_list();
		
		// assign saved search and search form templates for display
		$this->ss->assign('WL_SAVED_SEARCH_FORM', $this->wl_saved_search_form());
 	    $this->ss->assign('WL_SEARCH_FORM', $this->wl_search_form());
 	    
 	    // display the module view
        $this->ss->assign('DISPLAY_CREATE',empty($this->wl_mod_create_list[$this->module]));
        $this->ss->display('include/SugarWireless/tpls/wirelessmodule.tpl');
		
		// print the footer
		$this->wl_footer();
 	}

}
?>
