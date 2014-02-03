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

require_once('include/Expressions/Expression/Generic/GenericExpression.php');
/**
 * <b>ifElse(Boolean c, Val1, Val2)</b><br>
 * Returns <i>Val1</i> if <i>c</i> is true<br/>
 * or <i>Val2</i> if <i>c</i> is false.<br/>
 * ex: <i>ifElse(true, "first", "second") = "first"</i><br/>
 * <i>ifElse(false, "first", "second")</i> = "second"
 */
class ConditionExpression extends GenericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$cond = $params[0]->evaluate();
		if ($cond == AbstractExpression::$TRUE) {
			return $params[1]->evaluate();
		} else {
			return $params[2]->evaluate();
		}
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var cond = params[0].evaluate();
			if (cond == SUGAR.expressions.Expression.TRUE) {
				return params[1].evaluate();
			} else {
				return params[2].evaluate();
			}
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("ifElse","cond");
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$BOOLEAN_TYPE, AbstractExpression::$GENERIC_TYPE, AbstractExpression::$GENERIC_TYPE);
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 3;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>