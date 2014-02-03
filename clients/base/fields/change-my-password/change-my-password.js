/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({extendsFrom:'ChangePasswordField',fieldTag:'input',initialize:function(options){app.view.invokeParent(this,{type:'field',name:'change-password',method:'initialize',args:[options]});app.error.errorName2Keys['current_password']='ERR_ENTER_OLD_PASSWORD';this.__extendModel();},__extendModel:function(){if(this.model&&!this.model._hasChangeMyPasswordModifs){var _proto=_.clone(this.model);this.model._hasChangeMyPasswordModifs=true;this.model._doValidateCurrentPassword=function(fields,errors,callback){var field=_.find(fields,function(field){return field.type==='change-my-password';});var current=this.get(field.name+'_current_password');var password=this.get(field.name+'_new_password'),confirmation=this.get(field.name+'_confirm_password');if(_.isEmpty(current)&&_.isEmpty(password)&&_.isEmpty(confirmation)){callback(null,fields,errors);return;}
var alertOptions={title:app.lang.get("LBL_VALIDATING"),level:"process"};app.alert.show('validation',alertOptions);app.api.verifyPassword(current,{success:function(data){if(!data||!data.valid){errors[field.name]=errors[field.name]||{};errors[field.name]['current_password']=true;}},error:function(error){errors[field.name]=errors[field.name]||{};errors[field.name]['current_password']=true;},complete:function(){app.alert.dismiss('validation');callback(null,fields,errors);}});};this.model.addValidationTask('current_password',_.bind(this.model._doValidateCurrentPassword,this.model));this.model.revertAttributes=function(options){var attrs=_.clone(this.attributes);_.each(attrs,function(value,attr){if(attr.match('_current_password')){this.unset(attr);}},this);_proto.revertAttributes.call(this,options);};}},format:function(value){if(this.action==='edit'){this.currentPassword=this.model.get(this.name+'_current_password');value='';}else if(value===true){value='value_setvalue_set';}
return value;},decorateError:function(errors){var ftag=this.fieldTag;if(errors['current_password']){this.fieldTag='input[name=current_password]';app.view.Field.prototype.decorateError.call(this,{current_password:true});}
errors=_.omit(errors,'current_password');if(!_.isEmpty(errors)){this.fieldTag='input[name!=current_password]';app.view.Field.prototype.decorateError.call(this,errors);}
this.fieldTag=ftag;}})