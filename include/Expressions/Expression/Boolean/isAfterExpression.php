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
require_once("include/Expressions/Expression/Date/DateExpression.php");


/**
 * <b>isAfter(Date day1, Date day2)</b><br>
 * Returns true day1 is after day2.<br/>
 * ex: <i>isBefore(date("1/1/2001"), date("2/2/2002"))</i> = false
 */
class isAfterExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$params = $this->getParameters();

		$a = DateExpression::parse($params[0]->evaluate());
		$b = DateExpression::parse($params[1]->evaluate());

		if(empty($a) || empty($b)) {
		    return false;
		}

		if ( $a > $b )	return AbstractExpression::$TRUE;
		return AbstractExpression::$FALSE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var a = SUGAR.util.DateUtils.parse(params[0].evaluate());
			var b = SUGAR.util.DateUtils.parse(params[1].evaluate());

			if ( a > b )	return SUGAR.expressions.Expression.TRUE;
			return SUGAR.expressions.Expression.FALSE;
EOQ;
	}

	/**
	 * Any generic type will suffice.
	 */
	static function getParameterTypes() {
		return array("date", "date");
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
		return "isAfter";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>