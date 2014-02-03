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

require_once('include/Expressions/Expression/Generic/GenericExpression.php');
/**
 * <b>related(Relationship <i>link</i>, String <i>field</i>)</b><br>
 * Returns the value of <i>field</i> in the related module <i>link</i><br/>
 * ex: <i>related($accounts, "industry")</i>
 */
class RelatedFieldExpression extends GenericExpression
{
	/**
	 * Returns the entire enumeration bare.
	 */
	function evaluate() {
		$params = $this->getParameters();
        //This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();

        if (empty($linkField)) {
            return "";
        }
        
        foreach($linkField as $id => $bean)
        {
            if (!empty($bean->field_defs[$relfield]) && isset($bean->$relfield))
            {
                if (!empty($bean->field_defs[$relfield]['type']))
                {
                    global $timedate;
                    if ($bean->field_defs[$relfield]['type'] == "date")
                    {
                        $ret = $timedate->fromDbDate($bean->$relfield);
                        if (!$ret)
                            $ret = $timedate->fromUserDate($bean->$relfield);
                        $ret->isDate = true;
                        return $ret;
                    }
                    if ($bean->field_defs[$relfield]['type'] == "datetime")
                    {
                        $ret = $timedate->fromDb($bean->$relfield);
                        if (!$ret)
                            $ret = $timedate->fromUser($bean->$relfield);
                        return $ret;
                    }
                    if ($bean->field_defs[$relfield]['type'] == "bool")
                    {
                        require_once("include/Expressions/Expression/Boolean/BooleanExpression.php");
                        if ($bean->$relfield)
                            return BooleanExpression::$TRUE;
                        else
                            return BooleanExpression::$FALSE;
                    }
                    //Currency values need to be converted to the current currency when the related value
                    //doesn't match this records currency
                    if ($bean->field_defs[$relfield]['type'] == "currency") {
                        if (!isset($this->context)) {
                            $this->setContext();
                        }
                        if (isset($this->context->base_rate) && isset($bean->base_rate) &&
                            $this->context->base_rate != $bean->base_rate
                        ) {
                            return SugarCurrency::convertWithRate(
                                $bean->$relfield,
                                $bean->base_rate,
                                $this->context->base_rate
                            );
                        }
                    }
                }
                return $bean->$relfield;
            }
        }
        
        return "";
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
		    var params = this.getParameters(),
			    linkField = params[0].evaluate(),
			    relField = params[1].evaluate();

			if (typeof(linkField) == "string" && linkField != "")
			{
                return this.context.getRelatedField(linkField, 'related', relField);
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
		return array("related");
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
