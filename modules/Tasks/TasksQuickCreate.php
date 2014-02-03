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

 
require_once('include/EditView/QuickCreate.php');



class TasksQuickCreate extends QuickCreate {
    
    var $javascript;
    
    function process() {
        global $current_user, $timedate, $app_list_strings, $current_language, $mod_strings;
        $mod_strings = return_module_language($current_language, 'Tasks');
        
        parent::process();

        $this->ss->assign("PRIORITY_OPTIONS", get_select_options_with_id($app_list_strings['task_priority_dom'], $app_list_strings['task_priority_default']));
        $this->ss->assign("STATUS_OPTIONS", get_select_options_with_id($app_list_strings['task_status_dom'], $app_list_strings['task_status_default']));
		$this->ss->assign("TIME_FORMAT", '('. $timedate->get_user_time_format().')');
        
        $focus = BeanFactory::getBean('Tasks');
        $time_start_hour = intval(substr($focus->time_start, 0, 2));
	    $time_start_minutes = substr($focus->time_start, 3, 5);
		if($time_start_minutes > 45) {
		   $time_start_hour += 1;
		}

        $time_pref = $timedate->get_time_format();
		if (strpos($time_pref, 'a')) {
               if(!isset($focus->meridiem_am_values)) {
                  $focus->meridiem_am_values = array('am'=>'am', 'pm'=>'pm');
               } 		
               $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_am_values, $time_start_hour < 12 ? 'am' : 'pm'));               
		} else if(strpos($time_pref, 'A')) {
		       if(!isset($focus->meridiem_AM_values)) {
		          $focus->meridiem_AM_values = array('AM'=>'AM', 'PM'=>'PM');
		       }       
		       $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_AM_values, $time_start_hour < 12 ? 'AM' : 'PM'));
		} //if-else

		$this->ss->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');
		$this->ss->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());

        
        if($this->viaAJAX) { // override for ajax call
            $this->ss->assign('saveOnclick', "onclick='if(check_form(\"tasksQuickCreate\")) return SUGAR.subpanelUtils.inlineSave(this.form.id, \"activities\"); else return false;'");
            $this->ss->assign('cancelOnclick', "onclick='return SUGAR.subpanelUtils.cancelCreate(\"subpanel_activities\")';");
        }
        
        $this->ss->assign('viaAJAX', $this->viaAJAX);

        $this->javascript = new javascript();
        $this->javascript->setFormName('tasksQuickCreate');
        
        $focus = BeanFactory::getBean('Tasks');
        $this->javascript->setSugarBean($focus);
        $this->javascript->addAllFields('');

        $this->ss->assign('additionalScripts', $this->javascript->getScript(false));
    }   
}
?>
