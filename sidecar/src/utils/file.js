
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

(function(app) {

    /**
   	 * File module provides methods to help with hanlding uploading error checking and validation
   	 *
   	 * @class Utils.File
   	 * @singleton
   	 * @alias SUGAR.App.file
   	 */
    app.augment('file', (function() {

        return {

            /**
             * Search given view for any file input fields, upload the files and attach to the bean
             *
             * @param {Backbone.View} view a view to search for file input fields and containing a model of type app.Bean
             * @param {Object} [callbacks] success or error callbacks that should be called
             * @param {Object} [options] api options to pass to the API behind the bean.uploadFile
             * @param {Boolean} [showAlert=true] whether or not to show the "Uploading" alert
             */
            checkFileFieldsAndProcessUpload : function(view, callbacks, options, showAlert) {
                callbacks = callbacks || {};
                options = options || {};
                showAlert = _.isUndefined(showAlert) ? true : showAlert;

                // Check if there are attachments
                var fields = this._getAttachmentFields(view);

                // Process attachment uploads
                if (fields.length > 0) {
                    if (showAlert) {
                        app.alert.show('upload', {level: 'process', title: 'LBL_UPLOADING', autoclose: false});
                    }
                    this._recursiveFileUpload(fields, view.model, callbacks, options, showAlert);
                } else {
                    if (callbacks.success) callbacks.success({});
                }
            },

            /**
             * Recursively upload all of the given files and call the appropriate callback on completion
             * Note: uploads are processed asynchronously, but one by one
             *
             * @param {Array} fields array of fields to upload to the given model
             * @param {app.Bean} model to attach the given fields to (requires the uploadFile function on the model)
             * @param {Object} [callbacks] success or error callbacks that should be called
             * @param {Object} [options] api options to pass to the API behind the bean.uploadFile
             * @param {Boolean} [showAlert=true] whether or not "Uploading" alert was shown (and we need to dismiss)
             * @param {Object} [results]
             * @private
             */
            _recursiveFileUpload: function(fields, model, callbacks, options, showAlert, results) {
                results = results || {};

                var $field, fieldName;

                if (fields.length === 0) {
                    if (callbacks.success) callbacks.success(results);
                    return;
                }

                $field = $(fields.shift());
                fieldName = $field.attr("name");

                model.uploadFile(fieldName, $field, {
                        field: fieldName,
                        success:_.bind(function(data) {
                            //compile results for eventual success callback
                            _.extend(results, data);

                            //if out of files to process, wrap it up
                            if (fields.length === 0) {
                                app.alert.dismiss('upload');
                                if (callbacks.success) callbacks.success(results);
                            } else {
                                //still more files to process, keep going
                                this._recursiveFileUpload(fields, model, callbacks, options, showAlert, results);
                            }
                        }, this),
                        error:_.bind(function(error) {
                            // Set model to new by removing it's id attribute. Note that in our initial attempt
                            // to upload file(s) we set delete_if_fails true so server has marked record deleted: 1
                            // Since we may have only create privs (e.g. we can't edit/delete Notes), we'll start anew.
                            if (options && options.deleteIfFails !== false) {
                                model.unset('id', {silent: true});
                            }

                            // All or nothing .. if uploading 1..* attachments, if any one fails the whole atomic
                            // operation has failed; so we really want to trigger error and possibly start over.
                            if (showAlert) app.alert.dismiss('upload');
                            this._triggerFieldValidationError(error, model, fieldName);

                            if (callbacks.error) callbacks.error(error);
                        }, this)
                    },
                    options);
            },

            /**
             * Trigger validation errors on the model
             *
             * @param {Object} error returned from an api call
             * @param {Backbone.Model} model that contains the files we need to trigger error validation on
             * @param {String} fieldName name of the field that failed to upload
             * @private
             */
            _triggerFieldValidationError: function(error, model, fieldName) {
                var errors = {};
                errors[error.responseText] = {};
                model.trigger('error:validation:' + fieldName, errors);
                model.trigger('error:validation', errors);
            },

            /**
             * Search the given view for any file input fields that have a name attribute and a value
             *
             * @param {Backbone.View} view a view to search for file input fields on
             * @return {Array}
             * @private
             */
            _getAttachmentFields: function(view) {
                return _.filter(view.$(":file"), function(field) {
                    var $field = $(field),
                        fieldValue = $field.val();
                    return (!_.isEmpty(fieldValue) && !_.isEmpty($field.attr("name")));
                }, this);
            }
        }

    })(), false);
})(SUGAR.App);
