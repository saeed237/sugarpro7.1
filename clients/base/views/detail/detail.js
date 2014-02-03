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
({toggled:false,fieldsToDisplay:app.config.fieldsToDisplay||5,events:{'click .more':'toggleMoreLess','click .less':'toggleMoreLess'},_renderHtml:function(){app.view.View.prototype._renderHtml.call(this);var fieldsArray=this.$("span[sfuuid]")||[];if(fieldsArray.length>this.fieldsToDisplay){_.each(fieldsArray,function(field,i){if(i>this.fieldsToDisplay-1){$(field).parent().parent().hide();}},this);this.$(".more").removeClass("hide");}
if(this.toggled){this.toggleMoreLess();}},toggleMoreLess:function(){this.toggled=!this.toggled;var fieldsArray=this.$("span[sfuuid]")||[];var that=this;_.each(fieldsArray,function(field,i){if(i>that.fieldsToDisplay-1){$(field).parent().parent().toggle();}});this.$(".less").toggleClass("hide");this.$(".more").toggleClass("hide");},bindDataChange:function(){if(this.model){this.model.on("change",function(){this.render();},this);}}})