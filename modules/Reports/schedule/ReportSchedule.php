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




class ReportSchedule{

var $table_name='report_schedules';
var $db;
function ReportSchedule(){
	$this->db = DBManagerFactory::getInstance();

}

/**
 * @deprecated deprecated since this syntax is only supported by MySQL
 * @return void
 * TODO THIS FUNCTIONALITY SHOULD BE REMOVED AFTER CONVERSION TO SUGARBEAN USE
 */
function drop_tables ()
{
    // TODO This code should never be used
    $query = 'DROP TABLE IF EXISTS '.$this->table_name;
    $this->db->query($query);
}

function save_schedule($id, $user_id, $report_id, $date_start, $interval, $active, $schedule_type){
	global $timedate;
	$time = time();
	$origDateStart = $date_start;
	$date_start_str = "";
	if(empty($id))
	{
		$id = create_guid();

		if( empty($date_start) )
		    $date_start = $timedate->nowDb();

        $next_run_date = $this->getNextRunDate($date_start, $interval);

	    if(strlen(trim($origDateStart))==0)
	        $date_start_str = " NULL ";
	    else
	        $date_start_str = " '$origDateStart' ";

		$query = "INSERT INTO $this->table_name (id, user_id, report_id, date_start,next_run, time_interval, active, schedule_type) VALUES ('$id', '$user_id', '$report_id', $date_start_str , '$next_run_date', '$interval', '$active', '$schedule_type')";
	}
	else
	{
	    if(strlen(trim($origDateStart))==0)
	       $date_start_str = " date_start = NULL, ";
	    else
	       $date_start_str = " date_start = '$origDateStart', ";

		$query = "UPDATE $this->table_name  SET time_interval=$interval, ".$date_start_str." active=$active, schedule_type='".$schedule_type."'";
		if(!empty($date_start) && $active)
		{
		    $next_run_date = $this->getNextRunDate($date_start, $interval);
			$query .= ", next_run='$next_run_date'";
		}
		$query .= " WHERE id='$id'";
	}
	$this->db->query($query, true, "error saving schedule");

	return $id;
}

function getNextRunDate($date_start,$interval)
{
    global $timedate;
	$time = time();

    $date_start = $timedate->fromDb($date_start)->ts;

    if($interval > 0)
    {
        // bug #44555: Start Dates are not Respected for Scheduled Reports
        while($date_start <= $time)
        {
            $date_start += $interval;
        }
    }

    return $timedate->fromTimestamp($date_start)->asDb();
}

/**
 * Converts datetime values from the database type
 * NOTE that this is currently hardcoded as this whole module should
 * be converted to using SugarBeans, which would make this obsolete
 * @param $row
 * @return converted row
 * TODO XXX Move this whole module to use SugarBeans
 */
protected function fromConvertReportScheduleDBRow($row){
    if(!$row) return false;
    foreach($row as $name => $value){
        switch($name){
            case 'date_start':
            case 'next_run':
            case 'date_modified':
                $row[$name] = $this->db->fromConvert($row[$name], 'datetime');
            default: break;
        }
    }
    return $row;
}

function get_users_schedule($id=''){
		if(empty($id)){
			global $current_user;
			$id = $current_user->id;
		}
		$return_array = array();
		$query = "SELECT * FROM $this->table_name WHERE user_id='$id'";
		$results = $this->db->query($query);
		while($row = $this->db->fetchByAssoc($results)){
			$return_array[$row['report_id']] = $this->fromConvertReportScheduleDBRow($row);
		}
		return $return_array;
}

function get_report_schedule_for_user($report_id, $user_id=''){
	if(empty($user_id)){
			global $current_user;
			$user_id = $current_user->id;
		}
	$query = "SELECT * FROM $this->table_name WHERE report_id='$report_id' AND user_id='$user_id' AND deleted=0";
	$results = $this->db->query($query);
	$row = $this->db->fetchByAssoc($results);
	return $this->fromConvertReportScheduleDBRow($row);
}

function get_report_schedule($report_id){
	$query = "SELECT * FROM $this->table_name WHERE report_id='$report_id' AND deleted=0";
	$results = $this->db->query($query);
	$return_array = array();
	while($row = $this->db->fetchByAssoc($results)){
		$return_array[] = $this->fromConvertReportScheduleDBRow($row);
	}
	return $return_array;
}

function get_reports_to_email($user_id= '', $schedule_type="pro"){
    global $timedate;
	$where = '';
	if(!empty($user_id)){
		$where = "AND user_id='$user_id'";
	}
	$time = $timedate->nowDb();
	$query = "SELECT report_schedules.* FROM $this->table_name \n".
			"join saved_reports on saved_reports.id=$this->table_name.report_id \n".
			"join users on users.id = report_schedules.user_id".
			" WHERE saved_reports.deleted=0 AND \n" .
			"$this->table_name.next_run < '$time' $where AND \n".
			"$this->table_name.deleted=0 AND \n".
			"$this->table_name.active=1 AND " .
			"$this->table_name.schedule_type='".$schedule_type."' AND\n".
			"users.status='Active' AND users.deleted='0'".
			"ORDER BY $this->table_name.next_run ASC";

	$results = $this->db->query($query);
	$return_array = array();
	while ($row = $this->db->fetchByAssoc($results))
    {
        $return_array[] = $this->fromConvertReportScheduleDBRow($row);
	}
	return $return_array;

}

function get_ent_reports_to_email($user_id= '', $schedule_type="ent"){
	$where = '';
	if(!empty($user_id)){
		$where = "AND user_id='$user_id'";
	}
	$time = gmdate($GLOBALS['timedate']->get_db_date_time_format(), time());
	$query = "SELECT report_schedules.* FROM $this->table_name \n".
			"join report_maker on report_maker.id=$this->table_name.report_id \n".
			"join users on users.id = report_schedules.user_id".
			" WHERE report_maker.deleted=0 AND \n" .
			"$this->table_name.next_run < '$time' $where AND \n".
			"$this->table_name.deleted=0 AND \n".
			"$this->table_name.active=1 AND " .
			"$this->table_name.schedule_type='".$schedule_type."' AND\n".
			"users.status='Active' AND users.deleted='0'".
			"ORDER BY $this->table_name.next_run ASC";
	$results = $this->db->query($query);
	$return_array = array();
	while($row = $this->db->fetchByAssoc($results)){
			$return_array[$row['report_id']] = $this->fromConvertReportScheduleDBRow($row);
	}
	return $return_array;

}

function update_next_run_time($schedule_id, $next_run, $interval){
        global $timedate;
		$last_run = $timedate->fromDb($next_run)->ts;
		$time = time();
		while($last_run <= $time){
			$last_run += $interval;
		}
		$next_run = $timedate->fromTimestamp($last_run)->asDb();
		$query = "UPDATE $this->table_name SET next_run='$next_run' WHERE id='$schedule_id'";
		$this->db->query($query);

}

function mark_deleted($id){
    $query = "UPDATE {$this->table_name} SET deleted = '1' WHERE id = '{$id}'";
    $GLOBALS['db']->query($query);
}
}
?>
