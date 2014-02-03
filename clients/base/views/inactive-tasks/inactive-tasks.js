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
({extendsFrom:'TabbedDashletView',plugins:['LinkedModel','Dashlet','Timeago'],initialize:function(options){options.meta=options.meta||{};options.meta.template='tabbed-dashlet';this._super('initialize',[options]);},createRecord:function(event,params){this.createRelatedRecord(params.module,params.link);},_renderHtml:function(){if(this.meta.config){this._super('_renderHtml');return;};_.each(this.collection.models,function(model){var pictureUrl=app.api.buildFileURL({module:'Users',id:model.get('assigned_user_id'),field:'picture'});model.set('picture_url',pictureUrl);},this);this._super('_renderHtml');}})