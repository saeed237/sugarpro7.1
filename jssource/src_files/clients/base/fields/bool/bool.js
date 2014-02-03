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

({
    _render: function() {
        app.view.Field.prototype._render.call(this);
        if(this.tplName === 'disabled') {
            this.$(this.fieldTag).attr("disabled", "disabled");
        }
    },
    unformat:function(value){
        value = this.$el.find(".checkbox").prop("checked") ? "1" : "0";
        return value;
    },
    format:function(value){
        value = (value=="1") ? true : false;
        return value;
    }
})
