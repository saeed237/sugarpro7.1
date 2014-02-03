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

class SetOptionsAction extends AbstractAction{
	protected $keysExpression =  "";
	protected $labelsExpressions =  "";
	
	function SetOptionsAction($params) {
        $this->params = $params;
		$this->targetField = $params['target'];
		$this->keysExpression = str_replace("\n", "",$params['keys']);
		$this->labelsExpression = str_replace("\n", "",$params['labels']);
	}
	
	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return  "
		SUGAR.forms.SetOptionsAction = function(target, keyExpr, labelExpr) {
			this.afterRender = true;
			if (_.isObject(target)){
				labelExpr = target.labels;
				keyExpr = target.keys;
				target = target.target
			}
			this.keyExpr = keyExpr;
			this.labelExpr = labelExpr;
			this.target = target;
		};
				
		SUGAR.util.extend(SUGAR.forms.SetOptionsAction, SUGAR.forms.AbstractAction, {
			exec: function(context) {
				if (typeof(context) == 'undefined')
					context = this.context;

				var keys = this.evalExpression(this.keyExpr, context),
					labels = this.evalExpression(this.labelExpr, context),
					empty = _.size(keys) === 1 && keys[0] === '';
					selected = '';

				if (context.view)
				{
					var field = context.view.getField(this.target);
					if (_.isString(labels))
						field.items = _.pick(App.lang.getAppListStrings(labels), keys);
					else
						field.items = _.object(keys, labels);

					slContext = context;

					field.model.fields[this.target].options = field.items;

					var visAction = new SUGAR.forms.SetVisibilityAction(this.target, (empty ? 'false' : 'true'), '');
					visAction.setContext(context);
					visAction.exec();
					if (!_.contains(keys, field.value)) {
						context.setValue(this.target, empty ? '' : keys[0]);
					}
				}
				else {
					var field = context.getElement(this.target);
					if ( field == null )	return null;


					if (keys instanceof Array && field.options != null)
					{
						// get the options of this select
						var options = field.options;

						for (var i = 0; i < options.length; i++) {
							if (options[i].selected)
								selected = options[i].value;
						}

						// empty the options
						while (options.length > 0) {
							field.remove(options[0]);
						}

						if (typeof(labels) == 'string') //get translated values from Sugar Language
						{
							var fullSet = SUGAR.language.get('app_list_strings', labels);
							labels = [];
							for (var i in keys)
							{
								labels[i] = fullSet[keys[i]];
							}
						}

						var new_opt;
						for (var i in keys) {
							if (labels instanceof Array)
							{
								if (typeof keys[i] == 'string')
								{
									if (typeof labels[i] == 'string') {
										new_opt = options[options.length] = new Option(labels[i], keys[i], keys[i] == selected);
									}
									else
									{
										new_opt = options[options.length] = new Option(keys[i], keys[i], keys[i] == selected);
									}
								}
							}
							else //Use the keys as labels
							{
								if (typeof keys[0] == 'undefined') {
									if (typeof(keys[i]) == 'string') {
										new_opt = options[options.length] = new Option(keys[i], i);
									}
								} else {
									if (typeof(value[i]) == 'string') {
										new_opt = options[options.length] = new Option(keys[i], keys[i]);
									}
								}
							}
							if (keys[i] == selected)
								new_opt.selected = true;

						}

						if(field.value != selected)
							SUGAR.forms.AssignmentHandler.assign(this.target, field.value);

						//Hide fields with empty lists
						var empty =  field.options.length == 1 && field.value == '';
						var visAction = new SUGAR.forms.VisibilityAction(this.target, (empty ? 'false' : 'true'), '');
						visAction.setContext(context);
						visAction.exec();

						if ( SUGAR.forms.AssignmentHandler.ANIMATE && !empty)
							SUGAR.forms.FlashField(field);
					}
					//Check if we are on a detailview and just need to hide the field
					else if (keys instanceof Array && (keys.length == 0 || (keys.length == 1 && keys[0] == ''))){
						//Use a normal visibility action to hide the field
						var va = new SUGAR.forms.VisibilityAction(this.target, 'false', '');
						va.exec(context);
					}
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
		return  "new SUGAR.forms.SetOptionsAction('{$this->targetField}','{$this->keysExpression}', '{$this->labelsExpression}')";
	}
	
	
	
	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBean $target
	 * A NoOP on the PHP side for setoptions
	 */
	function fire(&$target) {
		
	}
	
	static function getActionName() {
		return "SetOptions";
	}
}
