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






class SugarWidgetFieldName extends SugarWidgetFieldVarchar
{

    function SugarWidgetFieldName(&$layout_manager) {
        parent::SugarWidgetFieldVarchar($layout_manager);
        $this->reporter = $this->layout_manager->getAttribute('reporter');
    }

	function displayList(&$layout_def)
	{
		if(empty($layout_def['column_key']))
		{
			return $this->displayListPlain($layout_def);
		}

		$module = $this->reporter->all_fields[$layout_def['column_key']]['module'];
		$name = $layout_def['name'];
		$layout_def['name'] = 'id';
		$key = $this->_get_column_alias($layout_def);
		$key = strtoupper($key);

		if(empty($layout_def['fields'][$key]))
		{
		  $layout_def['name'] = $name;
			return $this->displayListPlain($layout_def);
		}

		$record = $layout_def['fields'][$key];
		$layout_def['name'] = $name;
		global $current_user;
		if ($module == 'Users' && !is_admin($current_user))
        	$module = 'Employees';
		$str = "<a target='_blank' href=\"index.php?action=DetailView&module=$module&record=$record\">";
		$str .= $this->displayListPlain($layout_def);
		$str .= "</a>";


        global $sugar_config;
        if (isset ($sugar_config['enable_inline_reports_edit']) && $sugar_config['enable_inline_reports_edit'] && !empty($record)) {
            $div_id = "$module&$record&$name";
            $str = "<div id='$div_id'><a target='_blank' href=\"index.php?action=DetailView&module=$module&record=$record\">";
            $value = $this->displayListPlain($layout_def);
            $str .= $value;
            $field_name = $layout_def['name'];
            $field_type = $field_def['type'];
            $str .= "</a>";
            if ($field_name == 'name')
                $str .= "&nbsp;" .SugarThemeRegistry::current()->getImage("edit_inline","border='0' alt='Edit Layout' align='bottom' onClick='SUGAR.reportsInlineEdit.inlineEdit(\"$div_id\",\"$value\",\"$module\",\"$record\",\"$field_name\",\"$field_type\");'");
            $str .= "</div>";
        }
		return $str;
	}

	function _get_normal_column_select($layout_def)
	{
        if ( isset($this->reporter->all_fields) ) {
            $field_def = $this->reporter->all_fields[$layout_def['column_key']];
        } else {
            $field_def = array();
        }

		if (empty($field_def['fields']) || empty($field_def['fields'][0]) || empty($field_def['fields'][1]))
		{
			return parent::_get_column_select($layout_def);
		}

		//	 'fields' are the two fields to concatenate to create the name.
		if ( ! empty($layout_def['table_alias'])) {
		    $alias = $this->reporter->db->concat($layout_def['table_alias'], $field_def['fields']);
		} elseif (! empty($layout_def['name'])) {
			$alias = $layout_def['name'];
		} else {
			$alias = "*";
		}

		return $alias;
	}

	function _get_column_select($layout_def)
	{
		global $locale, $current_user;

        if ( isset($this->reporter->all_fields) ) {
            $field_def = $this->reporter->all_fields[$layout_def['column_key']];
        } else {
            $field_def = array();
        }

        //	 'fields' are the two fields to concatenate to create the name
        if(!isset($field_def['fields']))
        {
			return $this->_get_normal_column_select($layout_def);
        }
		$localeNameFormat = $locale->getLocaleFormatMacro($current_user);
		$localeNameFormat = trim(preg_replace('/s/i', '', $localeNameFormat));

		if (empty($field_def['fields']) || empty($field_def['fields'][0]) || empty($field_def['fields'][1])) {
			return parent::_get_column_select($layout_def);
		}

		if ( ! empty($layout_def['table_alias'])) {
		    $comps = preg_split("/([fl])/", $localeNameFormat, null, PREG_SPLIT_DELIM_CAPTURE);
		    $name = array();
		    foreach($comps as $val) {
		        if($val == 'f') {
		            $name[] = $this->reporter->db->convert($layout_def['table_alias'].".".$field_def['fields'][0], 'IFNULL', array("''"));
		        } elseif($val == 'l') {
		            $name[] = $this->reporter->db->convert($layout_def['table_alias'].".".$field_def['fields'][1], 'IFNULL', array("''"));
		        } else {
		            if(!empty($val)) {
		                $name[] = $this->reporter->db->quoted($val);
		            }
		        }
		    }
		    $alias = $this->reporter->db->convert($name, "CONCAT");
		} elseif (! empty($layout_def['name']))	{
			$alias = $layout_def['name'];
		} else {
			$alias = "*";
		}

		return $alias;
	}

