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
 * <b>count(Relate <i>link</i>)</b><br>
 * Returns the number of records related to this record by <i>link</i><br/>
 * ex: <i>count($contacts)</i> in Accounts would return the <br/>
 * number of contacts related to this account.
 */
class CountRelatedExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
        $linkField = $this->getParameters()->evaluate();
        //This should be of relate type, which means an array of SugarBean objects
        if (!is_array($linkField)) {
            return false;
        }

        return count($linkField);
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		    var linkField = this.getParameters().evaluate();

			if (typeof(linkField) == "string" && linkField != "")
			{
                return SUGAR.forms.AssignmentHandler.getRelatedField(linkField, 'count');
			}
			else if (typeof(rel) == "object") {
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
		return array("count");
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    static function getParameterTypes() {
		return array(AbstractExpression::$RELATE_TYPE);
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