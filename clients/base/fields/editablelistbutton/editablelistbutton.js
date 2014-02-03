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
({events:{'click [name=inline-save]':'saveClicked','click [name=inline-cancel]':'cancelClicked'},extendsFrom:'ButtonField',initialize:function(options){app.view.invokeParent(this,{type:'field',name:'button',method:'initialize',args:[options]});if(this.name==='inline-save'){this.model.off("change",null,this);this.model.on("change",function(){this.changed=true;},this);}},_loadTemplate:function(){app.view.Field.prototype._loadTemplate.call(this);if(this.view.action==='list'&&_.indexOf(['edit','disabled'],this.action)>=0){this.template=app.template.getField('button','edit',this.module,'edit');}else{this.template=app.template.empty;}},_validationComplete:function(isValid){if(!isValid){this.setDisabled(false);return;}
if(!this.changed){this.cancelEdit();return;}
var self=this,options={success:function(model){self.changed=false;self.view.toggleRow(model.id,false);self._refreshListView();},complete:function(){self.setDisabled(false);},showAlerts:{'process':true,'success':{messages:app.lang.get('LBL_RECORD_SAVED',self.module)}},relate:self.model.link?true:false};options=_.extend({},options,self.getCustomSaveOptions(options));var callbacks={success:function(){self.model.save({},options);}};async.forEachSeries(this.view.rowFields[this.model.id],function(view,callback){app.file.checkFileFieldsAndProcessUpload(view,{success:function(){callback.call();}},{deleteIfFails:false},true);},callbacks.success);},getCustomSaveOptions:function(options){return{};},saveModel:function(){this.setDisabled(true);var fieldsToValidate=this.view.getFields(this.module);this.model.doValidate(fieldsToValidate,_.bind(this._validationComplete,this));},cancelEdit:function(){if(this.isDisabled()){this.setDisabled(false);}
this.changed=false;this.model.revertAttributes();this.view.clearValidationErrors();this.view.toggleRow(this.model.id,false);},saveClicked:function(evt){this.saveModel();},cancelClicked:function(evt){this.cancelEdit();},_refreshListView:function(){var filterPanelLayout=this.view;while(filterPanelLayout&&filterPanelLayout.name!=='filterpanel'){filterPanelLayout=filterPanelLayout.layout;}
if(filterPanelLayout&&!filterPanelLayout.disposed&&this.collection){filterPanelLayout.applyLastFilter(this.collection);}}})