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
({extendsFrom:'RowactionField',initialize:function(options){options.def.event=options.def.event||'list:unlinkrow:fire';options.def.acl_action=options.def.acl_action||'delete';app.view.invokeParent(this,{type:'field',name:'rowaction',method:'initialize',args:[options]});this.type='rowaction';},hasAccess:function(){var link=this.context.get("link");var parentModule=this.context.get("parentModule");var required=app.utils.isRequiredLink(parentModule,link);if(required){return false;}
return app.view.invokeParent(this,{type:'field',name:'rowaction',method:'hasAccess'});}})