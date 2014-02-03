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

class FormatedNameExpression extends StringExpression {
	/**
	 * Returns itself when evaluating.
	 */
	function evaluate() {
		$params	  = $this->getParameters();
		$sal =    $params[0]->evaluate();
		$first =  $params[1]->evaluate();
		$last =   $params[2]->evaluate();
		$title =  $params[3]->evaluate();
		
		global $locale;
		return $locale->getLocaleFormattedName($first, $last, $sal, $title);
		
	}

	/**
	 * Returns the JS Equivalent of the evaluate function.
	 */
	static function getJSEvaluate() {
		return <<<EOQ
var params	= this.getParameters();
var comp = {s:params[0].evaluate(), f:params[1].evaluate(), l:params[2].evaluate(), t:params[3].evaluate()};
var name = '';
for(i=0; i<name_format.length; i++) {
	if(comp[name_format.substr(i,1)] != undefined) {
    	name += comp[name_format.substr(i,1)];
	} else {
		name += name_format.substr(i,1);
	}
}
return name;
EOQ;
	}

	/**
	 * Returns the opreation name that this Expression should be
	 * called by.
	 */
	static function getOperationName() {
		return "formatName";
	}

	/**
	 * Returns the exact number of parameters needed.
	 */
	static function getParamCount() {
		return 4;
	}

	/**
	 * Returns the String representation of this Expression.
	 */
	function toString() {
	}
    static function getParameterTypes() {
		return AbstractExpression::$STRING_TYPE;
	}
}
?>