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




class SugarWidgetFieldDateTime extends SugarWidgetReportField
{
	var $reporter;
	var $assigned_user=null;

    function SugarWidgetFieldDateTime($layout_manager)
    {
        parent::SugarWidgetReportField($layout_manager);
    }

	// get the reporter attribute
    // deprecated, now called in the constructor
    /**
     * @deprecated
     */
	function getReporter() {
	}

	// get the assigned user of the report
	function getAssignedUser()
	{
		$json_obj = getJSONobj();

		$report_def_str = $json_obj->decode($this->reporter->report_def_str);

		if(empty($report_def_str['assigned_user_id'])) return null;

		$this->assigned_user = BeanFactory::getBean('Users');
		$this->assigned_user->retrieve($report_def_str['assigned_user_id']);
		return $this->assigned_user;
	}

	function queryFilterOn($layout_def)
	{
		global $timedate;
        $begin = $layout_def['input_name0'];
        $hasTime = $this->hasTime($begin);
        if(!$hasTime)
        {
            return $this->queryDay($layout_def, $timedate->fromDbDate($begin));
        }
        return $this->queryDateOp($this->_get_column_select($layout_def), $begin, '=', "datetime");
	}

    /**
     * expandDate
     *
     * This function helps to convert a date only value to have a time value as well.  It first checks
     * to see if a time value exists.  If a time value exists, the function just returns the date value
     * passed in.  If the date value is the 'Today' macro then some special processing occurs as well.
     * Finally the time portion is applied depending on whether or not this date should be for the end
     * in which case the 23:59:59 time value is applied otherwise 00:00:00 is used.
     *
     * @param $date String value of the date value to expand
     * @param bool $end Boolean value indicating whether or not this is for an end time period or not
     * @return $date TimeDate object with time value applied
     */
	protected function expandDate($date, $end = false)
	{
	    global $timedate;
	    if($this->hasTime($date)) {
	        return $date;
	    }

        //C.L. Bug 48616 - If the $date is set to the Today macro, then adjust accordingly
        if(strtolower($date) == 'today')
        {
           $startEnd = $timedate->getDayStartEndGMT($timedate->getNow(true));
           return $end ? $startEnd['end'] : $startEnd['start'];
        }

        $parsed = $timedate->fromDbDate($date);
        $date = $timedate->tzUser(new SugarDateTime());
        $date->setDate($parsed->year, $parsed->month, $parsed->day);

	    if($end) {
	        return $date->setTime(23, 59, 59);
	    } else {
	        return $date->setTime(0, 0, 0);
	    }
	}

	function queryFilterBefore($layout_def)
	{
        $begin = $this->expandDate($layout_def['input_name0']);
        return $this->queryDateOp($this->_get_column_select($layout_def), $begin, '<', "datetime");
	}

	function queryFilterAfter($layout_def)
	{
        $begin = $this->expandDate($layout_def['input_name0'], true);
        return $this->queryDateOp($this->_get_column_select($layout_def), $begin, '>', "datetime");
	}

	function queryFilterBetween_Dates($layout_def)
	{
        $begin = $this->expandDate($layout_def['input_name0']);
     	$end = $this->expandDate($layout_def['input_name1'], true);
        $column = $this->_get_column_select($layout_def);
	    return "(".$this->queryDateOp($column, $begin, ">=", "datetime")." AND ".
            $this->queryDateOp($column, $end, "<=", "datetime").")\n";
	}

    /**
     * Returns SQL WHERE query for previous fiscal year filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_previous_fiscal_year($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '-1 year', '');
    }

    /**
     * Returns SQL WHERE query for previous fiscal quarter filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_previous_fiscal_quarter($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '-3 month', '');
    }

    /**
     * Returns SQL WHERE query for current fiscal year filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_current_fiscal_year($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '', '+1 year');
    }

    /**
     * Returns SQL WHERE query for current fiscal quarter filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_current_fiscal_quarter($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '', '+3 month');
    }

    /**
     * Returns SQL WHERE query for next fiscal year filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_next_fiscal_year($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '+1 year', '+2 year');
    }

    /**
     * Returns SQL WHERE query for next fiscal quarter filter
     * in regard to fiscal start date and current date
     *
     * @param $layout_def - filter def
     * @return string - SQL WHERE query for filter
     */
    public function queryFiltertp_next_fiscal_quarter($layout_def)
    {
        return $this->getFiscalYearFilter($layout_def, '+3 month', '+6 month');
    }

