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

require_once('include/Expressions/Expression/Numeric/NumericExpression.php');

/**
 * <b>daysUntil(Date d)</b><br>
 * Returns number of days from now until the specified date.
 */
class DaysUntilExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = DateExpression::parse($this->getParameters()->evaluate());
        if(!$params) {
            return false;
        }
        $now = TimeDate::getInstance()->getNow();
        //set the time to 0, as we are returning an integer based on the date.
        $now->setTime(0, 0, 0);
        $params->setTime(1, 0, 0);
        $tsdiff = $params->ts - $now->ts;
        $diff = (int)floor($tsdiff/86400);
        $extrasec = $tsdiff%86400;
        if($extrasec != 0) {
            $extra = $params->get(sprintf("%+d seconds", $extrasec));
            if($extra->day_of_year != $params->day_of_year) {
                $diff++;
            }
        }
        return $diff;
	}


	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var then = SUGAR.util.DateUtils.parse(this.getParameters().evaluate());
			var now = new Date();
			now.setHours(0);
			now.setMinutes(0);
			now.setSeconds(0);
			then.setHours(1);
			then.setMinutes(0);
			then.setSeconds(0);
			var diff = then - now;
			var days = Math.floor(diff / 86400000);
			var extrasec = diff % 86400000;
			var extra = new Date();
			extra.setTime(then.getTime() + extrasec);
			if (extra.getDate() != then.getDate())
			    days++;

			return days;
EOQ;
	}


	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "daysUntil";
	}

	/**
	 * All parameters have to be a date.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$DATE_TYPE);
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
