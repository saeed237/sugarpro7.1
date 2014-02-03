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
({useSugarEmailClient:false,initialize:function(options){options=options||{};options.def=options.def||{};if(_.isUndefined(options.def.link)){options.def.link=true;}
app.view.Field.prototype.initialize.call(this,options);this.useSugarEmailClient=(app.user.getPreference("use_sugar_email_client")==="true");},format:function(value){if(_.isArray(value)){var primaryEmail=_.find(value,function(email){return email.primary_address&&email.primary_address!=="0";});return primaryEmail?primaryEmail.email_address:'';}
return value;},unformat:function(value){var self=this,emails=this.model.get('email'),changed=false;if(!_.isArray(emails)){emails=[];}
_.each(emails,function(email,index){if(email.primary_address&&email.primary_address!=="0"&&email.email_address!==value)
{changed=true;emails[index].email_address=value;}},this);if(emails.length==0){emails.push({email_address:value,primary_address:"1",hasAnchor:false,_wasNotArray:true});changed=true;}
if(changed){this.model.set(this.name,emails);this.model.trigger('change:'+this.name);}
return emails;}})