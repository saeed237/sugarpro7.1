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
({associatedModels:null,events:{'click .preview-list-item':'previewRecord'},plugins:['Tooltip'],initialize:function(options){app.view.View.prototype.initialize.call(this,options);app.events.on("list:preview:decorate",this.decorateRow,this);this.associatedModels=app.data.createMixedBeanCollection();},bindDataChange:function(){this.model.on("change",this.populateResults,this);},populateResults:function(){this.associatedModels.reset();app.view.View.prototype.render.call(this);},previewRecord:function(e){var $el=this.$(e.currentTarget),data=$el.data(),model=app.data.createBean(data.module,{id:data.id});model.fetch({showAlerts:true,success:_.bind(function(model){model.module=data.module;app.events.trigger("preview:render",model,this.associatedModels);},this)});},decorateRow:function(model){this.$("tr.highlighted").removeClass("highlighted current above below");if(model){var rowName=model.module+"_"+model.get("id");var curr=this.$("tr[name='"+rowName+"']");curr.addClass("current highlighted");curr.prev("tr").addClass("highlighted above");curr.next("tr").addClass("highlighted below");}}})