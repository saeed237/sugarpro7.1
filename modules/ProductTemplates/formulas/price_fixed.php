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

/*********************************************************************************

 * Description:  
 ********************************************************************************/



class Fixed {

	function is_readonly() {
		return '';
	}
	
	function get_edit_html() {
		return "<input id='pricing_factor_Fixed' type='hidden' value='1'>";
	}
	
	function get_detail_html($formula, $factor) {
		global $current_language, $app_list_strings;
		$template_mod_strings = return_module_language($current_language, "ProductTemplates");
		return $app_list_strings['pricing_formula_dom'][$formula];
	}
	
	function get_formula_js() {
		return "form.discount_price.readOnly=false;\n";  
	}

	function calculate_price($cost_price=1, $list_price=1, $discount_price=1, $factor=1) {
		return $discount_price;
	}
}
?>
