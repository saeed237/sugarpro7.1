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
({linkModules:[],events:{'click label[for=relationship]':'setFocus'},initialize:function(options){app.view.View.prototype.initialize.call(this,options);this.linkModules=this.context.get("linkModules");},setFocus:function(e){this.$("#relationship").select2("open");},_renderHtml:function(ctx,options){var self=this;app.view.View.prototype._renderHtml.call(this,ctx,options);this.$(".select2").select2({width:'100%',allowClear:true,placeholder:app.lang.get("LBL_SEARCH_SELECT")}).on("change",function(e){if(_.isEmpty(e.val)){self.context.trigger("link:module:select",null);}else{var meta=self.linkModules[e.val];self.context.trigger("link:module:select",{link:meta.link,module:meta.module});}});},_dispose:function(){this.$(".select2").select2('destroy');app.view.View.prototype._dispose.call(this);}})