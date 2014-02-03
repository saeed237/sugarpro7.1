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


if(!empty($_REQUEST['save_schedule_msi'])){
	global $current_user, $timedate, $app_strings;
require_once('modules/Reports/schedule/ReportSchedule.php');
$rs = new ReportSchedule();
global $timedate;
if(!empty($_REQUEST['schedule_id'])){
	$id = $_REQUEST['schedule_id'];
}else{
	$id = '';	
}


if(!empty($_REQUEST['date_start'])){
	$date_start = $timedate->to_db($_REQUEST['date_start'], true);
}else{
	$date_start = '';	
}


if(!empty($_REQUEST['schedule_active']) ){
	$active = 1;
}else{
	$active = 0;	
}

if(!empty($_REQUEST['schedule_type']) ){
	$schedule_type = $_REQUEST['schedule_type'];
}else{
	$schedule_type = "pro";	
}

$rs->save_schedule($id,$current_user->id, $_REQUEST['id'],$date_start,$_REQUEST['schedule_time_interval'], $active, $schedule_type);
$refreshPage = (isset($_REQUEST['refreshPage']) ? $_REQUEST['refreshPage'] : "true");
if (!$active) {
	$date_start = $app_strings['LBL_LINK_NONE'];
} else {	
	if(empty($date_start)){
  		$date_start = gmdate($GLOBALS['timedate']->get_db_date_time_format(), time());
	} else {
  		$date_start = $timedate->handle_offset($date_start, $timedate->get_db_date_time_format(), false);
	}	
	$date_start = $timedate->to_display_date_time($date_start);
} // else

if ($refreshPage == "false") {
	echo "<script>opener.window.setSchuleTime('$date_start');window.close();</script>";	
} else {
	echo '<script>opener.window.location.reload();window.close();</script>';
}
}
?>