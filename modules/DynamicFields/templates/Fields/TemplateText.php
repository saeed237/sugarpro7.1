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

require_once('modules/DynamicFields/templates/Fields/TemplateField.php');
class TemplateText extends TemplateField{
	var $type='varchar';
    var $supports_unified_search = true;
		
	function get_xtpl_edit(){
		$name = $this->name;
		$returnXTPL = array();
	
		if(!empty($this->help)){
		    $returnXTPL[strtoupper($this->name . '_help')] = translate($this->help, $this->bean->module_dir);
		}
	
		if(isset($this->bean->$name)){
		    $returnXTPL[$this->name] = $this->bean->$name;
		}else{
			if(empty($this->bean->id)){
				 $returnXTPL[$this->name] =  $this->default_value;	
			}	
		}
		return $returnXTPL;
	}
	function get_xtpl_search(){
		if(!empty($_REQUEST[$this->name])){
			return $_REQUEST[$this->name];
		}	
	}
	
	
	
	function get_xtpl_detail(){
		$name = $this->name;
		if(isset($this->bean->$name)){
			return $this->bean->$name;	
		}
		return '';
		
	}
    
	
}


?>
