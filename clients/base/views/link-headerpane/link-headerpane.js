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
({extendsFrom:'HeaderpaneView',linkModule:null,link:null,initialize:function(options){this.plugins=_.clone(this.plugins)||[];this.plugins.push('LinkedModel');this.events=_.extend({},this.events||{},{'click [name=create_button]':'createClicked','click [name=cancel_button]':'cancelClicked','click [name=select_button]':'selectClicked'});this.action=options.meta.action;var meta=app.metadata.getView(null,options.name);options.meta=_.extend({type:'headerpane'},options.meta,meta[this.action]);app.view.invokeParent(this,{type:'view',name:'headerpane',method:'initialize',args:[options]});this.context.on("link:module:select",this.setModule,this);},setModule:function(meta){if(meta){this.linkModule=meta.module;this.link=meta.link;}else{this.linkModule=null;this.link=null;}},_dispose:function(){this.context.off("link:module:select",null,this);app.view.invokeParent(this,{type:'view',name:'headerpane',method:'_dispose'});},selectClicked:function(){if(_.isEmpty(this.link)){app.alert.show('invalid-data',{level:'error',messages:app.lang.get('ERROR_EMPTY_LINK_MODULE'),autoClose:true});return;}
var parentModel=this.model,module=app.data.getRelatedModule(this.model.module,this.link),link=this.link,self=this;app.drawer.open({layout:'link-selection',context:{module:module}},function(model){if(!model){return;}
var relatedModel=app.data.createRelatedBean(parentModel,model.id,link),options={showAlerts:true,relate:true,success:function(model){app.drawer.closeImmediately(self.context,model);},error:function(error){app.alert.show('server-error',{level:'error',messages:'ERR_GENERIC_SERVER_ERROR',autoClose:false});}};relatedModel.save(null,options);});},createClicked:function(){if(_.isEmpty(this.link)){app.alert.show('invalid-data',{level:'error',messages:app.lang.get('ERROR_EMPTY_LINK_MODULE'),autoClose:true});return;}
var model=this.createLinkModel(this.model,this.link);app.drawer.open({layout:'create-actions',context:{module:model.module,model:model,create:true}},function(context,model){if(!model){return;}
app.drawer.closeImmediately(context,model);});},cancelClicked:function(){app.drawer.close();}})