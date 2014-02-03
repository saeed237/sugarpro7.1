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
(function(app){app.events.on("app:init",function(){app.plugins.register('Editable',['view'],{onAttach:function(component,plugin){this.editableKeyDowned=_.bind(function(evt){this.editableHandleKeyDown.call(this,evt,evt.data.field);},this);this.editableMouseClicked=_.debounce(_.bind(function(evt){this.editableHandleMouseDown.call(this,evt,evt.data.field);},this),0);this.on("init",function(){app.routing.before("route",this.beforeRouteChange,this,true);$(window).on("beforeunload."+this.cid,_.bind(this.warnUnsavedChangesOnRefresh,this));this.before("unsavedchange",this.beforeViewChange,this,true);if(_.isEmpty(app.additionalComponents['drawer'])){return;}
app.drawer.before("reset",this.beforeRouteChange,this,true);this._currentUrl=Backbone.history.getFragment();});},beforeRouteChange:function(params){var onConfirm=_.bind(this.onConfirmRoute,this);return this.warnUnsavedChanges(onConfirm);},beforeViewChange:function(param){if(!(param&&_.isFunction(param.callback))){app.logger.error('Custom unsavedchange must contain callback function.');return true;}
var onConfirm=_.bind(function(){if(param.callback&&_.isFunction(param.callback)){param.callback.call(this);}},this);return this.warnUnsavedChanges(onConfirm,param.message);},warnUnsavedChanges:function(onConfirm,customMessage){if(this.resavingAfterMetadataSync){return false;}
this.$(":focus").trigger("change");if(_.isFunction(this.hasUnsavedChanges)&&this.hasUnsavedChanges()){this._targetUrl=Backbone.history.getFragment();app.router.navigate(this._currentUrl,{trigger:false,replace:true});app.alert.show('leave_confirmation',{level:'confirmation',messages:app.lang.get(customMessage||'LBL_WARN_UNSAVED_EDITS',this.module),onConfirm:onConfirm,templateOptions:{cancelContLabel:'LBL_CANCEL_BUTTON_LABEL_UNSAVED_CONT',confirmContLabel:'LBL_CONFIRM_BUTTON_LABEL_UNSAVED_CONT'}});return false;}
return true;},warnUnsavedChangesOnRefresh:function(){if(this.resavingAfterMetadataSync){return false;}
if(_.isFunction(this.hasUnsavedChanges)&&this.hasUnsavedChanges()){return app.lang.get('LBL_WARN_UNSAVED_EDITS',this.module);}
return;},onConfirmRoute:function(){this.unbindBeforeHandler();app.router.navigate(this._targetUrl,{trigger:true});},toggleFields:function(fields,isEdit){var viewName=(isEdit)?'edit':this.action;_.each(fields,function(field){if(field.action===viewName){return;}
var meta=this.getFieldMeta(field.name);if(meta&&isEdit&&meta.readonly){return;}
_.defer(function(field){if(field.disposed!==true){field.setMode(viewName);}},field);field.$(field.fieldTag).off("keydown.record",this.editableKeyDowned);$(document).off("mousedown.record"+field.name,this.editableMouseClicked);},this);},toggleField:function(field,isEdit){var viewName;if(_.isUndefined(isEdit)){viewName=(field.tplName===this.action)?"edit":this.action;}else{viewName=(isEdit)?"edit":this.action;}
if(!field.triggerBefore('toggleField',viewName)){return false;}
field.setMode(viewName);if(viewName==="edit"){if(_.isFunction(field.focus)){field.focus();}else{var $el=field.$(field.fieldTag+":first");$el.focus().val($el.val());}
if(_.isFunction(field.bindKeyDown)){field.bindKeyDown(this.editableKeyDowned);}else{field.$(field.fieldTag).on("keydown.record",{field:field},this.editableKeyDowned);}
if(_.isFunction(field.bindDocumentMouseDown)){field.bindDocumentMouseDown(this.editableMouseClicked);}else{$(document).on("mousedown.record"+field.name,{field:field},this.editableMouseClicked);}}else{field.$(field.fieldTag).off("keydown.record");$(document).off("mousedown.record"+field.name);}},editableHandleMouseDown:function(evt,field){if(field.tplName===this.action){return;}
var currFieldParent=field.$el,targetPlaceHolder=this.$(evt.target).parents("span[sfuuid='"+field.sfId+"']"),preventPlaceholder=this.$(evt.target).closest('.prevent-mousedown');var inPreventPlaceholder=(preventPlaceholder.length>0);var inTargetPlaceholder=(targetPlaceHolder.length>0);var isFocusInField=(currFieldParent.find(":focus").length>0);var drawerOpened=!_.isEmpty(app.drawer._components);if(inPreventPlaceholder||inTargetPlaceholder||isFocusInField||drawerOpened){return;}
this.toggleField(field,false);this.trigger("editable:mousedown",evt,field);},editableHandleKeyDown:function(evt,field){if(evt.which==27){this.toggleField(field,false);}
this.trigger("editable:keydown",evt,field);},unbindBeforeHandler:function(){app.routing.offBefore("route",this.beforeRouteChange,this);$(window).off("beforeunload."+this.cid);if(_.isEmpty(app.additionalComponents['drawer'])){return;}
app.drawer.offBefore("reset",this.beforeRouteChange,this);this.offBefore("unsavedchange");},onDetach:function(){$(document).off("mousedown",this.editableMouseClicked);this.editableKeyDowned=null;this.editableMouseClicked=null;this.unbindBeforeHandler();}});});})(SUGAR.App);