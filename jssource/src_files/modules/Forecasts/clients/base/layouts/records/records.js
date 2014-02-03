/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

/**
 * Forecast Records View
 *
 * Events
 *
 * forecasts:worksheet:committed
 *  on: this.context
 *  by: commitForecast
 *  when: after a successful Forecast Commit
 */
({
    /**
     * The options from the initialize call
     */
    initOptions: undefined,

    /**
     * Overrides the Layout.initialize function and does not call the parent so we can defer initialization
     * until _onceInitSelectedUser is called
     *
     * @override
     */
    initialize: function(options) {
        // the parent is not called here so we make sure that nothing else renders until after we init the
        // the forecast module
        this.initOptions = options;

        var acls = app.user.getAcls().Forecasts,
            hasAccess = (!_.has(acls, 'access') || acls.access == 'yes');
        if(hasAccess) {
            // Check to make sure users have proper values in their sales_stage_won/_lost cfg values
            if(app.utils.checkForecastConfig()) {
                // correct config exists, continue with syncInitData
                this.syncInitData();
            } else {
                // codeblock this sucka
                this.codeBlockForecasts('LBL_FORECASTS_MISSING_STAGE_TITLE', 'LBL_FORECASTS_MISSING_SALES_STAGE_VALUES');
            }
        } else {
            this.codeBlockForecasts('LBL_FORECASTS_ACLS_NO_ACCESS_TITLE', 'LBL_FORECASTS_ACLS_NO_ACCESS_MSG');
        }
    },

    /**
     * Blocks forecasts from continuing to load
     */
    codeBlockForecasts: function(title, msg) {
        var alert = app.alert.show('no_access_to_forecasts', {
            level: 'error',
            autoClose: false,
            title: app.lang.get(title, "Forecasts") + ":",
            messages: [app.lang.get(msg, "Forecasts")]
        });

        alert.getCloseSelector().on('click', function() {
            alert.getCloseSelector().off();
            app.router.navigate('#Home', {trigger: true});
        });
    },

    /**
     * Overrides loadData to defer it running until we call it in _onceInitSelectedUser
     *
     * @override
     */
    loadData: function() {
    },

    /**
     * {@inheritdoc}
     */
    bindDataChange: function() {
        // we need this here to track when the selectedTimeperiod changes and then also move it up to the context
        // so the recordlists can listen for it.
        if (!_.isUndefined(this.model)) {
            this.collection.on('reset', function() {
                // get the first model and set the last commit date
                var lastCommit = _.first(this.collection.models);
                var commitDate = undefined;
                if (lastCommit instanceof Backbone.Model && lastCommit.has('date_modified')) {
                    commitDate = lastCommit.get('date_modified');
                }
                this.context.set({'currentForecastCommitDate': commitDate});
            }, this);
            // since the selected user change on the context, update the model
            this.context.on('change:selectedUser', function(model, changed) {
                var update = {
                    'selectedUserId': changed.id,
                    'forecastType': app.utils.getForecastType(changed.isManager, changed.showOpps)
                }
                this.model.set(update);
            }, this);
            // since the selected timeperiod changes on the model, update the timeperiod
            this.model.on('change:selectedTimePeriod', function(model, changed) {
                this.context.set('selectedTimePeriod', changed);
            }, this);
            // if the model changes, run a fetch
            this.model.on('change', function() {
                // clear this out this someone on the model change, this will be set once the collection resets
                this.context.set({'currentForecastCommitDate' : undefined}, {silent: true});
                this.collection.fetch();
            }, this);

            // listen on the context for a commit trigger
            this.context.on('forecasts:worksheet:commit', function(user, worksheet_type, forecast_totals) {
                this.commitForecast(user, worksheet_type, forecast_totals);
            }, this);
        }
    },

    /**
     * Opens the Forecasts Config drawer
     */
    openConfigDrawer: function() {
        // if there is no drawer open, then we need to open the drawer.
        if(app.drawer._components.length == 0) {
            // trigger the forecast config by going to the config route, while replacing what
            // is currently there so when we use app.route.goBack() from the cancel button
            app.router.navigate('Forecasts/config', {replace: true, trigger: true});
        }
    },

    /**
     * Get the Forecast Init Data from the server
     *
     * @param {Object} options
     */
    syncInitData: function(options) {
        var callbacks,
            url;

        options = options || {};
        // custom success handler
        options.success = _.bind(function(model, data, options) {
            // Add Forecasts-specific stuff to the app.user object
            app.user.set(data.initData.userData);
            if (data.initData.forecasts_setup === 0) {
                // Immediately open the config drawer so user can set up config
                this.openConfigDrawer();
            } else {
                this.initForecastsModule(data, options);
            }
        }, this);

        // since we have not initialized the view yet, pull the model from the initOptions.context
        var model = this.initOptions.context.get('model');
        callbacks = app.data.getSyncCallbacks('read', model, options);
        this.trigger("data:sync:start", 'read', model, options);

        url = app.api.buildURL("Forecasts/init", null, null, options.params);
        app.api.call("read", url, null, callbacks);
    },

    /**
     * Process the Forecast Data
     *
     * @param {Object} data contains the data passed back from Forecasts/init endpoint
     * @param {Object} options
     */
    initForecastsModule: function(data, options) {
        var ctx = this.initOptions.context;
        // we watch for the first selectedUser change to actually init the Forecast Module case then we know we have
        // a proper selected user
        ctx.once('change:selectedUser', this._onceInitSelectedUser, this);

        // set items on the context from the initData payload
        ctx.set({
            currentForecastCommitDate: undefined,
            selectedTimePeriod: data.defaultSelections.timeperiod_id.id,
            selectedRanges: data.defaultSelections.ranges
        }, {silent: true});

        ctx.get('model').set({'selectedTimePeriod': data.defaultSelections.timeperiod_id.id}, {silent: true});

        // set the selected user to the context
        app.utils.getSelectedUsersReportees(app.user.toJSON(), ctx);
    },

    /**
     * Event handler for change:selectedUser
     * Triggered once when the user is set for the first time.  After setting user it calls
     * the init of the records layout
     *
     * @param {Backbone.Model} model the model from the change event
     * @param {String} change the updated selectedUser value from the change event
     * @private
     */
    _onceInitSelectedUser: function(model, change) {
        // init the recordlist view
        app.view.Layout.prototype.initialize.call(this, this.initOptions);

        // set the selected user and forecast type on the model
        this.model.set('selectedUserId', change.id, {silent: true});
        this.model.set('forecastType', app.utils.getForecastType(change.isManager, change.showOpps));
        // bind the collection sync to our custom sync
        this.collection.sync = _.bind(this.sync, this);

        // load the data
        app.view.Layout.prototype.loadData.call(this);
        // bind the data change
        this.bindDataChange();
        // render everything
        if (!this.disposed) this.render();
    },

    /**
     * Custom sync method used by this.collection
     *
     * @param {String} method
     * @param {Backbone.Model} model
     * @param {Object} options
     */
    sync: function(method, model, options) {
        var callbacks,
            url;

        options = options || {};

        options.params = options.params || {};

        var args_filter = [],
            filter = null;
        if (this.model.has('selectedTimePeriod')) {
            args_filter.push({"timeperiod_id": this.model.get('selectedTimePeriod')});
        }
        if (this.model.has('selectedUserId')) {
            args_filter.push({"user_id": this.model.get('selectedUserId')});
            args_filter.push({"forecast_type": this.model.get('forecastType')});
        }

        if (!_.isEmpty(args_filter)) {
            filter = {"filter": args_filter};
        }

        options.params.order_by = 'date_entered:DESC'
        options = app.data.parseOptionsForSync(method, model, options);

        // custom success handler
        options.success = _.bind(function(model, data, options) {
            if(!this.disposed) {
                this.collection.reset(data);
            }
        }, this);

        callbacks = app.data.getSyncCallbacks(method, model, options);
        this.trigger("data:sync:start", method, model, options);

        url = app.api.buildURL("Forecasts/filter", null, null, options.params);
        app.api.call("create", url, filter, callbacks);
    },

    /**
     * Commit A Forecast
     *
     * @triggers forecasts:worksheet:committed
     * @param {Object} user
     * @param {String} worksheet_type
     * @param {Object} forecast_totals
     */
    commitForecast: function(user, worksheet_type, forecast_totals) {
        var forecast = new this.collection.model(),
            forecastType = app.utils.getForecastType(user.isManager, user.showOpps),
            forecastData = {};


        // we need a commit_type so we know what to do on the back end.
        forecastData.commit_type = worksheet_type;
        forecastData.timeperiod_id = forecast_totals.timeperiod_id || this.model.get('selectedTimePeriod');
        forecastData.forecast_type = forecastType;

        forecast.save(forecastData, { success: _.bind(function(model, response) {
            // we need to make sure we are not disposed, this handles any errors that could come from the router and window
            // alert events
            if (!this.disposed) {
                // Call sync again so commitLog has the full collection
                // method gets overridden and options just needs an
                this.collection.fetch();
                this.context.trigger("forecasts:worksheet:committed", worksheet_type, response);
                app.alert.show('success', {
                    level: 'success',
                    autoClose: true,
                    title: app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE", "Forecasts") + ":",
                    messages: [app.lang.get("LBL_FORECASTS_WORKSHEET_COMMIT_SUCCESS", "Forecasts")]
                });
            }
        }, this), silent: true, alerts: { 'success': false }});
    }
})
