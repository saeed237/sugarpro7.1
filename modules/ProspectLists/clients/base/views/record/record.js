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
({extendsFrom:'RecordView',delegateButtonEvents:function(){this.context.on('button:export_button:click',this.exportListMembers,this);app.view.invokeParent(this,{type:'view',name:'record',method:'delegateButtonEvents'});},exportListMembers:function(){app.alert.show('export_loading',{level:'process',title:app.lang.getAppString('LBL_PORTAL_LOADING')});app.api.exportRecords({module:this.module,uid:this.model.id,entire:false,members:true,filter:null},this.$el,{complete:function(){app.alert.dismiss('export_loading');}});}})