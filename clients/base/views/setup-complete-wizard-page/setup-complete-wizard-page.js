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
({extendsFrom:"WizardPageView",wizardName:"",initialize:function(options){this.events=_.extend({},this.events,{"click a.thumbnail":"linkClicked","click [name=start_sugar_button]:not(.disabled)":"next"});app.view.invokeParent(this,{type:'view',name:'wizard-page',method:'initialize',args:[options]});this.wizardName=this.context.get("wizardName")||"user";},isPageComplete:function(){return true;},linkClicked:function(ev){var href,redirectUrl,target=this.$(ev.currentTarget);if(this.$(target).attr("target")!=="_blank"){ev.preventDefault();$("#header").show();href=this.$(target).attr("href");if(href.indexOf('#bwc/')===0){redirectUrl=href.split('#bwc/')[1];app.bwc.login(redirectUrl);}else{app.router.navigate($(ev.currentTarget).attr("href"),{trigger:true});}}},_render:function(){this._super('_render');app.user.unset("show_wizard");}})