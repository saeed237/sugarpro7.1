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
    className: "filtered tabbable tabs-left",

    // "Hide/Show" state per panel
    HIDE_SHOW_KEY: 'hide-show',
    HIDE_SHOW: {
        HIDE: 'hide',
        SHOW: 'show'
    },

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.Layout.prototype.initialize.call(this, opts);

        this.hideShowLastStateKey = app.user.lastState.key(this.HIDE_SHOW_KEY, this);

        this.on("panel:toggle", this.togglePanel, this);
        this.listenTo(this.collection, "reset", function() {
            //Update the subpanel to be open or closed depending on how user left it last
            var hideShowLastState = app.user.lastState.get(this.hideShowLastStateKey);
            if(_.isUndefined(hideShowLastState)) {
                this.togglePanel(this.collection.length > 0, false);
            } else {
                this.togglePanel(hideShowLastState === this.HIDE_SHOW.SHOW, false);
            }
        });
        //Decorate the subpanel based on if the collection is empty or not
        this.listenTo(this.collection, "reset add remove", this._checkIfSubpanelEmpty, this);
    },
    /**
     * Check if subpanel collection is empty and decorate subpanel header appropriately
     * @private
     */
    _checkIfSubpanelEmpty: function(){
        this.$(".subpanel").toggleClass("empty", this.collection.length === 0);
    },
    /**
     * Places layout component in the DOM.
     * @override
     * @param {Component} component
     */
    _placeComponent: function(component) {
        this.$(".subpanel").append(component.el);
        this._hideComponent(component, false);
    },
    /**
     * Toggles panel
     * @param {Boolean} show TRUE to show, FALSE to hide
     * @param {Boolean} saveState(optional) TRUE to save the current state
     */
    togglePanel: function(show, saveState) {
        this.$(".subpanel").toggleClass("closed", !show);
        //check if there's second param then check it and save show/hide to user state
        if(arguments.length === 1 || saveState) {
            app.user.lastState.set(this.hideShowLastStateKey, show ? this.HIDE_SHOW.SHOW : this.HIDE_SHOW.HIDE);
        }
        _.each(this._components, function(component) {
            this._hideComponent(component, show);
        }, this);
    },
    /**
     * Show or hide component except `panel-top`.
     * @param {Component} component
     */
    _hideComponent: function(component, show) {
        if (component.name != "panel-top") {
            if (show) {
                component.show();
            } else {
                component.hide();
            }
        }
    }
})
