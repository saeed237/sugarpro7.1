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
({extendsFrom:'RowactionField',disableButton:true,initialize:function(options){app.view.invokeParent(this,{type:'field',name:'rowaction',method:'initialize',args:[options]});this.type='rowaction';},bindDataChange:function(){this.context.on('forecasts:worksheet:quota_changed',function(){this.disableButton=false;if(!this.disposed){this.render();}},this);this.context.on('forecasts:worksheet:committed',function(){this.disableButton=true;if(!this.disposed){this.render();}},this);this.context.on('forecasts:assign_quota',this.assignQuota,this);},_render:function(){app.view.invokeParent(this,{type:'field',name:'rowaction',method:'_render'});this.setDisabled(this.disableButton);},hasAccess:function(){var su=(this.context.get('selectedUser'))||app.user.toJSON(),isManager=su.isManager||false,showOpps=su.showOpps||false;return(su.id===app.user.get('id')&&isManager&&showOpps===false);},assignQuota:function(worksheetType,selectedUser,selectedTimeperiod){app.api.call('create',app.api.buildURL('ForecastManagerWorksheets/assignQuota'),{'user_id':selectedUser.id,'timeperiod_id':selectedTimeperiod},{success:_.bind(function(o){app.alert.dismiss('saving_quota');app.alert.show('success',{level:'success',autoClose:true,title:app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE","Forecasts")+":",messages:[app.lang.get('LBL_QUOTA_ASSIGNED','Forecasts')]});this.disableButton=true;this.context.trigger('forecasts:quota_assigned');if(!this.disposed){this.render();}},this)});}})