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
({initialize:function(options){this.index=options.meta.index;app.view.Layout.prototype.initialize.call(this,options);this.on("render",function(){this.model.trigger("applyDragAndDrop");},this);this.context.on("dashboard:collapse:fire",this.collapse,this);},_addComponentsFromDef:function(components){if(!(this.meta.preview||this.meta.empty)){var dashletDef=_.first(components),dashletMeta,dashletModule,toolbar={},pattern=/^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/,label=this.meta.label;if(dashletDef.view){toolbar=dashletDef.view['custom_toolbar']||{};dashletMeta=app.metadata.getView(dashletDef.view.module,dashletDef.view.name||dashletDef.view.type);dashletModule=dashletDef.view.module?dashletDef.view.module:null;}else if(dashletDef.layout){toolbar=dashletDef.view['custom_toolbar']||{};dashletMeta=app.metadata.getLayout(dashletDef.layout.module,dashletDef.layout.name||dashletDef.layout.type);dashletModule=dashletDef.layout.module?dashletDef.layout.module:null;}
if(!dashletModule&&dashletDef.context&&dashletDef.context.module){dashletModule=dashletDef.context.module;}
if(pattern.test(this.meta.label)){label=app.lang.get(label,dashletModule,dashletDef.view||dashletDef.layout);}
if(_.isEmpty(toolbar)&&dashletMeta&&dashletMeta['custom_toolbar']){toolbar=dashletMeta['custom_toolbar'];}
if(toolbar!=="no"){components.push({view:{type:'dashlet-toolbar',label:label,toolbar:toolbar}});}}
if(this.meta.empty){this.$el.html(app.template.empty(this));}else{this.$el.html(this.template(this));}
var context=this.context.parent||this.context;app.view.Layout.prototype._addComponentsFromDef.call(this,components,context,context.get("module"));},createComponentFromDef:function(def,context,module){if(def.view&&!_.isUndefined(def.view.toolbar)){var dashlet=_.first(this._components);if(_.isFunction(dashlet.getLabel)){def.view.label=dashlet.getLabel();}
context=dashlet.context;}
var skipFetch=def.view?def.view.skipFetch:def.layout.skipFetch;if(def.context&&skipFetch!==false){def.context.skipFetch=true;}
return app.view.Layout.prototype.createComponentFromDef.call(this,def,context,module);},setInvisible:function(){if(this._invisible===true){return;}
var comp=_.first(this._components);this.model.on("setMode",this.setMode,this);this._invisible=true;this.$el.addClass('hide');this.listenTo(comp,"render",this.unsetInvisible,this);},unsetInvisible:function(){if(this._invisible!==true){return;}
var comp=_.first(this._components);comp.trigger("show");this._invisible=false;this.model.off("setMode",null,this);this.$el.removeClass('hide');this.stopListening(comp,"render");},_placeComponent:function(comp,def){if(this.meta.empty){this.$el.append(comp.el);}else if(this.meta.preview){this.$el.addClass("preview-data");this.$("[data-dashlet=widget]").append(comp.el);}else if(def.view&&!_.isUndefined(def.view.toolbar)){this.$("[data-dashlet=toolbar]").append(comp.el);}else{if(comp.triggerBefore("render")===false){this.setInvisible();}
this.$("[data-dashlet=widget]").append(comp.el);}},setDashletMetadata:function(meta){var metadata=this.model.get("metadata"),component=this.getCurrentComponent(metadata,this.index);_.each(meta,function(value,key){this[key]=value;},component);this.model.set("metadata",app.utils.deepCopy(metadata),{silent:true});this.model.trigger("change:layout");if(this.model.mode==='view'){this.model.save(null,{silent:true,showAlerts:true});}
return component;},getCurrentComponent:function(metadata,tracekey){var position=tracekey.split(''),component=metadata.components;_.each(position,function(index){component=component.rows?component.rows[index]:component[index];},this);return component;},addDashlet:function(meta){var component=this.setDashletMetadata(meta);var def=component.view||component.layout||component;this.meta.empty=false;this.meta.label=def.label||def.name||"";_.each(this._components,function(component){component.layout=null;component.dispose();},this);this._components=[];if(component.context){_.extend(component.context,{forceNew:true})}
this.meta.components=[component];this._addComponentsFromDef(this.meta.components);this.loadData();this.render();},removeDashlet:function(){var metadata=this.model.get("metadata"),component=this.getCurrentComponent(metadata,this.index);_.each(component,function(value,key){if(key!=='width'){delete component[key];}},this);this.model.set("metadata",app.utils.deepCopy(metadata),{silent:true});this.model.trigger("change:layout");if(this.model.mode==='view'){this.model.save(null,{showAlerts:true});}
this.meta.empty=true;_.each(this._components,function(component){component.layout=null;component.dispose();},this);this._components=[];this._addComponentsFromDef([{view:'dashlet-cell-empty',context:{module:'Home',skipFetch:true}}]);this.render();},addRow:function(columns){this.layout.addRow(columns);},reloadDashlet:function(options){var component=_.first(this._components),context=component.context;context.resetLoadFlag();component.loadData(options);},editDashlet:function(evt){var self=this,meta=app.utils.deepCopy(_.first(this.meta.components)),type=meta.layout?"layout":"view";if(_.isString(meta[type])){meta[type]={name:meta[type],config:true};}else{meta[type].config=true;}
meta[type]=_.extend({},meta[type],meta.context);if(meta.context){meta.context.skipFetch=true;delete meta.context.link;}
app.drawer.open({layout:{name:'dashletconfiguration',components:[meta]},context:{model:new app.Bean(),forceNew:true}},function(model){if(!model)return;var conf=model.toJSON(),dash={context:{module:model.get("module")||(meta.context?meta.context.module:null),link:model.get("link")||null}};delete conf.config;if(_.isEmpty(dash.context.module)&&_.isEmpty(dash.context.link)){delete dash.context;}
dash[type]=conf;self.addDashlet(dash);});},collapse:function(collapsed){this.$(".dashlet-toggle > i").toggleClass("icon-chevron-down",collapsed);this.$(".dashlet-toggle > i").toggleClass("icon-chevron-up",!collapsed);this.$(".thumbnail").toggleClass("collapsed",collapsed);this.$("[data-dashlet=widget]").toggleClass("hide",collapsed);},setMode:function(type){if(!this._invisible){return;}
if(type==='edit'||type==='drag'){this.show();}else{this.hide();}},_dispose:function(){this.model.off("setMode",null,this);this.off("render");this.context.off("dashboard:collapse:fire",null,this);app.view.Layout.prototype._dispose.call(this);}})