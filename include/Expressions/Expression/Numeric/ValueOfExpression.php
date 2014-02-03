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
 * <b>number(String s)</b><br>
 * Returns the numeric value of <i>s</i>.<br/>
 * ex: <i>number("1,200")</i> = 1200
 */
class ValueOfExpression extends NumericExpression {
	
	/**
	 * Returns the negative of the expression that it contains.
	 */
	function evaluate() {
		$val = $this->getParameters()->evaluate();
		if (is_string($val))
		{
			$val = str_replace(",", "", $val);
			if (!is_numeric($val))
			   throw new Exception("Error: '$val' is not a number");
			if (strpos($val, ".") !== false) {
				$val =  $val;
			}
			else {
			    $val = (int) $val;
			}
		}
		if (is_numeric($val))
		{
			return $val;
		}
		else {
		    throw new Exception("Error: '$val' is not a number");
		}
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var val = this.getParameters().evaluate() + "";
			val = val.replace(/,/g, "");
			var out = 0;
			if (val.indexOf(".") != -1)
				out = parseFloat(val);
			else 
			    out = parseInt(val);
			if (isNaN(out))
			   throw "Error: '" + val + "' is not a number";
			
			return out;
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "number";
	}
	
	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}
	
	/**
	 * All parameters have to be a string.
	 */
    static function getParameterTypes() {
		return AbstractExpression::$GENERIC_TYPE;
	}
}
?>