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
({extendsFrom:'BaseeditView',events:{'click [name=save_button]':'saveModel'},initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.context.off("subnav:save",null,this);this.context.on("subnav:save",this.saveModel,this);this.model.on("error:validation",this.handleValidationError,this);},saveModel:function(){var self=this,deleteIfFails=_.isUndefined(self.model.id);this.model.save(null,{success:function(){app.alert.dismiss('save_edit_view');app.file.checkFileFieldsAndProcessUpload(self,{success:function(){app.navigate(self.context,self.model,'detail');}},{deleteIfFails:false});},fieldsToValidate:this.getFields(this.module)});},checkFileFieldsAndProcessUpload:function(model,callbacks){callbacks=callbacks||{};var $files=_.filter($(":file"),function(file){var $file=$(file);return($file.val()&&$file.attr("name")&&$file.attr("name")!=="")?$file.val()!=="":false;});var filesToUpload=$files.length;if(filesToUpload>0){app.alert.show('upload',{level:'process',title:'LBL_UPLOADING',autoclose:false});for(var file in $files){var $file=$($files[file]),fileField=$file.attr("name");model.uploadFile(fileField,$file,{field:fileField,success:function(){filesToUpload--;if(filesToUpload===0){app.alert.dismiss('upload');if(callbacks.success)callbacks.success();}},error:function(error){filesToUpload--;if(filesToUpload===0){app.alert.dismiss('upload');}
var errors={};errors[error.responseText]={};model.trigger('error:validation:'+this.field,errors);model.trigger('error:validation');}});}}
else{if(callbacks.success)callbacks.success();}},_renderHtml:function(){app.view.View.prototype._renderHtml.call(this);if(!this.model.id){this.context.trigger('subnav:set:title',app.lang.get('LBL_NEW_FORM_TITLE',this.module));}}})