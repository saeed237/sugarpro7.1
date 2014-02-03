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
     * Language Helper. Provides interface to pull language strings out of a language
     * label cache.
     *
     * @class Core.LanguageHelper
     * @singleton
     * @alias SUGAR.App.lang
     */
    app.augment("lang", {

        /**
         * Retrieves a string for a given key.
         *
         * This function searches the module strings first and falls back to the app strings.
         *
         * If the label is a template, it will be compiled and executed with the given `context`.
         *
         * @param {String} key Key of the string to retrieve.
         * @param {String/Array} module(optional) Module the label belongs to.
         * @param {String/Boolean/Number/Array/Object} context (optional) Template context.
         * @return {String} String for the given key or the `key` parameter if the key is not found in language pack.
         */
        get: function (key, module, context) {
            var moduleString;

            if (_.isArray(module)) {
                _.find(module, function (moduleName) {
                    moduleString = this._get("mod_strings", key, moduleName, context);
                    return !_.isEmpty(moduleString);
                }, this);
            } else {
                moduleString = this._get("mod_strings", key, module, context)
            }

            return moduleString ||
                this._get("app_strings", key, null, context) ||
                key;
        },

        /**
         * Retrieves an application string for a given key.
         * @param {String} key Key of the string to retrieve.
         * @return {String} String for the given key or the `key` parameter if the key is not found in the language pack.
         */
        getAppString: function(key) {
            return this._get("app_strings", key) || key;
        },

        /**
         * Retrieves an application list string or object.
         * @param {String} key Key of the string to retrieve.
         * @return {Object/String} String or object for the given key. If key is not found, an empty object is returned.
         */
        getAppListStrings: function(key) {
            return this._get("app_list_strings", key) || {};
        },

        /**
         * Retrieves a string of a given type.
         *
         * If the label is a template, it will be compiled and executed with the given `context`.
         * @param {String} type Type of string pack: `app_strings`, `app_list_strings`, `mod_strings`.
         * @param {String} key Key of the string to retrieve.
         * @param {String} module(optional) Module the label belongs to.
         * @param {String/Boolean/Number/Array/Object} context(optional) Template context.
         * @return {String} String for the given key.
         * @private
         */
        _get: function(type, key, module, context) {
            var bundle = app.metadata.getStrings(type);
            bundle = module ? bundle[module] : bundle;
            var str = bundle ? this._sanitize(bundle[key]) : null;
            if (str && !_.isUndefined(context) && _.isString(str) && (str.indexOf("{{") > -1)) {
                key = "lang." + (module ? key + "." + module : key);
                str = Handlebars.templates[key] ? Handlebars.templates[key](context) : app.template.compile(key, str)(context);
            }
            return str;
        },

        /**
         * Sanitizes a string.
         *
         * This function strips trailing colon.
         *
         * @param {String} str String to sanitize.
         * @return {String} Sanitized string or `str` parameter if it's not a string.
         * @private
         */
        _sanitize: function(str) {
            return (_.isString(str) && (str.lastIndexOf(":") == str.length - 1)) ?
                    str.substring(0, str.length - 1) : str;
        },

        /**
         * Gets app language code.
         * @return {String} Language code.
         */
        getLanguage: function() {
            return this.currentLanguage;
        },

        /**
         * Sets app language code and syncs it with the server.
         * @param {String} language language code such as `en_us`.
         * @param {Function} callback(optional) callback function to be called on language set completes.
         * @param {Object} options(optional) Options:
         *
         * - noSync: true if you don't need to fetch /metadata.
         * - noUserUpdate: true if you don't need to update /me.
         */
        setLanguage:function (language, callback, options) {
            var self = this;
            options = options || {};
            _.each(Handlebars.templates, function(value, key) {
                if (key.indexOf("lang.") == 0) {
                    delete Handlebars.templates[key];
                }
            });
            if (options.noSync === true) {
                app.cache.set("lang", language);
                return;
            }
            app.sync({
                callback: function(err) {
                    var langHasChanged = false;
                    if (!err) {
                        self.updateLanguage(language);
                        langHasChanged = !app.api.isAuthenticated() && !options.noUserUpdate;
                        app.cache.set('langHasChanged', langHasChanged);//persist even after reloads
                        app.events.trigger('app:locale:change');
                    }
                    if (callback) callback(err);
                },
                getPublic: !app.api.isAuthenticated(),
                noUserUpdate: options.noUserUpdate || false,
                language: language,
                forceRefresh: true,  // Needed to make sure new labels are injected
                metadataTypes: ['labels']
            });

        },

        /**
         * Updates language code.
         * @param {String} language Language code.
         */
        updateLanguage: function(language) {
            app.cache.set("lang", language);
            app.user.setPreference('language', language);
        }

    });

})(SUGAR.App);
