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
({fields:null,initialize:function(options){app.view.Field.prototype.initialize.call(this,options);this.fields=[];},getPlaceholder:function(){var placeholder='<span sfuuid="'+this.sfId+'">';_.each(this.def.fields,function(fieldDef){if(this.def.readonly){fieldDef.readonly=true;}
var field=app.view.createField({def:fieldDef,view:this.view,viewName:this.options.viewName,model:this.model});this.fields.push(field);field.parent=this;placeholder+=field.getPlaceholder();},this);placeholder+='</span>';return new Handlebars.SafeString(placeholder);},showNoData:function(){if(!this.def.readonly){return false;}
return!_.some(this.fields,function(field){return field.name&&field.model.has(field.name);});},_render:function(){this._loadTemplate();if(_.contains(this.fallbackActions,this.action)){this.$el.html(this.template(this)||'');}
if(this.def&&this.def.css_class){this.getFieldElement().addClass(this.def.css_class);}
this.focusIndex=0;this._addViewClass(this.action);return this;},focus:function(){if(this.focusIndex<0||!this.focusIndex){this.focusIndex=0;}
if(this.focusIndex>=this.fields.length){this.focusIndex=-1;return false;}else{if(this.fields[this.focusIndex]&&this.fields[this.focusIndex].isDisabled()){this.focusIndex++;return this.focus();}
if(_.isFunction(this.fields[this.focusIndex].focus)&&this.fields[this.focusIndex].focus()){}else{var field=this.fields[this.focusIndex];var $el=field.$(field.fieldTag+":first");$el.focus().val($el.val());this.focusIndex++;}
return true;}},setDisabled:function(disable){disable=_.isUndefined(disable)?true:disable;app.view.Field.prototype.setDisabled.call(this,disable);_.each(this.fields,function(field){field.setDisabled(disable);},this);},setViewName:function(view){app.view.Field.prototype.setViewName.call(this,view);_.each(this.fields,function(field){field.setViewName(view);},this);},setMode:function(name){this.focusIndex=0;app.view.Field.prototype.setMode.call(this,name);_.each(this.fields,function(field){field.setMode(name);},this);},bindDomChange:function(){},bindDataChange:function(){},unbindDom:function(){},_dispose:function(){_.each(this.fields,function(field){field.parent=null;field.dispose();});this.fields=null;app.view.Field.prototype._dispose.call(this);}})