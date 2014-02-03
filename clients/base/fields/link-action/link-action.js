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
({extendsFrom:'StickyRowactionField',events:{'click a[name=select_button]':'openSelectDrawer'},openSelectDrawer:function(){if(this.isDisabled()){return;}
var parentModel=this.context.get("parentModel"),linkModule=this.context.get("module"),link=this.context.get("link"),self=this;app.drawer.open({layout:'link-selection',context:{module:linkModule}},function(model){if(!model){return;}
var relatedModel=app.data.createRelatedBean(parentModel,model.id,link),options={showAlerts:true,relate:true,success:function(model){self.context.resetLoadFlag();self.context.set('skipFetch',false);self.context.loadData();},error:function(error){app.alert.show('server-error',{level:'error',messages:'ERR_GENERIC_SERVER_ERROR',autoClose:false});}};relatedModel.save(null,options);});},isDisabled:function(){if(app.view.invokeParent(this,{type:'field',name:'sticky-rowaction',method:'isDisabled'})){return true;}
var link=this.context.get("link");var parentModule=this.context.get("parentModule");var required=app.utils.isRequiredLink(parentModule,link);return required;}})