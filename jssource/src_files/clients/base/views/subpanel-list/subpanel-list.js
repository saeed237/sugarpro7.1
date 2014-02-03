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
     * Custom RecordlistView used within Subpanel layouts.
     *
     * @class View.SubpanelListView
     * @alias SUGAR.App.view.views.SubpanelListView
     * @extends View.RecordlistView
     */
    extendsFrom: 'RecordlistView',
    fallbackFieldTemplate: 'list',
    plugins: ['ErrorDecoration', 'Editable'],

    contextEvents: {
        "list:editall:fire": "toggleEdit",
        "list:editrow:fire": "editClicked",
        "list:unlinkrow:fire": "warnUnlink"
    },

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        app.view.invokeParent(this, {type: 'view', name: 'recordlist', method: 'initialize', args: [options]});
        // Setup max limit on collection's fetch options for this subpanel's context
        if (app.config.maxSubpanelResult) {
            var options = {
                limit: app.config.maxSubpanelResult
            };
            var collectionOptions = this.context.has('collectionOptions') ? this.context.get('collectionOptions') : {};
            this.context.set('collectionOptions', _.extend(collectionOptions, options));
        }
        this.layout.on("hide", this.toggleList, this);
        // Listens to parent of subpanel layout (subpanels)
        this.listenTo(this.layout.layout, 'filter:change', this.renderOnFilterChanged);

        //event register for preventing actions
        //when user escapes the page without confirming deletion
        app.routing.before("route", this.beforeRouteUnlink, this, true);
        $(window).on("beforeunload.unlink" + this.cid, _.bind(this.warnUnlinkOnRefresh, this));
    },
    // SP-1383: Subpanel filters hide some panels when related filters are changed
    // So when 'Related' filter changed, this ensures recordlist gets reloaded
    renderOnFilterChanged: function() {
        this.collection.trigger('reset');
        this.render();
    },

    /**
     * When parent recordlist's initialize is invoked (above), this will get called
     * and populate our the list's meta with the proper view subpanel metadata.
     * @return {Object} The view metadata for this module's subpanel.
     */
    _initializeMetadata: function() {
        return  _.extend({},
            app.metadata.getView(null, 'subpanel-list', true),
            app.metadata.getView(this.options.module, 'record-list', true),
            app.metadata.getView(this.options.module, 'subpanel-list', true)
        );
    },

    /**
     * Unlink (removes) the selected model from the list view's collection
     */
    unlinkModel: function() {
        var self = this,
            model = this._modelToUnlink;

        model.destroy({
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': {
                    messages: self.getUnlinkMessages(self._modelToUnlink).success
                }
            },
            relate: true,
            success: function() {
                var redirect = self._targetUrl !== self._currentUrl;
                self._modelToUnlink = null;
                self.collection.remove(model, { silent: redirect });

                if (redirect) {
                    self.unbindBeforeRouteUnlink();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(self._targetUrl, {trigger: true});
                    return;
                }

                // We trigger reset after removing the model so that
                // panel-top will re-render and update the count.
                self.collection.trigger('reset');
                self.render();
            }
        });
    },

    /**
     * Toggles the list visibility
     * @param {Boolean} show TRUE to show, FALSE to hide.
     */
    toggleList: function(show) {
        this.$el[show ? 'show' : 'hide']();
    },

    /**
     * Pre-event handler before current router is changed
     *
     * @return {Boolean} true to continue routing, false otherwise
     */
    beforeRouteUnlink: function () {
        if (this._modelToUnlink) {
            this.warnUnlink(this._modelToUnlink);
            return false;
        }
        return true;
    },

    /**
     * Format the message displayed in the alert
     *
     * @param {Bean} model to unlink
     * @returns {Object} formatted confirmation and success messages
     */
    getUnlinkMessages: function(model) {
        var messages = {},
            name = model.get('name') || (model.get('first_name') + ' ' + model.get('last_name')) || '',
            context = app.lang.get('LBL_MODULE_NAME_SINGULAR', model.module).toLowerCase() + ' ' + name.trim();

        messages.confirmation = app.lang.get('NTC_UNLINK_CONFIRMATION') + context + '?';
        messages.success = app.lang.get('NTC_UNLINK_SUCCESS') + context + '.';
        return messages;
    },

    /**
     * Popup dialog message to confirm unlink action
     *
     * @param {Backbone.Model} model the bean to unlink
     */
    warnUnlink: function(model) {
        var self = this;
        this._modelToUnlink = model;

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(this._currentUrl, {trigger: false, replace: true});
        }

        app.alert.show('unlink_confirmation', {
            level: 'confirmation',
            messages: self.getUnlinkMessages(model).confirmation,
            onConfirm: _.bind(self.unlinkModel, self),
            onCancel: function() {
                self._modelToUnlink = null;
            }
        });
    },

    /**
     * Popup browser dialog message to confirm unlink action
     *
     * @return {String} the message to be displayed in the browser alert
     */
    warnUnlinkOnRefresh: function() {
        if (this._modelToUnlink) {
            return this.getUnlinkMessages(this._modelToUnlink).confirmation;
        }
    },

    /**
     * Detach the event handlers for warning unlink
     */
    unbindBeforeRouteUnlink: function() {
        app.routing.offBefore("route", this.beforeRouteUnlink, this);
        $(window).off("beforeunload.unlink" + this.cid);
    },

    /**
     * @override
     * @private
     */
    _dispose: function() {
        this.unbindBeforeRouteUnlink();
        this._super('_dispose');
    }
})