    public function queryFilterNot_Equals_str($layout_def)
	{
		global $timedate;

        $column = $this->_get_column_select($layout_def);
        $begin = $layout_def['input_name0'];
        $hasTime = $this->hasTime($begin);
        if(!$hasTime){
     	    $end = $this->expandDate($begin, true);
            $begin = $this->expandDate($begin);
            $cond = $this->queryDateOp($column, $begin, "<", "datetime")." OR ".
                $this->queryDateOp($column, $end, ">", "datetime");
        } else {
            $cond =  $this->queryDateOp($column, $begin, "!=", "datetime");
        }
        return "($column IS NULL OR $cond)";
	}

    /**
     * Get assigned or logged in user's current date and time value.
     * @param boolean $timestamp Format of return value, if set to true, return unix like timestamp , else a formatted date.
     */
	function get_users_current_date_time($timestamp=false)
	{
	 	global $current_user;
        global $timedate;

        $begin = TimeDate::getInstance()->nowDb();
        //kbrill bug #13884
       	//$begin = $timedate->to_display_date_time($begin,true,true,$this->assigned_user);
		$begin = $timedate->handle_offset($begin, $timedate->get_db_date_time_format(), false, $this->assigned_user);

        if (!$timestamp) {
        	return $begin;
        } else {
        	$begin_parts = explode(' ', $begin);
        	$date_parts=explode('-', $begin_parts[0]);
        	$time_parts=explode(':', $begin_parts[1]);
        	$curr_timestamp=mktime($time_parts[0],$time_parts[1],0,$date_parts[1], $date_parts[2],$date_parts[0]);
        	return $curr_timestamp;
        }

	}
	/**
	 * Get specified date and time for a particalur day, in current user's timezone.
	 * @param int $days Adjust date by this number of days, negative values are valid.
	 * @param time string falg for desired time value, start: minimum time, end: maximum time, default: current time
	 */
	function get_db_date($days,$time) {
        global $timedate;

        $begin = date($GLOBALS['timedate']->get_db_date_time_format(), time()+(86400 * $days));  //gmt date with day adjustment applied.
        //kbrill bug #13884
        //$begin = $timedate->to_display_date_time($begin,true,true,$this->assigned_user);
		$begin = $timedate->handle_offset($begin, $timedate->get_db_date_time_format(), false, $this->assigned_user);

        if ($time=='start') {
            $begin_parts = explode(' ', $begin);
            $be = $begin_parts[0] . ' 00:00:00';
        }
        else if ($time=='end') {
            $begin_parts = explode(' ', $begin);
            $be = $begin_parts[0] . ' 23:59:59';
        } else {
            $be=$begin;
        }

        //convert date to db format without converting to GMT.
        $begin = $timedate->handle_offset($be, $timedate->get_db_date_time_format(), false, $this->assigned_user);

        return $begin;
	}

	/**
	 * Get filter string for a date field.
	 * @param array layout_def field def for field being filtered
	 * @param string $begin start date value (in DB format)
	 * @param string $end End date value (in DB format)
	 */
	function get_start_end_date_filter(& $layout_def, $begin,$end)
	{
	    if (isset ($layout_def['rel_field'])) {
	        $field_name = $this->reporter->db->convert(
	            $this->reporter->db->convert($this->_get_column_select($layout_def), 'date_format', '%Y-%m-%d'),
	            "CONCAT",
	            array("' '", $this->reporter->db->convert($layout_def['rel_field'], 'time_format'))
	        );
	    } else {
	       $field_name = $this->_get_column_select($layout_def);
	    }
	    return $field_name.">=".$this->reporter->db->quoted($begin)." AND ".$field_name."<=".$this->reporter->db->quoted($end)."\n";
	}

