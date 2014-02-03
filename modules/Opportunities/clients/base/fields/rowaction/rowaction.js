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
({extendsFrom:"RowactionField",initialize:function(options){this.plugins=_.clone(this.plugins)||[];this.plugins.push('DisableDelete');app.view.invokeParent(this,{type:'field',name:'rowaction',method:'initialize',args:[options]});this.model.on("change:closed_revenue_line_items",function(){this.render();if(_.isFunction(this.view.initButtons)){this.view.initButtons();}
if(_.isFunction(this.view.setButtonStates)){this.view.setButtonStates(this.view.STATE.VIEW);}},this);}})