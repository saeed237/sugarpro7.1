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

require_once("include/Expressions/Actions/AbstractAction.php");
require_once("include/Expressions/Expression/Date/DateExpression.php");

class SetValueAction extends AbstractAction{
	protected $expression =  "";

	function SetValueAction($params) {
		$this->targetField = $params['target'];
		$this->expression = str_replace("\n", "",$params['value']);
	}

	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return  "
		SUGAR.forms.SetValueAction = function(target, valExpr) {
			if (_.isObject(target)){
			    this.expr = target.value;
			    this.target = target.target;
			} else {
                this.expr = valExpr;
                this.target = target;
			}
		};
		SUGAR.util.extend(SUGAR.forms.SetValueAction, SUGAR.forms.AbstractAction, {
			exec : function(context)
			{
				if (typeof(context) == 'undefined')
				    context = this.context;

				try {
				    var val = this.evalExpression(this.expr, context);
				    context.setValue(this.target, val);
				} catch (e) {
	                context.setValue(this.target, '');
			    }
	       }
		});";
	}


	/**
	 * Returns the javascript code to generate this actions equivalent.
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return  "new SUGAR.forms.SetValueAction('{$this->targetField}','" . addslashes($this->expression) . "')";
	}




	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBean $target
	 */
	function fire(&$target) {
        set_error_handler('handleExpressionError', E_ERROR);
        try {
            $result = Parser::evaluate($this->expression, $target)->evaluate();
        } catch(Exception $e){
            $GLOBALS['log']->fatal("Exception evaluating expression in SetValueAction, {$this->expression} : {$e->getMessage()}\n{$e->getTraceAsString()}");
            $result = "";
        }
        restore_error_handler();
        $field = $this->targetField;
        $def = array();
        if (!empty($target->field_defs[$field]))
            $def  = $target->field_defs[$field];
        if ($result instanceof DateTime)
        {
            global $timedate;
            if (isset($def['type']) && ($def['type'] == "datetime" || $def['type'] == "datetimecombo"))
            {
                $result = DateExpression::roundTime($result);
                $target->$field = $timedate->asDb($result);
            }
            else if (isset($def['type']) && $def['type'] == "date")
            {
                $result = DateExpression::roundTime($result);
                $target->$field = $timedate->asDbDate($result);
            } else {
                //If the target field isn't a date, convert it to a user formated string
                if (isset($result->isDate) && $result->isDate)
                    $target->$field = $timedate->asUserDate($result);
                else
                    $target->$field = $timedate->asUser($result);
            }
        }
        else if (isset($def['type']) && $def['type'] == "bool")
        {
            $target->$field = $result === true || $result === AbstractExpression::$TRUE;
        }
        else
        {
            $target->$field = $result;
        }
	}

	/**
	 * Returns the definition of this action in array format.
	 *
	 */
	function getDefinition() {
		return array(
			"action" => $this->getActionName(),
	        "params" => array(
                "target" => $this->targetField,
	            "value" => $this->expression,
            )
	    );
	}

	static function getActionName() {
		return "SetValue";
	}
}