	/**
	 * Create query for binary operation of field of certain type
	 * Produces query like:
	 * arg1 op to_date(arg2), e.g.:
	 * 		date_closed < '2009-12-01'
	 * @param string $arg1 1st arg - column name
	 * @param string|DateTime $arg2 2nd arg - value to be converted
	 * @param string $op
	 * @param string $type
	 */
    protected function queryDateOp($arg1, $arg2, $op, $type)
    {
        global $timedate;
        if($arg2 instanceof DateTime) {
            $arg2 = $timedate->asDbType($arg2, $type);
        }
        return "$arg1 $op ".$this->reporter->db->convert($this->reporter->db->quoted($arg2), $type)."\n";
    }

    /**
     * Return current date in required user's TZ
     * @return SugarDateTime
     */
    protected function now()
    {
        global $timedate;
        return $timedate->tzUser($timedate->getNow(), $this->getAssignedUser());
    }

	/**
     * Create query from the beginning to the end of certain day
     * @param array $layout_def
     * @param SugarDateTime $day
     */
    protected function queryDay($layout_def, SugarDateTime $day)
    {
        $begin = $day->get_day_begin();
        $end = $day->get_day_end();
        return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
    }

	function queryFilterTP_yesterday($layout_def)
	{
		global $timedate;
		return $this->queryDay($layout_def, $this->now()->get("-1 day"));
	}

	function queryFilterTP_today($layout_def)
	{
		global $timedate;
		return $this->queryDay($layout_def, $this->now());
	}

	function queryFilterTP_tomorrow(& $layout_def)
	{
		global $timedate;
		return $this->queryDay($layout_def, $this->now()->get("+1 day"));
	}

