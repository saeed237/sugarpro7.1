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

require_once('modules/DynamicFields/templates/Fields/TemplateURL.php');
class TemplateIFrame extends TemplateURL{
	var $type='iframe';
	
function get_html_edit(){
        $this->prepare();
        return "<input type='text' name='". $this->name. "' id='".$this->name."' size='".$this->size."' title='{" . strtoupper($this->name) ."_HELP}' value='{". strtoupper($this->name). "}'>";
    }
	
	function get_html_label() {
		return "LALALALA";
	}
	
	function get_xtpl_detail(){
        $value = parent::get_xtpl_detail();
        $value .= "BLAH BLAH";
        return $value;
    }
    
	function get_field_def(){
		$def = parent::get_field_def();
		$def['height'] = !empty($this->height) ? $this->height : $this->ext4;
		return $def;	
	} 

}
?>
