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
({className:'preview-headerbar',events:{'click [data-direction]':'triggerPagination','click .preview-headerbar .closeSubdetail':'triggerClose'},initialize:function(options){app.view.View.prototype.initialize.call(this,options);if(this.layout){this.layout.off("preview:pagination:update",null,this);this.layout.on("preview:pagination:update",this.render,this);}},triggerPagination:function(e){var direction=this.$(e.currentTarget).data();this.layout.trigger("preview:pagination:fire",direction);},triggerClose:function(){app.events.trigger("list:preview:decorate",null,this);app.events.trigger("preview:close");}})