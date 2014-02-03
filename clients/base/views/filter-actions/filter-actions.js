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
({events:{"change input":"filterNameChanged","keyup input":"filterNameChanged","click a.filter-close":"triggerClose","click a.save_button:not(.disabled)":"triggerSave","click a.delete_button:not(.hide)":"triggerDelete"},tagName:"article",className:"filter-header",rowState:false,initialize:function(opts){app.view.View.prototype.initialize.call(this,opts);this.layout.on("filter:create:open",function(model){var self=this,name=model?model.get("name"):'';this.setFilterName(name);if(!name){_.defer(function(){self.$("input").focus();});}},this);this.listenTo(this.layout,"filter:create:rowsValid",this.toggleRowState);this.listenTo(this.layout,"filter:set:name",this.setFilterName);},getFilterName:function(){return this.$("input").val();},setFilterName:function(name){this.$("input").val(name);this.toggleDelete(!name);},filterNameChanged:_.debounce(function(event){this.layout.trigger('filter:create:validate');},400),toggleDelete:function(t){this.$(".delete_button").toggleClass("hide",t);},toggleDisabled:function(){this.$(".save_button").toggleClass('disabled',!(this.getFilterName()&&this.rowState));},toggleRowState:function(t){this.rowState=_.isUndefined(t)?!this.rowState:!!t;this.toggleDisabled();},triggerClose:function(){var id=this.layout.editingFilter.get('id');this.layout.trigger("filter:create:close",true,id);},triggerSave:function(){var filterName=this.getFilterName();this.layout.trigger("filter:create:save",filterName);},triggerDelete:function(){this.layout.trigger("filter:create:delete");}})