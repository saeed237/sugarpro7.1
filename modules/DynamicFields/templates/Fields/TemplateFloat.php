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

require_once('modules/DynamicFields/templates/Fields/TemplateRange.php');

class TemplateFloat extends TemplateRange
{
	var $type = 'float';
	var $default = null;
	var $default_value = null;
	var $len = '18';
	var $precision = '8';

	function TemplateFloat(){
		parent::__construct();
		$this->vardef_map['precision']='ext1';
		//$this->vardef_map['precision']='precision';
	}

    function get_field_def(){
    	$def = parent::get_field_def();
		$def['precision'] = isset($this->ext1) && $this->ext1 != '' ? $this->ext1 : $this->precision;
    	return $def;
    }

    function get_db_type(){
		$precision = (!empty($this->precision))? $this->precision: 6;
    	if(empty($this->len)) {
			return parent::get_db_type();
		}
		return " ".sprintf($GLOBALS['db']->getColumnType("decimal_tpl"), $this->len, $precision); 
	}
	
}
