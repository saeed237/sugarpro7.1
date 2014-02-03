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

require_once("include/Expressions/Expression/Numeric/NumericExpression.php");
/**
 * <b>pow(Number n, Number p)</b><br/>
 * Returns </i>n</i> to the <i>p</i> power.<br/>
 * ex: <i>pow(2, 3)</i> = 8
 */
class PowerExpression extends NumericExpression {
	/**
	 * Returns the negative of the expression that it contains.
	 */
	function evaluate() {
		$params = $this->getParameters();

		$base = $params[0]->evaluate();
		$power = $params[1]->evaluate();

		return pow($base, $power);
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();

			var base = params[0].evaluate();
			var power = params[1].evaluate();

			return Math.pow(base, power);
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "pow";
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}
}
?>