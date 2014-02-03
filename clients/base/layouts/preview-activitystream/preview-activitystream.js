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
({extendsFrom:'ActivitystreamLayout',_previewOpened:false,initialize:function(options){app.view.invokeParent(this,{type:'layout',name:'activitystream',method:'initialize',args:[options]});app.events.on("preview:render",this.fetchActivities,this);app.events.on('preview:open',function(){this._previewOpened=true;},this);app.events.on('preview:close',function(){this._previewOpened=false;this.disposeAllActivities();},this);},fetchActivities:function(model,collection,fetch,previewId){this.disposeAllActivities();this.collection.dataFetched=false;this.$el.hide();this.collection.reset();this.collection.resetPagination();this.collection.fetch({endpoint:function(method,collection,options,callbacks){var url=app.api.buildURL(model.module,'activities',{id:model.get('id'),link:true},options.params);return app.api.call('read',url,null,callbacks);},success:_.bind(this.renderActivities,this)});},renderActivities:function(collection){var self=this;if(this.disposed){return;}
if(this._previewOpened){if(collection.length===0){this.$el.hide();}else{this.$el.show();collection.each(function(activity){self.renderPost(activity,true);});}}else{_.delay(function(){self.renderActivities(collection);},500);}},setCollectionOptions:function(){},exposeDataTransfer:function(){},loadData:function(){},bindDataChange:function(){this.collection.on('add',function(activity){if(!this.disposed){this.renderPost(activity);}},this);}})