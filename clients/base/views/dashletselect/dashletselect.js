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
({extendsFrom:'FilteredListView',initialize:function(options){var meta=app.metadata.getView(null,'dashletselect')||{};options.meta=_.extend({},meta,options.meta||{});this._super('initialize',[options]);this.context=_.extend(_.clone(this.context),{resetLoadFlag:function(){return;}});this.context.on('dashletlist:select-and-edit',function(model,collection){this.selectDashlet(model.get('metadata'));},this);this.context.on('dashletlist:preview:fire',function(model,collection){this.previewDashlet(model.get('metadata'));},this);},previewDashlet:function(metadata){var layout=this.layout,previewLayout;while(layout){if(layout.getComponent('preview-pane')){previewLayout=layout.getComponent('preview-pane').getComponent('dashlet-preview');previewLayout.showPreviewPanel();break;}
layout=layout.layout;}
if(previewLayout){if(!metadata.preview){metadata.preview=metadata.config;}
var previousComponent=_.last(previewLayout._components);if(previousComponent.name!=='dashlet-preview'){var index=previewLayout._components.length-1;previewLayout._components[index].dispose();previewLayout.removeComponent(index);}
var contextDef,component={label:app.lang.get(metadata.name,metadata.preview.module),name:metadata.type,preview:true};if(metadata.preview.module||metadata.preview.link){contextDef={skipFetch:false,forceNew:true,module:metadata.preview.module,link:metadata.preview.link};}else if(metadata.module){contextDef={module:metadata.module};}
component.view=_.extend({module:metadata.module},metadata.preview,component);if(contextDef){component.context=contextDef;}
previewLayout._addComponentsFromDef([{layout:{type:'dashlet',label:app.lang.get(metadata.preview.label||metadata.name,metadata.preview.module),preview:true,components:[component]}}],this.context.parent);previewLayout.loadData();previewLayout.render();}},selectDashlet:function(metadata){app.drawer.load({layout:{name:'dashletconfiguration',components:[{view:_.extend({},metadata.config,{label:app.lang.get(metadata.name,metadata.config.module),name:metadata.type,config:true,module:metadata.config.module||metadata.module})}]},context:{module:metadata.config.module||metadata.module,forceNew:true,skipFetch:true}});},getFilteredList:function(dashlets){var parentModule=app.controller.context.get('module'),parentView=app.controller.context.get('layout');return _.chain(dashlets).filter(function(dashlet){var filter=dashlet.filter;if(_.isUndefined(filter)){return true;}
var filterModules=filter.module||[parentView],filterViews=filter.view||[parentView];if(_.isString(filterModules)){filterModules=[filterModules];}
if(_.isString(filterViews)){filterViews=[filterViews];}
return _.contains(filterModules,parentModule)&&_.contains(filterViews,parentView);}).value();},_getDashlets:function(type,name,module,meta){var dashlets=[],hadDashlet=meta&&meta.dashlets&&app.view.componentHasPlugin({type:type,name:name,module:module,plugin:'Dashlet'});if(!hadDashlet){return dashlets;}
_.each(meta.dashlets,function(dashlet){if(!dashlet.config){return;}
var description=app.lang.get(dashlet.description,dashlet.config.module);if(!app.acl.hasAccess('access',module||dashlet.config.module)){return;}
dashlets.push({type:name,filter:dashlet.filter,metadata:_.extend({component:name,module:module,type:name},dashlet),title:app.lang.get(dashlet.name,dashlet.config.module),description:description});},this);return dashlets;},_addBaseViews:function(){var components=[];_.each(app.metadata.getView(),function(view,name){var dashlets=this._getDashlets('view',name,null,view.meta);if(!_.isEmpty(dashlets)){components=_.union(components,dashlets);}},this);return components;},_addModuleViews:function(){var components=[];_.each(app.metadata.getModuleNames(),function(module){_.each(app.metadata.getView(module),function(view,name){var dashlets=this._getDashlets('view',name,module,view.meta);if(!_.isEmpty(dashlets)){components=_.union(components,dashlets);}},this);},this);return components;},loadData:function(){if(this.collection.length){this.filteredCollection=this.collection.models;return;}
var dashletCollection=_.union(this._addBaseViews(),this._addModuleViews()),filteredDashletCollection=this.getFilteredList(dashletCollection);this.collection.add(filteredDashletCollection);this.collection.dataFetched=true;this._renderData();},getFields:function(){return _.flatten(_.pluck(this.meta.panels,'fields'));}})