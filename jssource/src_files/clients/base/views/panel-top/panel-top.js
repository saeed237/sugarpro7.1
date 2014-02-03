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
    /**
     * Header section for Subpanel layouts
     *
     * @class View.SubpanelHeaderView
     * @alias SUGAR.App.view.views.SubpanelHeaderView
     */
    className: "subpanel-header",
    events: {
        "click": "togglePanel",
        'click a[name=create_button]:not(".disabled")': 'createRelatedClicked',
    },

    plugins: ['LinkedModel'],

    /**
     * @override
     * @param opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);
        var context = this.context;
        // This is in place to get the lang strings from the right module. See
        // if there is a better way to do this later.
        this.parentModule = context.parent.get('module');
        context.parent.on('panel-top:refresh', function(link) {
            if (context.get('link') === link) {
                context.get('collection').fetch();
            }
        });
    },

    /**
     * Event handler for the create button.
     *
     * @param {Event} event The click event.
     */
    createRelatedClicked: function(event) {
        this.createRelatedRecord(this.module)
    },

    /**
    * Event handler that closes the subpanel layout when the SubpanelHeader is clicked
    * @param e DOM event
    */
    togglePanel: function(e) {
        // Make sure we aren't toggling the panel when the user clicks on a dropdown action.
        var toggleSubpanel = !$(e.target).parents("span.actions").length;
        if (toggleSubpanel) {
            this._toggleSubpanel();
        }
    },

    _toggleSubpanel: function() {
        var isHidden = this.layout.$(".subpanel").hasClass("closed");
        this.layout.trigger("panel:toggle", isHidden);
    },

    /**
     * @override
     */
    bindDataChange: function() {
        if (this.collection) {
            this.listenTo(this.collection, 'reset', this.render);
        }
    }
})
