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
 * <b>isNumeric(String string)</b><br/>
 * Returns true if <i>string</i> contains only digits, <br/>
 * negative sign, or a decimal point.
 *
 */
class IsNumericExpression extends BooleanExpression
{
    /**
     * Returns itself when evaluating.
     */
    public function evaluate()
    {
        $params = $this->getParameters()->evaluate();
        if ($params === '' || is_null($params)) {
            return AbstractExpression::$FALSE;
        }
        if (preg_match('/^(\-)?([0-9]+)?(\.[0-9]+)?$/', $params)) {
            return AbstractExpression::$TRUE;
        }

        return AbstractExpression::$FALSE;
    }

    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate()
    {
        return <<<EOQ
			var params = this.getParameters().evaluate();
			if (params == '') {
		        SUGAR.expressions.Expression.FALSE
			}
			if ( /^(\-)?([0-9]+)?(\.[0-9]+)?$/.test(params) )	return SUGAR.expressions.Expression.TRUE;
			return SUGAR.expressions.Expression.FALSE;
EOQ;
    }

    /**
     * Any generic type will suffice.
     */
    public static function getParameterTypes()
    {
        return array("string");
    }

    /**
     * Returns the maximum number of parameters needed.
     */
    public static function getParamCount()
    {
        return 1;
    }

    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName()
    {
        return "isNumeric";
    }

    /**
     * Returns the String representation of this Expression.
     */
    public function toString()
    {
    }
}
