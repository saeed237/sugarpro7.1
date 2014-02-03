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
({
    plugins: ['Dropdown', 'Timeago', 'EllipsisInline', 'Tooltip'],

    /**
     * Notifications bean collection.
     *
     * @property {Data.BeanCollection}
     */
    collection: null,

    /**
     * Collections for additional modules.
     */
    _alertsCollections: {},

    /**
     * Intervals for additional modules' reminders.
     */
    _intervals: {},

    /**
     * Interval ID defined when the pulling mechanism is running.
     *
     * @property {Integer}
     * @protected
     */
    _intervalId: null,

    /**
     * Default options used when none are supplied through metadata.
     *
     * Supported options:
     * - delay: How often (minutes) should the pulling mechanism run.
     * - limit: Limit imposed to the number of records pulled.
     * - severity_css: An object where its keys map to a specific notification
     * severity and values to a matching CSS class.
     *
     * @property {Object}
     * @protected
     */
    _defaultOptions: {
        delay: 5,
        limit: 4,
        severity_css: {
            alert: 'label-important',
            information: 'label-info',
            other: 'label-inverse',
            success: 'label-success',
            warning: 'label-warning'
        }
    },

    /**
     * {@inheritDoc}
     */
    initialize: function(options) {
        options.module = 'Notifications';

        this._super('initialize', [options]);
        app.events.on('app:sync:complete', this._bootstrap, this);
        app.events.on('app:logout', this.stopPulling, this);
    },

    /**
     * Bootstrap feature requirements.
     *
     * @return {View.Notifications} Instance of this view.
     * @protected
     */
    _bootstrap: function() {
        this._initOptions();
        this._initCollection();
        this._initReminders();
        this.startPulling();
        return this;
    },

    /**
     * Initialize options, default options are used when none are supplied
     * through metadata.
     *
     * @return {View.Notifications} Instance of this view.
     * @protected
     */
    _initOptions: function() {
        var options = _.extend(this._defaultOptions, this.meta || {});

        this.delay = options.delay * 60 * 1000;
        this.limit = options.limit;
        this.severityCss = options.severity_css;

        return this;
    },

    /**
     * Initialize feature collection.
     *
     * @return {View.Notifications} Instance of this view.
     * @protected
     */
    _initCollection: function() {
        this.collection = app.data.createBeanCollection(this.module);
        this.collection.options = {
            params: {
                order_by: 'date_entered:desc'
            },
            limit: this.limit,
            myItems: true,
            fields: ['date_entered', 'id', 'name', 'severity']
        };

        this.collection.sync = _.wrap(
            this.collection.sync,
            function(sync, method, model, options) {
                options = options || {};
                options.endpoint = function(method, model, options, callbacks) {
                    var url = app.api.buildURL(model.module, 'pull', {}, options.params);
                    return app.api.call('read', url, {}, callbacks);
                };

                sync(method, model, options);
            }
        );

        return this;
    },

    /**
     * Initialize reminders for Calls and Meetings.
     *
     * Setup the reminderMaxTime that is based on maximum reminder time option
     * added to the pulls delay to get a big interval to grab for possible
     * reminders.
     * Setup collections for each module that we support with reminders.
     *
     * FIXME this will be removed when we integrate reminders with
     * Notifications on server side. This is why we have modules hardcoded.
     * We also don't check for meta as optional because it is required.
     * We will keep all this code private because we don't want to support it
     *
     * @private
     */
    _initReminders: function() {

        var timeOptions = _.keys(app.lang.getAppListStrings('reminder_time_options')),
            max = _.max(timeOptions, function(key) {
            return parseInt(key, 10);
        });

        this.reminderMaxTime = parseInt(max, 10) + this.delay / 1000;

        _.each(['Calls', 'Meetings'], function(module) {
            this._alertsCollections[module] = app.data.createBeanCollection(module);
            this._alertsCollections[module].options = {
                limit: this.meta.remindersLimit,
                fields: ['date_start', 'id', 'name', 'reminder_time', 'location']
            };
            this._intervals[module] = {};
        }, this);

        return this;
    },

    /**
     * Retrieve label according to supplied severity.
     *
     * @param {String} severity Notification severity.
     * @return {String} Matching label or severity if supplied severity
     *   doesn't exist.
     */
    getSeverityLabel: function(severity) {
        var list = app.lang.getAppListStrings('notifications_severity_list');
        return list[severity] || severity;
    },

    /**
     * Retrieve CSS class according to supplied severity.
     *
     * @param {String} severity Notification severity.
     * @return {String} Matching css class or an empty string if supplied
     * severity doesn't exist.
     */
    getSeverityCss: function(severity) {
        return this.severityCss[severity] || '';
    },

    /**
     * Start pulling mechanism, executes an immediate pull request and defines
     * an interval which is responsible for executing pull requests on time
     * based interval.
     *
     * @return {View.Notifications} Instance of this view.
     */
    startPulling: function() {
        if (!_.isNull(this._intervalId)) {
            return this;
        }

        var self = this;

        this.pull();
        this._pullReminders();
        this._intervalId = window.setInterval(function() {
            if (!app.api.isAuthenticated()) {
                self.stopPulling();
                return;
            }

            self.pull();
            self._pullReminders();

        }, this.delay);

        return this;
    },

    /**
     * Stop pulling mechanism.
     *
     * @return {View.Notifications} Instance of this view.
     */
    stopPulling: function() {
        if (!_.isNull(this._intervalId)) {
            window.clearInterval(this._intervalId);
            this._intervalId = null;
        }

        return this;
    },

    /**
     * Pull and render notifications, if view isn't disposed or dropdown isn't
     * opened.
     *
     * @return {View.Notifications} Instance of this view.
     */
    pull: function() {
        if (this.disposed || this.isOpened()) {
            return this;
        }

        var self = this;

        this.collection.fetch({
            success: function() {
                if (self.disposed || self.isOpened()) {
                    return this;
                }

                self.render();
            }
        });

        return this;
    },

    /**
     * Pull next reminders from now to the next remindersMaxTime.
     *
     * This will give us all the reminders that should be triggered during the
     * next maximum reminders time (with pull delay).
     */
    _pullReminders: function() {

        if (this.disposed) {
            return this;
        }

        var date = new Date(),
            startDate = date.toISOString(),
            endDate;

        date.setTime(date.getTime() + this.reminderMaxTime * 1000);
        endDate = date.toISOString();

        _.each(['Calls', 'Meetings'], function(module) {

            this._alertsCollections[module].filterDef = _.extend({},
                this.meta.remindersFilterDef || {},
                {
                    'date_start': {'$dateBetween': [startDate, endDate]},
                    'users.id': {'$equals': app.user.get('id')}
                }
            );
            this._alertsCollections[module].fetch({
                silent: true,
                merge: true,
                //Notifications should never trigger a metadata refresh
                apiOptions: {skipMetadataHash: true},
                success: _.bind(function(data) {
                    if (!this.disposed) {
                        this._parseReminders(data);
                    }
                }, this)
            });
        }, this);

        return this;
    },

    /**
     * Creates reminders based on {@link Backbone.Collection#fetch} from latest
     * pull.
     *
     * Creates new and delete old reminders for the new data received.
     *
     * @param {Data.BeanCollection} data Data from response.
     * @private
     */
    _parseReminders: function(data) {

        if (!data.length) {
            return this;
        }

        var deadIds = _.difference(_.keys(this._intervals[data.module]), data.pluck('id'));

        _.each(deadIds, function(id) {
            this._clearReminders(data.module, id);
        }, this);

        data.each(function(model) {
            this._parseReminder(model);
        }, this);

        return this;
    },

    /**
     * Creates an alert reminder based on model given.
     *
     * If the model didn't change the reminder time and if we already set it
     * up, keep it.
     *
     * @param {Backbone.Model} model The model to create a reminder from.
     * @private
     */
    _parseReminder: function(model) {
        var hasChanged = !_.has(this._intervals[model.module], model.id) ||
            !!model.changedAttributes(this._intervals[model.module][model.id].prevAttr);

        if (!hasChanged) {
            return this;
        }

        // FIXME we need to support timezone of the user preferences not of the browser/location.
        var diff = new Date(model.get('date_start')) - new Date(),
            delay = diff - parseInt(model.get('reminder_time'), 10) * 1000;

        if (delay < 0) {
            return this;
        }

        this._clearReminders(model.module, model.id);

        this._intervals[model.module][model.id] = {
            timer: setTimeout(_.bind(function() {
                this._showReminderAlert(model);
            }, this), delay),
            prevAttr: _.pick(model.attributes, 'reminder_time', 'date_start')
        };

        return this;
    },

    /**
     * Clears alerts' interval of a given record or of all in module given.
     *
     * @param {String} module Module to clear intervals for.
     * @param {String} [id] Id of a record or `undefined` to clear all.
     * @private
     */
    _clearReminders: function(module, id) {

        if (id) {
            if (_.has(this._intervals[module], id)) {
                clearTimeout(this._intervals[module][id].timer);
                delete this._intervals[module][id];
            }
            return;
        }

        _.each(this._intervals[module], function(data) {
            clearTimeout(data.timer);
        }, this);
        this._intervals[module] = {};
    },

    /**
     * Show reminder alert based on given model.
     *
     * @param {Backbone.Model} model Model that is triggering a reminder.
     *
     * @private
     */
    _showReminderAlert: function(model) {
        var url = app.router.buildRoute(model.module, model.id),
            dateFormat = app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref'),
            dateValue = app.date.format(new Date(model.get('date_start')), dateFormat),
            template = app.template.getView('notifications.notifications-alert'),
            message = template({
                title: app.lang.get('LBL_REMINDER_TITLE', model.module),
                module: model.module,
                model: model,
                location: model.get('location'),
                description: model.get('description'),
                dateStart: dateValue
            });
        _.defer(function() {
            if (confirm(message)) {
                app.router.navigate(url, {trigger: true});
            }
        });
        delete this._intervals[model.module][model.id];
    },

    /**
     * Check if dropdown is opened.
     *
     * @return {Boolean} True if dropdown is opened, false otherwise.
     */
    isOpened: function() {
        return this.$('.notification-list').hasClass('open');
    },

    /**
     * If notifications collection is available and has models, two 'severity'
     * related properties are injected into each model:
     * - severityCss: Model severity matching CSS class.
     * - severityLabel: Model severity label.
     *
     * {@inheritDoc}
     */
    _renderHtml: function() {
        if (!app.api.isAuthenticated() || app.config.appStatus === 'offline') {
            return;
        }

        if (!_.isObject(this.collection)) {
            this._super('_renderHtml');
            return;
        }

        _.each(this.collection.models, function(model) {
            model.set('severityCss', this.getSeverityCss(model.get('severity')));
            model.set('severityLabel', this.getSeverityLabel(model.get('severity')));
        }, this);

        this._super('_renderHtml');
    },

    /**
     * {@inheritDoc}
     *
     * Stops pulling for new notifications and disposes all reminders.
     */
    _dispose: function() {
        this.stopPulling();

        _.each(this._alertsCollections, function(collection, module) {
            this._clearReminders(module);
            collection.off();
        }, this);
        this._alertsCollections = {};

        this._super('_dispose');
    }
})
