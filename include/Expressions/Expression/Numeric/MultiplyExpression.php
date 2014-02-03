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
 * <b>multiply(Number n, ...)</b><br>
 * Multiplies the supplied numbers and returns the result.<br/>
 * ex: <i>multiply(-4, 2, 3)</i> = -24
 */
class MultiplyExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$product = 1;
		foreach ( $this->getParameters() as $expr )
			$product *= $expr->evaluate();
		return $product;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var product = 1;
			for ( var i = 0; i < params.length; i++ )	product *= params[i].evaluate();
			return product;
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "multiply";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		$str = "";
		
		foreach ( $this->getParameters() as $expr ) {
			if ( ! $expr instanceof ConstantExpression )	$str .= "(";
			$str .= $expr->toString() . " * ";
			if ( ! $expr instanceof ConstantExpression )	$str .= ")";
		}
	}
}
?>