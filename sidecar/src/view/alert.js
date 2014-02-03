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

/**
 * Alert  
 * @class View.Alert
 * @alias SUGAR.App.view.alert
 * @singleton
 *
 * Interface for creating alerts via show and dismiss. Also, this module
 * keeps an internal dictionary of alerts created which can later be accessed
 * by key. This is useful so that client code can dismiss a particular alert.
 *
 * Note that the client application may provide custom implementation of {@link View.AlertView} class.
 * This implementation will be in charge of rendering the alert to it's UI.
 *
 * At minimum, a client app's must provide:
 *
 * 1. `#alerts` element in its `index.html`.
 * 2. Pre-compiled template called `alert`. The template can be compiled at application start-up:
 * <code>app.template.compile("alert", "template body...");</code>
 */
(function(app) {

    // Dictionary of alerts
    var _alerts = {};

    var _alert = {

        /**
         * Initializes alert module at application start-up.
         */
        init: function() {
            /**
             * Alert element selector.
             *
             * The default value is `$('#alerts')`. Override using {@link Config#alertsEl} setting.
             * @property {Object}
             */
            this.$alerts = $(app.config.alertsEl || '#alerts');

            /**
             * Alert view class.
             *
             * The default value is {@link View.AlertView}.
             * However, if `app.view.[Capitalized-appId]AlertView` or `app.view.[Capitalized-platform]AlertView` class
             * exists, it will be used instead.
             * @property {Function}
             */
            this.klass = app.view[app.utils.capitalize(app.config.appId) + "AlertView"] ||
                app.view.views[app.utils.capitalize(app.config.platform) + 'AlertView'] ||
                app.view.views['BaseAlertView'] ||
                app.view[app.utils.capitalize(app.config.platform) + "AlertView"] ||
                app.view.AlertView;
        },

        /**
         * Displays an alert message and adds to internal dictionary of alerts.
         * Use supplied key later to dismiss the alert. Caller is responsible for using language translation
         * before calling!
         *
         * To create and close alerts, this function uses private factory method {@link View.Alert#_create}
         * which instantiates alert view class specified by the {@link View.Alert#klass} property and places the alert
         * instance in the DOM as the first element in the {@link View.Alert#$alerts} element.
         *
         * The {@link View.AlertView} class provides boilerplate implementation for a typical single alert view.
         * You can customize alert behavior by extending {@link View.AlertView} class.
         * At minimum, you have to make sure that a pre-compiled template named `"alert"` exists.
         *
         * </code></pre>
         *
         * Examples:
         * <pre><code>
         * var a1 = app.alert.show('delete_warning', {
         *     level: 'warning',
         *     title: 'Warning',
         *     messages: 'Are you sure you want to delete this record?',
         *     autoclose: true
         * });
         *
         * var a2 = app.alert.show('internal_error', {
         *     level: 'error',
         *     messages: ['Internal Error', 'Response code: 500']
         * })
         *
         * </code></pre>
         *
         * @param {Object} options(optional)
         *
         * The options are framework as well as application specific.
         *
         * - level: alert level. `alert-[level]` class will be added to the alert view.
         * - autoClose: boolean flag indicating if the alert must be closed after dismiss delay: See {@link Config#alertAutoCloseDelay} setting.
         * - closeable: boolean flag indicating if the alert can be closed by the user. Note that non-"info" alerts are closeable
         * by default if this setting is not specified. Framework attaches click event handler if this flag is true.
         * - messages: string or array of string messages. This parameter is normalized to array before rendering alerts.
         * @return {View.AlertView} Alert instance.
         * @method
         */
        show: function(key, options) {
            if (!this.$alerts || this.$alerts.length == 0) return null;

            options = _.extend({
                level: 'info',
                autoClose: false
            }, options || {});

            if (_.isUndefined(options.closeable)) {
                // Success, error, warning alerts can be closed by users
                options.closeable = options.level != 'info';
            }

            if (options.messages) {
                options.messages = _.isString(options.messages) ? [options.messages] : options.messages;
            }

            var alert = _alerts[key];
            // Create a new alert view if it doesn't exist
            if (!alert) {
                alert = this._create(key, options);
                _alerts[key] = alert;
            }

            alert.level = options.level;

            // Initialize autoclose timer
            if (!!options.autoClose) this._setAutoCloseTimer(alert, options.onAutoClose, options.autoCloseDelay);

            alert.render(options);

            // Attach 'click' handler if the alert can be closed
            if (options.closeable) {
                var button = alert.getCloseSelector();
                button.off('click');
                button.on('click', _.bind(function() {
                    this.dismiss(key);
                }, this));
            }

            return alert;
        },

        /**
         * Creates an instance of alert view class and places view in the DOM.
         * @param {String} key Alert ID.
         * @param {Object} options Options.
         * @return {View.AlertView} Instance of alert view class.
         * @private
         */
        _create: function(key, options) {
            var alert = new this.klass(options);
            alert.key = key;
            alert.$el.prependTo(this.$alerts);
            return alert;
        },

        /**
         * Sets the timeout to dismiss the alert view after either the alertAutoCloseDelay configured or 9 seconds
         * @param {Object} alert the alert to auto close
         * @param {Function} onAutoClose callback function to call on the autoclose
         * @private
         */
        _setAutoCloseTimer: function(alert, onAutoClose, autoCloseDelay) {
            if (alert.timerId) clearTimeout(alert.timerId);
            alert.timerId = setTimeout(_.bind(function() {
                if(_.isFunction(onAutoClose)) {
                    onAutoClose(alert.key); //callback for when the timeout occurs and the alert is closing
                }
                this.dismiss(alert.key);

            }, this), autoCloseDelay || app.config.alertAutoCloseDelay || 9000);
        },

        /**
         * Removes an alert message by key.
         * @param {String} key The key provided when previously calling show.
         * @method
         */
        dismiss: function(key) {
            var alert = _alerts[key];
            if (!alert) return;
            if (alert.timerId) clearTimeout(alert.timerId);
            alert.close();
            delete _alerts[key];
        },

        /**
         * Removes all alert messages with a given level.
         * @param {String} level(optional) Level of alerts to dismiss.
         * Dismisses all alerts if the level is not specified.
         * @method
         */
        dismissAll: function(level) {
            _.each(_alerts, function(alert, key) {
                if (!level || alert.level == level) {
                    this.dismiss(key);
                }
            }, this);
        },

        /**
         * Gets an alert with a given key.
         * @param {String} key The key of the alert to retrieve.
         * @return {View.AlertView} Alert view with the specified key.
         */
        get: function(key) {
            return _alerts[key];
        },

        /**
         * Gets alerts that are currently displayed.
         * @return {Object} All alerts.
         */
        getAll: function() {
            return _alerts;
        }
    };

    app.augment("alert", _alert, false);


    /**
     * Base class for alerts.
     *
     * Extend this class to provide custom alert behavior:
     * <pre><code>
     * var PortalAlertView = app.view.AlertView.extend({
     *
     *    initialize: function(options) {
     *       app.view.AlertView.prototype.initialize.call(this, options);
     *
     *       // You may override and/or pre-compile alert template
     *       this.tpl = 'my-alert';
     *       app.template.compile('my-alert', 'handlebars code...');     *
     *    },
     *
     *    render: function(options) {
     *        // Provide your custom rendering logic.
     *        // For example, switch between different templates
     *        this.tpl = "alert2";
     *        app.view.AlertView.prototype.render.call(this, options);
     *    },
     *
     *    close: function() {
     *        // Provide your custom dismiss logic: animation, fade effects, etc.
     *    }
     * });
     * </code></pre>
     * @class View.AlertView
     * @alias SUGAR.App.view.AlertView
     */
    app.view.AlertView = app.view.View.extend({

        /**
         * CSS class name.
         */
        className: "alert",

        /**
         * Name of the default template.
         */
        tpl: "alert",

        /**
         * Closes an alert.
         */
        close: function() {
            this.getCloseSelector().off('click');
            this.$el.remove();
        },

        /**
         * Gets selector for DOM elements that need to be clicked in order to close an alert.
         * @return {Object} jQuery/Zepto selector of the close button.
         */
        getCloseSelector: function() {
            return this.$('.close');
        },

        /**
         * Renders an alert.
         *
         * The method executes a pre-compiled template and replaces the inner HTML of this view root DOM element.
         * Additionally, `alert-[level]` class is added to the root element and `closeable` class if this alert
         * supports close button.
         * @param options(optional) Options are used as the context for alert template.
         */
        render: function(options) {
            options = options || {};
            if (options.closeable) {
                this.$el.addClass("closeable");
            }
            this.$el.addClass("alert-" + options.level);

            var tpl = app.template.get(options.tpl || this.tpl) || app.template.empty;
            this.$el.html(tpl(options));
        }

    });


})(SUGAR.App);
