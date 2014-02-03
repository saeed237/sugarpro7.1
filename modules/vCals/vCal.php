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


require_once('modules/Calendar/Calendar.php');

class vCal extends SugarBean {
	// Stored fields
	var $id;
	var $date_modified;
	var $user_id;
	var $content;
	var $deleted;
	var $type;
	var $source;
	var $module_dir = "vCals";
	var $table_name = "vcals";

	var $object_name = "vCal";

	var $new_schema = true;

	var $field_defs = array(
	);

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	const UTC_FORMAT = 'Ymd\THi00\Z';

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function vCal()
    {
        self::__construct();
    }

	public function __construct()
	{

		parent::__construct();
		$this->disable_row_level_security = true;
	}

	function get_summary_text()
	{
		return "";
	}


	function fill_in_additional_list_fields()
	{
	}

	function fill_in_additional_detail_fields()
	{
	}

	function get_list_view_data()
	{
	}

        // combines all freebusy vcals and returns just the FREEBUSY lines as a string
	function get_freebusy_lines_cache(&$user_bean)
	{
		$str = '';
		// First, get the list of IDs.
		$query = "SELECT id from vcals where user_id='{$user_bean->id}' AND type='vfb' AND deleted=0";
		$vcal_arr = $this->build_related_list($query, BeanFactory::getBean('vCals'));

		foreach ($vcal_arr as $focus)
		{
			if (empty($focus->content))
			{
				return '';
			}

			$lines = explode("\n",$focus->content);

			foreach ($lines as $line)
			{
				if ( preg_match('/^FREEBUSY[;:]/i',$line))
				{
					$str .= "$line\n";
				}
			}
		}

		return $str;
	}

	// query and create the FREEBUSY lines for SugarCRM Meetings and Calls and
        // return the string
	function create_sugar_freebusy($user_bean, $start_date_time, $end_date_time)
	{
		$str = '';
		global $DO_USER_TIME_OFFSET,$timedate;

		$DO_USER_TIME_OFFSET = true;
		if(empty($GLOBALS['current_user']) || empty($GLOBALS['current_user']->id)) {
		    $GLOBALS['current_user'] = $user_bean;
		}
		// get activities.. queries Meetings and Calls
		$acts_arr =
		CalendarActivity::get_activities($user_bean->id,
			array("show_calls" => true),
			$start_date_time,
			$end_date_time,
			'freebusy');

		// loop thru each activity, get start/end time in UTC, and return FREEBUSY strings
		foreach($acts_arr as $act)
		{
			$startTimeUTC = $act->start_time->format(self::UTC_FORMAT);
			$endTimeUTC = $act->end_time->format(self::UTC_FORMAT);

			$str .= "FREEBUSY:". $startTimeUTC ."/". $endTimeUTC."\n";
		}
		return $str;

	}

        // return a freebusy vcal string
        function get_vcal_freebusy($user_focus,$cached=true)
        {
           global $locale, $timedate;
           $str = "BEGIN:VCALENDAR\n";
           $str .= "VERSION:2.0\n";
           $str .= "PRODID:-//SugarCRM//SugarCRM Calendar//EN\n";
           $str .= "BEGIN:VFREEBUSY\n";

           $name = $locale->getLocaleFormattedName($user_focus->first_name, $user_focus->last_name);
           $email = $user_focus->email1;

           // get current date for the user
           $now_date_time = $timedate->getNow(true);

           // get start date ( 1 day ago )
           $start_date_time = $now_date_time->get("yesterday");

           // get date 2 months from start date
			global $sugar_config;
			$timeOffset = 2;
            if (isset($sugar_config['vcal_time']) && $sugar_config['vcal_time'] != 0 && $sugar_config['vcal_time'] < 13)
			{
				$timeOffset = $sugar_config['vcal_time'];
			}
           $end_date_time = $start_date_time->get("+$timeOffset months");

           // get UTC time format
           $utc_start_time = $start_date_time->asDb();
           $utc_end_time = $end_date_time->asDb();
           $utc_now_time = $now_date_time->asDb();

           $str .= "ORGANIZER;CN=$name:$email\n";
           $str .= "DTSTART:$utc_start_time\n";
           $str .= "DTEND:$utc_end_time\n";

           // now insert the freebusy lines
           // retrieve cached freebusy lines from vcals
		   if ($timeOffset != 0)
		   {
           if ($cached == true)
           {
             $str .= $this->get_freebusy_lines_cache($user_focus);
           }
           // generate freebusy from Meetings and Calls
           else
           {
               $str .= $this->create_sugar_freebusy($user_focus,$start_date_time,$end_date_time);
			}
           }

           // UID:20030724T213406Z-10358-1000-1-12@phoenix
           $str .= "DTSTAMP:$utc_now_time\n";
           $str .= "END:VFREEBUSY\n";
           $str .= "END:VCALENDAR\n";
           return $str;

	}

	// static function:
        // cache vcals
        function cache_sugar_vcal(&$user_focus)
        {
            vCal::cache_sugar_vcal_freebusy($user_focus);
        }

	// static function:
        // caches vcal for Activities in Sugar database
        function cache_sugar_vcal_freebusy(&$user_focus)
        {
            $focus = BeanFactory::getBean('vCals');
            // set freebusy members and save
            $arr = array('user_id'=>$user_focus->id,'type'=>'vfb','source'=>'sugar');
            $focus->retrieve_by_string_fields($arr);


            $focus->content = $focus->get_vcal_freebusy($user_focus,false);
            $focus->type = 'vfb';
            $focus->date_modified = null;
            $focus->source = 'sugar';
            $focus->user_id = $user_focus->id;
            $focus->save();
        }

	/**
	 * get ics file content for meeting invite email
	 */
	public static function get_ical_event(SugarBean $bean, User $user){
		$str = "";

		$str .= "BEGIN:VCALENDAR\n";
		$str .= "VERSION:2.0\n";
		$str .= "PRODID:-//SugarCRM//SugarCRM Calendar//EN\n";
		$str .= "BEGIN:VEVENT\n";
		$str .= "UID:".$bean->id."\n";
		$str .= "ORGANIZER;CN=".$user->full_name.":".$user->email1."\n";
		$str .= "DTSTART:".SugarDateTime::createFromFormat($GLOBALS['timedate']->get_db_date_time_format(),$bean->date_start)->format(self::UTC_FORMAT)."\n";
		$str .= "DTEND:".SugarDateTime::createFromFormat($GLOBALS['timedate']->get_db_date_time_format(),$bean->date_end)->format(self::UTC_FORMAT)."\n";
		$str .= "DTSTAMP:". $GLOBALS['timedate']->getNow(false)->format(self::UTC_FORMAT) ."\n";
		$str .= "SUMMARY:" . $bean->name . "\n";
		$str .= "DESCRIPTION:" . $bean->description . "\n";
		$str .= "END:VEVENT\n";
		$str .= "END:VCALENDAR\n";

		return $str;
	}

}

?>
