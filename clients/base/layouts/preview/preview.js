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
({events:{"click .closeSubdetail":"hidePreviewPanel"},initialize:function(opts){app.view.Layout.prototype.initialize.call(this,opts);app.events.on("preview:open",this.showPreviewPanel,this);app.events.on("preview:close",this.hidePreviewPanel,this);},showPreviewPanel:function(event){if(_.isUndefined(app.drawer)||app.drawer.isActive(this.$el)){var layout=this.$el.parents(".sidebar-content");layout.find(".side-pane").removeClass("active");layout.find(".dashboard-pane").hide();layout.find(".preview-pane").addClass("active");}},hidePreviewPanel:function(event){if(_.isUndefined(app.drawer)||app.drawer.isActive(this.$el)){var layout=this.$el.parents(".sidebar-content");layout.find(".side-pane").addClass("active");layout.find(".dashboard-pane").show();layout.find(".preview-pane").removeClass("active");}}})