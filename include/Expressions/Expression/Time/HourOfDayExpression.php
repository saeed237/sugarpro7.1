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

require_once('include/Expressions/Expression/Time/TimeExpression.php');

/**
 * <b>hourOfDay(Date d)</b><br/>
 * Returns the hour of the day (24 hour format) of a given date/time.<br>
 */
class HourOfDayExpression extends TimeExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = DateExpression::parse($this->getParameters()->evaluate());
		if(!$params) {
		    return false;
		}
		return $params->hour;
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var time = this.getParameters().evaluate();
			return new Date(time).getHours();
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "hourOfDay";
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>