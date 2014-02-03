/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({linkTemplate:null,initialize:function(opts){app.view.View.prototype.initialize.call(this,opts);this.linkTemplate=app.template.getView(this.name+'.link',this.module);},_renderHtml:function(){_.each(this.meta.providers,function(provider){provider.link=this.linkTemplate(provider);},this);app.view.View.prototype._renderHtml.call(this);}})