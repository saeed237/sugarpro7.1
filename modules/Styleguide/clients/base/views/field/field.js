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
({className:'container-fluid',section:{},parent_link:'',useTable:true,tempfields:[],errorfields:[],_render:function(){this.section.title='Form Elements';this.section.description='Basic fields that support detail, record, and edit modes with error addons.';var self=this,fieldTypeReq=this.context.get('field_type'),fieldTypes=(fieldTypeReq==='all'?['text','bool','email','date','currency']:[fieldTypeReq]),errors={required:true,'This is an error message.':{}},errorMeta={},fieldMeta={};this.useTable=(fieldTypeReq==='all'?true:false);this.parent_link=(fieldTypeReq==='all'?'docs/index.forms':'field/all');this.tempfields=[];this.errorfields=[];_.each(fieldTypes,function(fieldType){fieldMeta=_.find(self.model.fields,function(field){if(field.type==='datetime'&&fieldType.indexOf('date')===0){field.type=fieldType;}
return field.type==fieldType;},self);if(fieldMeta){if(_.isObject(self.meta['template_values'][fieldType])&&!_.isArray(self.meta['template_values'][fieldType])){_.each(self.meta['template_values'][fieldType],function(value,name){self.model.set(name,value);},self);}else{self.model.set(fieldMeta.name,self.meta['template_values'][fieldType]);}
errorMeta=app.utils.deepCopy(fieldMeta);errorMeta.name=fieldMeta.name+'_ERROR';fieldMeta.errorMeta=[];fieldMeta.errorMeta.push(errorMeta);self.tempfields.push(fieldMeta);}});if(fieldTypeReq!=='all'){this.title=fieldTypeReq+' field';var descTpl=app.template.getView('styleguide.'+fieldTypeReq,'Styleguide');if(descTpl){this.description=descTpl();}}
app.view.View.prototype._render.call(this);_.each(this.fields,function(field){if(field.tplName==='edit'){field.setMode('edit');}
if(field.tplName==='disabled'){field.setDisabled(true);field.setMode('edit');}
if(field.tplName==='error'){field.setMode('edit');self.model.trigger('error:validation:'+field.name,errors);}},this);}})