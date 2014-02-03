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


require_once('include/json_config.php');

class MeetingsViewEdit extends ViewEdit
{
    /**
     * @const MAX_REPEAT_INTERVAL Max repeat interval.
     */
    const MAX_REPEAT_INTERVAL = 30;
 	/**
 	 * @see SugarView::preDisplay()
 	 *
 	 * Override preDisplay to check for presence of 'status' in $_REQUEST
 	 * This is to support the "Close And Create New" operation.
 	 */
 	public function preDisplay()
 	{
 		if(!empty($_REQUEST['status']) && ($_REQUEST['status'] == 'Held')) {
	       $this->bean->status = 'Held';
 		}

 		parent::preDisplay();
 	}

 	/**
 	 * @see SugarView::display()
 	 */
 	public function display()
 	{
 		global $json;
        $json = getJSONobj();
        $json_config = new json_config();
		if (isset($this->bean->json_id) && !empty ($this->bean->json_id)) {
			$javascript = $json_config->get_static_json_server(false, true, 'Meetings', $this->bean->json_id);

		} else {
			$this->bean->json_id = $this->bean->id;
			$javascript = $json_config->get_static_json_server(false, true, 'Meetings', $this->bean->id);

		}
 		$this->ss->assign('JSON_CONFIG_JAVASCRIPT', $javascript);
 		if($this->ev->isDuplicate){
	        $this->bean->status = $this->bean->getDefaultStatus();
 		} //if
        
        $this->ss->assign('APPLIST', $GLOBALS['app_list_strings']);
        
        $repeatIntervals = array();
        for ($i = 1; $i <= self::MAX_REPEAT_INTERVAL; $i++) {
            $repeatIntervals[$i] = $i;
        }
        $this->ss->assign("repeat_intervals", $repeatIntervals);

        $fdow = $GLOBALS['current_user']->get_first_day_of_week();
        $dow = array();
        for ($i = $fdow; $i < $fdow + 7; $i++){
            $dayIndex = $i % 7;
            $dow[] = array("index" => $dayIndex , "label" => $GLOBALS['app_list_strings']['dom_cal_day_short'][$dayIndex + 1]);
        }
        $this->ss->assign('dow', $dow);
        $this->ss->assign('repeatData', json_encode($this->view_object_map['repeatData']));
          
 		parent::display();
 	}
}
