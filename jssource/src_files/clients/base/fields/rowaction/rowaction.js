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
    extendsFrom: 'ButtonField',
    initialize: function(options) {
        this.options.def.events = _.extend({}, this.options.def.events, {
            'click .rowaction': 'rowActionSelect'
        });
        app.view.invokeParent(this, {type: 'field', name: 'button', method: 'initialize', args:[options]});
    },
    rowActionSelect: function(evt) {
        if(this.isDisabled()){
            return;
        }
        // make sure that we are not disabled first
        if(this.preventClick(evt) !== false) {
            if ($(evt.currentTarget).data('event')) {
                this.view.context.trigger($(evt.currentTarget).data('event'), this.model);
            }
        }
    }
})
