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
 * <b>rollupCurrencySum(Relate <i>link</i>, String <i>field</i>)</b><br>
 * Returns the sum of the values of <i>field</i> in records related by <i>link</i><br/>
 * ex: <i>rollupCurrencySum($products, "likely_case")</i> in Opportunities would return the <br/>
 * sum of the likely_case field converted to base currency for all the products related to this Opportunity
 */
class CurrencySumRelatedExpression extends NumericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	public function evaluate() {
		$params = $this->getParameters();
		//This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();

		$ret = 0;

		if (!is_array($linkField) || empty($linkField))
            return $ret;

        if (!isset($this->context)) {
            //If we don't have a context provided, we have to guess. This can be a large performance hit.
            $this->setContext();
        }
        $toRate = isset($this->context->base_rate) ? $this->context->base_rate : null;

        foreach($linkField as $bean)
        {
            if (!empty($bean->$relfield)) {
                $ret = SugarMath::init($ret)->add(
                    SugarCurrency::convertWithRate($bean->$relfield, $bean->base_rate, $toRate)
                )->result();
            }
        }

        return $ret;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	public static function getJSEvaluate() {
		return <<<EOQ
		    var params = this.getParameters();
			var linkField = params[0].evaluate();
			var relField = params[1].evaluate();

			if (typeof(linkField) == "string" && linkField != "")
			{
                return this.context.getRelatedField(linkField, 'rollupCurrencySum', relField);
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
	public static function getOperationName() {
		return array("rollupCurrencySum");
	}

	/**
	 * The first parameter is a number and the second is the list.
	 */
    public static function getParameterTypes() {
		return array(AbstractExpression::$RELATE_TYPE, AbstractExpression::$STRING_TYPE);
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	public static function getParamCount() {
		return 2;
	}
}

?>
