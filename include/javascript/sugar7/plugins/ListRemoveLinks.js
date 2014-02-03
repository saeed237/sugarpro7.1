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
(function(app){app.events.on("app:init",function(){app.plugins.register('ListRemoveLinks',['view'],{onAttach:function(component,plugin){var removeLinks=function(){component.$('a:not(.rowaction)').contents().unwrap();};component.on('render',removeLinks,null,component);app.events.on("list:preview:decorate",removeLinks,this);},onDetach:function(){app.events.off("list:preview:decorate",null,this);}});});})(SUGAR.App);