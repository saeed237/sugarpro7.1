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
 * <b>isRequiredCollection(String table)</b><br/>
 * Returns true none of the fields under html element <i>table</i> are empty.
 */
class IsRequiredCollectionExpression extends BooleanExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$params = $this->getParameters();
		$val = $params[0]->evaluate();
	    return AbstractExpression::$TRUE;

		//return AbstractExpression::$FALSE;
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			var params = this.getParameters().evaluate();
            table = document.getElementById(params);
            children = YAHOO.util.Dom.getElementsByClassName('sqsEnabled', 'input', table);
            for(id in children) {
                if(trim(children[id].value) != '') {
                   return SUGAR.expressions.Expression.TRUE;
                }
            }
			return SUGAR.expressions.Expression.FALSE;
EOQ;
	}

	/**
	 * Any generic type will suffice.
	 */
	static function getParameterTypes() {
		return array("string");
	}

	/**
	 * Returns the maximum number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "isRequiredCollection";
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
}
?>