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
 * <b>not(Boolean b)</b><br/>
 * Returns false if <i>b</i> is true, and true if <i>b</i> is false.<br/>
 * ex: <i>not(false)</i> = true
 */
class NotExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		if ( $this->getParameters()->evaluate() === AbstractExpression::$FALSE)
			return AbstractExpression::$TRUE;
		else
			return AbstractExpression::$FALSE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			if ( this.getParameters().evaluate() == SUGAR.expressions.Expression.FALSE )
				return SUGAR.expressions.Expression.TRUE;
			else
				return SUGAR.expressions.Expression.FALSE;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "not";
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>