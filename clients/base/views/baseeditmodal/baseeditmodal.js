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
({events:{'click [name=save_button]':'saveButton','click [name=cancel_button]':'cancelButton'},saveButton:function(){var self=this,createModel=this.context.get('createModel');self.$('[name=save_button]').attr('data-loading-text',app.lang.get('LBL_LOADING'));self.$('[name=save_button]').button('loading');createModel.set('portal_flag',true);createModel.save(null,{relate:true,fieldsToValidate:this.getFields(this.module),success:function(){var view=_.extend({},self,{model:createModel});app.file.checkFileFieldsAndProcessUpload(view,{success:function(){self.saveComplete();}});},error:function(){self.resetButton();}});},cancelButton:function(){this.$('.modal').modal('hide').find('form').get(0).reset();if(this.context.has('createModel')){this.context.get('createModel').clear();}},saveComplete:function(){this.$('.modal').modal('hide').find('form').get(0).reset();this.resetButton();this.collection.fetch({relate:true});},resetButton:function(){this.$('[name=save_button]').button('reset');}})