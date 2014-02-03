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



class SugarWidgetFieldMultiEnum extends SugarWidgetFieldEnum {
	public function queryFilternot_one_of(&$layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value) {
			array_push($arr, "'".$GLOBALS['db']->quote($value)."'");
		}
	    $reporter = $this->layout_manager->getAttribute("reporter");

    	$col_name = $this->_get_column_select($layout_def) . " NOT LIKE " ;
    	$arr_count = count($arr);
    	$query = "";
    	foreach($arr as $key=>$val) {
    		$query .= $col_name;
			$value = preg_replace("/^'/", "'%", $val, 1);
			$value = preg_replace("/'$/", "%'", $value, 1);
			$query .= $value;
			if ($key != ($arr_count - 1))
    			$query.= " OR " ;	
    	}
		return '('.$query.')';        
	}
        
    public function queryFilterone_of(&$layout_def) {
		$arr = array ();
		foreach ($layout_def['input_name0'] as $value) {
			array_push($arr, "'".$GLOBALS['db']->quote($value)."'");
		}
	    $reporter = $this->layout_manager->getAttribute("reporter");

    	$col_name = $this->_get_column_select($layout_def) . " LIKE " ;
    	$arr_count = count($arr);
    	$query = "";
    	foreach($arr as $key=>$val) {
    		$query .= $col_name;
			$value = preg_replace("/^'/", "'%", $val, 1);
			$value = preg_replace("/'$/", "%'", $value, 1);
			$query .= $value;
			if ($key != ($arr_count - 1))
    			$query.= " OR " ;	
    	}
		return '('.$query.')';        
	}

	public function queryFilteris($layout_def) {
		$input_name0 = $layout_def['input_name0'];
		if (is_array($layout_def['input_name0'])) {
			$input_name0 = $layout_def['input_name0'][0];
		}

		// Bug 40022
		// IS filter doesn't add the carets (^) to multienum custom field values  
		$input_name0 = $this->encodeMultienumCustom($layout_def, $input_name0);
		
		return $this->_get_column_select($layout_def)." = ".$this->reporter->db->quoted($input_name0)."\n";
	}

	public function queryFilteris_not($layout_def) {
		$input_name0 = $layout_def['input_name0'];
		if (is_array($layout_def['input_name0'])) {
			$input_name0 = $layout_def['input_name0'][0];
		}

		// Bug 50549
		// IS NOT filter doesn't add the carets (^) to multienum custom field values  
		$input_name0 = $this->encodeMultienumCustom($layout_def, $input_name0);
		
		return $this->_get_column_select($layout_def)." <> ".$this->reporter->db->quoted($input_name0)."\n";
	}
	
    /**
     * Returns an OrderBy query for multi-select. We treat multi-select the same as a normal field because
     * the values stored in the database are in the format ^A^,^B^,^C^ though not necessarily in that order.
     * @param  $layout_def
     * @return string
     */
    public function queryOrderBy($layout_def) {
        return SugarWidgetReportField::queryOrderBy($layout_def);
    }
    
    /**
     * Function checks if the multienum field is custom, and escapes it with carets (^) if it is
     * @param array $layout_def field layout definition
     * @param string $value value to be escaped
     * @return string
     */
    private function encodeMultienumCustom($layout_def, $value) {
    	$field_def = $this->reporter->getFieldDefFromLayoutDef($layout_def);
    	// Check if it is a custom field
		if (!empty($field_def['source']) && ($field_def['source'] == 'custom_fields' || ($field_def['source'] == 'non-db' && !empty($field_def['ext2']) && !empty($field_def['id']))) && !empty($field_def['real_table']))
		{
			$value = encodeMultienumValue(array($value)); 
		}
		return $value;
    }
}
?>
