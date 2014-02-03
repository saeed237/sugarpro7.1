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



class SugarWidgetFieldDate extends SugarWidgetFieldDateTime
{
    function displayList($layout_def)
    {
        global $timedate;
        // i guess qualifier and column_function are the same..
        if (! empty($layout_def['column_function'])) {
            $func_name = 'displayList'.$layout_def['column_function'];
            if ( method_exists($this,$func_name)) {
                $display = $this->$func_name($layout_def);
                return $display;
            }
        }
        $content = $this->displayListPlain($layout_def);
		return $content;
    }

    function queryFilterBefore($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], "<", "date");
    }

    function queryFilterAfter($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], ">", "date");
    }

    function queryFilterNot_Equals_str($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "($column IS NULL OR ".$this->queryDateOp($column, $layout_def['input_name0'], '!=', "date").")\n";
    }

    function queryFilterOn($layout_def)
    {
        return $this->queryDateOp($this->_get_column_select($layout_def), $layout_def['input_name0'], "=", "date");
    }

    function queryFilterBetween_Dates(& $layout_def)
    {
        $begin = $layout_def['input_name0'];
        $end = $layout_def['input_name1'];
        $column = $this->_get_column_select($layout_def);

        return "(".$this->queryDateOp($column, $begin, ">=", "date")." AND ".
            $this->queryDateOp($column, $end, "<=", "date").")\n";
    }

	function queryFilterTP_yesterday($layout_def)
	{
		global $timedate;
        $layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true)->get("-1 day"));
        return $this->queryFilterOn($layout_def);
	}

	function queryFilterTP_today($layout_def)
	{
		global $timedate;
        $layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true));
        return $this->queryFilterOn($layout_def);
	}

	function queryFilterTP_tomorrow(& $layout_def)
	{
		global $timedate;
		$layout_def['input_name0'] = $timedate->asDbDate($timedate->getNow(true)->get("+1 day"));
        return $this->queryFilterOn($layout_def);
	}

    protected function queryMonth($layout_def, $month)
    {
        $end = clone($month);
        $end->setDate($month->year, $month->month, $month->days_in_month);
        $beginDate = $month->asDbDate();
        $endDate = $end->asDbDate();
        return $this->get_start_end_date_filter($layout_def, $beginDate, $endDate);
    }

    protected function now()
    {
        global $timedate;
        return $timedate->tzGMT($timedate->getNow(), $this->getAssignedUser());
    }
}
