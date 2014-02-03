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

require_once('modules/DynamicFields/templates/Fields/TemplateEnum.php');
require_once('include/utils/array_utils.php');
class TemplateRadioEnum extends TemplateEnum{
	var $type = 'radioenum';
	
	function get_html_edit(){
		$this->prepare();
		$xtpl_var = strtoupper( $this->name);
		return "{RADIOOPTIONS_".$xtpl_var. "}";
	}
	
	function get_field_def(){
		$def = parent::get_field_def();
		$def['dbType'] = 'enum';
		$def['separator'] = '<br>';
		return $def;	
	}
	
	
	function get_xtpl_edit($add_blank = false){
		$name = $this->name;
		$value = '';
		if(isset($this->bean->$name)){
			$value = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				$value= $this->default_value;	
			}	
		}
		if(!empty($this->help)){
		    $returnXTPL[$this->name . '_help'] = translate($this->help, $this->bean->module_dir);
		}
		
		global $app_list_strings;
		$returnXTPL = array();
		$returnXTPL[strtoupper($this->name)] = $value;

		
		$returnXTPL[strtoupper('RADIOOPTIONS_'.$this->name)] = $this->generateRadioButtons($value, false);
		return $returnXTPL;	
		
		
	}
	

	function generateRadioButtons($value = '', $add_blank =false){
		global $app_list_strings;
		$radiooptions = '';
		$keyvalues = $app_list_strings[$this->ext1];
		if($add_blank){
			$keyvalues = add_blank_option($keyvalues);
		}
		$help = (!empty($this->help))?"title='". translate($this->help, $this->bean->module_dir) . "'": '';
		foreach($keyvalues as $key=>$displayText){
			$selected = ($value == $key)?'checked': '';
			$radiooptions .= "<input type='radio' id='{$this->name}{$key}' name='$this->name'  $help value='$key' $selected><span onclick='document.getElementById(\"{$this->name}{$key}\").checked = true' style='cursor:default' onmousedown='return false;'>$displayText</span><br>\n";
		}
		return $radiooptions;
		
	}
	
	function get_xtpl_search(){
		$searchFor = '';
		if(!empty($_REQUEST[$this->name])){
			$searchFor = $_REQUEST[$this->name];
		}
		global $app_list_strings;
		$returnXTPL = array();
		$returnXTPL[strtoupper($this->name)] = $searchFor;
		$returnXTPL[strtoupper('RADIOOPTIONS_'.$this->name)] = $this->generateRadioButtons($searchFor, true);
		return $returnXTPL;	

	}
	
	function get_xtpl_detail(){
		$name = $this->name;
		if(isset($this->bean->$name)){
			global $app_list_strings;
			if(isset($app_list_strings[$this->ext1])){
				if(isset($app_list_strings[$this->ext1][$this->bean->$name])){
					return $app_list_strings[$this->ext1][$this->bean->$name];
				}
			}
		}else{
		    if(empty($this->bean->id)){
		        return $this->default_value;
		    }
		}
		return '';
	}
	
	function get_db_default(){
    return '';
}
	
}


?>
