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
    events: {
        'click [data-dashletaction]': 'actionClicked'
    },
    extendsFrom: 'ButtonField',
    /**
     * Trigger the function which is in the dashlet view.
     *
     * @param {Event} evt Mouse event.
     */
    actionClicked: function(evt) {
        if (this.preventClick(evt) === false) {
            return;
        }
        var action = $(evt.currentTarget).data('dashletaction');
        this._runAction(evt, action);
    },

    /**
     * Handles rowaction's event trigger and propagate the event to the main dashlet.
     *
     * @param {Event} evt Mouse event.
     * @param {String} action Name of executing parent action.
     * @protected
     */
    _runAction: function(evt, action) {
        if (!action) {
            return;
        }
        var dashlet = this.view.layout ? _.first(this.view.layout._components) : null;
        if (dashlet && _.isFunction(dashlet[action])) {
            dashlet[action](evt, this.def.params);
        } else if (_.isFunction(this.view[action])) {
            this.view[action](evt, this.def.params);
        }
    }
})
