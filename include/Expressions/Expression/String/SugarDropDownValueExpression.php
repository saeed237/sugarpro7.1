<?php
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

require_once("include/Expressions/Expression/String/StringExpression.php");

/**
 * <b>getDropdownValue(String list_name, String key)</b><br>
 * Returns the translated value for the given <i>key</i><br/>
 * found in the <i>list_name</i> DropDown list<br/>
 * This list must be defined in the DropDown editor.<br/>
 * ex: <i>getDropdownValue("my_list", "foo")</i>
 */
class SugarDropDownValueExpression extends StringExpression {
	
	/**
	 * Returns the negative of the expression that it contains.
	 */
	function evaluate() {
		global $app_list_strings;
		$params = $this->getParameters();
        $list = $params[0]->evaluate();
        $key = $params[1]->evaluate();
		
        if (isset($app_list_strings[$list]) && is_array($app_list_strings[$list]) 
                && isset($app_list_strings[$list][$key])) 
        {
            return $app_list_strings[$list][$key];
        }
        
        
        
        return ""; 
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		    var params = this.getParameters();
		    var list = params[0].evaluate();
		    var key = params[1].evaluate();
            var arr = this.context.getAppListStrings(list);
            if (arr == "undefined") return "";
            for (var i in arr) {
                if (typeof i == "string" && i == key)
                    return arr[i];
            }
            return "";
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("getDropdownValue", "getDDValue");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}
}
?>
