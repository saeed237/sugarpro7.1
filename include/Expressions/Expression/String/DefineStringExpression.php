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
 * <b>toString(val)</b><br/>
 * Converts the given value to a string.<br>
 * ex: <i>toString(5.5)</i> = "5.5"
 */
class DefineStringExpression extends StringExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
        try {
            $val = $this->getParameters()->evaluate();
            //Dates should be formated before being cast to a string
            if(($val instanceof SugarDateTime) && !empty($val->def))
            {
                global $timedate;
                require_once("include/Expressions/Expression/Date/DateExpression.php");
                $date = DateExpression::roundTime($val);
                if ($val->def['type'] == "date")
                {
                    //Date
                    $date->setTimezone(new DateTimeZone("UTC"));
                    $retstr = $timedate->asUserDate($date);
                } else
                {
                    //Datetime
                    $retstr = $timedate->asUser($date);
                }
            }
            else {
                $retstr = $val . "";
            }
        } catch (Exception $e) {
            $GLOBALS['log']->warn('DefineStringExpression::evaluate() returned empty string due to received exception: '.$e->getMessage());
            $retstr = "";
        }
		return $retstr;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			return this.getParameters().evaluate() + "";
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("toString", "string");
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Any generic type will suffice.
	 */
    static function getParameterTypes() {
		return array("generic");
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>