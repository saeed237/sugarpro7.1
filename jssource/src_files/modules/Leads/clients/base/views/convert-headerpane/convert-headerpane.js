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
    extendsFrom: 'HeaderpaneView',

    events:{
        'click [name=save_button]:not(".disabled")': 'initiateSave',
        'click [name=cancel_button]': 'initiateCancel'
    },

    initialize: function(options) {
        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: 'initialize', args: [options]});
        this.context.on('lead:convert-save:toggle', this.toggleSaveButton, this);
    },

    /**
     * Grab the lead's name and set the title to Convert: Name
     */
    _renderHtml: function() {
        var leadsModel = this.context.get('leadsModel');
        var name = !_.isUndefined(leadsModel.get('name')) ? leadsModel.get('name') : leadsModel.get('first_name') + ' ' + leadsModel.get('last_name');
        this.title = app.lang.get("LBL_CONVERTLEAD_TITLE", this.module) + ': ' + name;
        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: '_renderHtml'});
    },

    /**
     * When finish button is clicked, send this event down to the convert layout to wrap up
     */
    initiateSave: function() {
        this.context.trigger('lead:convert:save');
    },

    /**
     * When cancel clicked, hide the drawer
     */
    initiateCancel : function() {
        app.drawer.close();
    },

    /**
     * Enable/disable the Save button
     *
     * @param enable true to enable, false to disable
     */
    toggleSaveButton: function(enable) {
        this.$('[name=save_button]').toggleClass('disabled', !enable);
    }
})
