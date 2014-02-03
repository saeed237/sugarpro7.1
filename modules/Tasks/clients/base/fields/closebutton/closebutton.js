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
({events:{'click [name="record-close"]':'closeClicked','click [name="record-close-new"]':'closeNewClicked'},extendsFrom:'RowactionField',initialize:function(options){app.view.invokeParent(this,{type:'field',name:'rowaction',method:'initialize',args:[options]});this.type='rowaction';},closeClicked:function(){this._close(false);},closeNewClicked:function(){this._close(true);},hasAccess:function(){var acl=app.view.invokeParent(this,{type:'field',name:'button',method:'hasAccess'});return acl&&this.model.get('status')!=='Completed';},_close:function(createNew){var self=this;this.model.set('status','Completed');this.model.save({},{success:function(){app.alert.show('close_task_success',{level:'success',autoClose:true,title:app.lang.get('LBL_TASK_CLOSE_SUCCESS',self.module)});if(createNew){var module=app.metadata.getModule(self.model.module);var prefill=app.data.createBean(self.model.module);prefill.copy(self.model);if(module.fields.status&&module.fields.status['default']){prefill.set('status',module.fields.status['default']);}else{prefill.unset('status');}
app.drawer.open({layout:'create-actions',context:{create:true,model:prefill}},function(){if(self.parent){self.parent.render();}else{self.render();}});}},error:function(error){app.alert.show('close_task_error',{level:'error',autoClose:true,title:app.lang.getAppString('ERR_AJAX_LOAD')});app.logger.error('Failed to close a task. '+error);self.model.revertAttributes();}});},bindDataChange:function(){if(this.model){this.model.on("change:status",this.render,this);}}})