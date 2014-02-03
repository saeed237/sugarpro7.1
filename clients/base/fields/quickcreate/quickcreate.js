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
({events:{'click .actionLink[data-event="true"]':'_handleActionLink'},plugins:['LinkedModel'],initialize:function(options){app.view.Field.prototype.initialize.call(this,options);app.events.on("create:model:changed",this.createModelChanged,this);},createHasChanges:false,createModelChanged:function(hasChanged){this.createHasChanges=hasChanged;},_handleActionLink:function(evt){var $actionLink=$(evt.currentTarget),module=$actionLink.data('module'),moduleMeta=app.metadata.getModule(this.context.get('module'));this.actionLayout=$actionLink.data('layout');if(this.createHasChanges){app.alert.show('send_confirmation',{level:'confirmation',messages:'LBL_WARN_UNSAVED_EDITS',onConfirm:_.bind(function(){app.drawer.reset(false);this.createRelatedRecord(module);},this)});}else if(moduleMeta&&moduleMeta.isBwcEnabled){this.createRelatedRecord(module);}else{app.drawer.reset();this.createRelatedRecord(module);}},routeToBwcCreate:function(module){var context=this.getRelatedContext(module);if(context){app.bwc.createRelatedRecord(module,this.context.get('model'),context.link);}else{var route=app.bwc.buildRoute(module,null,'EditView');app.router.navigate(route,{trigger:true});}},getRelatedContext:function(module){var meta=app.metadata.getModule(module),context;if(meta&&meta.menu.quickcreate.meta.related){var parentModel=this.context.get('model');if(parentModel.isNew()){return;}
context=_.find(meta.menu.quickcreate.meta.related,function(metadata){return metadata.module===parentModel.module;});}
return context;},openCreateDrawer:function(module){var relatedContext=this.getRelatedContext(module),model=null;if(relatedContext){model=this.createLinkModel(this.context.get('model'),relatedContext.link);}
app.drawer.open({layout:this.actionLayout||'create-actions',context:{create:true,module:module,model:model}},_.bind(function(refresh,model){if(refresh){if(model&&!model.id){app.router.refresh();return;}
if(model&&relatedContext){this.context.trigger('panel-top:refresh',relatedContext.link);return;}
this._loadContext(app.controller.context,module);if(app.controller.context.children){_.each(app.controller.context.children,function(context){this._loadContext(context,module);},this);}}},this));},_loadContext:function(context,module){var collection=context.get('collection');if(collection&&collection.module===module){var options={showAlerts:false};collection.resetPagination();context.resetLoadFlag(false);context.set('skipFetch',false);options=_.extend(options,context.get('collectionOptions'));context.loadData(options);}}})