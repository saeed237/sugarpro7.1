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

require_once('include/SugarWireless/SugarWirelessListView.php');

/**
 * ViewWirelessmain extends SugarWirelessView and is the main homepage for
 * SugarWireless.
 */
class ViewWirelessmain extends SugarWirelessListView
{
	/**
	 * Constructor for the view, it runs the constructor of SugarWirelessView.
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Private function that grabs the last viewed from Tracker
	 */
	private function wl_last_viewed(){
		// set up last viewed
		$tracker = BeanFactory::getBean('Trackers');
		$last_viewed = $tracker->get_recently_viewed($GLOBALS['current_user']->id, '');

		if (count($last_viewed) > 0){
			$this->ss->assign('last_viewed', true);
			$this->ss->assign('LBL_LAST_VIEWED', $GLOBALS['app_strings']['LBL_LAST_VIEWED']);
			$last_viewed_list = array();
			// set up array for template
			foreach($last_viewed as $last_viewed_obj){
				// check to make sure the last viewed is in the wireless modules
				if (isset($this->wl_mod_select_list[$last_viewed_obj['module_name']])){
					$last_viewed_list[$last_viewed_obj['item_id']] =
						array(	'summary' => $last_viewed_obj['item_summary'],
								'module' => $last_viewed_obj['module_name']
							);
				}
			}
			// pass the array to template
			$this->ss->assign('LAST_VIEWED_LIST', $last_viewed_list);
		}
	}

	private function wl_activities_today(){
		global $timedate;
		$today = $timedate->nowDbDate();

        $where = array();
		$where['Calls'] = "date_start > '" . $today . " 00:00:00' AND date_start < '" . $today . " 23:59:59'";
		$where['Meetings'] = "date_start > '" . $today . " 00:00:00' AND date_start < '" . $today . " 23:59:59'";
		$where['Tasks'] = "date_due > '" . $today . " 00:00:00' AND date_due < '" . $today . " 23:59:59'";

		$activities_array = array(	'Call' => 'Calls',
									'Meeting' => 'Meetings',
									'Task' => 'Tasks' );

		$act_list = array();
		$todays_activities = false;
		require_once('include/ListView/ListViewData.php');
		$lvd = new ListViewData();

		foreach($activities_array as $bean=>$module){
		    $$bean = BeanFactory::getBean($module);

			$data = $lvd->getListViewData($$bean, $where[$module] . " AND " . $$bean->table_name .".assigned_user_id = '{$GLOBALS['current_user']->id}'", 0, -1, $this->get_filter_fields($module));

			if (!empty($data['data'])){
				$act_list[$module] = $data['data'];
				$todays_activities = true;
			}
		}

		$this->ss->assign('todays_activities', $todays_activities);
		$this->ss->assign('activities_today', $act_list);
	}

	/**
	 * Public function that handles the display of the main page
	 */
	public function display(){
		// print the header, also print welcome message
	    $this->wl_header(true);
	    // print select list
	    $this->wl_select_list();

	    $this->wl_activities_today();
	    $this->wl_last_viewed();

		// display the main page
		$this->ss->display('include/SugarWireless/tpls/wirelessmain.tpl');
		// print the footer
		$this->wl_footer();
	}
}
?>