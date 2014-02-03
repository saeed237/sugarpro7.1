/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({extendsFrom:'TabbedDashletView',plugins:['LinkedModel','Dashlet','Timeago'],initialize:function(options){options.meta=options.meta||{};options.meta.template='tabbed-dashlet';this._super('initialize',[options]);},_initTabs:function(){app.view.invokeParent(this,{type:'view',name:'tabbed-dashlet',method:'_initTabs',platform:'base'});var today=new Date();today.setHours(23,59,59);today.toISOString();_.each(_.pluck(_.pluck(this.tabs,'filters'),'date_due'),function(filter){_.each(filter,function(value,operator){if(value==='today'){filter[operator]=today;}});});},createRecord:function(event,params){this.createRelatedRecord(params.module,params.link);},_renderHtml:function(){if(this.meta.config){this._super('_renderHtml');return;};var tab=this.tabs[this.settings.get('activeTab')];if(tab.overdue_badge){this.overdueBadge=tab.overdue_badge;}
_.each(this.collection.models,function(model){var pictureUrl=app.api.buildFileURL({module:'Users',id:model.get('assigned_user_id'),field:'picture'});model.set('picture_url',pictureUrl);},this);this._super('_renderHtml');}})