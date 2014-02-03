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
 * <b>strToUpper(String s)</b><br/> 
 * Returns <i>s</i> converted to upper case.<br/>
 * ex: <em>strToLower("Hello World")</em> = "HELLO WORLD"
 */
class StrToUpperExpression extends StringExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$param =$this->getParameters();
		if (is_array($param))
			$param = $param[0];
    $strtoupper = function_exists('mb_strtoupper') ? mb_strtoupper($param->evaluate(), 'UTF-8') : strtoupper($param->evaluate());
		return $strtoupper;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var string = this.getParameters().evaluate() + "" ;
			return string.toUpperCase();
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "strToUpper";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>
