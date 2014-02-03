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
 * <b>indexOf(val, List l)</b><br>
 * Returns the position of <i>val</i> in <i>l</i><br/>
 * or -1 if <i>l</i> does not contain <i>val</i>.<br/>
 * ex: <i>indexOf("a", createList("a", "b", "c"))</i> = 0,<br/>
 * <i>indexOf("foo", createList("a", "b", "c"))</i> = -1
 */
class IndexOfExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$array  = $params[1]->evaluate();
		$value  = $params[0]->evaluate();
		
		for ($i=0; $i < sizeOf($array); $i++) {
			if ($array[$i] == $value) {
				return $i;
			}
		}
		return -1;
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var arr  = params[1].evaluate();
			var val  = params[0].evaluate();

			for (var i=0; i < arr.length; i++) {
			if (arr[i] == val) {
				return i;
			} 
		}
		return -1;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "indexOf";
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array("generic", "enum");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>