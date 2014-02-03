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
({plugins:['Dropdown','Tooltip'],initialize:function(options){app.view.View.prototype.initialize.call(this,options);app.events.on("app:sync:complete",this.setCurrentUserData,this);app.user.on("change:picture",this.setCurrentUserData,this);app.user.on("change:full_name",this.setCurrentUserData,this);},_renderHtml:function(){if(!app.router||!app.api.isAuthenticated()||app.config.appStatus==='offline'){return;}
this.showAdmin=app.acl.hasAccess('admin','Administration')||app.acl.hasAccessToAny('admin')||app.acl.hasAccessToAny('developer');app.view.View.prototype._renderHtml.call(this);},setCurrentUserData:function(){this.fullName=app.user.get("full_name");this.userName=app.user.get("user_name");this.userId=app.user.get('id');var picture=app.user.get("picture");this.pictureUrl=picture?app.api.buildFileURL({module:"Users",id:app.user.get("id"),field:"picture"}):'';this.render();},_dispose:function(){if(app.user)app.user.off(null,null,this);app.view.Component.prototype._dispose.call(this);}})