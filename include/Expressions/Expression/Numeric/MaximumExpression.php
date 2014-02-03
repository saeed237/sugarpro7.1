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
 * <b>max(Number num, ...)</b><br/>
 * Returns highest value number passed in<br>
 * ex: <i>max(-4, 2, 3)</i> = 3
 */
class MaximumExpression extends NumericExpression {
	/**
	 * Returns the largest value in a set
	 */
	function evaluate() {
		$params = $this->getParameters();
		
		$max = false;
		foreach ( $this->getParameters() as $expr ) {
			$val = $expr->evaluate();
			if ($max === false || $val > $max)
				$max = $val;
		}
		return $max;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var max = null;
			for ( var i = 0; i < params.length; i++ )	
			{
				var val = 	params[i].evaluate();
				if(max == null || val > max)
					max = val;
			}
			return max;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "max";
	}
}
?>