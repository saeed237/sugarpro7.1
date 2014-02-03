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

require_once("include/Expressions/Expression/Boolean/BooleanExpression.php");

/**
 * <b>isValidEmail(String email)</b><br/>
 * Returns true if <i>email</i> is in a valid email address format. <br/>
 * ex: <i>isValidEmail("invalid@zxcv")</i> = false,<br/>
 * <i>isValidEmail("good@test.com")</i> = true
 */
class IsValidEmailExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$emailStr = $this->getParameters()->evaluate();

		if ($emailStr == "")
            return AbstractExpression::$TRUE;

        $lastChar = $emailStr[strlen($emailStr) - 1];
		if ( !preg_match('/[^\.]/i', $lastChar) )	return AbstractExpression::$FALSE;

		// validate it
		$emailArr = preg_split('/[,;]/', $emailStr);
		for ( $i = 0; $i < sizeof($emailArr) ; $i++) {
			$emailAddress = $emailArr[$i];
			if (trim($emailAddress) != '') {
				if (!preg_match('/^\s*[\w.%+\-]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}\s*$/i', $emailAddress) &&
				    !preg_match('/^.*<[A-Z0-9._%+\-]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}>\s*$/i', $emailAddress) )
					return AbstractExpression::$FALSE;
			}
		}

		return AbstractExpression::$TRUE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		var emailStr = this.getParameters().evaluate();
		
		if ( typeof emailStr != "string" ) return SUGAR.expressions.Expression.FALSE;

		if ( emailStr == "" ) return SUGAR.expressions.Expression.TRUE;
		
		var lastChar = emailStr.charAt(emailStr.length - 1);
		if ( !lastChar.match(/[^\.]/i) )	return SUGAR.expressions.Expression.FALSE;

		// validate it
		var emailArr = emailStr.split(/[,;]/);		// if multiple e-mail addresses
		for (var i = 0; i < emailArr.length; i++) {
			var emailAddress = emailArr[i];
			emailAddress = emailAddress.replace(/^\s+|\s+$/g,"");
			if ( emailAddress != '') {
				if(!/^\s*[\w.%+\-]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}\s*$/i.test(emailAddress) &&
				   !/^.*<[A-Z0-9._%+\-]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}>\s*$/i.test(emailAddress))
				   return SUGAR.expressions.Expression.FALSE;
			}
		}

		return SUGAR.expressions.Expression.TRUE;
EOQ;
	}

	/**
	 * Any generic type will suffice.
	 */
	static function getParameterTypes() {
		return array("string");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "isValidEmail";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>