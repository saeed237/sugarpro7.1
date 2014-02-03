
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
 * SideCar Platform
 * @ignore
 */
var SUGAR = SUGAR || {};

/**
 * SUGAR.App contains the core instance of the app. All related modules can be found within the SUGAR namespace.
 * An uninitialized instance will exist on page load but you will need to call {@link App#init} to initialize your instance.
 * By default, the app uses `body` element and `div#content` as root element and content element respectively.
 * <pre><code>
 * var app = SUGAR.App.init({
 *      el: "#root",
 *      contentEl: "#content"
 * });
 * </pre></code>
 * If you want to initialize an app without initializing its modules,
 * <pre><code>var app = SUGAR.App.init({el: "#root", silent: true});</code></pre>
 *
 * @class App
 * @singleton
 */
SUGAR.App = (function() {
    var _app,
        _modules = {};

    var _make$ = function(selector) {
        return selector instanceof $ ? selector : $(selector);
    };

    /**
     * @constructor Constructor class for the main framework app
     * @param {Object} opts(optional) Configuration options
     * @return {App} Application instance
     * @private
     */
    function App(opts) {
        var appId = _.uniqueId("SugarApp_");
        opts = opts || {};

        return _.extend({
            /**
             * Unique application ID
             * @property {String}
             */
            appId: appId,

            /**
             * Base element to use as the root of the app.
             *
             * This is a jQuery/Zepto node.
             * @property {Object}
             */
            $rootEl: _make$(opts.el || "body"),

            /**
             * Content element selector.
             *
             * Application controller {@link Core.Controller} loads layouts into the content element.
             * This is a jQuery/Zepto node.
             * @property {Object}
             */
            $contentEl: _make$(opts.contentEl || "#content"),

            /**
             * Alias to SUGAR.Api
             * @property {Object}
             */
            api: null,

            /**
             * Additional components.
             *
             * These components are created and rendered only once when the application starts.
             * Application specific code is responsible for managing the components
             * after they have been put into DOM by the framework.
             */
            additionalComponents: {}

        }, this, Backbone.Events);
    }

    return {
        /**
         * Initializes an app.
         * @param {Object} opts(optional) Configuration options
         *
         * - el: root app element
         * - contentEl: main content element
         * - silent: `true` if you want to suppress initialization of modules
         * @return {App} Application instance
         * @method
         */
        init: function(opts) {
            _app = _app || _.extend(this, new App(opts));

            // Register app specific events
            _app.events.register(
                /**
                 * @event
                 * Fires when the app object is initialized. Modules bound to this event will initialize.
                 */
                "app:init",
                this
            );

            _app.events.register(
                /**
                 * Fires when the application has
                 * finished loading its dependencies and should initialize
                 * everything.
                 *
                 * <pre><code>
                 * obj.on("app:start", callback);
                 * </pre></code>
                 * @event
                 */
                "app:start",
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when the app is beginning to sync data / metadata from the server.
                 */
                "app:sync",
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when the app has finished its syncing process and is ready to proceed.
                 */
                "app:sync:complete",
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when a sync process failed
                 */
                "app:sync:error",
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when login succeeds.
                 */
                "app:login:success",
                this
            );

            _app.events.register(
                /**
                 * @event
                 * Fires when the app logs out.
                 */
                "app:logout",
                this
            );

            _app.events.register(
                /**
                 * Fires when route changes a new view has been loaded.
                 *
                 * <pre><code>
                 * obj.on("app:view:change", callback);
                 * </pre></code>
                 * @event
                 */
                "app:view:change",
                this
            );

            _app.events.register(
                /**
                 * Fires when client application's user changes the locale, thus indicating that the application should
                 * "re-render" itself.
                 *
                 * <pre><code>
                 * obj.on("app:local:change", callback);
                 * </pre></code>
                 * @event
                 */
                'app:locale:change',
                this
            );

            // App cache must be inited first
            if (_app.cache) {
                _app.cache.init(this);
            }

            // Instantiate controller: <Capitalized-appId>Controller or Controller.
            var className = _app.utils.capitalize(_app.config ? _app.config.appId : "") + "Controller";
            var Klass = this[className] || this.Controller;
            this.controller = new Klass();

            _app.api = SUGAR.Api.getInstance({
                defaultErrorHandler: (opts && opts.defaultErrorHandler) ? opts.defaultErrorHandler : SUGAR.App.error.handleHttpError,
                serverUrl: _app.config.serverUrl,
                platform: _app.config.platform,
                timeout: _app.config.serverTimeout,
                keyValueStore: _app[_app.config.authStore || "cache"],
                clientID: _app.config.clientID,
            });

            this._init(opts);

            return _app;
        },

        // Initializes application.
        // Performs loading css (optional), metadata sync and sync callback.
        _init: function(opts) {
            var self = this;
            var syncCallback = function(error){

                // _app will be nulled out if destroy was called on app before we
                // asynchronously get here. This happens when running tests (see spec-helper).
                if(!_app) {
                    return;
                }
                if (error) {
                    self.trigger("app:sync:error", error);
                    return;
                }
                self._initModules();
                self._loadConfig();
                if (!opts.silent) {
                    _app.trigger("app:init", self);
                }
                if (opts.callback && _.isFunction(opts.callback)) {
                    opts.callback(_app);
                }
            };
            var cssCallback = function(callback) {
                if (_app.config.loadCss) {
                    _app.loadCss(callback);
                } else {
                    callback();
                }
            };
            if (_app.config.syncConfig !== false ) {
                var options = {
                    getPublic: true
                };
                cssCallback(function() {
                    _app.metadata.sync(syncCallback, options);
                });
            } else {
                cssCallback(function() {
                    syncCallback();
                });
            }
            //Resync the metadata when the refresh token is used in case the refreshed was forced by the server due to a metadata change.
            //If no metadata has changed, the server will 304 and metadata-manger will no-op
            _app.api.setRefreshTokenSuccessCallback(function(c){
                _app.sync({callback:c});
            });

            return _app;
        },

        // Initializes application modules.
        _initModules: function() {
            _.each(_modules, function(module) {
                if (_.isFunction(module.init)) {
                    module.init(this);
                }
            }, this);
        },

        // Loads configuration from local storage and extends current settings
        _loadConfig: function() {
            // extend our config with settings from local storage if we have it
            _app.config = _app.config || {};
            _app.config = _.extend(_app.config, _app.metadata.getConfig());
        },

        /**
         * Adds css @url to the page.
         * @param {Function} callback(optional)
         */
        loadCss: function(callback) {

            _app.api.css(_app.config.platform, _app.config.themeName, {
                success:function (rsp) {

                    if (_app.config.loadCss === "url") {
                        _.each(rsp.url, function(url) {
                            $("<link>")
                                .attr({
                                    rel: "stylesheet",
                                    href: _app.utils.buildUrl(url)
                                })
                                .appendTo("head");
                        });
                    }
                    else {
                        _.each(rsp.text, function(text) {
                            $("<style>").html(text).appendTo("head");
                        });
                    }

                    if (_.isFunction(callback)) {
                        callback();
                    }
                }
            });
        },

        /**
         * Starts the main execution phase of the application.
         * @method
         */
        start: function() {
            _app.events.registerAjaxEvents();
            _app.trigger("app:start", this);
            _app.routing.start();
        },

        /**
         * Destroys the instance of the current app.
         */
        destroy: function() {
            // TODO: Not properly implemented
            if (Backbone.history) {
                Backbone.history.stop();
            }

            _app = null;
        },

        /**
         * Augments the application with a module.
         *
         * Module should be an object with an optional `init(app)` function.
         * The init function is passed the current instance of
         * the application when app's {@link App#init} method gets called.
         * Use the `init` function to perform custom initialization logic during app initialization.
         *
         * @param {String} name Name of the module.
         * @param {Object} obj Module to agument the app with.
         * @param {Boolean} init(optional) Flag indicating if the module should be initialized immediately.
         */
        augment: function(name, obj, init) {
            this[name] = obj;
            _modules[name] = obj;

            if (init && obj.init && _.isFunction(obj.init)) {
                obj.init.call(_app);
            }
        },

        /**
         * Syncs an app.
         *
         * The `app:sync` event is fired when the sync process begins.
         * The `app:sync:complete` event will be fired when
         * the series of sync operations have finished.
         * The events are not fired if the sync happens for public metadata.
         *
         * @param {Object} options(optional) Options:
         *
         * - callback: function which is called when sync completes.
         * - getPublic: flag indicating if only public metadata should be synced.
         * @method
         */
        sync: function(options) {
            var self = this;
            options = options || {};

            // For public call, we need to do just metadata sync without triggering events
            if (options.getPublic) {
                return self.syncPublic(options);
            }

            // 1. Update server info and run compatibility check
            // 2. Update preferred language if it was changed
            // 3. Load user preferences
            // 4. Fetch metadata
            // 5. Declare models
            async.waterfall([function(callback) {
                self.isSynced = false;
                self.trigger("app:sync");
                var doUpdateLanguage = !options.noUserUpdate && (options.language || _app.cache.get('langHasChanged'));
                if (doUpdateLanguage) {
                    var language = options.language || _app.lang.getLanguage();
                    self.user.updateLanguage(language, callback);
                    _app.cache.cut('langHasChanged');
                }
                else {
                    callback();
                }
            }, function(callback) {
                self.user.load(callback);
            }, function(callback) {
                self.metadata.sync(callback, options);
            }, function(callback) {
                self.data.declareModels();
                callback();
            }], function(err) {
                if (err) {
                    self.trigger("app:sync:error", err);
                } else {
                    self.isSynced = true;
                    self.trigger("app:sync:complete");
                }
                if (_.isFunction(options.callback)) options.callback(err);
            });
        },

        /**
         * Syncs public metadata.
         * @param options(optional) Options.
         *
         * - callback: function which is called when sync completes.
         * - param: language options.
         */
        syncPublic: function(options) {
            options = options || {};
            options.getPublic = true;
            this.metadata.sync(options.callback, options);
        },

        /**
         * Navigates to a new route.
         *
         * @param {Core.Context} context(optional) Context object to extract the module from.
         * @param {Data.Bean} model(optional) Model object to route with.
         * @param {String} action(optional) Action name.
         */
        navigate: function(context, model, action) {
            var route, id, module;
            context = context || _app.controller.context;
            model = model || context.get("model");
            id = model.id;
            module = context.get("module") || model.module;

            route = this.router.buildRoute(module, id, action);
            this.router.navigate(route, {trigger: true});
        },

        /**
         * Logs in this app.
         *
         * @param  {Object} credentials user credentials.
         * @param  {Object} info(optional) extra data to be passed in login request such as client user agent, etc.
         * @param  {Object} callbacks(optional) callback object.
         */
        login: function(credentials, info, callbacks) {
            callbacks  = callbacks || {};

            _app.api.login(credentials, info, {
                success: function(data) {
                    _app.trigger("app:login:success", data);
                    if (callbacks.success) callbacks.success(data);
                },
                error: function(error) {
                    _app.error.handleHttpError(error);
                    if (callbacks.error) callbacks.error(error);
                },
                complete: callbacks.complete
            });
        },

        /**
         * Logs out this app.
         * @param  {Object} callbacks(optional) callback object.
         * @param {Boolean} clear(optional) Flag indicating if user information must be deleted from local storage.
         * @return {Object} XHR request object.
         */
        logout: function(callbacks, clear) {
            var originalComplete, originalError;
            callbacks = callbacks || {};
            originalComplete = callbacks.complete;
            originalError = callbacks.error;

            callbacks.complete = function(data) {
                // The 'clear' comes from the logout URL (see router.js)
                _app.trigger("app:logout", clear);
                if (originalComplete) {
                    originalComplete(data);
                }
            };
            callbacks.error = function(error) {
                _app.error.handleHttpError(error);
                if (originalError) originalError(error);
            };

            return _app.api.logout(callbacks);
        },

        /**
         * Checks if the server version and flavor are compatible.
         * @param {Object} data Server information.
         * @return {Boolean|Object} `true` if server is compatible and an error object if not.
         */
        isServerCompatible: function(data) {
            var flavors = this.config.supportedServerFlavors,
                minVersion = this.config.minServerVersion,
                isSupportedFlavor,
                isSupportedVersion,
                error;

            // We assume the app is not interested in the compatibility check if it doesn't have compatibility config.
            if (_.isEmpty(flavors) && !minVersion) return true;

            // Undefined or null data with defined compatibility config means the server is incompatible

            isSupportedFlavor  = !!((_.isEmpty(flavors)) || (data && _.contains(flavors, data.flavor)));
            isSupportedVersion = !!(!minVersion || (data && this.utils.versionCompare(data.version, minVersion, ">=")));

            if (isSupportedFlavor && isSupportedVersion) {
                return true;
            }
            else if (!isSupportedVersion) {
                error = {
                    code: "server_version_incompatible",
                    label: "ERR_SERVER_VERSION_INCOMPATIBLE"
                };
            } else {
                error = {
                    code: "server_flavor_incompatible",
                    label: "ERR_SERVER_FLAVOR_INCOMPATIBLE"
                };
            }

            error.server_info = data;
            return error;
        },

        modules: _modules
    };

}());
