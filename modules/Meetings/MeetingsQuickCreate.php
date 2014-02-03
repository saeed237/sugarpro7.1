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



class MeetingsQuickCreate extends QuickCreate {
    
    var $javascript;
    
    function process() {
        global $current_user, $timedate, $app_list_strings, $current_language, $mod_strings, $timeMeridiem;
        $mod_strings = return_module_language($current_language, 'Meetings');
        
        parent::process();

        $this->ss->assign("STATUS_OPTIONS", get_select_options_with_id($app_list_strings['meeting_status_dom'], $app_list_strings['meeting_status_default']));
		$this->ss->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
		$this->ss->assign("TIME_FORMAT", '('. $timedate->get_user_time_format().')');
		$this->ss->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');
		


        
        if($this->viaAJAX) { // override for ajax call
            $this->ss->assign('saveOnclick', "onclick='if(check_form(\"meetingsQuickCreate\")) return SUGAR.subpanelUtils.inlineSave(this.form.id, \"activities\"); else return false;'");
            $this->ss->assign('cancelOnclick', "onclick='return SUGAR.subpanelUtils.cancelCreate(\"subpanel_activities\")';");
        }
        
        $this->ss->assign('viaAJAX', $this->viaAJAX);

        $this->javascript = new javascript();
        $this->javascript->setFormName('meetingsQuickCreate');
        
        $focus = BeanFactory::getBean('Meetings');
        $this->javascript->setSugarBean($focus);
        $this->javascript->addAllFields('');

		if (is_null($focus->date_start))
			$focus->date_start = $timedate->to_display_date(TimeDate::getInstance()->nowDb());
		if (is_null($focus->time_start))
			$focus->time_start = $timedate->to_display_time(TimeDate::getInstance()->nowDb(), true);
		if (!isset ($focus->duration_hours))
			$focus->duration_hours = "1";

        
        $date_start_array=explode(" ",trim($focus->date_start));
        if (count($date_start_array)==2) {
			$focus->time_start = $timedate->to_db_time($date_start_array[1], false);
        	//$focus->date_start = $date_start_array[0];
        }

		$this->ss->assign("DATE_START", $focus->date_start);
		$this->ss->assign("TIME_START", substr($focus->time_start,0,5));
		$time_start_hour = intval(substr($focus->time_start, 0, 2));
		$time_start_minutes = substr($focus->time_start, 3, 5);
		
		if ($time_start_minutes > 0 && $time_start_minutes < 15) {
			$time_start_minutes = "15";
		} else
			if ($time_start_minutes > 15 && $time_start_minutes < 30) {
				$time_start_minutes = "30";
			} else
				if ($time_start_minutes > 30 && $time_start_minutes < 45) {
					$time_start_minutes = "45";
				} else
					if ($time_start_minutes > 45) {
						$time_start_hour += 1;
						$time_start_minutes = "00";
					}
		
		
		// We default the to assume that the time preference is set to 11:00 (i.e. without meridiem)
		$hours_arr = array ();
		$num_of_hours = 24;
		$start_at = 0;

		$time_pref = $timedate->get_time_format();
		if(strpos($time_pref, 'a') || strpos($time_pref, 'A')) {
		   $num_of_hours = 13;
		   $start_at = 1;	
		} 
		
		/*
		// Seems to be problematic... $time_meridiem is always empty
		if (empty ($time_meridiem)) {
			$num_of_hours = 24;
			$start_at = 0;
		}
		*/
		
		for ($i = $start_at; $i < $num_of_hours; $i ++) {
			$i = $i."";
			if (strlen($i) == 1) {
				$i = "0".$i;
			}
			$hours_arr[$i] = $i;
		}

        $this->ss->assign("TIME_START_HOUR_OPTIONS", get_select_options_with_id($hours_arr, $time_start_hour));
		$this->ss->assign("TIME_START_MINUTE_OPTIONS", get_select_options_with_id($focus->minutes_values, $time_start_minutes));
		$this->ss->assign("DURATION_HOURS", $focus->duration_hours);
		$this->ss->assign("DURATION_MINUTES_OPTIONS", get_select_options_with_id($focus->minutes_values, $focus->duration_minutes));
        // Test to see if time format is 11:00am; otherwise it's 11:00AM 
        if($num_of_hours == 13) {    
        		
		   if (strpos($time_pref, 'a')) {
		   	   
               if(!isset($focus->meridiem_am_values)) {
                  $focus->meridiem_am_values = array('am'=>'am', 'pm'=>'pm');
               } 		
               
               $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_am_values, $time_start_hour < 12 ? 'am' : 'pm'));
               
		   } else {
		       if(!isset($focus->meridiem_AM_values)) {
		          $focus->meridiem_AM_values = array('AM'=>'AM', 'PM'=>'PM');
		       }
		       
		       $this->ss->assign("TIME_MERIDIEM", get_select_options_with_id($focus->meridiem_AM_values, $time_start_hour < 12 ? 'AM' : 'PM'));
               
		   } //if-else
           
        }

        $this->ss->assign('additionalScripts', $this->javascript->getScript(false));
    }   
}
?>
