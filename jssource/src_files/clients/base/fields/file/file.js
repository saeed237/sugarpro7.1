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
    fieldTag: 'input[type=file]',
    supportedImageExtensions: {
        'image/jpeg': 'jpg',
        'image/png': 'png',
        'image/gif': 'gif'
    },
    events: {
        'click [data-action=download]': 'startDownload',
        'click [data-action=delete]': 'deleteFile'
    },
    fileUrl: '',
    plugins: ['File','EllipsisInline'],

    /**
     * Contains id of {Data.Bean} from which file should be duplicated.
     *
     * @property {String} _duplicateModuleId
     * @protected
     */
    _duplicateModuleId: null,

    /**
     * Set ups id of {Data.Bean} from which file should be duplicated.
     *
     * @param {String} modelId Id of model
     */
    duplicateFromModel: function(modelId) {
        this._duplicateModuleId = modelId;
    },

    /**
     * Handler for delete file control
     *
     * Calls api to remove attached file from the model and
     * clear value and shows input[type=file] to upload new file
     * @param {Event} e
     */
    deleteFile: function(e) {
        var self = this;
        app.alert.show('delete_file_confirmation', {
            level: 'confirmation',
            messages: app.lang.get('LBL_FILE_DELETE_CONFIRM', self.module),
            onConfirm: function() {
                var data = {
                        module: self.module,
                        id: self.model.id,
                        field: self.name
                    },
                    callbacks = {
                        success: function() {
                            self.model.set(self.name, '');
                            self.model.save({}, {
                                //Show alerts for this request
                                showAlerts: {
                                    'process': true,
                                    'success': {
                                        messages: app.lang.get('LBL_FILE_DELETED', self.module)
                                    }
                                },
                                fields: [self.name]
                            });
                            if (self.disposed) {
                                return;
                            }
                            // Because delete button is enabled in edit mode only and
                            // bindDataChange is overrided to prevent rendering field
                            // in edit mode call render method manually
                            self.render();
                        },
                        error: function(data) {
                            // refresh token if it has expired
                            app.error.handleHttpError(data, {});
                        }
                    };
                app.api.file('delete', data, null, callbacks, {htmlJsonFormat: false});
            }
        });
    },

    /**
     * {@inheritDoc}
     *
     * Override field templates for merge-duplicate view.
     */
    _loadTemplate: function() {
        this._super('_loadTemplate');
        if (this.view.name === 'merge-duplicates') {
            this.template = app.template.getField(this.type,
                'merge-duplicates-' + this.tplName,
                this.module, this.tplName
            ) || app.template.empty;
            this.tplName = 'list';
        }
    },

    _render: function() {
        // This array will contain objects accessible in the view
        this.model = this.model || this.view.model;
        app.view.Field.prototype._render.call(this);
        return this;
    },
    format: function(value) {
        var attachments = [];
        // Not the same behavior either the value is a string or an array of files
        if (_.isArray(value)) {
            // If it's an array, we get the uri for each files in the response
            _.each(value, function(file) {
                var fileObj = {
                    name: file.name,
                    url: file.uri
                };
                attachments.push(fileObj);
            }, this);
        } else if (value) {
            // If it's a string, build the uri with the api library
            var isImage = this._isImage(this.model.get('file_mime_type')),
                forceDownload = !isImage,
                mimeType = isImage ? 'image' : '',
                fileObj = {
                    name: value,
                    mimeType: mimeType,
                    url: app.api.buildFileURL({
                            module: this.module,
                            id: this.model.id,
                            field: this.name
                        },
                        {
                            htmlJsonFormat: false,
                            passOAuthToken: false,
                            cleanCache: true,
                            forceDownload: forceDownload
                        })
                };
            attachments.push(fileObj);
        }
        return (this.tplName === "list") ? _.first(attachments) : attachments;
    },
    startDownload: function(e) {
        var uri = this.$(e.currentTarget).data('url');

        app.api.fileDownload(uri, {
            error: function(data) {
                // refresh token if it has expired
                app.error.handleHttpError(data, {});
            }
        }, {iframe: this.$el});
    },

    /**
     * {@inheritDoc}
     *
     * Overrides `change` event for file field.
     * We should call `render` method when change event is triggered if:
     * 1. it is not duplicate-merge view and field isn't in edit mode. If it is
     * in edit mode we cannot set a value of a type `file` input.
     * 2. it is duplicate-merge view and field is in edit mode. Because
     * for this view we display file field as label (not input[type=file])
     * in edit mode we should update view on change.
     *
     * Add handler for `duplicate:field` event to setup id of model from which file
     * field should be duplicated. We need two handlers for `duplicate:field` and
     * `duplicate:field:[fieldName]` to have ability to handle event when call is
     * for all fields from model or for certain field. e.g. in merge-duplicates
     * view we trigger this event for certain field and for copy bean we trigger
     * it for all fields.
     *
     * Also add handler for `data:sync:start` event
     * to add additional parameter in request (options.params) if file should be
     * duplicated from another model.
     */
    bindDataChange: function() {
        if (!this.model) {
            return;
        }
        this.model.on('change:' + this.name, function() {
            if (_.isUndefined(this.options.viewName) || this.options.viewName !== 'edit') {
                this.render();
            } else if (this.view.name === 'merge-duplicates' &&
                this.options.viewName &&
                this.options.viewName === 'edit'
            ) {
                this.render();
            }
            this.duplicateFromModel(null);
        }, this);

        this.model.on('duplicate:field', this._onDuplicate, this);
        this.model.on('duplicate:field:' + this.name, this._onDuplicate, this);
        this.model.on('data:sync:start', function(method, options) {
            if (!_.isNull(this._duplicateModuleId) &&
                (method == 'update' || method == 'create')
            ) {
                options.params = options.params || {};
                options.params[this.name + '_duplicateModuleId'] = this._duplicateModuleId;
            }
        }, this);
    },

    /**
     * Handler for `duplicate:field` event triggered on model. Set ups id of
     * model from which file field should be duplicated.
     *
     * @param {Data.Bean} model Model from which file should be duplicated.
     * @private
     */
    _onDuplicate: function(model) {
        if (model instanceof Backbone.Model) {
            this.duplicateFromModel(model.get('id'));
        }
    },

    /**
     * {@inheritdoc}
     *
     * Because input file uses full local path to file as value,
     * value can contains directory names.
     * Unformat value to have file name only in it.
     */
    unformat: function (value) {
        return value.split('/').pop().split('\\').pop();
    },

    /**
     * Check if input mime type is an image or not.
     *
     * @param {String} mime type.
     * @return {Boolean} true if mime type is an image.
     * @private
     */
    _isImage: function(mimeType) {
        return !!this.supportedImageExtensions[mimeType];
    }
})
