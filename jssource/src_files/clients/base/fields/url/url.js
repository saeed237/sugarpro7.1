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
    plugins: ['EllipsisInline'],
    format:function(value){
        if (value && !value.match(/^([a-zA-Z]+):\/\//)) {
            value = "http://" + value;
        }
        return value;
    },
    unformat:function(value){
        value = (value!='' && value!='http://') ? value.trim() : "";
        return value;
    },
    getFieldElement: function() {
        return this.$('a');
    },
    _render: function() {
        this.def.link_target = _.isUndefined(this.def.link_target) ? '_blank' : this.def.link_target;
        app.view.Field.prototype._render.call(this);
    }
})
