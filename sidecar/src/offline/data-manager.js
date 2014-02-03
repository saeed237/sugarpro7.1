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

    var SYNC_STATES = {
        CREATE: 1,
        UPDATE: 2,
        DELETE: 3
    };

    var _methods = {};
    _methods[SYNC_STATES.CREATE] = "create";
    _methods[SYNC_STATES.UPDATE] = "update";
    _methods[SYNC_STATES.DELETE] = "delete";

    app.Offline.dataManager = {

        SYNC_STATES: SYNC_STATES,

        migrate: function(metadata, options) {
            options || (options = {});

            app.dataManager.beanModel = app.Offline.Bean;
            //app.dataManager.beanCollection = app.Offline.BeanCollection;

            if (!app.Offline.storageAdapter.open()) {
                if (options.callback) options.callback.call(this, "Can't open database"); // TODO: Pass something meaningful in the callback
                return;
            }

            app.Offline.storageAdapter.migrate(metadata, options.oldMetadata,
                function() {
                    if (options.callback) options.callback.call(this, null, metadata);
                },
                function(error) {
                    if (options.callback) options.callback.call(this, error);
                }
            );
        },

        /**
         * Backbone sync override.
         * @param method
         * @param model
         * @param options
         * @ignore
         */
        sync: function(method, model, options) {
            options = options || {};

            if (options.skipOffline) {
                return app.dataManager.sync(method, model, options);
            }

            var prevState = model.syncState;
            var prevModifiedAt = model.modifiedAt;
            var callback, origSuccess, origError;

            origSuccess = options.success;
            origError = options.error;

            app.logger.trace('offline-sync-' + (options.synced ? '[synced]' : '[not_synced]') + '-' + method + ": " + model);

            if (options.synced && (method != "read")) {
                options.error = function(error) {
                    if (!(model instanceof app.BeanCollection)) {
                        // Rollback previous state in case of offline storage failure
                        model.syncState = prevState;
                        model.modifiedAt = prevModifiedAt;
                    }
                    if (origError) origError(error);
                };

                if (!(model instanceof app.BeanCollection)) {
                    model.syncState = null;
                    model.modifiedAt = null;
                }

                if (prevState == SYNC_STATES.DELETE) {
                    method = "delete";
                }
                else if (prevState == SYNC_STATES.CREATE) {
                    method = method == "delete" ? "delete" : "update";
                }
            }
            else {
                if (method != "read") {
                    if (model.isNew()) {
                        model.syncState = SYNC_STATES.CREATE;
                        model.modifiedAt = (new Date()).getTime();
                    }
                    else if (prevState != SYNC_STATES.CREATE) {
                        model.modifiedAt = (new Date()).getTime();
                    }

                    if (model.syncState == null) {
                        model.syncState = method == "delete" ? SYNC_STATES.DELETE : SYNC_STATES.UPDATE;
                    }

                    if ((prevState != SYNC_STATES.CREATE) && (method == "delete")) {
                        method = "update";
                    }
                }

                callback = function(data) {
                    var error = null;
                    if (data instanceof app.Offline.DbError) error = data;
                    if (error) {
                        // TODO: Perhaps, we should trigger an event here
                        app.logger.error('Offline sync failed');
                        app.logger.error(error);
                    }
                    else {
                        app.logger.debug("Got data from offline storage, isEmpty: " + _.isEmpty(data));
                        // TODO: Should I update the model with data for "read" action?
                        // Or should I invoke the success callback
                    }

                    // We should skip remote sync if we are explicitly asked to or
                    // we just fetched a record that has not been synced with the server yet
                    var skipRemoteSync = options.skipRemoteSync ||
                        (model instanceof app.BeanCollection) ||
                        ((method == "delete") && (prevState == SYNC_STATES.CREATE)) ||
                        ((method == "read") && (model.syncState != null));

                    if (!skipRemoteSync) {

                        options.success = function(data) {
                            options.synced = true;
                            options.oldId = model.id;
                            options.success = origSuccess;
                            options.error = origError;
                            model.save(data, options);
                        };
                        options.error = function(err) {
                            app.logger.warn("Remote sync failed");
                            app.logger.warn(err);
                            if (origError) origError(err);
                        };

                        // Call remote sync
                        app.logger.trace('calling remote sync');
                        app.dataManager.sync(_methods[model.syncState] || method, model, options);
                    }
                    else {
                        if (error && origError) origError(error);
                        else if (origSuccess) origSuccess(data);
                    }

                }; // callback

                options.success = callback;
                options.error = callback;

            }

            app.Offline.storageAdapter.sync(method, model, options);
        }

    };

})(SUGAR.App);