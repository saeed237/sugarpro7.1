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
({titleSelectedValues:'',titleViewNameTitle:'',optionsLang:{},toggleTitleTpl:{},events:{'click .resetLink':'onResetLinkClicked'},initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.titleViewNameTitle=app.lang.get('LBL_FORECASTS_CONFIG_TITLE_FORECAST_BY','Forecasts');this.optionsLang=app.lang.getAppListStrings('forecasts_config_worksheet_layout_forecast_by_options_dom');this.toggleTitleTpl=app.template.getView('forecastsConfigHelpers.toggleTitle','Forecasts');},onResetLinkClicked:function(evt){evt.preventDefault();evt.stopImmediatePropagation();},bindDataChange:function(){if(this.model){this.model.on('change:forecast_by',function(){this.titleSelectedValues=this.optionsLang[this.model.get('forecast_by')];this.updateTitle();},this);}},updateTitle:function(){var tplVars={title:this.titleViewNameTitle,selectedValues:this.titleSelectedValues,viewName:'forecastsConfigForecastBy'};this.$el.find('#'+this.name+'Title').html(this.toggleTitleTpl(tplVars));},_render:function(){app.view.View.prototype._render.call(this);this.$el.addClass('accordion-group');this.updateTitle();}})