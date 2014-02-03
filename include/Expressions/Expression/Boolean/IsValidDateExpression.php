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
 * <b>isValidDate(String date)</b><br/>
 * Returns true if <i>date</i> is a valid date string.
 *
 */
class IsValidDateExpression extends BooleanExpression {
	/**
	 * Returns true if a passed in date string (in User format) is valid
	 */
	function evaluate() {
        global $current_user;
        $dtStr = $this->getParameters()->evaluate();

        if(empty($dtStr)) {
            return AbstractExpression::$TRUE;
        }
        try {
            $td = TimeDate::getInstance();
            $date = $td->fromUser($dtStr, $current_user);
            if(!empty($date) && $td->asUser($date) == $dtStr) {
                return AbstractExpression::$TRUE;
            }
            //Next try without time
            $date = $td->fromUserDate($dtStr, $current_user);
            if(!empty($date) && $td->asUserDate($date) == $dtStr)  {
                return AbstractExpression::$TRUE;
            }
            return AbstractExpression::$FALSE;
        } catch(Exception $e) {
            return AbstractExpression::$FALSE;
        }
	}

	/**
	 * Returns true is a passed in date string (in user format) is valid.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		var dtStr = this.getParameters().evaluate();
		if ( typeof dtStr != "string" ) return SUGAR.expressions.Expression.FALSE;
		if (dtStr == "") return SUGAR.expressions.Expression.TRUE;
        var format = "Y-m-d";
        if (SUGAR.expressions.userPrefs)
            format = SUGAR.expressions.userPrefs.datef;
        var date = SUGAR.util.DateUtils.parse(dtStr, format);
        if(date != false && date != "Invalid Date")
		    return SUGAR.expressions.Expression.TRUE;
		return SUGAR.expressions.Expression.FALSE;
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
		return "isValidDate";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>
