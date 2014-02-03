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
(function(app){app.events.on('app:init',function(){app.plugins.register('Tooltip',['layout','view','field'],{_$pluginTooltips:null,_pluginTooltipCssSelector:'[rel=tooltip]',onAttach:function(){if((this instanceof app.view.View)||(this instanceof app.view.Field)){this.before('render',function(){this.destroyAllPluginTooltips();},this);this.on('render',function(){this.initializeAllPluginTooltips();},this);}else if(this instanceof app.view.Layout){this.on('init',function(){this.initializeAllPluginTooltips();},this);}},onDetach:function(){this.destroyAllPluginTooltips();},initializeAllPluginTooltips:function(){this.removePluginTooltips();this.addPluginTooltips();},destroyAllPluginTooltips:function(){this.removePluginTooltips();this._$pluginTooltips=null;},addPluginTooltips:function($element){var $tooltips=this._getPluginTooltips($element);this._$pluginTooltips=this._$pluginTooltips||[];this._$pluginTooltips.push(app.utils.tooltip.initialize($tooltips));$tooltips.on('click.tooltip',function(){$(this).tooltip('hide');});},removePluginTooltips:function($element){var $tooltips=this._getPluginTooltips($element);app.utils.tooltip.destroy($tooltips);},_getPluginTooltips:function($element){return $element?$element.find(this._pluginTooltipCssSelector):this.$(this._pluginTooltipCssSelector);}});});})(SUGAR.App);(function($){$(function(){if(!Modernizr.touch){return;}
$.fn.tooltip=function(){return this;};});})(jQuery);