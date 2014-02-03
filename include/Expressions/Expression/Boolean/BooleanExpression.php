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

require_once('include/Expressions/Expression/AbstractExpression.php');

/**
 * Base class that all functions which return a boolean value should extend.
 */
abstract class BooleanExpression extends AbstractExpression
{
	/**
	 * Validates the parameters and throws an Exception if invalid.
	 *
	function validateParameters() {
		$params = $this->getParameters();
		$count  = $this->getParamCount();
		$types  = $this->getParameterTypes();

		// make sure count is a number
		if ( !is_numeric($count) )	throw new Exception($this->getOperationName() . ": Number of paramters required must be a number.");

		// make sure types is a array or string
		if ( ( !is_string($types) && !is_array($types) ) || ( $types != AbstractExpression::$BOOLEAN_TYPE && $count != AbstractExpression::$INFINITY && $count != sizeof($types) ) )
			throw new Exception($this->getOperationName() . ": Parameter types must be valid and match the parameter count.");

		// if we require 0 parameters but we still have parameters
		if ( $count == 0 && isset($params) )	throw new Exception($this->getOperationName() . ": Does not require any parameters.");

		// we require multiple but params only has 1
		if ( $count > 1 && !is_array($params) )	throw new Exception($this->getOperationName() . ": Requires exactly $count parameter(s).");

		// if params is just a string, and we require a single string
		if ( $count == 1 && $types == AbstractExpression::$BOOLEAN_TYPE && ( $this->is_sugarbool($params) || $params instanceof BooleanExpression ) )
			return;

		// no params needed, and no params given
		if ( $count == 0 && !isset($params))	return;

		// we require only 1 and params has multiple
		if ( $count == 1 && is_array($params) )	throw new Exception($this->getOperationName() . ": Requires exactly $count parameter(s).");

		// check parameter range
		if ( $count != AbstractExpression::$INFINITY && sizeof($params) != $count )
			throw new Exception($this->getOperationName() . ": Requires exactly $count parameter(s).");

		if ( $types == AbstractExpression::$BOOLEAN_TYPE ) {
			// make sure all parameters are typeof StringExpression or a string literal
			foreach ( $params as $param ) {
				if ( ! $param instanceof Expression )
					throw new Exception($this->getOperationName() . ": All parameters must be booleans.");
			}
		} else {
			for ( $i = 0 ; $i < sizeof($types) ; $i++ ) {
				$type  = $types[$i];
				$param = $params[$i];

				// invalid type
				if ( empty(AbstractExpression::$TYPE_MAP[$type]) )
					throw new Exception($this->getOperationName() . ": invalid type specified.");

				// improper type
				if ( ! $param instanceof AbstractExpression::$TYPE_MAP[$type] )
					throw new Exception($this->getOperationName() . ": the parameter at index $i must be of type $type.");
			}
		}
	}*/

	/**
	 * All parameters have to be a string.
	 */
	static function getParameterTypes() {
		return AbstractExpression::$BOOLEAN_TYPE;
	}
}

?>