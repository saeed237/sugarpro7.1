<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once('include/Expressions/Expression/Numeric/SumRelatedExpression.php');
/**
 * <b>countConditional(Relate <i>link</i>, Field <i>string</i>, Values <i>list</i>)</b><br>
 * Returns the number of records related to this record by <i>link</i> and that matches the values for a specific field
 * ex: <i>count($contacts, 'first_name', array('Joe'))</i> in Accounts would return the <br/>
 * number of contacts related to this account with the first name of 'Joe'
 */
class CountConditionalRelatedExpression extends SumRelatedExpression
{
    /**
     * Returns the entire enumeration bare.
     */
    public function evaluate()
    {
        $params = $this->getParameters();
        //This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $field = $params[1]->evaluate();
        $values = $params[2]->evaluate();
        //This should be of relate type, which means an array of SugarBean objects
        if (!is_array($linkField)) {
            return false;
        }

        if (!is_array($values)) {
            $values = array($values);
        }
        
        $count = 0;
        foreach ($linkField as $link) {
            if (in_array($link->$field, $values)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns the JS Equivalent of the evaluate function.
     *
     * Currently there is no JS Equivalent as this is a server side only method
     */
    public static function getJSEvaluate()
    {
        return false;
    }

    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName()
    {
        return array("countConditional");
    }

    /**
     * The first parameter is a number and the second is the list.
     */
    public static function getParameterTypes()
    {
        return array(
            AbstractExpression::$RELATE_TYPE,
            AbstractExpression::$STRING_TYPE,
            AbstractExpression::$GENERIC_TYPE
        );
    }

    /**
     * Returns the maximum number of parameters needed.
     */
    public static function getParamCount()
    {
        return 3;
    }

    /**
     * Returns the String representation of this Expression.
     */
    public function toString()
    {
    }
}
