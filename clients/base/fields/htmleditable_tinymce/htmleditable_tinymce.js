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
({fieldSelector:'.htmleditable',_htmleditor:null,_isDirty:false,_saveOnSetContent:true,_render:function(){this.destroyTinyMCEEditor();app.view.Field.prototype._render.call(this);this._getHtmlEditableField().attr('name',this.name);if(this._isEditView()){this._renderEdit(this.options.def.tinyConfig||null);}else{this._renderView();}},bindDataChange:function(){this.model.on('change:'+this.name,function(model,value){if(this._isEditView()){this._saveOnSetContent=false;this.setEditorContent(value);}else{this.setViewContent(value)}},this);},setViewContent:function(value){var editable=this._getHtmlEditableField();if(editable&&!_.isEmpty(editable.get(0).contentDocument)){if(editable.contents().find('body').length>0){editable.contents().find('body').html(value);}}},_renderEdit:function(options){var self=this;this.initTinyMCEEditor(options);this._getHtmlEditableField().on('change',function(){self.model.set(self.name,self._getHtmlEditableField().val());});},_renderView:function(){this.setViewContent(this.value);},_isEditView:function(){return(this._getHtmlEditableField().prop('tagName')==='TEXTAREA');},getTinyMCEConfig:function(){return{script_url:'include/javascript/tiny_mce/tiny_mce.js',theme:"advanced",skin:"sugar7",plugins:"style,table,advhr,advimage,advlink,iespell,inlinepopups,media,searchreplace,print,contextmenu,paste,noneditable,visualchars,nonbreaking,xhtmlxtras",entity_encoding:"raw",theme_advanced_buttons1:"code,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,iespell,media,advhr,|,print,|",theme_advanced_buttons2:"cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,forecolor,backcolor,tablecontrols,|,",theme_advanced_toolbar_location:"top",theme_advanced_toolbar_align:"left",theme_advanced_statusbar_location:"none",theme_advanced_resizing:true,schema:"html5",template_external_list_url:"lists/template_list.js",external_link_list_url:"lists/link_list.js",external_image_list_url:"lists/image_list.js",media_external_list_url:"lists/media_list.js",theme_advanced_path:false,theme_advanced_source_editor_width:500,theme_advanced_source_editor_height:400,inlinepopups_skin:"sugar7modal",relative_urls:false,remove_script_host:false};},initTinyMCEEditor:function(optConfig){var self=this;if(_.isEmpty(this._htmleditor)){var config=optConfig||this.getTinyMCEConfig();var __superSetup__=config.setup;config.setup=function(editor){if(_.isFunction(__superSetup__)){__superSetup__.call(this,editor);}
self._htmleditor=editor;self._htmleditor.onInit.add(function(ed){self.setEditorContent(self.value);$(ed.getWin()).blur(function(e){self._saveEditor();});});self._htmleditor.onDeactivate.add(function(ed){self._saveEditor();});self._htmleditor.onSetContent.add(function(ed){if(self._saveOnSetContent){self._saveEditor(true);}
self._saveOnSetContent=true;});self._htmleditor.onChange.add(function(ed,l){self._isDirty=true;});};config.oninit=function(inst){self.context.trigger('tinymce:oninit',inst);};$('.htmleditable').tinymce(config);}},destroyTinyMCEEditor:function(){if(!_.isNull(this._htmleditor)){this._saveEditor(true);this._htmleditor.remove();this._htmleditor.destroy();this._htmleditor=null;}},_saveEditor:function(force){var save=force|this._isDirty;if(save){this.model.set(this.name,this.getEditorContent(),{silent:true});this._isDirty=false;}},_getHtmlEditableField:function(){return this.$el.find(this.fieldSelector);},setEditorContent:function(value){if(_.isEmpty(value)){value="";}
if(this._isEditView()&&this._htmleditor&&this._htmleditor.dom){this._htmleditor.setContent(value);}},getEditorContent:function(){return this._htmleditor.getContent();},_dispose:function(){this.destroyTinyMCEEditor();app.view.Field.prototype._dispose.call(this);}})