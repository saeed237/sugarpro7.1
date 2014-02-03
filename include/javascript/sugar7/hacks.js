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
(function(app){var _oldMetadataSet=app.metadata.set;app.metadata.set=function(data){_.each(data.modules,function(module){if(!_.isUndefined(module.fields)){var field=module.fields.team_name;if(field){delete field.len;field.type="teamset";}
_.each(module.fields,function(field){if(field.name&&(field.type==="relate")&&(field.name.length>2&&(field.name.length-
field.name.lastIndexOf("_id"))===3))
{field.type="id";delete field.source;}});}},this);_oldMetadataSet.apply(this,arguments);};})(SUGAR.App);WebKitMutationObserver=function(){};WebKitMutationObserver.prototype.observe=function(){};