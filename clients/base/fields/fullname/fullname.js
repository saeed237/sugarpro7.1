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
({extendsFrom:'FieldsetField',plugins:['EllipsisInline'],formatMap:{'first_name':'f','last_name':'l','salutation':'s'},initialize:function(options){var formatPlaceholder=app.user.getPreference('default_locale_name_format')||'';options.def.fields=_.sortBy(options.def.fields,function(field){return formatPlaceholder.indexOf(this.formatMap[field.name]);},this);this._super('initialize',[options]);},_loadTemplate:function(){this._super('_loadTemplate');if(this.def.link){var action=this.def.route&&this.def.route.action?this.def.route.action:'';this.href='#'+app.router.buildRoute(this.module||this.context.get('module'),this.model.id,action,this.def.bwcLink);}
this.template=app.template.getField(this.type,this.view.name+'-'+this.tplName,this.model.module)||this.template;},getPlaceholder:function(){return app.view.Field.prototype.getPlaceholder.call(this);},_render:function(){_.each(this.fields,function(field){field.dispose();delete this.view.fields[field.sfId];},this);this.fields=[];app.view.Field.prototype._render.call(this);_.each(this.fields,function(field){field.setElement(this.$("span[sfuuid='"+field.sfId+"']"));field.render();},this);return this;},format:function(name){return app.utils.formatNameLocale({first_name:this.model.get('first_name'),last_name:this.model.get('last_name'),salutation:this.model.get('salutation')});},bindDataChange:function(){if(this.model){this.model.on("change:"+this.name,function(){if(this.fields.length===0){this.render();}},this);_.each(this.def.fields,function(field){this.model.on("change:"+field.name,this.updateValue,this);},this);}},updateValue:function(){this.model.set(this.name,this.format());},setMaxWidth:function(width){this.$('.record-cell').css({'max-width':width});},getCellPadding:function(){var padding=0,$cell=this.$('.record-cell');if(!_.isEmpty($cell)){padding=parseInt($cell.css('padding-left'),10)+parseInt($cell.css('padding-right'),10);}
return padding;}})