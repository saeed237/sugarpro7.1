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

class SetRequiredAction extends AbstractAction{
	protected $expression =  "";
	
	function SetRequiredAction($params) {
		$this->targetField = $params['target'];
		$this->targetLabel = $params['label'];
		$this->expression = str_replace("\n", "",$params['value']);
	}
	
/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return  "
SUGAR.forms.SetRequiredAction = function(variable, expr, label) {
    this.variable = variable;
    this.expr = expr;
    this.label    = label;
    this._el_lbl  = document.getElementById(this.label);
    this.msg = this._el_lbl.innerText;
}

/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.util.extend(SUGAR.forms.SetRequiredAction, SUGAR.forms.AbstractAction, {

    /**
     * Triggers the required dependencies.
     */
    exec: function(context)
    {
        if (typeof(context) == 'undefined')
		    context = this.context;
        var el = SUGAR.forms.AssignmentHandler.getElement(this.variable);
        this.required = this.evalExpression(this.expr, context);

        if ( typeof(SUGAR.forms.FormValidator) != 'undefined' )
            SUGAR.forms.FormValidator.setRequired(el.form.name, el.name, this.required);


        if (this._el_lbl != null && el != null) {
            var p = this._el_lbl,
                els = YAHOO.util.Dom.getElementsBy( function(e) { return e.className == 'req'; }, \"span\", p),
                reqSpan = false,
                fName = el.name;

            if ( els != null && els[0] != null)
                reqSpan = els[0];

            if ( (this.required == true  || this.required == 'true')) {
                if (!reqSpan) {
                    var node = document.createElement(\"span\");
                    node.innerHTML = \"<font color='red'>*</font>\";
                    node.className = \"req\";
                    this._el_lbl.appendChild(node);

                    var i = this.findInValidate(this.context.formName, fName)
                    if (i > -1)
                        validate[this.context.formName][i][2] = true;
                    else
                        addToValidate(this.context.formName, fName, 'text', true, this.msg);
                }
            } else {
                if ( p != null  && reqSpan != false) {
                    p.removeChild(reqSpan);
                }
                var i = this.findInValidate(this.context.formName, fName)
                if (i > -1)
                    validate[this.context.formName][i][2] = false;
            }
        }
    },

     findInValidate : function(form, field)
     {
         if (validate && validate[form]){
             for (var i in validate[form]){
                if (typeof(validate[form][i]) == 'object' && validate[form][i][0] == field)
                    return i;
             }
         }
         return -1;
     }
});";
	}

	/**
	 * Returns the javascript code to generate this actions equivalent. 
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return "new SUGAR.forms.SetRequiredAction('{$this->targetField}','{$this->expression}', '{$this->targetLabel}')";
	}
	
	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBeam $target
	 */
	function fire(&$target) {
		//This is a no-op under PHP
	}
	
	static function getActionName() {
		return "SetRequired";
	}
	
}