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
({clearValidationError:function(model,fields){var self=this;if(!_.isEmpty(fields.changes)){_.each(fields.changes,function(num,key){var field=self.getField(key);if(field){var controlGroup=field.$el.parents('.control-group:first');if(controlGroup){controlGroup.removeClass("error");controlGroup.find('.add-on').remove();controlGroup.find('.help-block').html("");}}});}},handleValidationError:function(errors){var self=this;_.each(errors,function(fieldErrors,fieldName){var field=self.getField(fieldName);var ftag=this.fieldTag||'';if(field){var controlGroup=field.$el.parents('.control-group:first');if(controlGroup){controlGroup.addClass("error");controlGroup.find('.add-on').remove();controlGroup.find('.help-block').html("");if(field.$el.parent().parent().find('.input-append').length>0){field.$el.unwrap()}
field.$el.wrap('<div class="input-append  '+ftag+'">');_.each(fieldErrors,function(errorContext,errorName){controlGroup.find('.help-block').append(app.error.getErrorString(errorName,errorContext));});$('<span class="add-on"><i class="icon-exclamation-sign"></i></span>').insertBefore(controlGroup.find('.help-block'));}}});}})