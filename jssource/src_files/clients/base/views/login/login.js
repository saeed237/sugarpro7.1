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
    plugins: ['ErrorDecoration'],
    fallbackFieldTemplate: 'edit',
    /**
     * Login form view.
     * @class View.Views.LoginView
     * @alias SUGAR.App.view.views.LoginView
     */
    events: {
        "click [name=login_button]": "login",
        "keypress": "handleKeypress"
    },

    /**
     * Process login on key 'Enter'
     * @param e
     */
    handleKeypress: function(e) {
        if (e.keyCode === 13) {
            this.$("input").trigger("blur");
            this.login();
        }
    },

    /**
     * Get the fields metadata from panels and declare a Bean with the metadata attached
     * @param meta
     * @private
     */
    _declareModel: function(meta) {
        meta = meta || {};

        var fields = {};
        _.each(_.flatten(_.pluck(meta.panels, "fields")), function(field) {
            fields[field.name] = field;
        });
        /**
         * Fields metadata needs to be converted to this format for App.data.declareModel
         *  {
          *     "username": { "name": "username", ... },
          *     "password": { "name": "password", ... },
          *      ...
          * }
         */
        app.data.declareModel('Login', {fields: fields});
    },

    /**
     * @override
     * @param options
     */
    initialize: function(options) {
        // Declare a Bean so we can process field validation
        this._declareModel(options.meta);

        // Reprepare the context because it was initially prepared without metadata
        options.context.prepare(true);

        app.view.View.prototype.initialize.call(this, options);

        var config = app.metadata.getConfig();
        if (config && app.config.forgotpasswordON === true) {
            this.showPasswordReset = true;
        }

    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this.logoUrl = app.metadata.getLogoUrl();
        app.view.View.prototype._render.call(this);
        this.refreshAddtionalComponents();
        /**
         * Added browser version check for MSIE since we are dropping support
         * for MSIE 9.0 for SugarCon
         */
        if (!this._isSupportedBrowser()) {
            app.alert.show('unsupported_browser', {
                level:'warning',
                title: '',
                messages: [
                    app.lang.getAppString('LBL_ALERT_BROWSER_NOT_SUPPORTED'),
                    app.lang.getAppString('LBL_ALERT_BROWSER_SUPPORT')
                ]
            });
        }
        var config = app.metadata.getConfig();
        if (config.system_status
            && config.system_status.level
            && (config.system_status.level == 'maintenance'
                || config.system_status.level == 'admin_only')) {
            app.alert.show('admin_only', {
                level:'warning',
                title: '',
                messages: [
                    '',
                    app.lang.getAppString(config.system_status.message),
                ]
            });            
        }
        return this;
    },

    /**
     * Refresh additional components
     */
    refreshAddtionalComponents: function() {
        _.each(app.additionalComponents, function(component) {
            component.render();
        });
    },

    /**
     * Process Login
     */
    login: function() {
        var self = this;
        this.model.doValidate(null,
            _.bind(function(isValid) {
                if (isValid) {
                    app.$contentEl.hide();
                    var args = {password: this.model.get("password"), username: this.model.get("username")};

                    app.alert.show('login', {level: 'process', title: app.lang.getAppString('LBL_LOADING'), autoClose: false});
                    app.login(args, null, {
                        error: function() {
                            app.$contentEl.show();
                            app.logger.debug("login failed!");
                        },
                        success: function() {
                            app.logger.debug("logged in successfully!");
                            app.events.on('app:sync:complete', function() {
                                app.logger.debug("sync in successfully!");
                                _.defer(_.bind(this.postLogin, this));
                            }, self);
                        },
                        complete: function() {
                            app.alert.dismiss('login');
                        }
                    });
                }
            }, self)
        );
    },
    /**
     * After login and app:sync:complete, we need to see if there's any post login setup we need to do prior to
     * rendering the rest of the Sugar app
     */
    postLogin: function(){
        if (!app.user.get('show_wizard')) {
            this.refreshAddtionalComponents();
            
            if (new Date().getTimezoneOffset() != (app.user.getPreference('tz_offset_sec')/-60)) {
                var link = new Handlebars.SafeString('<a href="#' + 
                                                     app.router.buildRoute('Users', app.user.id, 'edit') + '">' + 
                                                     app.lang.get('LBL_TIMEZONE_DIFFERENT_LINK') + '</a>');
                
                var message = app.lang.get('TPL_TIMEZONE_DIFFERENT', null, {link: link});
                
                app.alert.show('offset_problem', {
                    messages: message,
                    closeable: true,
                    level: 'warning'
                });
            }
        }
        app.$contentEl.show();
    },

    /**
     * Taken from sugar_3. returns true if the users browser is recognized
     * @return {Boolean}
     * @private
     */
    _isSupportedBrowser:function () {
        var supportedBrowsers = {
            msie:{min:9},
            mozilla:{min:18},
            // For Safari & Chrome jQuery.Browser returns the webkit revision instead of the browser version
            // and it's hard to determine this number.
            safari:{min:536},
            chrome:{min:537}
        };
        for (var b in supportedBrowsers) {
            if ($.browser[b]) {
                var current = parseInt($.browser.version);
                var supported = supportedBrowsers[b];
                return current >= supported.min;
            }
        }
    }
})
