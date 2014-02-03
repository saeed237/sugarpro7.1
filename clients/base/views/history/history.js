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
({extendsFrom:'TabbedDashletView',plugins:['LinkedModel','Dashlet','Timeago'],initialize:function(options){options.meta=options.meta||{};options.meta.template='tabbed-dashlet';app.view.invokeParent(this,{type:'view',name:'tabbed-dashlet',method:'initialize',platform:'base',args:[options]});},_getFilters:function(index){var filterDate=new Date();filterDate.setDate(filterDate.getDate()-this.settings.get('filter'));var filterStr=app.date.format(filterDate,'Y-m-d');var tab=this.tabs[index],filter={},filters=[];filter[tab.filter_applied_to]={$gte:filterStr};filters.push(filter);return filters;},createRecord:function(event,params){var bwcExceptions=['Emails'],meta=app.metadata.getModule(params.module)||{};if(meta.isBwcEnabled&&!_.contains(bwcExceptions,params.module)){this._createBwcRecord(params.module,params.link);return;}
this.createRelatedRecord(params.module,params.link);},_createBwcRecord:function(module,link){if(this.module!=='Home'){app.bwc.createRelatedRecord(module,this.model,link);return;}
var params={return_module:this.module,return_id:this.model.id};var route=app.bwc.buildRoute(module,null,'EditView',params);app.router.navigate(route,{trigger:true});},_openCreateDrawer:function(module,layout){layout=layout||'create-actions';app.drawer.open({layout:layout,context:{create:true,module:module,prepopulate:this._prePopulateDrawer(module)}},_.bind(function(context,newModel){if(newModel&&newModel.id){this.layout.loadData();}},this));},_prePopulateDrawer:function(module){var data={related:this.model};if(module==='Emails'){data['to_addresses']=this.model;}
return data;},_renderHtml:function(){if(this.meta.config){app.view.View.prototype._renderHtml.call(this);return;}
_.each(this.collection.models,function(model){var pictureUrl=app.api.buildFileURL({module:'Users',id:model.get('assigned_user_id'),field:'picture'});model.set('picture_url',pictureUrl);},this);app.view.invokeParent(this,{type:'view',name:'tabbed-dashlet',method:'_renderHtml',platform:'base'});},_dispose:function(){this.$('.select2').select2('destroy');app.view.invokeParent(this,{type:'view',name:'tabbed-dashlet',method:'_dispose',platform:'base'});}})