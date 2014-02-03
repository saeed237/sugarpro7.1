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

class ReadOnlyAction extends AbstractAction{
	protected $expression =  "";

	function ReadOnlyAction($params) {
        $this->params = $params;
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
		SUGAR.forms.ReadOnlyAction = function(target, expr) {
			if (_.isObject(target)){
                expr = target.value;
                target = target.target
            }
			this.target = target;
			this.expr = expr;
		}

		SUGAR.util.extend(SUGAR.forms.ReadOnlyAction, SUGAR.forms.AbstractAction, {
			/**
			 * Triggers the style dependencies.
			 */
			exec: function(context)
			{
				if (typeof(context) == 'undefined') context = this.context;
				var val = this.evalExpression(this.expr, context),
					set = val == SUGAR.expressions.Expression.TRUE;
				
				if (context.view) {
					var field = context.view.getField(this.target);
					if (field) {
						field.setDisabled(set);
					}
					context.view.setFieldMeta(this.target, {'readonly':set});
				}
				else {
					var el = SUGAR.forms.AssignmentHandler.getElement(this.target);
					if (!el)
						return;

					this.setReadOnly(el, set);
						this.setDateField(el, set);
				}

			},

			setReadOnly: function(el, set)
			{
				var D = YAHOO.util.Dom;
				var property = el.type == 'checkbox' || 'select' ? 'disabled' : 'readonly';
				el[property] = set;
				if (set)
				{
					D.setStyle(el, 'background-color', '#EEE');
					if (!SUGAR.isIE)
					   D.setStyle(el, 'color', '#22');
				} else
				{
					D.setStyle(el, 'background-color', '');
						if (!SUGAR.isIE)
							D.setStyle(el, 'color', '');
				}
			},

			setDateField: function(el, set)
			{
				var D = YAHOO.util.Dom, id = el.id, trig = D.get(id + '_trigger');
				if(!trig) return;
				var fields = [
					D.get(id + '_date'),
					D.get(id + '_minutes'),
					D.get(id + '_meridiem'),
					D.get(id + '_hours')];

				for (var i in fields)
					if (fields[i] && fields[i].id)
						this.setReadOnly(fields[i], set);

				if (set)
					D.setStyle(trig, 'display', 'none');
				else
					D.setStyle(trig, 'display', '');
			}
		});";
	}

	/**
	 * Returns the javascript code to generate this actions equivalent.
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return "new SUGAR.forms.ReadOnlyAction('{$this->targetField}','{$this->expression}')";
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
		return "ReadOnly";
	}

}