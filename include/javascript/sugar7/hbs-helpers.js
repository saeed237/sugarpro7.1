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
(function(app){app.events.on("app:init",function(){Handlebars.registerHelper('moduleIconLabel',function(module){var name=app.lang.getAppListStrings('moduleIconList')[module]||app.lang.getAppListStrings('moduleListSingular')[module]||module,space=name.indexOf(" ");return(space!=-1)?name.substring(0,1)+name.substring(space+1,space+2):name.substring(0,2);});Handlebars.registerHelper('moduleIconToolTip',function(module){return app.lang.getAppListStrings('moduleListSingular')[module]||module;});Handlebars.registerHelper('getDDLabel',function(value,key){return app.lang.getAppListStrings(key)[value]||value;});Handlebars.registerHelper('subViewTemplate',function(key,data,options){var template=app.template.getView(key,options.hash.module);return template?template(data):'';});Handlebars.registerHelper('subFieldTemplate',function(fieldName,view,data,options){var template=app.template.getField(fieldName,view,options.hash.module);return template?template(data):'';});Handlebars.registerHelper('subLayoutTemplate',function(key,data,options){var template=app.template.getLayout(key,options.hash.module);return template?template(data):'';});});})(SUGAR.App);