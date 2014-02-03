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
({extendsFrom:'RecordlistView',initialize:function(options){app.view.invokeParent(this,{type:'view',name:'recordlist',method:'initialize',args:[options]});this.layout.on("list:record:deleted",function(deletedModel){this.deleteCommitWarning(deletedModel);},this);},parseFields:function(){var catalog=app.view.invokeParent(this,{type:'view',name:'recordlist',method:'parseFields'});_.each(catalog,function(group,i){catalog[i]=_.filter(group,function(fieldMeta){var leave=true;if(app.metadata.getModule("Forecasts","config").is_setup){if(fieldMeta.name.indexOf('_case')!=-1){var field='show_worksheet_'+fieldMeta.name.replace('_case','');leave=(app.metadata.getModule("Forecasts","config")[field]==1);}}else{leave=!(fieldMeta.name=="commit_stage");}
return leave;});});return catalog;},deleteCommitWarning:function(deletedModel){var message=null;if(deletedModel.get("commit_stage")=="include"){message=app.lang.get("WARNING_DELETED_RECORD_RECOMMIT","RevenueLineItems");app.alert.show("included_list_delete_warning",{level:"warning",messages:message,onLinkClick:function(){app.alert.dismissAll();}});}
return message;},})