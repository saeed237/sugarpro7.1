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

class VisibilityAction extends AbstractAction{
	protected $targetField = array();
	protected $expression = "";
	
	function VisibilityAction($params) {
        $this->params = $params;
		$this->targetField = $params['target'];
		$this->expression = str_replace("\n", "",$params['value']);
		$this->view = isset($params['view']) ? $params['view'] : "";
	}
	
	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return "
		var App = App || null;
		SUGAR.forms.SetVisibilityAction = function(target, expr, view)
		{
			this.afterRender = true;
			if (_.isObject(target)){
				expr = target.value;
				target = target.target
			}
			this.target = target;
			this.expr	= 'cond(' + expr + ', \"\", \"none\")';
			this.view = view;

			if (!SUGAR.forms.SetVisibilityAction.initialized)
			{
				var head = document.getElementsByTagName('head')[0];
				var cssdef = '.vis_action_hidden * { visibility:hidden}'
				var newStyle = document.createElement('style');
				newStyle.setAttribute('type', 'text/css');
				if (newStyle.styleSheet)
					newStyle.styleSheet.cssText = cssdef;
				else
					newStyle.innerHTML = cssdef;
				head.appendChild(newStyle);
				SUGAR.forms.SetVisibilityAction.initialized = true;
			}
		}
		
		/**
		 * Triggers this dependency to be re-evaluated again.
		 */
		SUGAR.util.extend(SUGAR.forms.SetVisibilityAction, SUGAR.forms.AbstractAction, {
		
			/**
			 * Triggers the style dependencies.
			 */
			exec: function(context)
			{
				if (typeof(context) == 'undefined')
					context = this.context;
				try {
					var exp = this.evalExpression(this.expr, context);
					var hide =  exp == 'none' || exp == 'hidden';
					var target = context && context.getElement && context.getElement(this.target) || null;
					if (target != null) {
						if (SUGAR.App)
							this.sidecarExec(context, target, hide);
						else
							this.legacyExec(context, target, hide);
					}
				} catch (e) {
					if (console && console.log) console.log(e);
				}
			},
			sidecarExec : function(context, target, hide) {
				var inv_class = 'vis_action_hidden';
					wasHidden = $(target).hasClass(inv_class);
				if (hide)
				{
					context.addClass(this.target, inv_class, true);
					//Disable the field to prevent tabbing into the edit mode of the field
					context.setFieldDisabled(this.target, true);
				}
				else
				{
					context.removeClass(this.target, inv_class, true);
					context.setFieldDisabled(this.target, false);
					if (wasHidden)
						SUGAR.forms.FlashField(target, null, this.target);
				}
			},
			legacyExec : function(context, target, hide) {
				var Dom = YAHOO.util.Dom;
				var inv_class = 'vis_action_hidden',
					inputTD = Dom.getAncestorByTagName(target, 'TD'),
					labelTD = Dom.getPreviousSiblingBy(inputTD, function(e){
				if (e.tagName == 'TD') return true;
					return false;
				});
				this.wrapContent(labelTD);
				this.wrapContent(inputTD);
				var wasHidden = Dom.hasClass(labelTD, inv_class);
				if (hide)
				{
					Dom.addClass(labelTD, inv_class);
					Dom.addClass(inputTD, inv_class);
				}
				else
				{
					Dom.removeClass(labelTD, inv_class);
					Dom.removeClass(inputTD, inv_class);
					if (wasHidden && this.view == 'EditView')
						SUGAR.forms.FlashField(target);
				}
				this.checkRow(Dom.getAncestorByTagName(inputTD, 'TR'), inv_class);

			},
			//we need to wrap plain text nodes in a span in order to hide the contents without hiding the TD itesef
			wrapContent: function(el)
			{
				if (el && this.containsPlainText(el))
				{
					var span = document.createElement('SPAN');
					var nodes = [];
					for(var i = 0; i < el.childNodes.length ; i++)
					{
						nodes[i] = el.childNodes[i];
					}
					for(var i = 0 ; i < nodes.length; i++)
					{
						span.appendChild(nodes[i]);
					}
					el.appendChild(span);
				}
			},
			containsPlainText: function(el)
			{
				for(var i = 0; i < el.childNodes.length; i++)
				{
					var node = el.childNodes[i];
					if (node.nodeName == '#text' && YAHOO.lang.trim(node.textContent) != '') {
						return true;
					}
				}
				return false;
			},
			checkRow: function(el, inv_class)
			{
				var hide = true;
				for(var i = 0; i < el.children.length; i++)
				{
					var node = el.children[i];
					//For each row, check if the column has the inv_class class attribute, if not, do not hide
					if (node.tagName.toLowerCase() == 'td' && !YAHOO.util.Dom.hasClass(node, inv_class)) {
						hide = false;
						break;
					}
				}
				el.style.display = hide ? 'none' : '';
			}

		});";
	}

	/**
	 * Returns the javascript code to generate this actions equivalent. 
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return "new SUGAR.forms.SetVisibilityAction('{$this->targetField}','{$this->expression}', '{$this->view}')";
	}
	
	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBean $target
	 */
	function fire(&$target) {
		require_once("include/Expressions/Expression/AbstractExpression.php");
		$result = Parser::evaluate($this->expression, $target)->evaluate();
		if ($result === AbstractExpression::$FALSE) {
			$target->field_defs[$this->targetField]['hidden'] = true;
		} else 
		{
			$target->field_defs[$this->targetField]['hidden'] = false;
		}
	}
	
	static function getActionName() {
		return "SetVisibility";
	}
	
}
