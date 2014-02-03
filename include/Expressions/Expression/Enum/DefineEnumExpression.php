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

require_once('include/Expressions/Expression/Enum/EnumExpression.php');
/**
 * <b>createList(v1, ...)</b><br/>
 * Returns a list made up of the passed in variables.<br/>
 * ex: <i>createList(123, "Hello World", "three", 4.5)</i>
 */
class DefineEnumExpression extends EnumExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$array  = array();

		if (is_array($params)) 
		{
			foreach ( $params as $param ) {
				$array[] = $param->evaluate();
			} 
		}
		else {
			$array[] = $params->evaluate();
		}

		return $array;
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters();
			var array = [];
			if (typeof(params.length) != "undefined")
			{
				for ( var i = 0; i < params.length; i++ ) {
					array[array.length] = params[i].evaluate();
				}
			} else {
				return [params.evaluate()];
			}
			return array;
EOQ;
	}


	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return AbstractExpression::$GENERIC_TYPE;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("createList", "enum");
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>