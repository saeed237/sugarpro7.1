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
 * <b>translateLabel(String label, String module)</b><br/>
 * Returns the translated version of a given label key<br/>
 * ex: <i>translateLabel("LBL_NAME", "Accounts")</i> = "Name"
 */
class SugarTranslateExpression extends StringExpression {
	
	function evaluate() {
		$params = $this->getParameters();
        $module = $params[1]->evaluate();
        if ($module == "")
              $module = "app_strings";
        $key = $params[0]->evaluate();
        return translate($key, $module);
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		  var params = this.getParameters();
		  var module = params[1].evaluate();
		  if (module == "")
		      module = "app_strings";
		  var key = params[0].evaluate();
		  return SUGAR.language.get(module, key);
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("translateLabel", "translate");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}
}
?>