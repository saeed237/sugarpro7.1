<?php
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

require_once('include/MVC/View/SugarView.php');

class CalendarViewSaveSettings extends SugarView {

	function CalendarViewSettings(){
 		parent::SugarView();
	}
	
	function process(){
		$this->display();
	}
	
	function display(){
		global $current_user;
		
		$db_start = $this->to_db_time($_REQUEST['day_start_hours'],$_REQUEST['day_start_minutes'],$_REQUEST['day_start_meridiem']);
		$db_end = $this->to_db_time($_REQUEST['day_end_hours'],$_REQUEST['day_end_minutes'],$_REQUEST['day_end_meridiem']);
		
		$current_user->setPreference('day_start_time', $db_start, 0, 'global', $current_user);
		$current_user->setPreference('day_end_time', $db_end, 0, 'global', $current_user);

		$current_user->setPreference('calendar_display_timeslots', $_REQUEST['display_timeslots'], 0, 'global', $current_user);
		$current_user->setPreference('show_tasks', $_REQUEST['show_tasks'], 0, 'global', $current_user);
		$current_user->setPreference('show_calls', $_REQUEST['show_calls'], 0, 'global', $current_user);

		if(isset($_REQUEST['day']) && !empty($_REQUEST['day']))
			header("Location: index.php?module=Calendar&action=index&view=".$_REQUEST['view']."&hour=0&day=".$_REQUEST['day']."&month=".$_REQUEST['month']."&year=".$_REQUEST['year']);
		else
			header("Location: index.php?module=Calendar&action=index");
	}
	
	private function to_db_time($hours,$minutes,$mer){
		$hours = intval($hours);
		$minutes = intval($minutes);
		$mer = strtolower($mer);
		if(!empty($mer)){
			if(($mer) == 'am')
				if($hours == 12)
					$hours = $hours - 12;
			if(($mer) == 'pm')
				if($hours != 12)
					$hours = $hours + 12;		
		}
		if($hours < 10)
			$hours = "0".$hours;
		if($minutes < 10)
			$minutes = "0".$minutes;	
		return $hours . ":". $minutes; 
	}
	

}

?>
