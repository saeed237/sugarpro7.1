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

class PanelVisibilityAction extends AbstractAction{
	protected $targetPanel = "";
	protected $expression = "";
	
	function PanelVisibilityAction($params) {
		$this->targetPanel = $params['target'];
		$this->expression = str_replace("\n", "",$params['value']);
	}
	
	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return <<<EOQ
/**
 * Comepetely hide or show a panel
 */
SUGAR.forms.PanelVisibilityAction = function(target, expr)
{
    this.target = target;
    this.expr   = 'cond(' + expr + ', "", "none")';
}


/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.util.extend(SUGAR.forms.PanelVisibilityAction, SUGAR.forms.AbstractAction, {
    hideChildren: function() {
        if (typeof(SUGAR.forms.PanelVisibilityAction.hiddenFields) == "undefined")
        {
            this.createFieldBin();
        }
        var target = document.getElementById(this.target);
        var field_table = target.getElementsByTagName('table')[0];
        if (field_table != null) 
        {
            field_table.id = this.target + "_tbl";
            SUGAR.forms.PanelVisibilityAction.hiddenFields.appendChild(field_table);
        }
    },
    
    showChildren: function() {
        var target = document.getElementById(this.target);
        var field_table = document.getElementById(this.target + "_tbl");
        if (field_table != null)
            target.appendChild(field_table);
    },
    
    createFieldBin: function() {
        var tmpElem = document.createElement('div');
        tmpElem.id = 'panelHiddenFields';
        tmpElem.style.display = 'none';
        document.body.appendChild(tmpElem);
        SUGAR.forms.PanelVisibilityAction.hiddenFields = tmpElem;
    },
    
    /**
     * Triggers the style dependencies.
     */
    exec: function(context)
    {
        if (typeof(context) == 'undefined')
            context = this.context;
        try {
            var visibility = this.evalExpression(this.expr, context);
            var target = document.getElementById(this.target);
            if (target != null) {               
                if (target.style.display != 'none')
                 SUGAR.forms.animation.sizes[this.target] = target.clientHeight;
                       
                if (SUGAR.forms.AssignmentHandler.ANIMATE) {
                    if (visibility == 'none' && target.style.display != 'none') {
                       SUGAR.forms.animation.Collapse(this.target, this.hideChildren, this);
                       return;
                    } 
                    else if (visibility != 'none' && target.style.display == 'none') 
                    {
                        this.showChildren();
                        SUGAR.forms.animation.Expand(this.target);
                        return;
                    }
                }
                
                if (visibility == 'none')
                    this.hideChildren();
                else
                    this.showChildren();
                target.style.display = visibility;
            }
        } catch (e) {if (console && console.log) console.log(e);}
    }
});

SUGAR.forms.animation.sizes = { };

SUGAR.forms.animation.Collapse = function(target, callback, scope)
{
    var t = document.getElementById(target);
    if (t == null) return;
    
    SUGAR.forms.animation.sizes[target] = t.clientHeight;
    t.style.overflow = "hidden";
    
    // Create a new ColorAnim instance
    var collapseAnim = new YAHOO.util.Anim(target, { height: { to: 0 } }, 0.5, YAHOO.util.Easing.easeBoth);
    collapseAnim.onComplete.subscribe(function () {
        t.style.display = 'none';
        callback.call(scope);
    });
    collapseAnim.animate();
};

SUGAR.forms.animation.Expand = function(target)
{
    var t = document.getElementById(target);
    if (t == null) return;
    
    
    t.style.overflow = "hidden";
    t.style.height = "0px";
    t.style.display = "";
    
    var expandAnim = new YAHOO.util.Anim(target, { height: { to: SUGAR.forms.animation.sizes[target]  } },
        0.5, YAHOO.util.Easing.easeBoth);
    
    expandAnim.onComplete.subscribe(function () {
        t.style.height = 'auto';
    });
    
    expandAnim.animate();
};
EOQ;

    }


	/**
	 * Returns the javascript code to generate this actions equivalent. 
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return "new SUGAR.forms.PanelVisibilityAction('{$this->targetPanel}','{$this->expression}')";
	}
	
	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBean $target
	 * 
	 * Should only be fired when saving from an edit view.
	 */
	function fire(&$target) {
		require_once ('modules/ModuleBuilder/parsers/ParserFactory.php') ;
        require_once 'modules/ModuleBuilder/parsers/constants.php' ;
        
        $parser = ParserFactory::getParser ( MB_EDITVIEW, $target->module_dir);
        $fields = $parser->getFieldsInPanel($this->targetPanel);
        foreach($fields as $field){
        	unset($target->$field);
        }
	}
	
	static function getActionName() {
		return "SetPanelVisibility";
	}
	
}