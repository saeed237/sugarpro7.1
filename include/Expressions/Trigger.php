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

require_once("include/Expressions/Dependency.php");
require_once("include/Expressions/Actions/AbstractAction.php");
require_once("include/Expressions/Expression/Parser/Parser.php");
require_once("include/Expressions/Expression/AbstractExpression.php");

/**
 * Expression trigger
 * @api
 */
class Trigger
{
	public $triggerFields = array();
	public $conditionFunction = "";
	static $ValueNotSetError = -1;

	function Trigger($condition, $fields = array()) {
		$this->conditionFunction = $condition;
		if (!is_array($fields))
			$fields = array($fields);
		$this->triggerFields = $fields;
	}

	function evaluate($target) {
		$result = Parser::evaluate($this->conditionFunction, $target)->evaluate();
		if ($result == AbstractExpression::$TRUE){
			return true;
		} else {
			return false;
		}
	}

	function getJavascript() {
		$js = "new SUGAR.forms.Trigger([";
		for ($i=0; $i < sizeOf($this->triggerFields); $i++) {
			$js .= "'{$this->triggerFields[$i]}'";
			if ($i < sizeOf($this->triggerFields) - 1){
				$js .= ",";
			}
		}
		$js .= "], '" . str_replace("\n","",$this->conditionFunction) . "')";
		return $js;
	}

	function getCondition() {
		return $this->conditionFunction;
	}

    function getFields(){
        return $this->triggerFields;
    }
}