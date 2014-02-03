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
     * Cache for legacy metadata.
     * @type {Object}
     */
    var metadataCache = {};

    /**
     * Holds the private legacy metadata converter methods.
     * @type {Object}
     */
    var metadataConverters = {
        /**
         * Converts legacy listviewdefs to the Sidecar list metadata.
         * @param  {Object} meta Module-unwrapped legacy metadata
         * @return {Object}      Sidecar list metadata
         */
        listviewdefs: function(meta) {
            var obj = {
                panels: [{
                    label: 'LBL_PANEL_DEFAULT',
                    fields: []
                }]
            };

            _.each(meta, function(value, key) {
                var fieldOverrides = {name: key.toLowerCase()};
                // assume the type comes from the name if no type was defined
                fieldOverrides.type = value['type'] || fieldOverrides.name;
                // need to map "team_name" to "teamset" as is seen in sugar7/hacks.js
                if (fieldOverrides.type === 'team_name') {
                    fieldOverrides.type = 'teamset';
                }
                if (app.config.platform === 'portal') {
                    fieldOverrides['default'] = true;
                } else {
                    // Coerce the value from the defs to a boolean.
                    fieldOverrides['default'] = !!value['default'];
                }

                if (_.isUndefined(value.enabled)) {
                    fieldOverrides.enabled = true;
                } else {
                    // Coerce the value from the defs to a boolean.
                    fieldOverrides.enabled = !!value.enabled;
                }

                _.extend(value, fieldOverrides);
                obj.panels[0].fields.push(value);
            });

            return obj;
        }
    };

    /**
     * Backwards compatibility (Bwc) class manages all required methods for BWC
     * modules.
     *
     * A BWC module is defined in the metadata by the `isBwcEnabled` property.
     *
     * @class Sugar.Bwc
     * @singleton
     * @alias SUGAR.App.bwc
     */
    var Bwc = {
        /**
         * Performs backward compatibility login.
         *
         * The OAuth token is passed and we do automatic in bwc mode by
         * getting a cookie with the PHPSESSIONID.
         */
        
        /**
         * Logs into sugar in BWC mode. Allows for use of current OAuth token as
         * a session id for backward compatible modules.
         * 
         * @param  {String} redirectUrl A URL to redirect to after logging in
         * @param  {Function} callback A function to call after logging in
         * @return {Void}
         */
        login: function(redirectUrl, callback) {
            var url = app.api.buildURL('oauth2', 'bwc/login');
            return app.api.call('create', url, {}, {
                success: function(data) {
                    // Set the session name into the cache so that certain bwc
                    // modules can access it as needed (studio)
                    if (data && data.name) {
                        app.cache.set("SessionName", data.name);
                    }

                    // If there was a callback, call it. This will almost always
                    // be used exlusively by studio when trying to refresh the 
                    // session after it expires.
                    if (callback) {
                        callback();
                    }

                    // If there was a redirectUrl passed, go there. This will 
                    // almost always be the case, except in studio when a login
                    // is simply updating the session id
                    if (redirectUrl) {
                        app.router.navigate('#bwc/' + redirectUrl, {trigger: true});
                    }
                }
            });
        },

        /**
         * Translates an action to a BWC action.
         *
         * If the action wasn't found to be translated, the given action is
         * returned.
         *
         * @param {String} action The action to translate to a BWC one.
         * @return {String} The BWC equivalent action.
         */
        getAction: function(action) {
            var bwcActions = {
                'create': 'EditView',
                'edit': 'EditView',
                'detail': 'DetailView'
            };

            return bwcActions[action] || action;
        },

        /**
         * Builds a backwards compatible route. For example:
         * bwc/index.php?module=MyModule&action=DetailView&record12345
         *
         * @param {String} module The name of the module.
         * @param {String} [id] The model's ID.
         * @param {String} [action] Backwards compatible action name.
         * @param {Object} [params] Extra params to be sent on the bwc link.
         * @return {String} The built route.
         */
        buildRoute: function(module, id, action, params) {

            /**
             * app.bwc.buildRoute is for internal use and we control its callers, so we're
             * assuming callers will provide the module param which is marked required!
             */
            var href = 'bwc/index.php?',
                params = _.extend({}, { module: module }, params);

            if (!action && !id || action==='DetailView' && !id) {
                params.action = 'index';
            } else {
                if (action) {
                    params.action = action;
                } else {
                    //no action but we do have id
                    params.action = 'DetailView';
                }
                if (id) {
                    params.record = id;
                }
            }
            return href + $.param(params);
        },

        /**
         * For BWC modules, we need to get URL params for creating the related record
         * @returns {Object} BWC URL parameters
         * @private
         */
        _createRelatedRecordUrlParams: function(parentModel, link) {
            var params = {
                parent_type: parentModel.module,
                parent_name: parentModel.get('name') || parentModel.get('full_name'),
                parent_id: parentModel.get("id"),
                return_module: parentModel.module,
                return_id: parentModel.get("id"),
                return_name: parentModel.get('name') || parentModel.get('full_name')
            };
            //Special case for Contacts->meetings. The parent should be the account rather than the contact
            if (parentModel.module == "Contacts" && parentModel.get("account_id") && (link == "meetings" || link == 'calls')) {
                params = _.extend(params, {
                    parent_type: "Accounts",
                    parent_id: parentModel.get("account_id"),
                    account_id: parentModel.get("account_id"),
                    account_name: parentModel.get("account_name"),
                    parent_name: parentModel.get("account_name"),
                    contact_id: parentModel.get("id"),
                    contact_name: parentModel.get("full_name")
                });
            }
            //Set relate field values as part of URL so they get pre-filled
            var fields = app.data.getRelateFields(parentModel.module, link);
            _.each(fields, function(field){
                params[field.name] = parentModel.get(field.rname);
                params[field.id_name] = parentModel.get("id");
                if(field.populate_list) {
                    // We need to populate fields from parent record into new related record
                    _.each(field.populate_list, function (target, source) {
                        source = _.isNumber(source) ? target : source;
                        if (!_.isUndefined(parentModel.get(source))) {
                            params[target] = parentModel.get(source);
                        }
                    }, this);
                }
            });
            return params;
        },

        /**
         * Route to Create Related record UI for a BWC module
         */
        createRelatedRecord: function(module, parentModel, link) {
            var params = this._createRelatedRecordUrlParams(parentModel, link);
            var route = app.bwc.buildRoute(module, null, "EditView", params);
            app.router.navigate("#" + route, {trigger: true}); // Set route so that we switch over to BWC mode
        },

        /**
         * Enables the ability to share a record from a BWC module.
         *
         * This will trigger the sharing action already defined in the
         * {@link BaseShareactionField#share()}.
         *
         * @param {String} module The module that we are sharing.
         * @param {String} id The record id that we are sharing.
         * @param {String} name The record name that we are sharing.
         */
        shareRecord: function(module, id, name) {
            var shareField = app.view.createField({
                def: {
                    type: 'shareaction'
                },
                module: module,
                model: app.data.createBean(module, {
                    id: id,
                    name: name
                }),
                view: app.view.createView({})
            });
            shareField.share();
        },

        /**
         * Revert bwc model attributes in order to skip warning unsaved changes.
         */
        revertAttributes: function() {
            var view = app.controller.layout.getComponent('bwc');
            if (!view) {
                return;
            }
            view.revertBwcModel();
        },

        /**
         * Accessor for private metadata converter functions.
         * @param  {String} type Name of legacy metadata type
         * @return {Function}
         */
        _getLegacyMetadataConverter: function(type) {
            return metadataConverters[type];
        },

        /**
         * Retrieves the legacy metadata from the server, and converts it to
         * Sidecar metadata. This method should be removed as soon as possible.
         * @param  {String} module
         * @param  {String} type
         * @return {Object}
         */
        getLegacyMetadata: function(module, type) {
            var converter = this._getLegacyMetadataConverter(type),
                cacheKey = module + '-' + type,
                bwcModule = app.metadata.getModule(module).isBwcEnabled;

            if (!metadataCache[cacheKey] && converter && bwcModule) {
                var result,
                    url = app.api.buildURL('metadata', 'legacy', {}, {module: module, type: type}),
                    request = app.api.call('read', url, null, {
                        success: function(data) {
                            result = converter(data[module]);
                        }
                    }, {async: false});
                metadataCache[cacheKey] = result;
            }

            return metadataCache[cacheKey];
        }
    };
    app.augment('bwc', Bwc, false);
})(SUGAR.App);