	function queryFilterIs($layout_def)
	{
		$layout_def['name'] = 'id';
		$layout_def['type'] = 'id';

        $input_name0 = $this->getInputValue($layout_def);

		if ($input_name0 == 'Current User') {
			global $current_user;
			$input_name0 = $current_user->id;
		}

		return SugarWidgetFieldid::_get_column_select($layout_def)."="
			.$this->reporter->db->quoted($input_name0)."\n";
	}

	function queryFilteris_not($layout_def)
	{

		$layout_def['name'] = 'id';
		$layout_def['type'] = 'id';
        $input_name0 = $this->getInputValue($layout_def);
		if ($input_name0 == 'Current User') {
			global $current_user;
			$input_name0 = $current_user->id;
		}

		return SugarWidgetFieldid::_get_column_select($layout_def)."<>"
			.$this->reporter->db->quoted($input_name0)."\n";
	}

    // $rename_columns, if true then you're coming from reports
	function queryFilterone_of($layout_def, $rename_columns = true)
	{

        if($rename_columns) { // this was a hack to get reports working, sugarwidgets should not be renaming $name!
    		$layout_def['name'] = 'id';
    		$layout_def['type'] = 'id';
        }
		$arr = array();

		foreach($layout_def['input_name0'] as $value)
		{
			if ($value == 'Current User') {
				global $current_user;
				array_push($arr,$this->reporter->db->quoted($current_user->id));
			}
			else
				array_push($arr,$this->reporter->db->quoted($value));
		}

		$str = implode(",",$arr);

		return SugarWidgetFieldid::_get_column_select($layout_def)." IN (".$str.")\n";
	}
    // $rename_columns, if true then you're coming from reports
	function queryFilternot_one_of($layout_def, $rename_columns = true)
	{

        if($rename_columns) { // this was a hack to get reports working, sugarwidgets should not be renaming $name!
    		$layout_def['name'] = 'id';
    		$layout_def['type'] = 'id';
        }
		$arr = array();

		foreach($layout_def['input_name0'] as $value)
		{
			if ($value == 'Current User') {
				global $current_user;
				array_push($arr,$this->reporter->db->quoted($current_user->id));
			}
			else
				array_push($arr,$this->reporter->db->quoted($value));
		}

		$str = implode(",",$arr);

		return SugarWidgetFieldid::_get_column_select($layout_def)." NOT IN (".$str.")\n";
	}

    /**
     * queryFilterreports_to
     *
     * @param $layout_def
     * @param bool $rename_columns
     * @return string
     */
    function queryFilterreports_to($layout_def, $rename_columns = true)
   	{
        $layout_def['name'] = 'id';
        $layout_def['type'] = 'id';
        $input_name0 = $this->getInputValue($layout_def);

        if ($input_name0 == 'Current User')
        {
            global $current_user;
            $input_name0 = $current_user->id;
        }

        return SugarWidgetFieldid::_get_column_select($layout_def)." IN (SELECT id FROM users WHERE reports_to_id = ". $this->reporter->db->quoted($input_name0). " AND status = 'Active' AND deleted=0)\n";
   	}

	function &queryGroupBy($layout_def)
	{
        if($layout_def['name'] == 'full_name') {
             $layout_def['name'] = 'id';
             $layout_def['type'] = 'id';

             $group_by =  SugarWidgetFieldid::_get_column_select($layout_def)."\n";
        } else {
            // group by clause for user name passes through here.
             $group_by = $this->_get_column_select($layout_def)."\n";
        }
        return $group_by;
	}
}

?>
