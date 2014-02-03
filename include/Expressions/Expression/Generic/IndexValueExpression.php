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

require_once('include/Expressions/Expression/Generic/GenericExpression.php');
/**
 * <b>valueAt(Number index, Enum values)</b><br>
 * Returns the value at position <i>index</i> in the collection <i>values</i>.<br/>
 * ex: <i>valueAt(1, enum("a", "b", "c") = "b"</i>
 */
class IndexValueExpression extends GenericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$array  = $params[1]->evaluate();
		$index  = $params[0]->evaluate();

		if ( $index >= sizeof($array) || $index < 0 )
			throw new Exception( $this->getOperationName() . ": Attempt to access an index out of bounds" );

		return $array[$index];
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var array  = params[1].evaluate();
			var index  = params[0].evaluate();

			if ( index >= array.length || index < 0 )
				throw ("value_at: Attempt to access an index out of bounds");

			return array[index];
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "valueAt";
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array("number", "enum");
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