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
/**
 * {@inheritDoc}
 *
 * Planned Activities dashlet takes advantage of the tabbed dashlet abstraction
 * by using its metadata driven capabilities to configure its tabs in order to
 * display planned activities of specific modules.
 *
 * Besides the metadata properties inherited from Tabbed dashlet, Planned Activities
 * dashlet also supports other properties:
 *
 * - {Array} invitation_actions field def for the invitation actions buttonset
 *           triggers showing invitation actions buttons and corresponding collection
 *
 * - {Array} overdue_badge field def to support overdue calculation, and showing
 *   an overdue badge when appropriate.
 *
 * @class View.Views.BasePlannedActivitiesView
 * @alias SUGAR.App.view.views.BasePlannedActivitiesView
 * @extends View.Views.BaseHistoryView
 */
({
    extendsFrom: 'HistoryView',

    /**
     * {@inheritDoc}
     */
    _initEvents: function() {
        this.events = _.extend(this.events, {
            'click [data-action=date-switcher]': 'dateSwitcher'
        });

        return this;
    },

    /**
     * {@inheritDoc}
     * @protected
     */
    _initTabs: function() {
        // FIXME: this should be replaced with this._super('_initTabs'); which
        // is currently throwing an error with the following message: "Attempt
        // to call different parent method from child method"
        app.view.invokeParent(this, {
            type: 'view',
            name: 'tabbed-dashlet',
            method: '_initTabs',
            platform: 'base'
        });

        _.each(this.tabs, function(tab) {
            if (!tab.invitation_actions) {
                return;
            }
            tab.invitations = this._createInvitationsCollection(tab);
        }, this);

        return this;
    },

    /**
     * Create invites collection to set the accept status on the given link.
     *
     * @param {Object} tab Tab properties.
     * @return {Data.BeanCollection} A new instance of bean collection.
     * @protected
     */
    _createInvitationsCollection: function(tab) {
        return app.data.createBeanCollection(tab.module, null, {
            link: {
                name: tab.module.toLowerCase(),
                bean: app.data.createBean('Users', {
                    id: app.user.get('id')
                })
            }
        });
    },

    /**
     * {@inheritDoc}
     */
    _getRecordsTemplate: function(module) {
        this._recordsTpl = this._recordsTpl || {};

        if (!this._recordsTpl[module]) {
            this._recordsTpl[module] = app.template.getView(this.name + '.records', module) ||
                app.template.getView(this.name + '.records', this.module) ||
                app.template.getView(this.name + '.records') ||
                app.template.getView('history.records', this.module) ||
                app.template.getView('history.records') ||
                app.template.getView('tabbed-dashlet.records', this.module) ||
                app.template.getView('tabbed-dashlet.records');
        }

        return this._recordsTpl[module];
    },

    /**
     * {@inheritDoc}
     */
    _getFilters: function(index) {
        var todayDate = new Date(),
            today = app.date.format(todayDate,'Y-m-d');

        var tab = this.tabs[index],
            filter = {},
            filters = [],
            defaultFilters = {
                today: {$lte: today},
                future: {$gt: today}
            };

        filter[tab.filter_applied_to] = defaultFilters[this.settings.get('date')];

        filters.push(filter);

        return filters;
    },

    /**
     * Event handler for date switcher.
     *
     * @param {Event} event Click event.
     */
    dateSwitcher: function(event) {
        var date = this.$(event.currentTarget).val();
        if (date === this.settings.get('date')) {
            return;
        }

        this.settings.set('date', date);
        this.layout.loadData();
    },

    /**
     * {@inheritDoc}
     *
     * On load of new data, make sure we reload invitations related data, if
     * it is defined for the current tab.
     */
    loadData: function() {
        if (this.disposed || this.meta.config) {
            return;
        }
        
        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.invitations) {
            tab.invitations.dataFetched = false;
        }
        this._super('loadData');
    },

    /**
     * {@inheritDoc}
     *
     * Force reload of invitations information (if they exist for this tab)
     * after showMore is clicked.
     */
    showMore: function() {
        var tab = this.tabs[this.settings.get('activeTab')];
        if (tab.invitations) {
            tab.invitations.dataFetched = false;
        }
        this._super('showMore');
    },

    /**
     * Fetch the invitation actions collection for
     * showing the invitation actions buttons
     * @param tab
     * @private
     */
    _fetchInvitationActions: function(tab) {
        this.invitationActions = tab.invitation_actions;
        tab.invitations.filterDef = {
            'id': {'$in': this.collection.pluck('id')}
        };

        var self = this;
        tab.invitations.fetch({
            relate: true,
            success: function(collection) {
                if (self.disposed) {
                    return;
                }

                _.each(collection.models, function(invitation) {
                    var model = this.collection.get(invitation.get('id'));
                    model.set('invitation', invitation);
                }, self);

                self.render();
            },
            complete: function() {
                tab.invitations.dataFetched = true;
            }
        });
    },
    /**
     * {@inheritDoc}
     *
     * New model related properties are injected into each model:
     *
     * - {Boolean} overdue True if record is prior to now.
     * - {Bean} invitation The invitation bean that relates the data with the
     *   Users' invitation statuses. This is the model supplied to the
     *   `invitation-actions` field.
     */
    _renderHtml: function() {
        if (this.meta.config) {
            app.view.View.prototype._renderHtml.call(this);
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];

        if (tab.overdue_badge) {
            this.overdueBadge = tab.overdue_badge;
        }

        if (!this.collection.length || !tab.invitations ||
            tab.invitations.dataFetched) {
            this._super('_renderHtml');
            return;
        }

        this._fetchInvitationActions(tab);
    }
})
