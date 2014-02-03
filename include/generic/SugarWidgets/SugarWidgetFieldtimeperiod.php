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


class SugarWidgetFieldTimeperiod extends SugarWidgetFieldEnum
{
    public function SugarWidgetFieldTimeperiod($layout_manager) {
        parent::SugarWidgetFieldEnum($layout_manager);
    }

	public function queryFilteris($layout_def) {
        $input_name0 = $this->getInputValue($layout_def);

        if($input_name0 == 'current') {
            $name = array_keys(TimePeriod::getCurrentName());
            $name = !empty($name) ? $name[0] : '';
            return SugarWidgetFieldid::_get_column_select($layout_def)." = '". $name ."'\n";
        }

		return parent::queryFilteris($layout_def);
	}

	public function queryFilteris_not($layout_def) {
        $input_name0 = $this->getInputValue($layout_def);

        if($input_name0 == 'current') {
            $name = array_keys(TimePeriod::getCurrentName());
            $name = !empty($name) ? $name[0] : '';
            return SugarWidgetFieldid::_get_column_select($layout_def)." NOT IN ('" . $name . "')\n";
        }

		return parent::queryFilteris_not($layout_def);
	}

	public function queryFilterone_of($layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value)
        {
            if($value == 'current') {
                $name = array_keys(TimePeriod::getCurrentName());
                $name = !empty($name) ? $name[0] : '';
                $arr[] = $this->reporter->db-quoted($name);
            } else {
                $arr[] = $this->reporter->db->quoted($value);
            }
		}
		$str = implode(",", $arr);
		return $this->_get_column_select($layout_def)." IN (".$str.")\n";
	}

	public function queryFilternot_one_of($layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value)
        {
            if($value == 'current') {
                $name = array_keys(TimePeriod::getCurrentName());
                $name = !empty($name) ? $name[0] : '';
                $arr[] = $this->reporter->db->quoted($name);
            } else {
                $arr[] = $this->reporter->db->quoted($value);
            }
		}
		$str = implode(",", $arr);
		return $this->_get_column_select($layout_def)." NOT IN (".$str.")\n";
	}
}
