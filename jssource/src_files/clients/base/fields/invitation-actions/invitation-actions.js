/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
({

    plugins: ['Tooltip'],

    events: {
        'click [data-action]': 'toggleStatus'
    },

    /**
     * Toggle invitation acceptance status.
     *
     * This will fire the save automatically to the server since it is a toggle
     * button and won't make sense to do save from the view (same as favorite).
     *
     * @param {Event} evt The click event that triggered the change.
     */
    toggleStatus: function(evt) {
        var attr = {};

        attr[this.name] = $(evt.currentTarget).data('action');

        this.model.save(attr, {relate: true});
    }
})
