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



class ProfitMargin {

	function is_readonly() {
		return 'readonly';
	}
	
	function get_edit_html($pricing_factor) {
		global $current_language;
		$template_mod_strings = return_module_language($current_language, "ProductTemplates");
		return "${template_mod_strings['LBL_POINTS']} <input language='javascript' onkeyup='set_discount_price(this.form)' id='pricing_factor_ProfitMargin' type='text' tabindex='1' size='4' maxlength='4' value='".$pricing_factor."'>";
	}
	
	function get_detail_html($formula, $factor) {
		global $current_language, $app_list_strings;
		$template_mod_strings = return_module_language($current_language, "ProductTemplates");
		return $app_list_strings['pricing_formula_dom'][$formula]." [".$template_mod_strings['LBL_POINTS']." = ".$factor."]";
	}
	
	function get_formula_js() {
		//ProfitMargin: $discount_price = $cost_price * 100 /(100 - $factor) 
		global $current_user, $sugar_config;
		$precision = null;

		if($precision == null) {
	 		$precision_val = $current_user->getPreference('default_currency_significant_digits');
			$precision = (empty($precision_val) ? $sugar_config['default_currency_significant_digits'] : $precision_val);			
		}
			
		$the_script = "form.discount_price.readOnly = true;\n";
		$the_script .= "this.document.getElementById('discount_price').value = unformatNumber(this.document.getElementById('cost_price').value, num_grp_sep, dec_sep) * 100 / (100 - unformatNumber(this.document.getElementById('pricing_factor_ProfitMargin').value, num_grp_sep, dec_sep));\n";
		$the_script .= "this.document.getElementById('discount_price').value = formatNumber(this.document.getElementById('discount_price').value, num_grp_sep, dec_sep, $precision, $precision);\n";
		return $the_script;  
	}

	function calculate_price($cost_price=1.00, $list_price=1.00, $discount_price=1.00, $factor=1) {
		//ProfitMargin: $discount_price = $cost_price * 100 /(100 - $factor) 
		$discount_price = $cost_price * 100 / (100 - $factor);
		return $discount_price;
	}
}
?>
