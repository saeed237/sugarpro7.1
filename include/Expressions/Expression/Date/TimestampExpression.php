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

require_once('include/Expressions/Expression/Date/DateExpression.php');

/**
 * <b>timestamp(<datetime string>)</b><br>
 * Returns the passed in datetime string as a unix timestamp
 */
class TimestampExpression extends DateExpression
{
    /**
     * Returns the entire enumeration bare.
     */
    public function evaluate()
    {
        $date = $this->getParameters()->evaluate();
        $params = DateExpression::parse($date);
        if (!$params) {
            return false;
        }
        if (!DateExpression::hasTime($date)) {
            $params->setTime(0, 0, 0);
        }
        return $params->getTimestamp();
    }

    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate()
    {
        return <<<EOQ
	    var datetime = this.getParameters().evaluate(),
            arr,
            ret = [],
            date = this.context.parseDate(datetime);

        return Math.round(+date.getTime()/1000);
EOQ;
    }

    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName()
    {
        return "timestamp";
    }

    /**
     * Returns the maximum number of parameters needed.
     */
    public static function getParamCount()
    {
        return 1;
    }

    /**
     * All parameters have to be a string.
     */
    public static function getParameterTypes()
    {
        return AbstractExpression::$DATE_TYPE;
    }
}
