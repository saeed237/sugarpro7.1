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
    events: {
        'click .add' : 'addItem',
        'click .remove' : 'removeItem',
        'click .btn[name=update_button]' : 'saveClicked',
        'click .btn.cancel_button' : 'cancelClicked'
    },
    visible: false,
    fieldOptions: null,
    fieldValues: null,
    defaultOption: null,
    fieldPlaceHolderTag: '[name=fieldPlaceHolder]',
    massUpdateViewName: 'massupdate-progress',
    /**
     * @property {Object} _defaultSettings The default settings to be applied to merge duplicates.
     * @property {Integer} _defaultSettings.maxRecordsToMerge Default number of records we can merge.
     * @protected
    */
    _defaultSettings: {
        maxRecordsToMerge: 5
    },

    initialize: function(options) {
        this.fieldValues = [{}];
        this.setMetadata(options);
        app.view.View.prototype.initialize.call(this, options);
        this.setDefault();

        this.delegateListFireEvents();
        this.before('render', this.isVisible);

        //event register for preventing actions
        // when user escapes the page without confirming deleting
        app.routing.before("route", this.beforeRouteDelete, this, true);
        $(window).on("beforeunload.delete" + this.cid, _.bind(this.warnDeleteOnRefresh, this));
    },
    delegateListFireEvents: function() {
        this.layout.on("list:massupdate:fire", this.show, this);
        this.layout.on("list:massaction:hide", this.hide, this);
        this.layout.on("list:massdelete:fire", this.warnDelete, this);
        this.layout.on("list:massexport:fire", this.massExport, this);
    },
    setMetadata: function(options) {
        options.meta.panels = options.meta.panels || [{fields:[]}];
        if(_.size(options.meta.panels[0].fields) === 0) {
            var moduleMetadata = app.metadata.getModule(options.module),
                massFields = [];
            _.each(moduleMetadata.fields, function(field){
                if(field.massupdate) {
                    var cloneField = app.utils.deepCopy(field);
                    cloneField.label = field.label || field.vname;
                    if(!cloneField.label) delete cloneField.label;
                    //TODO: Remove hack code for teamset after metadata return correct team type
                    if(cloneField.name === 'team_name') {
                        cloneField.type = 'teamset';
                        cloneField.css_class = 'span9';
                        cloneField = {
                            type: 'fieldset',
                            name: 'team_name',
                            label: cloneField.label,
                            css_class : 'row-fluid',
                            fields: [
                                cloneField,
                                {
                                    'name' : 'team_name_type',
                                    'type' : 'bool',
                                    'text' : 'LBL_SELECT_APPEND_TEAMS',
                                    'css_class' : 'span3'
                                }
                            ]
                        };
                    }
                    if(cloneField.type === 'bool') {
                        cloneField.type = 'enum';
                        cloneField.options = 'checkbox_dom';
                    }
                    massFields.push(cloneField);
                }
            });
            options.meta.panels[0].fields = massFields;
        }
    },
    _render: function() {
        var result = app.view.View.prototype._render.call(this),
            self = this;

        if (this.$(".select2.mu_attribute")) {
            this.$(".select2.mu_attribute")
                .select2({
                    width: '100%',
                    minimumResultsForSearch: 5
                })
                .on("change", function(evt) {
                    var $el = $(this),
                        name = $el.select2('val'),
                        index = $el.data('index');
                    var option = _.find(self.fieldOptions, function(field){
                        return field.name == name;
                    });
                    self.replaceUpdateField(option, index);
                    self.placeField($el);
                });
            this.$(".select2.mu_attribute").each(function(){
                self.placeField($(this));
            });
        }

        if(this.fields.length == 0) {
            this.hide();
        }
        return result;
    },
    isVisible: function() {
        return this.visible;
    },
    placeField: function($el) {
        var name = $el.select2('val'),
            index = $el.data('index'),
            fieldEl = this.getField(name).$el;

        if($el.not(".disabled") && fieldEl) {
            var holder = this.$(this.fieldPlaceHolderTag + "[index=" + index + "]");
            this.$("#fieldPlaceHolders").append(holder.children());
            holder.html(fieldEl);
        }
    },
    addItem: function(evt) {
        if(!$(evt.currentTarget).hasClass("disabled")) {
            this.addUpdateField();
            // this will not be called in an async process so no need to
            // check for the view to be disposed
            this.render();
        }
    },
    removeItem: function(evt) {
        var index = $(evt.currentTarget).data('index');
        this.removeUpdateField(index);
        // this will not be called in an async process so no need to
        // check for the view to be disposed
        this.render();
    },
    addUpdateField: function() {
        this.fieldValues.splice(this.fieldValues.length - 1, 0, this.defaultOption);
        this.defaultOption = null;
        this.setDefault();
    },
    removeUpdateField: function(index) {
        var fieldValue = this.fieldValues[index];
        if(fieldValue) {
            if(fieldValue.name) {
                this.model.unset(fieldValue.name);
                this.fieldValues.splice(index, 1);
            } else {
                //last item should be empty
                var removed = this.fieldValues.splice(index - 1, 1);
                this.defaultOption = removed[0];
            }
            this.setDefault();
        }
    },
    replaceUpdateField: function(selectedOption, targetIndex) {
        var fieldValue = this.fieldValues[targetIndex];

        if(fieldValue.name) {
            this.model.unset(fieldValue.name);
            this.fieldOptions.push(fieldValue);
            this.fieldValues[targetIndex] = selectedOption;
        } else {
            this.model.unset(this.defaultOption.name);
            this.fieldOptions.push(this.defaultOption);
            this.defaultOption = selectedOption;
        }
    },
    setDefault: function() {
        var assignedValues = _.pluck(this.fieldValues, 'name');
        if(this.defaultOption) {
            assignedValues = assignedValues.concat(this.defaultOption.name);
        }
        //remove the attribute options that has been already assigned
        this.fieldOptions = (this.meta) ? _.reject(_.flatten(_.pluck(this.meta.panels, 'fields')), function(field){
            return (field) ? _.contains(assignedValues, field.name) : false;
        }) : [];
        //set first item as default
        this.defaultOption = this.defaultOption || this.fieldOptions.splice(0, 1)[0];
    },

    /**
     * Create the Progress view unless it is initialized.
     * Return the progress view component in the same layout.
     *
     * @return {Backbone.View} MassupdateProgress view component.
     */
    getProgressView: function() {
        var progressView = this.layout.getComponent(this.massUpdateViewName);
        if (!progressView) {
            progressView = app.view.createView({
                context: this.context,
                name: this.massUpdateViewName,
                layout: this.layout
            });
            this.layout._components.push(progressView);
            this.layout.$el.append(progressView.$el);
        }
        progressView.render();
        return progressView;
    },

    /**
     * Create massupdate collection against the parent module.
     * Design the model synchronizing progressively.
     *
     * @param {String} baseModule parent module name.
     * @return {Backbone.Collection} Massupdate collection.
     */
    getMassUpdateModel: function(baseModule) {
        var massModel = this.context.get('mass_collection'),
            chunkSize = app.config.maxQueryResult,
            progressView = this.getProgressView(),
            massCollection = massModel ? _.extend({}, massModel, {
                defaultMethod: 'update',
                module: 'MassUpdate',
                baseModule: baseModule,

                /**
                 * Maximum number of retrial attempt.
                 *
                 * @property
                 */
                maxAllowAttempt: 3,

                /**
                 * Chunk for each execution.
                 *
                 * @property
                 */
                chunks: null,

                /**
                 * Discarded records due to the permission.
                 *
                 * @property
                 */
                discards: [],

                /**
                 * Current trial attempt number.
                 *
                 * @property
                 */
                attempt: 0,

                /**
                 * Pause status.
                 * If current job is on progress,
                 * the next queue will be paused.
                 *
                 * @property
                 */
                paused: false,

                /**
                 * Reset mass job.
                 */
                resetProgress: function() {
                    massModel.reset();
                    this.length = 0;
                },

                /**
                 * Update current progress job.
                 */
                updateProgress: function() {
                    this.remove(this.chunks.splice(0));
                    massModel.length = this.length;
                },

                /**
                 * Update the next chunk queue.
                 */
                updateChunk: function() {
                    if (!this.chunks) {
                        this.chunks = this.slice(0, chunkSize);
                        this.trigger('massupdate:start');
                    }
                    if (_.isEmpty(this.chunks)) {
                        this.chunks = this.slice(0, chunkSize);
                    }
                },

                /**
                 * Resume the job from the previous paused status.
                 */
                resumeFetch: function() {
                    if (!this._pauseOptions) {
                        return;
                    }
                    this.paused = false;
                    this.trigger('massupdate:resume');
                    this.fetch(this._pauseOptions);
                },

                /**
                 * Request pausing mass job.
                 */
                pauseFetch: function() {
                    this.paused = true;
                },

                /**
                 * {@inheritDoc}
                 * Instead of fetching entire set,
                 * split entire set into small chunks
                 * and repeat fetching until entire set is completed.
                 */
                sync: function(default_method, model, options) {
                    if (model.paused) {
                        this._pauseOptions = options;
                        this.trigger('massupdate:pause');
                        return;
                    }
                    this.method = options.method;

                    //split set into chunks.
                    this.updateChunk();
                    var callbacks = {
                        success: function(data, response) {
                            model.attempt = 0;
                            model.updateProgress();
                            model.trigger('massupdate:done');
                            if (model.length === 0) {
                                model.trigger('massupdate:end');
                                if (_.isFunction(options.success)) {
                                    options.success(model, data, response);
                                }
                            } else {
                                model.fetch(options);
                            }
                        },
                        error: function(xhr, status, error) {
                            model.attempt++;
                            model.trigger('massupdate:fail');
                            if (model.attempt <= model.maxAllowAttempt) {
                                model.fetch(options);
                            } else if (_.isFunction(options.error)) {
                                model.trigger('massupdate:end');
                                options.error(xhr, status, error);
                            }
                        },
                        complete: function(xhr, status) {
                            model.trigger('massupdate:always');
                            if (_.isFunction(options.complete)) {
                                options.complete(xhr, status);
                            }
                        }
                    },
                        method = options.method || this.defaultMethod,
                        data = this.getAttributes(options.attributes, method),
                        url = app.api.buildURL(baseModule, this.module, data, options.params);
                    app.api.call(method, url, data, callbacks);
                },

                /**
                 * Convert collection attributes into MassUpdate API format.
                 * @param {Object} attributes Collection attributes.
                 * @return {Object} MassUpdate data format.
                 */
                getAttributes: function(attributes, action) {
                    return {
                        massupdate_params: _.extend({
                            'uid': (this.entire) ? null : this.getAvailableList(action),
                            'entire': this.entire,
                            'filter': (this.entire) ? this.filterDef : null
                        }, attributes)
                    };
                },

                /**
                 * Check the access role for entire selection.
                 * Return only available model ids and store the discarded ids.
                 *
                 * @param action
                 * @return {Array} List of available model ids.
                 */
                getAvailableList: function(action) {
                    var action2permission = {
                            'update': 'edit',
                            'delete': 'delete'
                        },
                        list = [];
                    _.each(this.chunks, function(model) {
                        if (app.acl.hasAccessToModel(action2permission[action], model) !== false) {
                            list.push(model.id);
                        } else {
                            this.discards.push(model.id);
                        }
                    }, this);
                    return list;
                }
            }) : null;
        progressView.initCollection(massCollection);
        return massCollection;
    },

    /**
     * Popup dialog message to confirm delete action
     */
    warnDelete: function() {
        var self = this;
        this._modelsToDelete = self.getMassUpdateModel(self.module);

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(self._currentUrl, {trigger: false, replace: true});
        }

        self.hideAll();

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: app.lang.get('NTC_DELETE_CONFIRMATION_MULTIPLE'),
            onConfirm: _.bind(self.deleteModels, self),
            onCancel: function() {
                self._modelsToDelete = null;
            }
        });
    },

    /**
     * Popup browser dialog message to confirm delete action
     *
     * @return {String} the message to be displayed in the browser dialog
     */
    warnDeleteOnRefresh: function() {
        if (this._modelsToDelete) {
            return app.lang.get('NTC_DELETE_CONFIRMATION_MULTIPLE');
        }
    },

    /**
     * Delete the model once the user confirms the action
     */
    deleteModels: function() {
        var self = this,
            collection = self._modelsToDelete;
        var lastSelectedModels = _.clone(collection.models);
        if(collection) {
            collection.fetch({
                //Don't show alerts for this request
                showAlerts: false,
                method: 'delete',
                error: function() {
                    app.alert.show('error_while_mass_update', {level:'error', title: app.lang.getAppString('ERR_INTERNAL_ERR_MSG'), messages: app.lang.getAppString('ERR_HTTP_500_TEXT'), autoClose: true});
                },
                success: function(data, response) {
                    self.layout.trigger("list:records:deleted", lastSelectedModels);
                    var redirect = self._targetUrl !== self._currentUrl;
                    if(response.status == 'done') {
                        //TODO: Since self.layout.trigger("list:search:fire") is deprecated by filterAPI,
                        //TODO: Need trigger for fetching new record list
                        self.layout.context.reloadData({showAlerts: false});
                    } else if (response.status == 'queued') {
                        app.alert.show('jobqueue_notice', {level: 'success', title: app.lang.getAppString('LBL_MASS_UPDATE_JOB_QUEUED'), autoClose: true});
                    }
                    self._modelsToDelete = null;
                    if (redirect) {
                        self.unbindBeforeRouteDelete();
                        //Replace the url hash back to the current staying page
                        app.router.navigate(self._targetUrl, {trigger: true});
                    }
                }
            });
        }
    },

    /**
     * Pre-event handler before current router is changed
     *
     * @return {Boolean} true to continue routing, false otherwise
     */
    beforeRouteDelete: function () {
        if (this._modelsToDelete) {
            this.warnDelete(this._modelsToDelete);
            return false;
        }
        return true;
    },

    massExport: function(evt) {
        this.hideAll();
        var massExport = this.context.get("mass_collection");
        var exportOptions;

        if (massExport) {
            app.alert.show('massexport_loading', {level: 'process', title: app.lang.getAppString('LBL_PORTAL_LOADING')});

            // we need to get our filter cleaned up.
            exportOptions = app.data.parseOptionsForSync("read", massExport).params;

            app.api.exportRecords({
                    module: this.module,
                    uid: (massExport.entire) ? null : massExport.pluck('id'),
                    entire: massExport.entire,
                    filter: (massExport.entire) ? exportOptions.filter : null
                },
                this.$el,
                {
                    complete: function(data) {
                        app.alert.dismiss('massexport_loading');
                    }
                });
        }
    },

    save: function() {
        var massUpdate = this.getMassUpdateModel(this.module),
            attributes = this.getAttributes(),
            self = this;

        this.once('massupdate:validation:complete', function(validate) {
            var errors = validate.errors,
                emptyValues = validate.emptyValues,
                confirmMessage = app.lang.getAppString('LBL_MASS_UPDATE_EMPTY_VALUES');

            this.$(".fieldPlaceHolder .error").removeClass("error");
            this.$(".fieldPlaceHolder .help-block").hide();

            if(_.isEmpty(errors)) {
                confirmMessage += '<br>[' + emptyValues.join(',') + ']<br>' + app.lang.getAppString('LBL_MASS_UPDATE_EMPTY_CONFIRM') + '<br>';
                if(massUpdate) {
                    var fetchMassupdate = _.bind(function() {
                        var successMessages = this.buildSaveSuccessMessages(massUpdate);
                        massUpdate.fetch({
                            //Show alerts for this request
                            showAlerts: true,
                            attributes: attributes,
                            error: function() {
                                app.alert.show('error_while_mass_update', {level:'error', title: app.lang.getAppString('ERR_INTERNAL_ERR_MSG'), messages: app.lang.getAppString('ERR_HTTP_500_TEXT'), autoClose: true});
                            },
                            success: function(data, response) {
                                self.hide();
                                if(response.status == 'done') {
                                    //TODO: Since self.layout.trigger("list:search:fire") is deprecated by filterAPI,
                                    //TODO: Need trigger for fetching new record list
                                    self.collection.fetch({
                                        //Don't show alerts for this request
                                        showAlerts: false,
                                        // Boolean coercion.
                                        relate: !!self.layout.collection.link
                                    });
                                } else if(response.status == 'queued') {
                                    app.alert.show('jobqueue_notice', {level: 'success', messages: successMessages[response.status], autoClose: true});
                                }
                            }
                        });
                    }, this);
                    if(emptyValues.length == 0) {
                        fetchMassupdate.call(this);
                    } else {
                        app.alert.show('empty_confirmation', {
                            level: 'confirmation',
                            messages: confirmMessage,
                            onConfirm: fetchMassupdate
                        });
                    }
                }
            } else {
                this.handleValidationError(errors);
            }
        }, this);

        this.checkValidationError();
    },

    /**
     * Build dynamic success messages to be displayed if the API call is successful
     * This is overridden by massaddtolist view which requires different success messages
     *
     * @param massUpdateModel - contains the attributes of what records are being updated (used by override in massaddtolist)
     */
    buildSaveSuccessMessages: function(massUpdateModel) {
        return {
            done: app.lang.getAppString('LBL_MASS_UPDATE_SUCCESS'),
            queued: app.lang.getAppString('LBL_MASS_UPDATE_JOB_QUEUED')
        };
    },

    /**
     * By default attributes are retrieved directly off the model, but broken out to allow for manipulation before handing off to the API
     */
    getAttributes: function() {
        var values = [this.defaultOption].concat(this.fieldValues),
            attributes = [],
            fieldFilter = function(field) {
                return field && field.name;
            };
        values = _.chain(values)
            //Grab the field arrays from any fields that have child fields
            //and merge them with the top level field list
            .union(_.chain(values)
                .pluck("fields")
                .compact()
                .flatten()
                .value()
            )
            //Remove any dupes or empties
            .uniq(fieldFilter)
            .filter(fieldFilter)
            .value();

        _.each(values, function(value) {
            attributes = _.union(attributes,
                _.values(_.pick(value, 'name', 'id_name'))
            );
            if (value.name === 'parent_name') {
                attributes.push('parent_id', 'parent_type');
            }
        }, this);
        return _.pick(this.model.attributes, attributes);
    },

    checkValidationError: function() {
        var self = this,
            emptyValues = [],
            errors = {},
            validator = {},
            fields = _.initial(this.fieldValues).concat(this.defaultOption),
            i = 0;

        var fieldsToValidate = _.filter(fields, function(f) {
            return f.name;
        });

        if (_.size(fieldsToValidate)) {
            _.each(fieldsToValidate, function(field) {
                i++;
                validator = {};
                validator[field.name] = field;
                field.required = (_.isBoolean(field.required) && field.required) || (field.required && field.required == 'true') || false;

                var value = this.model.get(field.name);
                if (!value) {
                    emptyValues.push(app.lang.get(field.label, this.model.module));
                    this.model.set(field.name, '', {silent: true});
                    if (field.id_name) {
                        this.model.set(field.id_name, '', {silent: true});
                    }
                }
                this.model._doValidate(validator, errors, function(didItFail, fields, errors, callback) {
                    if (i === _.size(fieldsToValidate)) {
                        self.trigger('massupdate:validation:complete', {
                            errors: errors,
                            emptyValues: emptyValues
                        });
                    }
                });
            }, this);
        } else {
            this.trigger('massupdate:validation:complete', {
                errors: errors,
                emptyValues: emptyValues
            });
        }

        return;
    },
    handleValidationError: function(errors) {
        var self = this;
        _.each(errors, function (fieldErrors, fieldName) {
            var fieldEl = self.getField(fieldName).$el,
                errorEl = fieldEl.find(".help-block");
            fieldEl.addClass("error");
            if(errorEl.length == 0) {
                errorEl = $("<span>").addClass("help-block");
                errorEl.appendTo(fieldEl);
            }
            errorEl.show().html("");
            _.each(fieldErrors, function (errorContext, errorName) {
                errorEl.append(app.error.getErrorString(errorName, errorContext));
            });
        });
    },
    show: function() {
        this.hideAll();
        this.visible = true;
        this.defaultOption = null;
        this.model.clear();
        this.setDefault();

        var massModel = this.context.get('mass_collection');
        massModel.off(null, null, this);
        massModel.on('add remove reset massupdate:estimate', this.setDisabled, this);
        massModel.on('massupdate:start massupdate:end', this.setDisabledOnUpdate, this);

        // show will be called only on context.trigger("list:massupdate:fire").
        // therefore this should never be called in a situation in which
        // the view is disposed.
        this.$el.show();
        this.render();
    },
    /**
     * Hide all views that make up the list mass action section (ie. massupdate, massaddtolist)
     */
    hideAll: function() {
        this.layout.trigger("list:massaction:hide");
    },
    hide: function() {
        if (this.disposed) {
            return;
        }
        this.visible = false;
        this.$el.hide();
    },
    setDisabledOnUpdate: function() {
        var massUpdate = this.context.get('mass_collection');
        if (massUpdate.length == 0) {
            this.$('.btn[name=update_button]').removeClass('disabled');
        } else {
            this.$('.btn[name=update_button]').addClass('disabled');
        }
    },
    setDisabled: function() {
        var massUpdate = this.context.get('mass_collection');
        if (massUpdate.length == 0 || massUpdate.entire == true) {
            this.$('.btn[name=update_button]').addClass('disabled');
        } else {
            this.$('.btn[name=update_button]').removeClass('disabled');
        }
    },
    saveClicked: function(evt) {
        if(this.$(".btn[name=update_button]").hasClass("disabled") === false) {
            this.save();
        }
    },
    cancelClicked: function(evt) {
        this.hide();
    },
    unbindData: function() {
        var massModel = this.context.get("mass_collection");
        if (massModel) {
            massModel.off(null, null, this);
        }
        app.view.View.prototype.unbindData.call(this);
    },

    /**
     * Detach the event handlers for warning delete
     */
    unbindBeforeRouteDelete: function() {
        app.routing.offBefore("route", this.beforeRouteDelete, this);
        $(window).off("beforeunload.delete" + this.cid);
    },

    _dispose: function() {
        this.unbindBeforeRouteDelete();
        this.$('.select2.mu_attribute').select2('destroy');
        app.view.View.prototype._dispose.call(this);
    }
})
