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
 * <b>rollupMin(Relate <i>link</i>, String <i>field</i>)</b><br>
 * Returns the lowest value of <i>field</i> in records related by <i>link</i><br/>
 * ex: <i>rollupMin($opportunities, "amount")</i> in Accounts would return the <br/>
 * lowest amount of any Opportunity related to this Account.
 */
class MinRelatedExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
		//This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();

		if (!is_array($linkField) || empty($linkField))
            return 0;

		$ret = false;

        foreach($linkField as $bean)
        {
            if (isset($bean->$relfield) && $ret === false || $ret > $bean->$relfield)
                $ret = $bean->$relfield;
        }

        return $ret;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		    var params = this.getParameters();
			var linkField = params[0].evaluate();
			var relField = params[1].evaluate();

			if (typeof(linkField) == "string" && linkField != "")
			{
                return SUGAR.forms.AssignmentHandler.getRelatedField(linkField, 'rollupMin', relField);
			} else if (typeof(rel) == "object") {
			    //Assume we have a Link object that we can delve into.
			    //This is mostly used for n level dives through relationships.
			    //This should probably be avoided on edit views due to performance issues.

			}

			return "";
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return array("rollupMin");
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$RELATE_TYPE, AbstractExpression::$STRING_TYPE);
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 2;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}

?>