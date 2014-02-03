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




class SugarWidgetFieldDateTimecombo extends SugarWidgetFieldDateTime {
	var $reporter;
	var $assigned_user=null;

    function SugarWidgetFieldDateTimecombo(&$layout_manager) {
        parent::SugarWidgetFieldDateTime($layout_manager);
        $this->reporter = $this->layout_manager->getAttribute('reporter');
    }
	//TODO:now for date time field , we just search from date start to date end. The time is from 00:00:00 to 23:59:59
	//If there is requirement, we can modify report.js::addFilterInputDatetimesBetween and this function
	function queryFilterBetween_Datetimes(& $layout_def) {
		global $timedate;
		if($this->getAssignedUser()) {
			$begin = $timedate->handle_offset($layout_def['input_name0'], $timedate->get_db_date_time_format(), false, $this->assigned_user);
			$end = $timedate->handle_offset($layout_def['input_name2'], $timedate->get_db_date_time_format(), false, $this->assigned_user);
		}
		else {
			$begin = $layout_def['input_name0'];
			$end = $layout_def['input_name1'];
		}
		return "(".$this->_get_column_select($layout_def).">=".$this->reporter->db->convert($this->reporter->db->quoted($begin), "datetime").
			" AND\n ".$this->_get_column_select($layout_def)."<=".$this->reporter->db->convert($this->reporter->db->quoted($end), "datetime").
			")\n";
	}

}
