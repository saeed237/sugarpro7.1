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
({events:{'click .btn.layout':'layoutClicked'},plugins:['Tooltip'],extendsFrom:'ButtonField',getFieldElement:function(){return this.$el;},_render:function(){var buttonField=app.view._getController({type:'field',name:'button',platform:app.config.platform});buttonField.prototype._render.call(this);},_loadTemplate:function(){app.view.Field.prototype._loadTemplate.call(this);if(this.action!=='edit'||(this.model.maxColumns<=1)){this.template=app.template.empty;}},format:function(value){var metadata=this.model.get("metadata");if(metadata){return(metadata.components)?metadata.components.length:1;}
return value;},layoutClicked:function(evt){var value=$(evt.currentTarget).data('value');this.setLayout(value);},setLayout:function(value){var span=12 / value;if(this.value){if(value===this.value){return;}
var setComponent=function(){var metadata=this.model.get("metadata");_.each(metadata.components,function(component){component.width=span;},this);if(metadata.components.length>value){_.times(metadata.components.length-value,function(index){metadata.components[value-1].rows=metadata.components[value-1].rows.concat(metadata.components[value+index].rows);},this);metadata.components.splice(value);}else{_.times(value-metadata.components.length,function(index){metadata.components.push({rows:[],width:span});},this);}
this.model.set("metadata",app.utils.deepCopy(metadata),{silent:true});this.model.trigger("change:metadata");};if(value!==this.value){app.alert.show('resize_confirmation',{level:'confirmation',messages:app.lang.get('LBL_DASHBOARD_LAYOUT_CONFIRM',this.module),onConfirm:_.bind(setComponent,this),onCancel:_.bind(this.render,this)});}else{setComponent.call(this);}}else{var metadata={components:[]};_.times(value,function(index){metadata.components.push({rows:[],width:span});},this);this.model.set("metadata",app.utils.deepCopy(metadata),{silent:true});this.model.trigger("change:metadata");}},bindDomChange:function(){},bindDataChange:function(){if(this.model){this.model.on("change:metadata",this.render,this);if(this.model.isNew()){this.setLayout(1);this.model.changed={};}}}})