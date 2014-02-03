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
 * <b>average(Number n, ...)</b><br>
 * Returns the average of the given numbers<br/>
 * ex: <i>average(2, 5, 11)</i> = 6
 */
class AverageExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$sum   = 0;
		$count = 0;
		foreach ( $this->getParameters() as $expr ) {
			$sum += $expr->evaluate();
			$count ++;
		}
		
		// since Expression guarantees at least 1 parameter
		// we can safely assume / by 0 will not happen
		return ( $sum / $count );
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var sum   = 0;
			var count = 0;
			var params = this.getParameters();
			for ( var i = 0; i < params.length; i++ ) {
				sum += params[i].evaluate();
				count++;
			}
			// since Expression guarantees at least 1 parameter
			// we can safely assume / by 0 will not happen
			return ( sum / count );
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "average";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		$str = "";
		
		foreach ( $this->getParameters() as $expr ) {
			if ( ! $expr instanceof ConstantExpression )	$str .= "(";
			$str .= $expr->toString();
			if ( ! $expr instanceof ConstantExpression )	$str .= ")";
		}
	}
}
?>