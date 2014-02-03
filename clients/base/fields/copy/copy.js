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
({'events':{'click input[type=checkbox]':'toggle','click button':'copyOnce'},_initialValues:null,_fields:null,_inSync:false,initialize:function(options){app.view.Field.prototype.initialize.call(this,options);this._initialValues={};this._fields={};if(_.isUndefined(this.def.sync)){this.def.sync=true;}
this.before('render',function(){this.setDisabled(!this.hasAccess());return true;},this);},toggle:function(evt){this.sync($(evt.currentTarget).is(':checked'));},sync:function(enable){enable=_.isUndefined(enable)||enable;if(this._inSync===enable){return;}
this._inSync=enable;if(!enable){this.syncCopy(false);this.restore();return;}
_.each(this.def.mapping,function(target,source){this.copy(source,target);var field=this.getField(target);if(!_.isUndefined(field)){field.setDisabled(true);}},this);this.syncCopy(true);},copyOnce:function(evt){_.each(this.def.mapping,function(target,source){this.copy(source,target);},this);},copy:function(from,to){if(!this.model.has(from)){return;}
if(_.isUndefined(this._initialValues[to])){this._initialValues[to]=this.model.get(to);}
if(app.acl.hasAccessToModel('edit',this.model,to)){this.model.set(to,this.model.get(from));}},restore:function(){_.each(this._initialValues,function(value,field){this.model.set(field,value);},this);_.each(this.def.mapping,function(target,source){var field=this.getField(target);if(!_.isUndefined(field)){field.setDisabled(false);}},this);this._initialValues={};},syncCopy:function(enable){if(!this.def.sync){return;}
if(!enable){this.model.off(null,this.copyChanged);return;}
var events=_.map(_.keys(this.def.mapping),function(field){return'change:'+field;});this.model.on(events.join(' '),this.copyChanged,this);},copyChanged:function(model,value){_.each(model.changedAttributes(),function(newValue,field){model.set(this.def.mapping[field],model.get(field));},this);},getField:function(name){if(_.isUndefined(this._fields[name])){this._fields[name]=_.find(this.view.fields,function(field){return field.name==name;});}
return this._fields[name];},unformat:function(value){return null;},format:function(value){if(_.isNull(value)){return this._inSync;}
return value;},bindDataChange:function(){if(this.model&&this.def.sync){var inSync=_.all(this.def.mapping,function(target,source){return this.model.get(source)===this.model.get(target);},this);this.sync(inSync);}},hasAccess:function(){return _.some(this.def.mapping||[],function(toField,fromField){return app.acl.hasAccessToModel('read',this.model,fromField)&&app.acl.hasAccessToModel('edit',this.model,toField);},this);}})