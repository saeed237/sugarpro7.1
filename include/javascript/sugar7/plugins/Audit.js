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
(function(app){app.events.on('app:init',function(){app.plugins.register('Audit',['view'],{onAttach:function(component,plugin){this.on('init',function(){this.context.on('button:audit_button:click',this.auditClicked,this);});},auditClicked:function(){var context=this.context.getChildContext({module:'Audit'});app.drawer.open({layout:'audit',context:context});},onDetach:function(component,plugin){this.context.off('button:audit_button:click',this.auditClicked,this);}});});})(SUGAR.App);