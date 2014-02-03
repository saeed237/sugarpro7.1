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


class TemplateDecimal extends TemplateFloat{
	var $type = 'decimal';
	var $default = null;
	var $default_value = null;
	
	function TemplateDecimal(){
    	parent::__construct();
	}

    function get_db_type()
	{
		if(empty($this->len)) {
			return parent::get_db_type();
		}
		$precision = (!empty($this->precision)) ? $this->precision : 6;
		return " ".sprintf($GLOBALS['db']->getColumnType("decimal_tpl"), $this->len, $precision); 
	}
}

?>
