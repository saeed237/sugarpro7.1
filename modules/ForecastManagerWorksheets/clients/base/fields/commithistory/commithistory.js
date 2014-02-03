/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({initialize:function(options){app.view.Field.prototype.initialize.call(this,options);this.on('render',function(){this.loadData();},this);},loadData:function(){var ctx=this.context.parent||this.context,su=ctx.get('selectedUser')||app.user.toJSON(),isManager=this.model.get('isManager'),showOpps=(su.id==this.model.get('user_id'))?1:0,forecastType=app.utils.getForecastType(isManager,showOpps),args_filter=[],options={};args_filter.push({"user_id":this.model.get('user_id')});args_filter.push({"forecast_type":forecastType});var url={"url":app.api.buildURL('Forecasts','filter'),"filters":{"filter":args_filter}};options.success=_.bind(function(data){this.buildLog(data);},this);app.api.call('create',url.url,url.filters,options,{context:this});},buildLog:function(data){data=data.records;var ctx=this.context.parent||this.context,forecastCommitDate=ctx.get('currentForecastCommitDate'),commitDate=new Date(forecastCommitDate),newestModel=new Backbone.Model(_.first(data)),otherModels=_.last(data,data.length-1),oldestModel={},displayCommitDate=newestModel.get('date_modified');for(var i=0;i<otherModels.length;i++){if(new Date(otherModels[i].date_modified)<=commitDate){oldestModel=new Backbone.Model(otherModels[i]);displayCommitDate=oldestModel.get('date_modified');break;}}
var tpl=app.template.getField(this.type,'log',this.module);this.$el.html(tpl({commit:app.utils.createHistoryLog(oldestModel,newestModel).text,commit_date:displayCommitDate}));this.$el.find("span.relativetime").timeago({logger:SUGAR.App.logger,date:SUGAR.App.date,lang:SUGAR.App.lang,template:SUGAR.App.template});},_render:function(){this.$el=this.view.$el.find('span[sfuuid="'+this.sfId+'"]');app.view.Field.prototype._render.call(this);}})