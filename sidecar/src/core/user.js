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

(function(app) {

    /**
     * Represents application's current user object.
     *
     * The user object contains settings that are fetched from the server
     * and whatever settings application wants to store.
     *
     * <pre><code>
     * // Sample user object that is fetched from the server:
     * {
     *      id: "1",
     *      full_name: "Administrator",
     *      user_name: "admin",
     *      preferences: {
     *          timezone: "America\/Los_Angeles",
     *          datepref: "m\/d\/Y",
     *          timepref: "h:ia"
     *      }
     * }
     *
     * // Use it like this:
     * var userId = SUGAR.App.user.get('id');
     * // Set app specific settings
     * SUGAR.App.user.set("sortBy:Cases", "case_number");
     *
     * // Bind event handlers if necessary
     * SUGAR.App.user.on("change", function() {
     *     // Do your thing
     * });
     *
     * </code></pre>
     *
     * @class Core.User
     * @singleton
     * @alias SUGAR.App.user
     */
    var User = Backbone.Model.extend({

        load: function(callback) {
            app.api.me("read", null, null, {
                success: function(data) {
                    if (data && data.current_user) {
                        // Set the user pref hash into the cache for use in
                        // checking user pref state change
                        if (data.current_user._hash) {
                            app.cache.set("userpref:hash", data.current_user._hash);
                        }
                        app.user.set(data.current_user);
                        var language = app.user.getPreference('language');
                        if (app.lang.getLanguage() != language) {
                            app.lang.setLanguage(language, null, {noUserUpdate: true, noSync: true});
                        }
                    }
                    if (callback) callback();
                },
                error: function(err) {
                    app.error.handleHttpError(err);
                    if (callback) callback(err);
                }
            });
        },
        loadLocale: function(callback) {
            app.api.call('read', app.api.buildURL('locale'), null, {
                success: function(data) {
                    if (data && data._hash) {
                        app.cache.set("userpref:hash", data._hash);
                        app.user.set({"_hash":data._hash});
                    }
                    if (callback) callback(data);
                },
                error: function(err) {
                    app.error.handleHttpError(err);
                    if (callback) callback(err);
                }
            });
        },
        /**
         * Updates the preferred language of the user.
         *
         * @param {String} language language Key
         * @param {Function} callback(optional) Callback called when update completes.
         */
        getLanguage: function() {
            return app.user.getPreference('language') || app.cache.get("lang");
        },

        /**
         * Updates the preferred language of the user.
         *
         * @param {String} language language Key
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updateLanguage: function(language, callback) {
            //Note that `err` is only relevant here when called for error case
            var done = function(err) {
                app.lang.updateLanguage(language);
                if (callback) callback(err);
            };
            this.update("update", {preferred_language: language}, done);
        },

        /**
         * Updates the user's profile.
         *
         * @param {Object} attributes The model attributes to update for user.
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updateProfile: function(attributes, callback) {
            //Note that `err` is only relevant here when called for error case
            var done = function(err) {
                if (callback) callback(err);
            };
            this.update("update", attributes, done);
        },
        /**
         * Updates the user's preferences.
         *
         * @param {Object} attributes The attributes to update for user.
         * @param {Function} callback(optional) Callback called when update completes.
         */
        updatePreferences: function(attributes, callback) {
            var self = this;
            if (app.api.isAuthenticated()) {
                app.api.call("update", app.api.buildURL('me/preferences'), attributes, {
                    success: function(data) {
                        if (data._hash) {
                            app.cache.set("userpref:hash", data._hash);
                            app.user.set({"_hash":data._hash});
                        }
                        //Immediately update our user's preferences to reflect latest changes
                        _.each(attributes, function(val, key) {
                            if (data[key]) {
                                self.setPreference(key, data[key]);
                            }
                        });
                        if (callback) callback();
                    },
                    error: function(err) {
                        app.error.handleHttpError(err);
                        if (callback) callback(err);
                    }
                });
            } else {
                if (callback) callback();
            }
        },

        /**
         * Updates the user
         *
         * @param {String} method operation type: read, update, create, delete {@see SUGAR.Api#me}
         * @param {Object} payload An object literal with payload
         * @param {Object} done Callback called when update completes. In case of
         * error, app.error.handleHttpError will already be handled here.
         */
        update: function(method, payload, callback) {
            if (app.api.isAuthenticated()) {
                app.api.me(method, payload, null, {
                    success: function(data) {
                        if (data.current_user) {
                            if (data.current_user._hash) {
                                app.cache.set("userpref:hash", data.current_user._hash);
                            }
                            app.user.set(data.current_user);
                        }
                        if (callback) callback();
                    },
                    error: function(err) {
                        app.error.handleHttpError(err);
                        if (callback) callback(err);
                    }
                });
            } else {
                callback();
            }
        },

        /**
         * Gets ACLs.
         *
         * @return Dictionary of ACLs. Precondition - user's logged in or a _reset call has set the user manually.
         */
        getAcls: function() {
            return app.user.get('acl') || {};
        },

        /**
         * Get preference by name.
         *
         * TODO support category parameter for preferences.
         *
         * @param {String} name The preference name.
         * @return {Array/Object/String/Number/Boolean} The value of the user preference.
         */
        getPreference: function(name) {

            var preferences = app.user.get('preferences') || {};
            return preferences[name];
        },

        /**
         * Set preference by name, will only be stored locally.
         *
         * TODO support category parameter for preferences.
         * TODO support save preferences on server.
         *
         * @param {String} name The preference name.
         * @param {Array/Object/String/Number/Boolean} value The new value of the user preference.
         * @return {Object} the instance of this user.
         */
        setPreference: function(name, value) {
            var preferences = app.user.get('preferences') || {};
            preferences[name] = value;
            return app.user.set('preferences', preferences);
        },

        /**
         * Allows interactions with the last state values, which are used to implement last application
         * states or the "stickiness" of the application.
         */
        lastState: (function() {
            var keySeparator = ':',
                keyPrefix = 'last-state',
                lastStates = {};

            var buildLastStateKeyForStorage = function(key) {
                var keyParts = key.split(keySeparator),
                    storedKey = [app.user.id, keyPrefix];

                storedKey = storedKey.concat(keyParts);

                return storedKey.join(keySeparator);
            };

            var getLastStateId = function(component) {
                var lastStateId;

                if (component.meta && component.meta.last_state) {
                    lastStateId = component.meta.last_state.id;
                }

                return lastStateId;
            };

            return {
                /**
                 * Get the last state value given a key.  If doesn't exist, return the default
                 * value as specified in the component metadata.
                 *
                 * @param {String} key
                 * @returns {String}
                 */
                get: function(key) {
                    var result, storedKey;

                    if (!_.isUndefined(key)) {
                        storedKey = buildLastStateKeyForStorage(key);
                        result = app.cache.get(storedKey) || this.defaults(key);
                    }

                    return result;
                },

                /**
                 * Save the last state in local storage.
                 *
                 * @param {String} key
                 * @param {String} value
                 */
                set: function(key, value) {
                    if (!_.isUndefined(key) && !_.isUndefined(value)) {
                        var storedKey = buildLastStateKeyForStorage(key);
                        app.cache.set(storedKey, value);
                    }
                },

                /**
                 * Get the key for a given component, which is used as a key for CRUD operations on
                 * last state values.
                 *
                 * @param {String} name
                 * @param {Object} component
                 * @returns {String}
                 */
                key: function(name, component) {
                    var lastStateId = getLastStateId(component);
                    return this.buildKey(name, lastStateId, component.module);
                },

                /**
                 * Build the key for a given name, lastStateId, and (optionally) module,
                 * which is used as a key for CRUD operations on last state values.
                 *
                 * @param {String} name
                 * @param {String} lastStateId
                 * @param {String} module(optional)
                 * @returns {String}
                 */
                buildKey: function(name, lastStateId, module) {
                    var keyString, keyParts = [];

                    if (lastStateId) {
                        if (module) {
                            keyParts.push(module);
                        }
                        keyParts.push(lastStateId, name);
                        keyString = keyParts.join(keySeparator);
                    }

                    return keyString;
                },

                /**
                 * Get the default last state for a key.
                 *
                 * @param {String} key
                 * @returns {String}
                 */
                defaults: function(key) {
                    return lastStates[key];
                },

                /**
                 * Register last states default values given a component.  The default value is
                 * specified in the component metadata.
                 *
                 * @param {Object} component
                 */
                register: function(component) {
                    var lastStateId = getLastStateId(component);
                    if (lastStateId){
                        _.each(component.meta.last_state.defaults, function(defaultState, key) {
                            lastStates[this.key(key, component)] = defaultState;
                        }, this);
                    }
                },

                /**
                 * Delete last state from local storage
                 *
                 * @param {String} key
                 */
                remove: function(key) {
                    var storedKey;
                    if (!_.isUndefined(key)) {
                        storedKey = buildLastStateKeyForStorage(key);
                        app.cache.cut(storedKey);
                    }
                }
            };
        })()
    });

    app.events.on("app:logout", function(clear) {
        if (clear === true) {
            app.user.clear({silent:true});
        }
    });

    app.augment("user", new User(), false);

})(SUGAR.App);
