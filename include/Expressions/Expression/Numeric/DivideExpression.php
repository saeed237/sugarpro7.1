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
 * <b>divide(Number numerator, Number denominator)</b><br>
 * Returns the <i>numerator</i> divided by the <i>denominator</i>.<br/>
 * ex: <i>divide(8, 2)</i> = 4
 */
class DivideExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$params = $this->getParameters();
		$numerator   = $params[0]->evaluate();
		$denominator = $params[1]->evaluate();
		if($denominator == 0) {
		    throw new Exception("Division by zero");
		}
		return $numerator/$denominator;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var numerator   = params[0].evaluate();
			var denominator = params[1].evaluate();
			if (denominator == 0)
			    throw "Devision by 0 error";
			return numerator/denominator;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "divide";
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}
}
?>