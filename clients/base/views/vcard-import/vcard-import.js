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
({initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.context.off("vcard:import:finish",null,this);this.context.on("vcard:import:finish",this.importVCard,this);},_renderField:function(field){app.view.View.prototype._renderField.call(this,field);if(field.name==='vcard_import'){field.setMode('edit');}},importVCard:function(){var self=this,vcardFile=$('[name=vcard_import]');if(_.isEmpty(vcardFile.val())){app.alert.show('error_validation_vcard',{level:'error',messages:'LBL_EMPTY_VCARD',autoClose:false});}else{app.file.checkFileFieldsAndProcessUpload(self,{success:function(data){var route=app.router.buildRoute(self.module,data.vcard_import);app.router.navigate(route,{trigger:true});app.alert.show('vcard-import-saved',{level:'success',messages:app.lang.get('LBL_IMPORT_VCARD_SUCCESS',self.module),autoClose:true});}},{deleteIfFails:true,htmlJsonFormat:false});}}})