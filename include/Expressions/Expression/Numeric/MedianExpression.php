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
 * <b>median(Number n, ...)</b><br/>
 * Returns the median of the supplied numbers.
 * ex: <i>median(4, 5, 5, 6, 7)</i> = 5
 */
class MedianExpression extends NumericExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$values = array();
		
		foreach ( $this->getParameters() as $expr )
			$values[] = $expr->evaluate();
		
		sort($values);
		if (sizeof($values) % 2 == 0) 
		{
			return ($values[sizeof($values)/2] + $values[sizeof($values)/2 - 1]) / 2;
		}
		
		return $values[floor(sizeof($values)/2)];
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var values = new Array();
			
			for ( var i = 0; i < params.length; i++ )
				values[values.length] = parseFloat(params[i].evaluate()); 
			
			// sort numerically
			values.sort(function(a, b) {return a - b;});
			
			if (values.length % 2 == 0) 
			{
				return (values[values.length/2] + values[values.length/2 - 1]) / 2;
			}
			
			return values[ Math.round(values.length/2) - 1 ];
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "median";
	}
	
	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
		//pass
	}
}
?>