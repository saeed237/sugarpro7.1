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
({extendsFrom:'FilteredListView',fallbackFieldTemplate:'list-header',initialize:function(options){this.action='list';if(options.context.parent){this.baseModule=options.context.parent.get('module');this.baseRecord=options.context.parent.get('modelId');}
this._super('initialize',[options]);if(!this.collection){this._initCollection();}},_initCollection:function(){var AuditCollection=app.BeanCollection.extend({module:'audit',baseModule:this.baseModule,baseRecordId:this.baseRecord,buildURL:function(params){params=params||{};var parts=[],url;parts.push(app.api.serverUrl);parts.push(this.baseModule);parts.push(this.baseRecordId);parts.push(this.module);url=parts.join('/');params=$.param(params);if(params.length>0){url+='?'+params;}
return url;},sync:function(method,model,options){var url=this.buildURL(options.params),callbacks=app.data.getSyncCallbacks(method,model,options);app.api.call(method,url,options.attributes,callbacks);}});this.collection=new AuditCollection();},loadData:function(){if(this.collection.dataFetched){return;}
this.collection.fetch();}})