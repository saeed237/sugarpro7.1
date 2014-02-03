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
 * <b>min(Number num, ...)</b><br/>
 * Returns lowest value number passed in<br>
 * ex: <i>min(-4, 2, 3)</i> = -4
 */
class MinimumExpression extends NumericExpression {
	/**
	 * Returns the smallest value in a set
	 */
	function evaluate() {
		$params = $this->getParameters();
		
		$min = false;
		foreach ( $this->getParameters() as $expr ) {
			$val = $expr->evaluate();
			if ($min === false || $val < $min)
				$min = $val;
		}
		return $min;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var min = null;
			for ( var i = 0; i < params.length; i++ )	
			{
				var val = 	params[i].evaluate();
				if(min == null || val < min)
					min = val;
			}
			return min;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "min";
	}
}
?>