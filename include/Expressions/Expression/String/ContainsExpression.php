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

require_once("include/Expressions/Expression/Boolean/BooleanExpression.php");

/**
 * <b>contains(String haystack, String needle)</b><br/>
 * Returns true if needle is within haystack.<br/>
 * ex: <i>contains("Hello World", "llo")</i> = true
 */
class ContainsExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$params	  = $this->getParameters();
		$haystack = $params[0]->evaluate();
		$needle	  = $params[1]->evaluate();

		if ( strpos($haystack, $needle) === false )
			return AbstractExpression::$FALSE;
		else
			return AbstractExpression::$TRUE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params	  = this.getParameters();
			var haystack  = params[0].evaluate() + "";
			var needle	  = params[1].evaluate();

			return ( haystack.indexOf(needle) > -1 ? SUGAR.expressions.Expression.TRUE : SUGAR.expressions.Expression.FALSE );
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "contains";
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
    static function getParameterTypes() {
		return AbstractExpression::$STRING_TYPE;
	}
}
?>