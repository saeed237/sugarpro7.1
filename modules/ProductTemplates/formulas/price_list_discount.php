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



class PercentageDiscount {

	function is_readonly() {
		return 'readonly';
	}
	
	function get_edit_html($pricing_factor) {
		global $current_language;
		$template_mod_strings = return_module_language($current_language, "ProductTemplates");
		return "${template_mod_strings['LBL_PERCENTAGE']} <input language='javascript' onkeyup='set_discount_price(this.form)' id='pricing_factor_PercentageDiscount' type='text' tabindex='1' size='4' maxlength='4' value='".$pricing_factor."'>";
	}
	
	function get_detail_html($formula,$factor) {
		global $current_language, $app_list_strings;
		$template_mod_strings = return_module_language($current_language, "ProductTemplates");
		return $app_list_strings['pricing_formula_dom'][$formula]." [".$template_mod_strings['LBL_PERCENTAGE']." = ".$factor."]";
	}
	
	function get_formula_js() {
		//Percentage Markup: $discount_price = $cost_price x (1 + $percentage) 
		global $current_user, $sugar_config;
		$precision = null;

		if($precision == null) {
	 		$precision_val = $current_user->getPreference('default_currency_significant_digits');
			$precision = (empty($precision_val) ? $sugar_config['default_currency_significant_digits'] : $precision_val);			
		}	
		$the_script = "form.discount_price.readOnly = true;\n";
		$the_script .= 	"this.document.getElementById('discount_price').value = formatNumber(Math.round(unformatNumber(this.document.getElementById('list_price').value, num_grp_sep, dec_sep) * (1 - (unformatNumber(this.document.getElementById('pricing_factor_PercentageDiscount').value, num_grp_sep, dec_sep) /100))*100)/100, num_grp_sep, dec_sep, $precision, $precision);\n";
		return $the_script;  
	}

	function calculate_price($cost_price, $list_price, $discount_price, $factor) {
		//Percentage Markup: $discount_price = $cost_price x (1 + $percentage) 
		$discount_price  = 	$list_price * (1 - ($factor/100));
		return $discount_price;
	}
}
?>
