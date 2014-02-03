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
({extendsFrom:'PreviewView',originalModel:undefined,closePreview:function(){this.originalModel=undefined;app.view.invokeParent(this,{type:'view',name:'preview',method:'closePreview'});},_renderPreview:function(model,collection,fetch,previewId,dontClose){var self=this;dontClose=dontClose||false;if(app.drawer&&!app.drawer.isActive(this.$el)){return;}
if(!dontClose&&this.originalModel&&model&&(this.originalModel.get("id")==model.get("id")&&previewId==this.previewId)){app.events.trigger("list:preview:decorate",false);app.events.trigger('preview:close');return;}
if(model){this.meta=app.metadata.getView(model.get('parent_type')||model.get('_module'),'record')||{};this.meta=this._previewifyMetadata(this.meta);}
if(fetch){var mdl=app.data.createBean(model.get('parent_type'),{'id':model.get('parent_id')});this.originalModel=model;mdl.fetch({showAlerts:true,success:function(model){self.renderPreview(model,collection);}});}else{this.renderPreview(model,collection);}
this.previewId=previewId;},showPreviousNextBtnGroup:function(){if(!this.model||!this.layout||!this.collection){return;}
var collection=this.collection;if(!collection.size()){this.layout.hideNextPrevious=true;}
var model=this.originalModel||this.model;var recordIndex=collection.indexOf(collection.get(model.id));this.layout.previous=collection.models[recordIndex-1]?collection.models[recordIndex-1]:undefined;this.layout.next=collection.models[recordIndex+1]?collection.models[recordIndex+1]:undefined;this.layout.hideNextPrevious=_.isUndefined(this.layout.previous)&&_.isUndefined(this.layout.next);this.layout.trigger("preview:pagination:update");},renderPreview:function(model,newCollection){if(newCollection){this.collection.reset(newCollection.models);}
if(model){this.model=app.data.createBean(model.module,model.toJSON());this.render();if(this.previewModule&&this.previewModule==="Activities"){this.layout.hideNextPrevious=true;this.layout.trigger("preview:pagination:update");}
app.events.trigger("preview:open",this);app.events.trigger("list:preview:decorate",this.originalModel,this);if(!this.$el.is(":visible")){this.context.trigger("openSidebar",this);}}},switchPreview:function(data,index,id,module){var self=this,currModule=module||this.model.module,currID=id||this.model.get("postId")||this.model.get("id"),currIndex=index||_.indexOf(this.collection.models,this.collection.get(this.originalModel.get('id')));if(this.switching||this.collection.models.length<2){return;}
this.switching=true;if(data.direction==="left"&&(currID===_.first(this.collection.models).get("parent_id"))||data.direction==="right"&&(currID===_.last(this.collection.models).get("parent_id"))){this.switching=false;return;}
else{data.direction==="left"?currIndex-=1:currIndex+=1;if(_.isUndefined(this.collection.models[currIndex].get("target_id"))&&this.collection.models[currIndex].get("activity_data")){currID=this.collection.models[currIndex].id;this.switching=false;this.switchPreview(data,currIndex,currID,currModule);}else{var targetModule=this.collection.models[currIndex].get("target_module")||currModule;this.model=app.data.createBean(targetModule);if(_.isUndefined(this.collection.models[currIndex].get("target_id"))){this.model.set("id",this.collection.models[currIndex].get("parent_id"));}else{this.model.set("postId",this.collection.models[currIndex].get("id"));this.model.set("id",this.collection.models[currIndex].get("target_id"));}
this.originalModel=this.collection.models[currIndex];this.model.fetch({showAlerts:true,success:function(model){model.set("_module",targetModule);self.model=null;app.events.trigger("preview:render",model,null,false);self.switching=false;}});}}}})