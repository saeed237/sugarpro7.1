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
 * <b>doBothExist(String s1, String s2)</b><br>
 * Returns true if both <i>s1</i> and <i>s2</i> are not empty.<br/>
 * ex: <i>doBothExist("not", "empty")</i> = true,<br/>
 * <i>doBothExist("empty", "")</i> = false
 */
class BinaryDependencyExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$a = $params[0]->evaluate();
		$b = $params[1]->evaluate();

		if ( strlen($a) != 0 && strlen($b) != 0 )
			return AbstractExpression::$TRUE;

		return AbstractExpression::$FALSE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var a = params[0].evaluate();
			var b = params[1].evaluate();
			if ( a != null && b != null && a != '' && b != '' )
				return SUGAR.expressions.Expression.TRUE;
			return SUGAR.expressions.Expression.FALSE;
EOQ;
	}

	/**
	 * Any generic type will suffice.
	 */
	static function getParameterTypes() {
		return array("string", "string");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "doBothExist";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>