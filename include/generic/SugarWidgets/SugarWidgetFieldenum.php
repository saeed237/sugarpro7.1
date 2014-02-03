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


class SugarWidgetFieldEnum extends SugarWidgetReportField
{
    public function SugarWidgetFieldEnum($layout_manager) {
        parent::SugarWidgetReportField($layout_manager);
    }

    public function queryFilterEmpty($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "(coalesce(" . $this->reporter->db->convert($column, "length") . ",0) = 0 OR $column = '^^')";
    }

    public function queryFilterNot_Empty($layout_def)
    {
        $column = $this->_get_column_select($layout_def);
        return "(coalesce(" . $this->reporter->db->convert($column, "length") . ",0) > 0 AND $column != '^^' )\n";
    }

	public function queryFilteris($layout_def) {
        $input_name0 = $this->getInputValue($layout_def);
		return $this->_get_column_select($layout_def)." = ".$this->reporter->db->quoted($input_name0)."\n";
	}

	public function queryFilteris_not($layout_def) {
        $input_name0 = $this->getInputValue($layout_def);
		return $this->_get_column_select($layout_def)." <> ".$this->reporter->db->quoted($input_name0)."\n";
	}

	public function queryFilterone_of($layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value)
        {
            $arr[] = $this->reporter->db->quoted($value);
		}
		$str = implode(",", $arr);
		return $this->_get_column_select($layout_def)." IN (".$str.")\n";
	}

	public function queryFilternot_one_of($layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value)
        {
            $arr[] = $this->reporter->db->quoted($value);
		}
		$str = implode(",", $arr);
		return $this->_get_column_select($layout_def)." NOT IN (".$str.")\n";
	}

    function & displayList($layout_def) {
        if(!empty($layout_def['column_key'])){
            $field_def = $this->reporter->all_fields[$layout_def['column_key']];
        }else if(!empty($layout_def['fields'])){
            $field_def = $layout_def['fields'];
        }
        $cell = $this->displayListPlain($layout_def);
        $str = $cell;
        global $sugar_config;
        if (isset ($sugar_config['enable_inline_reports_edit']) && $sugar_config['enable_inline_reports_edit']) {
            $module = $this->reporter->all_fields[$layout_def['column_key']]['module'];
            $name = $layout_def['name'];
            $layout_def['name'] = 'id';
            $key = $this->_get_column_alias($layout_def);
            $key = strtoupper($key);

            //If the key isn't in the layout fields, skip it
            if (!empty($layout_def['fields'][$key]))
            {
                $record = $layout_def['fields'][$key];
                $field_name = $field_def['name'];
                $field_type = $field_def['type'];
                $div_id = $field_def['module'] ."&$record&$field_name";
                $str = "<div id='$div_id'>" . $cell . "&nbsp;"
                     . SugarThemeRegistry::current()->getImage(
                        "edit_inline",
                        "border='0' alt='Edit Layout' align='bottom' onClick='SUGAR.reportsInlineEdit.inlineEdit(" .
                        "\"$div_id\",\"$cell\",\"$module\",\"$record\",\"$field_name\",\"$field_type\");'"
                       )
                     . "</div>";
            }
        }
        return $str;
    }
	function & displayListPlain($layout_def) {
		if(!empty($layout_def['column_key'])){
			$field_def = $this->reporter->all_fields[$layout_def['column_key']];
		}else if(!empty($layout_def['fields'])){
			$field_def = $layout_def['fields'];
		}

		if (!empty($layout_def['table_key'] ) &&( empty ($field_def['fields']) || empty ($field_def['fields'][0]) || empty ($field_def['fields'][1]))){
			$value = $this->_get_list_value($layout_def);
		}else if(!empty($layout_def['name']) && !empty($layout_def['fields'])){
			$key = strtoupper($layout_def['name']);
			$value = $layout_def['fields'][$key];
		}
		$cell = '';

			if(isset($field_def['options'])){
				$cell = translate($field_def['options'], $field_def['module'], $value);
			}else if(isset($field_def['type']) && $field_def['type'] == 'enum' && isset($field_def['function'])){
	            global $beanFiles;
	            if(empty($beanFiles)) {
	                include('include/modules.php');
	            }
	            $bean_name = get_singular_bean_name($field_def['module']);
	            require_once($beanFiles[$bean_name]);
	            $list = $field_def['function']();
	            $cell = $list[$value];
	        }
		if (is_array($cell)) {

			//#22632
			$value = unencodeMultienum($value);
			$cell=array();
			foreach($value as $val){
				$returnVal = translate($field_def['options'],$field_def['module'],$val);
				if(!is_array($returnVal)){
					array_push( $cell, translate($field_def['options'],$field_def['module'],$val));
				}
			}
			$cell = implode(", ",$cell);
		}
		return $cell;
	}

	public function queryOrderBy($layout_def) {
		$field_def = $this->reporter->all_fields[$layout_def['column_key']];
		if (!empty ($field_def['sort_on'])) {
			$order_by = $layout_def['table_alias'].".".$field_def['sort_on'];
		} else {
			$order_by = $this->_get_column_select($layout_def);
		}
		$list = array();
        if(isset($field_def['options'])) {
		    $list = translate($field_def['options'], $field_def['module']);
        } elseif(isset($field_def['type']) && $field_def['type'] == 'enum' && isset($field_def['function'])) {
	        global $beanFiles;
		    if(empty($beanFiles)) {
		        include('include/modules.php');
		    }
		    $bean_name = get_singular_bean_name($field_def['module']);
		    require_once($beanFiles[$bean_name]);
            $list = $field_def['function']();
        }
		if (empty ($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a') {
			$order_dir = "ASC";
		} else {
			$order_dir = "DESC";
		}
		return $this->reporter->db->orderByEnum($order_by, $list, $order_dir);
    }

    public function displayInput($layout_def) {
        global $app_list_strings;

        if(!empty($layout_def['remove_blank']) && $layout_def['remove_blank']) {
            if ( isset($layout_def['options']) &&  is_array($layout_def['options']) ) {
                $ops = $layout_def['options'];
            }
            elseif (isset($layout_def['options']) && isset($app_list_strings[$layout_def['options']])){
            	$ops = $app_list_strings[$layout_def['options']];
                if(array_key_exists('', $app_list_strings[$layout_def['options']])) {
             	   unset($ops['']);
	            }
            }
            else{
            	$ops = array();
            }
        }
        else {
            $ops = $app_list_strings[$layout_def['options']];
        }

        $str = '<select multiple="true" size="3" name="' . $layout_def['name'] . '[]">';
        $str .= get_select_options_with_id($ops, $layout_def['input_name0']);
        $str .= '</select>';
        return $str;
    }
}
