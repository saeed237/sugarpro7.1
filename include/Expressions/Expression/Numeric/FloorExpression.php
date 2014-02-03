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

require_once("include/Expressions/Expression/Numeric/NumericExpression.php");
/**
 * <b>floor(Number n)</b><br>
 * Returns <i>n</i> rounded down to the next integer.<br/>
 * ex: <i>floor(5.73)</i> = 5
 */
class FloorExpression extends NumericExpression {
	/**
	 * Returns the negative of the expression that it contains.
	 */
	function evaluate() {
		return floor( $this->getParameters()->evaluate() );
	}
	
	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
			return Math.floor( this.getParameters().evaluate() );
EOQ;
	}
	
	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "floor";
	}
	
	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 1;
	}
}
?>