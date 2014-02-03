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
 * @singleton
 * @alias SUGAR.App.sugarAuthStore
 */
(function(app) {
    var serviceName = "SugarCRM",
        emptyFn = function() {},
        tokenMap = {
            "AuthAccessToken" : app.AUTH_ACCESS_TOKEN,
            "AuthRefreshToken" : app.AUTH_REFRESH_TOKEN
        };

    var _keychain = {
        /**
         * Returns the auth token of the current user.
         *
         * This method simply reads the global AUTH_ACCESS_TOKEN or
         * AUTH_REFRESH_TOKEN that was set when the native application was launched.
         *
         * @param {String} key Item key.
         * @return {String} authentication token for the current user.
         */
        get: function(key) {
            return tokenMap[key];
        },

        /**
         * Puts an item into the keychain.
         * @param {String} key Item key.
         * @param {String} value Item to put.
         */
        set: function(key, value) {
            tokenMap[key] = value;
        },

        /**
         * Deletes an item from the keychain.
         * @param {String} key Item key.
         */
        cut: function(key) {
            delete tokenMap[key];
        }
    };

    app.augment("sugarAuthStore", _keychain);

})(SUGAR.App);