	function queryFilterTP_last_7_days($layout_def)
	{
		global $timedate;

		$begin = $this->now()->get("-6 days")->get_day_begin();
		$end = $this->now()->get_day_end();

		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryFilterTP_next_7_days($layout_def)
	{
		global $timedate;

		$begin = $this->now()->get_day_begin();
		$end = $this->now()->get("+6 days")->get_day_end();

		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

    /**
     * Create query from the beginning to the end of certain month
     * @param array $layout_def
     * @param SugarDateTime $month
     */
    protected function queryMonth($layout_def, $month)
    {
        $begin = $month->setTime(0, 0, 0);
        $end = clone($begin);
		$end->setDate($begin->year, $begin->month, $begin->days_in_month)->setTime(23, 59, 59);
        return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
    }

    function queryFilterTP_last_month($layout_def)
	{
		global $timedate;
		$month = $this->now();
		return $this->queryMonth($layout_def, $month->setDate($month->year, $month->month-1, 1));
	}

	function queryFilterTP_this_month($layout_def)
	{
		global $timedate;
		return $this->queryMonth($layout_def, $this->now()->get_day_by_index_this_month(0));
	}

	function queryFilterTP_next_month($layout_def)
	{
		global $timedate;
		$month = $this->now();
		return $this->queryMonth($layout_def, $month->setDate($month->year, $month->month+1, 1));
	}

	function queryFilterTP_last_30_days($layout_def)
	{
		global $timedate;
		$begin = $this->now()->get("-29 days")->get_day_begin();
		$end = $this->now()->get_day_end();
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryFilterTP_next_30_days($layout_def)
	{
		global $timedate;
		$begin = $this->now()->get_day_begin();
		$end = $this->now()->get("+29 days")->get_day_end();
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}


	function queryFilterTP_this_quarter($layout_def)
	{
		global $timedate;
		$begin = $this->now();
		$begin->setDate($begin->year, floor(($begin->month-1)/3)*3+1, 1)->setTime(0, 0);
		$end = $begin->get("+3 month")->setTime(23, 59, 59);
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryFilterTP_last_year($layout_def)
	{
		global $timedate;
		$begin = $this->now();
		$begin->setDate($begin->year-1, 1, 1)->setTime(0, 0);
		$end = clone $begin;
		$end->setDate($end->year, 12, 31)->setTime(23, 59, 59);
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryFilterTP_this_year($layout_def)
	{
		global $timedate;
		$begin = $this->now();
		$begin->setDate($begin->year, 1, 1)->setTime(0, 0);
		$end = clone $begin;
		$end->setDate($end->year, 12, 31)->setTime(23, 59, 59);
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryFilterTP_next_year(& $layout_def)
	{
		global $timedate;
		$begin = $this->now();
		$begin->setDate($begin->year+1, 1, 1)->setTime(0, 0);
		$end = clone $begin;
		$end->setDate($end->year, 12, 31)->setTime(23, 59, 59);
		return $this->get_start_end_date_filter($layout_def,$begin->asDb(),$end->asDb());
	}

	function queryGroupBy($layout_def)
	{
		// i guess qualifier and column_function are the same..
		if (!empty ($layout_def['qualifier'])) {
			$func_name = 'queryGroupBy'.$layout_def['qualifier'];
			if (method_exists($this, $func_name)) {
				return $this-> $func_name ($layout_def)." \n";
			}
		}
		return parent :: queryGroupBy($layout_def)." \n";
	}

	function queryOrderBy($layout_def)
	{
        if (!empty ($layout_def['qualifier'])) {
			$func_name ='queryOrderBy'.$layout_def['qualifier'];
			if (method_exists($this, $func_name)) {
				return $this-> $func_name ($layout_def)."\n";
			}
		}
		$order_by = parent :: queryOrderBy($layout_def)."\n";
		return $order_by;
	}

    function displayListPlain($layout_def) {
        global $timedate;
        $content = parent:: displayListPlain($layout_def);
        // awu: this if condition happens only in Reports where group by month comes back as YYYY-mm format
        if (count(explode('-',$content)) == 2){
            return $content;
        // if date field
        }elseif(substr_count($layout_def['type'], 'date') > 0){
            // if date time field
            if(substr_count($layout_def['type'], 'time') > 0 && $this->get_time_part($content)!= false){
                $td = $timedate->to_display_date_time($content);
                return $td;
            }else{// if date only field
                $td = $timedate->to_display_date($content, false); // Avoid PHP notice of returning by reference.
                return $td;
            }
        }
    }

    function get_time_part($date_time_value)
    {
        global $timedate;

        $date_parts=$timedate->split_date_time($date_time_value);
        if (count($date_parts) > 1) {
            return $date_parts[1];
        } else {
            return false;
        }
    }

    function displayList($layout_def) {
        global $timedate;
        // i guess qualifier and column_function are the same..
        if (!empty ($layout_def['column_function'])) {
            $func_name = 'displayList'.$layout_def['column_function'];
            if (method_exists($this, $func_name)) {
                return $this-> $func_name ($layout_def);
            }
        }
        $content = parent :: displayListPlain($layout_def);
        return $timedate->to_display_date_time($content);
    }

	function querySelect(& $layout_def) {
		// i guess qualifier and column_function are the same..
		if (!empty ($layout_def['column_function'])) {
			$func_name = 'querySelect'.$layout_def['column_function'];
			if (method_exists($this, $func_name)) {
				return $this-> $func_name ($layout_def)." \n";
			}
		}
		return parent :: querySelect($layout_def)." \n";
	}
	function & displayListday(& $layout_def) {
        global $timedate;
        $field_name = strtoupper($this->_get_column_alias($layout_def));
        $tmp_field_name = str_replace('_DAY_', '_DAYREAL_', $field_name);
        if($tmp_field_name != $field_name && isset($layout_def['fields'][$tmp_field_name]))
        {
            return $timedate->to_display_date($layout_def['fields'][$tmp_field_name], true);
        }
        else
        {
		    return parent:: displayListPlain($layout_def);
        }
	}

	function & displayListyear(& $layout_def) {
		global $app_list_strings;
    	$value = parent:: displayListPlain($layout_def);
    	return $value;
	}

	function displayListmonth($layout_def)
	{
		global $app_list_strings;
		$display = '';
		$match = array();
        if (preg_match('/(\d{4})-(\d\d)/', $this->displayListPlain($layout_def), $match)) {
			$match[2] = preg_replace('/^0/', '', $match[2]);
			$display = $app_list_strings['dom_cal_month_long'][$match[2]]." {$match[1]}";
		}
		return $display;

	}

    /**
     * Returns the fiscal start date in user TZ if it exists
     * otherwise uses 01-01 of current year
     *
     * @return DateTime - Fiscal start date in user TZ
     */
    private function getFiscalStartDate()
    {
        // Pick fiscal start date
        $admin = BeanFactory::getBean('Administration');
        $config = $admin->getConfigForModule('Forecasts', 'base');

        $timedate = TimeDate::getInstance();
        $now = $timedate->getNow(true);

        if (!empty($config['timeperiod_start_date'])) {
            $fiscalDate = $timedate->fromString($config['timeperiod_start_date']);
        } else {
            // If there is no fiscal start date, use 1st of January
            // Probably because of reseting the forecast settings, while running an old report
            $GLOBALS['log']->error('Fiscal start date not set. Using 1st January.');
            $fiscalDate = $now->setDate($now->year, 1, 1)->setTime(0, 0, 0);
        }

        return $fiscalDate;
    }

    /**
     * Normalizes the date field, so we can group by year/quarter
     * in regard to fiscal start date
     *
     * @param $column - DB column name
     * @return string - date field normalized in regard to fiscal start date
     */
    private function getNormalizedDate($column)
    {
        $fiscalDate = $this->getFiscalStartDate();

        // Need to add tz offset for grouping
        $column = $this->reporter->db->convert($column, 'add_tz_offset');

        if ($fiscalDate->day_of_year > 0) {
            $column = $this->reporter->db->convert(
                $column,
                'add_date',
                array('-' . $fiscalDate->day_of_year, 'DAY')
            );
        }

        return $column;
    }

    /**
     * Return the between WHERE query for Fiscal Year/Quarter queries
     *
     * Both begin/end dates use the same fiscal date, but are updated
     * by the $modifyBegin/$modifyEnd parameters
     *
     * @param $layout_def - Filter layout_def
     * @param string $modifyStart - Modification to fiscal start date
     * @param string $modifyEnd - Modification to fiscal start date
     * @param string $date - Date for which to find fiscal quarter/year, if not set uses current date
     * @return string - BETWEEN WHERE query for Fiscal filter
     */
    protected function getFiscalYearFilter($layout_def, $modifyStart, $modifyEnd, $date = '')
    {
        $timedate = TimeDate::getInstance();

        // Get Fiscal Start Date
        $fiscalDate = $this->getFiscalStartDate();

        // We need to make changes to fiscal date, depending on current date
        // See if date is set, if not, use current date
        if (empty($date)) {
            $date = $timedate->getNow(true);
        } else {
            $date = $timedate->fromString($date);
        }

        // Use Year from the date we're checking
        $fiscalDate->setDate($date->year, $fiscalDate->month, $fiscalDate->day);

        // If we're dealing with year filter, we need to set the year
        if (strpos($layout_def['qualifier_name'], 'year') !== false) {
            // Set year for the fiscal period, depending on current date
            if ($fiscalDate > $date) {
                $fiscalDate->modify("-1 year");
            }
        } elseif (strpos($layout_def['qualifier_name'], 'quarter') !== false) {
            // If we're dealing with quarter filter, we need to set the month

            $currentMonth = $date->format("m");
            $tempFiscalMonth = $fiscalDate->format("m");

            // Find the quarter in regard to the fiscal month
            $monthDiff = $currentMonth - $tempFiscalMonth;
            if ($monthDiff < 0) {
                $monthDiff -= 1;
            }
            $monthDiff = 3 * floor($monthDiff / 3);

            // Update the month
            if ($monthDiff != 0) {
                $fiscalDate->modify($monthDiff . " month");
            }
        }

        // Modify the start date
        $start = clone $fiscalDate;
        if (!empty($modifyStart)) {
            $start->modify($modifyStart);
        }

        // Modify the end date
        $end = clone $fiscalDate;
        if (!empty($modifyEnd)) {
            $end->modify($modifyEnd);
        }

        $column = $this->_get_column_select($layout_def);

        $startTime = $start->asDb(true);
        $endTime = $end->asDb(true);

        // Return the WHERE statement
        return "(" . $this->queryDateOp($column, $startTime, ">=", "datetime")
            . " AND " . $this->queryDateOp($column, $endTime, "<", "datetime") . ")\n";
    }

    /**
     * Returns the select query used for displaying the group data
     *
     * @param $layout_def - group by layout def
     * @return string - Select query used for display
     */
    public function querySelectfiscalQuarter($layout_def)
    {
        return $this->queryGroupByFiscalQuarter($layout_def) . " " . $this->_get_column_alias($layout_def) . "\n";
    }

    /**
     * Returns the value to be displayed for the group by
     *
     * @param $layout_def - group by layout def
     * @return string - string for display
     */
    public function displayListfiscalQuarter($layout_def)
    {
        $match = array();
        if (preg_match('/(\d{4})-(\d)/', $this->displayListPlain($layout_def), $match)) {

            return 'Q' . $match[2] .' ' . $match[1];
        }
        return '';
    }

    /**
     * Returns the group by part of the query for
     * grouping by fiscal quarter
     *
     * @param $layout_def - group by layout def
     * @return string - fiscal quarter group by query
     */
    public function queryGroupByFiscalQuarter($layout_def)
    {
        $column = $this->_get_column_select($layout_def);

        $date = $this->getNormalizedDate($column);

        $query = $this->reporter->db->convert(
            $this->reporter->db->convert(
                $date,
                "date_format",
                array('%Y')
            ),
            'CONCAT',
            array("'-'",
                $this->reporter->db->convert(
                    $date,
                    "quarter"
                )
            )
        );

        return $query;
    }

    /**
     * Returns the select query used for displaying the group data
     *
     * @param $layout_def - group by layout def
     * @return string - Select query used for display
     */
    public function querySelectfiscalYear($layout_def)
    {
        return $this->queryGroupByFiscalYear($layout_def) . " " . $this->_get_column_alias($layout_def) . "\n";
    }

    /**
     * Returns the value to be displayed for the group by
     *
     * @param $layout_def - group by layout def
     * @return string - string for display
     */
    public function displayListfiscalYear($layout_def)
    {
        global $app_list_strings;
        $value = parent::displayListPlain($layout_def);

        return $value;
    }

    /**
     * Returns the group by part of the query for
     * grouping by fiscal year
     *
     * @param $layout_def - group by layout def
     * @return string - fiscal year group by query
     */
    public function queryGroupByFiscalYear($layout_def)
    {
        $column = $this->_get_column_select($layout_def);

        $date = $this->getNormalizedDate($column);

        $query = $this->reporter->db->convert($date, "date_format", array('%Y'));

        return $query;
    }

    /**
     * Returns part of query for select
     *
     * @param array $layout_def for field
     * @return string part of select query with year & month only
     */
    function querySelectmonth($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y-%m')) . ' ' . $this->_get_column_alias($layout_def) . "\n";
    }

    /**
     * Returns part of query for group by
     *
     * @param array $layout_def for field
     * @return string part of group by query with year & month only
     */
    function queryGroupByMonth($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y-%m')) . "\n";
    }

    /**
     * For oracle we have to return order by string like group by string instead of return field alias
     *
     * @param array $layout_def definition of field
     * @return string order by string for field
     */
    function queryOrderByMonth($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        $orderBy = $this->reporter->db->convert($return, "date_format", array('%Y-%m'));

        if (empty($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a')
        {
            return $orderBy . " ASC\n";
        }
        else
        {
            return $orderBy . " DESC\n";
        }
    }

    /**
     * Select addon datetime field for "day" field in reports
     *
     * @param $layout_def array definition of new field
     * @return string piece for creation "select" query
     */
    function querySelectdayreal($layout_def)
    {
        return $this->reporter->db->convert($this->_get_column_select($layout_def), "date_format", array('%Y-%m-%d %H:%i:%s'))." ".$this->_get_column_alias($layout_def)."\n";
    }

    /**
     * Returns part of query for select
     *
     * @param array $layout_def for field
     * @return string part of select query with year & month & day
     */
    function querySelectday($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y-%m-%d')) . ' ' . $this->_get_column_alias($layout_def) . "\n";
    }

    /**
     * Returns part of query for group by
     *
     * @param array $layout_def for field
     * @return string part of group by query with year & month & day
     */
    function queryGroupByDay($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y-%m-%d')) . "\n";
    }

    /**
     * Returns part of query for select
     *
     * @param array $layout_def for field
     * @return string part of select query with year only
     */
    function querySelectyear($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y')) . ' ' . $this->_get_column_alias($layout_def) . "\n";
    }

    /**
     * Returns part of query for group by
     *
     * @param array $layout_def for field
     * @return string part of group by query with year only
     */
    function queryGroupByYear($layout_def)
    {
        $return = $this->_get_column_select($layout_def);
        if ($layout_def['type'] == 'datetime')
        {
            $return = $this->reporter->db->convert($return, 'add_tz_offset');
        }
        return $this->reporter->db->convert($return, "date_format", array('%Y')) . "\n";
    }

	function querySelectquarter($layout_def)
	{
	    $column = $this->_get_column_select($layout_def);
	    return $this->reporter->db->convert($this->reporter->db->convert($column, "date_format", array('%Y')),
	        	'CONCAT',
	            array("'-'", $this->reporter->db->convert($column, "quarter")))
	        ." ".$this->_get_column_alias($layout_def)."\n";
	}

	function displayListquarter(& $layout_def) {
		$match = array();
        if (preg_match('/(\d{4})-(\d)/', $this->displayListPlain($layout_def), $match)) {
			return "Q".$match[2]." ".$match[1];
		}
		return '';

	}

	function queryGroupByQuarter($layout_def)
	{
		$this->getReporter();
        $column = $this->_get_column_select($layout_def);
	    return $this->reporter->db->convert($this->reporter->db->convert($column, "date_format", array('%Y')),
	        	'CONCAT',
	            array("'-'", $this->reporter->db->convert($column, "quarter")));
	}

    /**
     * For oracle we have to return order by string like group by string instead of return field alias
     *
     * @param array $layout_def definition of field
     * @return string order by string for field
     */
    public function queryOrderByQuarter($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        $orderBy = $this->reporter->db->convert(
            $this->reporter->db->convert($column, "date_format", array('%Y')),
            'CONCAT',
            array("'-'", $this->reporter->db->convert($column, "quarter"))
        );


        if (empty($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a')
        {
            return $orderBy . " ASC\n";
        }
        else
        {
            return $orderBy . " DESC\n";
        }
    }

    function displayInput(&$layout_def) {
    	global $timedate, $current_language, $app_strings;
        $home_mod_strings = return_module_language($current_language, 'Home');
        $filterTypes = array(' '                 => $app_strings['LBL_NONE'],
                             'TP_today'         => $home_mod_strings['LBL_TODAY'],
                             'TP_yesterday'     => $home_mod_strings['LBL_YESTERDAY'],
                             'TP_tomorrow'      => $home_mod_strings['LBL_TOMORROW'],
                             'TP_this_month'    => $home_mod_strings['LBL_THIS_MONTH'],
                             'TP_this_year'     => $home_mod_strings['LBL_THIS_YEAR'],
                             'TP_last_30_days'  => $home_mod_strings['LBL_LAST_30_DAYS'],
                             'TP_last_7_days'   => $home_mod_strings['LBL_LAST_7_DAYS'],
                             'TP_last_month'    => $home_mod_strings['LBL_LAST_MONTH'],
                             'TP_last_year'     => $home_mod_strings['LBL_LAST_YEAR'],
                             'TP_next_30_days'  => $home_mod_strings['LBL_NEXT_30_DAYS'],
                             'TP_next_7_days'   => $home_mod_strings['LBL_NEXT_7_DAYS'],
                             'TP_next_month'    => $home_mod_strings['LBL_NEXT_MONTH'],
                             'TP_next_year'     => $home_mod_strings['LBL_NEXT_YEAR'],
                             );

        $cal_dateformat = $timedate->get_cal_date_format();
        $str = "<select name='type_{$layout_def['name']}'>";
        $str .= get_select_options_with_id($filterTypes, (empty($layout_def['input_name0']) ? '' : $layout_def['input_name0']));
//        foreach($filterTypes as $value => $label) {
//            $str .= '<option value="' . $value . '">' . $label. '</option>';
//        }
        $str .= "</select>";


        return $str;
    }

    /**
     * @param  $date
     * @return bool false if the date is a only a date, true if the date includes time.
     */
    protected function hasTime($date)
    {
        return strlen(trim($date)) < 11 ? false : true;
    }

}
