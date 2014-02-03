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
({extendsFrom:'PanelTopView',initialize:function(options){app.view.invokeParent(this,{type:'view',name:'panel-top',method:'initialize',args:[options]});if(this.parentModule=="Accounts"){this.meta.buttons=_.filter(this.meta.buttons,function(item){if(item.type!="actiondropdown"){return true;}
return false;});}},createRelatedClicked:function(event){app.alert.dismiss('opp-rli-create');app.view.invokeParent(this,{type:'view',name:'panel-top',method:'createRelatedClicked',args:[event]});}})