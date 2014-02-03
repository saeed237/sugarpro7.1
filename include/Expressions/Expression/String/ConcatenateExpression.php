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

require_once("include/Expressions/Expression/String/StringExpression.php");

/**
 * <b>concat(String s, ...)</b><br/>
 * Appends two or more pieces of text together.<br/>
 * ex: <i>concat("Hello", " ", "World")</i> = "Hello World"
 */
class ConcatenateExpression extends StringExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		// TODO: add caching of return values
		$concat = "";
		foreach ( $this->getParameters() as $expr ) {
			$concat .= $expr->evaluate();
		}
		return $concat;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var concat = "";
			var params = this.getParameters() ;
			for ( var i = 0; i < params.length; i++ ) {
				concat += params[i].evaluate();
			}
			return concat;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "concat";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>