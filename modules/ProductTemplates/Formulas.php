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


// We suggest that if you wish to modify an existing formula, copy & paste the existing formula file to a new file
// this will prevent conflicts with future upgrades.

// To add a new formula, you will need to register the new file below and in the pricing_formula_dom array
// in modules/ProductTemplates/language/<lang>.lang.php
// FG - No more need to change local file. Added inclusion of custom/modules/ProductTemplates/formulas/*.php
//global $price_formulas;

function refresh_price_formulas()
{
    $GLOBALS['price_formulas'] = array(
        //$discount_price manually entered by admin
        'Fixed'=>'modules/ProductTemplates/formulas/price_fixed.php'

        //Profit Margin: $discount_price = $cost_price * 100 /(100 - $factor)
    ,'ProfitMargin'=>'modules/ProductTemplates/formulas/price_profit_margin.php'

        //Percentage Markup: $discount_price = $cost_price x (1 + $percentage)
    ,'PercentageMarkup'=>'modules/ProductTemplates/formulas/price_cost_markup.php'

        //Percentage Discount: $discount_price = $list_price x (1 - $percentage)
    ,'PercentageDiscount'=>'modules/ProductTemplates/formulas/price_list_discount.php'

        //List: $discount_price = $list_price
    ,'IsList'=>'modules/ProductTemplates/formulas/price_list.php'
    );

    // FG - Bug 44515 - Added inclusion of all .php formula files in custom/modules/ProductTemplates/formulas (if exists).
    //                  Every file must contain a class whose name must equals the file name (without extension) all lowercase except the first letter, uppercase.
    //                  Here devs can add classes for custom formulas - The Upgrade Safe Way
    if (sugar_is_dir("custom/modules/ProductTemplates/formulas"))
    {
        $_files = glob("custom/modules/ProductTemplates/formulas/*.php");
        foreach ($_files as $filename)
        {
            $_formulaId = ucfirst(basename(strtolower($filename), ".php"));
            $GLOBALS['price_formulas'][$_formulaId] = $filename;
        }
    }
}

function get_formula_details($pricing_factor) {
	global $price_formulas;
	foreach ($price_formulas as $formula=>$file) {
		require_once($file);
		$focus = new $formula;
		$readonly = $focus->is_readonly();
		$edit_html = $focus->get_edit_html($pricing_factor);
		$formula_js = $focus->get_formula_js();
		$output[$formula] = array('readonly'=>$readonly,'edit_html'=>$edit_html,'formula_js'=>$formula_js);
	}
	return $output;
}

function get_edit($formulas, $formula) {
	$the_script = '';
	//begin by creating all the divs for each formula's price factor
	foreach ($formulas as $name=>$content) {
		if ($name == $formula) {
			$the_script  .= "<div align='center' id='edit_$name' style='display:inline'> ${content['edit_html']}</div> \n";
		}
		else {
			$the_script  .= "<div align='center' id='edit_$name' style='display:none'> ${content['edit_html']}</div> \n";
		}
	}
	$the_script .= "<script type='text/javascript' language='Javascript'> \n";
	$the_script .= "<!--  to hide script contents from old browsers \n\n";
	$the_script .= "function show_factor() { \n";
	//first turn off all pricing factor divs
	foreach ($formulas as $name=>$content) {
		$the_script .= "	this.document.getElementById('edit_$name').style.display='none'; \n";
	}

	//then turn on a new pricing factor div based on the selected formula
	$the_script .= "	switch(this.document.forms.EditView.pricing_formula.value) { \n";
	foreach ($formulas as $name=>$content) {
		$the_script .= "		case '$name': \n";
		$the_script .= "			this.document.getElementById('edit_$name').style.display='inline'; \n";
		$the_script .= "		  	return true; \n";
	}
	$the_script .= "		} \n";
	$the_script .= "} \n";

	$the_script .= "function set_discount_price(form) { \n";
	$the_script .= "	switch(form.pricing_formula.value) { \n";
	foreach ($formulas as $name=>$content) {
		$the_script .= "		case '$name': \n";
		$the_script .= "			${content['formula_js']} \n";
		$the_script .= "			form.pricing_factor.value = form.pricing_factor_$name.value; \n";
		$the_script .= "		  	return true; \n";
}
	$the_script .= "		} \n";
	$the_script .= "} \n";
    $the_script .= "if ( typeof document.forms.EditView != 'undefined' ) { set_discount_price(document.forms.EditView); }\n";

	$the_script .= "//  End -->\n</script> \n\n";

	return $the_script;
}

function get_detail($formula, $factor) {
	global $mod_strings, $price_formulas;
	if (isset($price_formulas[$formula]))
	{
		require_once($price_formulas[$formula]);
		$focus = new $formula;
		return $focus->get_detail_html($formula, $factor);
	}
	else
	{
		return '';
	}
}
