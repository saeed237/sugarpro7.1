/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
({
    extendsFrom: 'RecordView',
    editAllMode: false,

    SAVEACTIONS: {
        SAVE_AND_CREATE: 'saveAndCreate',
        SAVE_AND_VIEW: 'saveAndView'
    },

    enableDuplicateCheck: false,
    dupecheckList: null, //duplicate list layout

    saveButtonName: 'save_button',
    cancelButtonName: 'cancel_button',
    saveAndCreateButtonName: 'save_create_button',
    saveAndViewButtonName: 'save_view_button',
    restoreButtonName: 'restore_button',

    /**
     * Initialize the view and prepare the model with default button metadata
     * for the current layout.
     */
    initialize: function (options) {
        var createViewEvents = {};
        createViewEvents['click a[name=' + this.saveButtonName + ']'] = 'save';
        createViewEvents['click a[name=' + this.cancelButtonName + ']'] = 'cancel';
        createViewEvents['click a[name=' + this.saveAndCreateButtonName + ']'] = 'saveAndCreate';
        createViewEvents['click a[name=' + this.saveAndViewButtonName + ']'] = 'saveAndView';
        createViewEvents['click a[name=' + this.restoreButtonName + ']'] = 'restoreModel';
        this.events = _.extend({}, this.events, createViewEvents);
        this.plugins = _.union(this.plugins || [], [
            'FindDuplicates'
        ]);

        //add states for create view
        this.STATE = _.extend({}, this.STATE, {
            CREATE: 'create',
            SELECT: 'select',
            DUPLICATE: 'duplicate'
        });
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'initialize', args:[options]});
        this.model.off("change", null, this);

        //keep track of what post-save action was chosen in case user chooses to ignore dupes
        this.context.lastSaveAction = null;

        //listen for the select and edit button
        this.context.on('list:dupecheck-list-select-edit:fire', this.editExisting, this);

        //extend the record view definition
        this.meta = _.extend({}, app.metadata.getView(this.module, 'record'), this.meta);

        //enable or disable duplicate check?
        var moduleMetadata = app.metadata.getModule(this.module);
        this.enableDuplicateCheck = (moduleMetadata && moduleMetadata.dupCheckEnabled) || false;

        var fields = (moduleMetadata && moduleMetadata.fields) ? moduleMetadata.fields : [];

        this.model.relatedAttributes = this.model.relatedAttributes || {};
        _.each(fields, function (field) {
            var userId, userName, isDuplicate;
            if (((field.name && field.name === 'assigned_user_id') || (field.id_name && field.id_name === 'assigned_user_id')) &&
                (field.type && field.type === 'relate')) {

                // set the default assigned user as current user, unless we are copying another record
                isDuplicate = this.model.has('assigned_user_id') && this.model.has('assigned_user_name');
                userId = isDuplicate ? this.model.get('assigned_user_id') : app.user.id;
                userName = isDuplicate ?
                    this.model.get('assigned_user_name') :
                    app.user.attributes.full_name;

                this.model.set('assigned_user_id', userId);
                this.model.set('assigned_user_name', userName);
                this.model.relatedAttributes.assigned_user_id = app.user.id;
                this.model.relatedAttributes.assigned_user_name = app.user.attributes.full_name;
            }
        }, this);

        this.model.on("error:validation", function(){
            this.alerts.showInvalidModel();
        }, this);

    },

    /**
     * Check unsaved changes
     *
     * @return true if current model contains unsaved changes
     * @link {app.plugins.view.editable}
     */
    hasUnsavedChanges: function() {
        if (this.resavingAfterMetadataSync)
            return false;

        return this.model.isNew() && this.model.hasChanged();
    },

    handleSync: function () {
        //override handleSync since there is no need to save the previous model state
    },

    delegateButtonEvents: function () {
        //override record view's button delegation
    },

    _render: function () {
        app.view.invokeParent(this, {type: 'view', name: 'record', method: '_render'});

        this.setButtonStates(this.STATE.CREATE);

        this.renderDupeCheckList();

        //SP-1502: Broadcast model changes so quickcreate field can keep track of unsaved changes
        app.events.trigger('create:model:changed', false);
        this.model.on('change', function() {
            app.events.trigger('create:model:changed', this.hasUnsavedChanges());
        }, this);
    },

    /**
     * Determine appropriate save action and execute it
     * Default to saveAndClose
     */
    save: function () {
        switch (this.context.lastSaveAction) {
            case this.SAVEACTIONS.SAVE_AND_CREATE:
                this.saveAndCreate();
                break;
            case this.SAVEACTIONS.SAVE_AND_VIEW:
                this.saveAndView();
                break;
            default:
                this.saveAndClose();
        }
    },

    /**
     * Save and close drawer
     */
    saveAndClose: function () {
        this.initiateSave(_.bind(function () {
            if (!this.model.id) {
                //If user creates a record he does not have access to, he will see a warning message
                this.alerts.showSuccessButDeniedAccess();
            }
            if(app.drawer){
                app.drawer.close(this.context, this.model);
            }
        }, this));
    },

    /**
     * Handle click on the cancel link
     */
    cancel: function () {
        if(app.drawer){
            app.drawer.close(this.context);
        }
    },

    /**
     * Handle click on save and create another link
     */
    saveAndCreate: function () {
        this.context.lastSaveAction = this.SAVEACTIONS.SAVE_AND_CREATE;
        this.initiateSave(_.bind(function () {
            if (this.model.id) {
                this.clear();
                this.model.set(this.model.relatedAttributes);
                this.resetDuplicateState();
            } else if (app.drawer) {
                //If user creates a record he does not have access to, close the drawer so it goes to the list view
                //Keeping the drawer opened is not possible because of the 404 error handler loading the error page
                this.alerts.showSuccessButDeniedAccess();
                if(app.drawer){
                    app.drawer.close(this.context, this.model);
                }
            }
        }, this));
    },

    /**
     * Handle click on save and view link
     */
    saveAndView: function () {
        this.context.lastSaveAction = this.SAVEACTIONS.SAVE_AND_VIEW;
        this.initiateSave(_.bind(function () {
            if (!this.model.id) {
                //If user creates a record he does not have access to, close the drawer so it goes to the list view
                this.alerts.showSuccessButDeniedAccess();
                if(app.drawer){
                    app.drawer.close(this.context, this.model);
                }
            } else {
                app.navigate(this.context, this.model);
            }
        }, this));
    },

    /**
     * Handle click on restore to original link
     */
    restoreModel: function () {
        this.model.clear();
        if (this._origAttributes) {
            this.model.set(this._origAttributes);
            this.model.isCopied = true;
        }
        this.createMode = true;
        if (!this.disposed) {
            this.render();
        }
        this.setButtonStates(this.STATE.CREATE);
    },

    /**
     * Check for possible duplicates before creating a new record
     * @param callback
     */
    initiateSave: function (callback) {
        this.disableButtons();
        async.waterfall([
            _.bind(this.validateModelWaterfall, this),
            _.bind(this.dupeCheckWaterfall, this),
            _.bind(this.createRecordWaterfall, this)
        ], _.bind(function (error) {
            this.enableButtons();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {
                this.context.lastSaveAction = null;
                callback();
            }
        }, this));
    },
    /**
     * Check to see if all fields are valid
     * @param callback
     */
    validateModelWaterfall: function(callback) {
        this.model.doValidate(this.getFields(this.module), function(isValid) {
            callback(!isValid);
        });
    },

    /**
     * Check for possible duplicate records
     * @param callback
     */
    dupeCheckWaterfall: function (callback) {
        var success = _.bind(function (collection) {
                if (this.disposed) {
                    callback(true);
                }
                if (collection.models.length > 0) {
                    this.handleDuplicateFound(collection);
                    callback(true);
                } else {
                    this.resetDuplicateState();
                    callback(false);
                }
            }, this),
            error = _.bind(function (e) {
                if (e.status == 412 && !e.request.metadataRetry) {
                    this.handleMetadataSyncError(e);
                } else {
                    this.alerts.showServerError();
                    callback(true);
                }
            }, this);
        if (this.skipDupeCheck() || !this.enableDuplicateCheck) {
            callback(false);
        } else {
            this.checkForDuplicate(success, error);
        }
    },

    /**
     * Create new record
     * @param callback
     */
    createRecordWaterfall: function (callback) {
        var success = function () {
                callback(false);
            },
            error = _.bind(function (e) {
                if (e.status == 412 && !e.request.metadataRetry) {
                    this.handleMetadataSyncError(e);
                } else if (e.status == 404) {
                    //Special case for 404 error. This happens when the user creates a record he won't have access to.
                    //In this case the POST request returns a 404 error. As it actually is a success, we want to prevent
                    //default error handlers and keep going, meaning closing the drawer and going back to the list view
                    callback();
                } else {
                    this.alerts.showServerError();
                    callback(true);
                }
            }, this);

        this.saveModel(success, error);
    },

    /**
     * Check the server to see if there are possible duplicate records.
     * @param success
     * @param error
     */
    checkForDuplicate: function (success, error) {
        var options = {
            //Show alerts for this request
            showAlerts: true,
            success: success,
            error: error
        };

        this.context.trigger("dupecheck:fetch:fire", this.model, options);
    },

    /**
     * Duplicate found: display duplicates and change buttons
     */
    handleDuplicateFound: function () {
        this.setButtonStates(this.STATE.DUPLICATE);
        this.dupecheckList.show();
        this.skipDupeCheck(true);
    },

    /**
     * Clear out all things related to duplicate checks
     */
    resetDuplicateState: function () {
        this.setButtonStates(this.STATE.CREATE);
        this.hideDuplicates();
        this.skipDupeCheck(false);
    },

    /**
     * Called when current record is being saved to allow customization of options and params
     * during save
     *
     * Override to return set of custom options
     *
     * @param {Object} options The current set of options that is going to be used.  This is hand for extending
     */
    getCustomSaveOptions: function (options) {
        return {};
    },

    /**
     * Create a new record
     * @param success
     * @param error
     */
    saveModel: function (success, error) {
        var self = this,
            options;
        success = _.wrap(success, function (func, model) {
            var successMessage = self.buildSuccessMessage(model);

            app.file.checkFileFieldsAndProcessUpload(self, {
                    success: function () {
                        var successKey = 'create-success';
                        func();
                        app.alert.show(successKey, {
                            level: 'success',
                            messages: successMessage,
                            autoClose: true,
                            autoCloseDelay: 10000,
                            onLinkClick: function() {
                                app.alert.dismiss(successKey);
                            }
                        });
                    }
                },
                {deleteIfFails: true}
            );
        });
        options = {
            success: success,
            error: error,
            viewed: true,
            relate: (self.model.link) ? true : null,
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': false,
                'error': false //error callback implements its own error handler
            },
            lastSaveAction: this.context.lastSaveAction
        };

        options = _.extend({}, options, self.getCustomSaveOptions(options));
        self.model.save(null, options);
    },

    /**
     * Using the model returned from the API call, build the success message
     * @param model
     * @returns {*}
     */
    buildSuccessMessage: function(model) {
        var modelAttributes,
            successLabel = 'LBL_RECORD_SAVED_SUCCESS',
            successMessageContext;

        //if we have model attributes, use them to build the message, otherwise use a generic message
        if (model && model.attributes) {
            modelAttributes = model.attributes;
        } else {
            modelAttributes = {};
            successLabel = 'LBL_RECORD_SAVED';
        }

        //use the model attributes combined with data from the view to build the success message context
        successMessageContext = _.extend({
            module: this.module,
            moduleSingularLower: this.moduleSingular.toLowerCase()
        }, modelAttributes);

        return app.lang.get(successLabel, this.module, successMessageContext);
    },

    /**
     * Check to see if we should skip duplicate check.
     * @param {Boolean} skip (optional) If specified, sets duplicate check to
     *  either true or false.
     * @return {*}
     */
    skipDupeCheck: function (skip) {
        var skipDupeCheck,
            saveButton = this.buttons[this.saveButtonName].getFieldElement();

        if (_.isUndefined(skip)) {
            skipDupeCheck = saveButton.data('skipDupeCheck');
            if (_.isUndefined(skipDupeCheck)) {
                skipDupeCheck = false;
            }
            return skipDupeCheck;
        } else {
            if (skip) {
                saveButton.data('skipDupeCheck', true);
            } else {
                saveButton.data('skipDupeCheck', false);
            }
        }
    },

    /**
     * Clears out field values
     */
    clear: function () {
        this.model.clear();
        if (!this.disposed) {
            this.render();
        }
    },

    /**
     * Make the specified record as the data to be edited, and merge the existing data.
     * @param model
     */
    editExisting: function (model) {
        var origAttributes = this.saveFormData(),
            skipDupeCheck = this.skipDupeCheck();

        this.model.clear();
        this.model.set(this.extendModel(model, origAttributes));

        this.createMode = false;
        if (!this.disposed) {
            this.render();
        }
        this.toggleEdit(true);

        this.hideDuplicates();
        this.skipDupeCheck(skipDupeCheck);
        this.setButtonStates(this.STATE.SELECT);
    },

    /**
     * Merge the selected record with the data entered in the form
     * @param newModel
     * @param origAttributes
     * @return {*}
     */
    extendModel: function (newModel, origAttributes) {
        var modelAttributes = _.clone(newModel.attributes);

        _.each(modelAttributes, function (value, key) {
            if (_.isUndefined(value) || _.isNull(value) ||
                ((_.isObject(value) || _.isArray(value) || _.isString(value)) && _.isEmpty(value))) {
                delete modelAttributes[key];
            }
        });

        return _.extend({}, origAttributes, modelAttributes);
    },

    /**
     * Save the data entered in the form
     * @return {*}
     */
    saveFormData: function () {
        this._origAttributes = _.clone(this.model.attributes);
        return this._origAttributes;
    },

    /**
     * Sets the dupecheck list type
     *
     * @param {String} type view to load
     */
    setDupeCheckType: function(type) {
        this.context.set('dupelisttype', type);
    },

    /**
     * Render duplicate check list table
     */
    renderDupeCheckList: function () {
        this.setDupeCheckType('dupecheck-list-edit');
        this.context.set('collection', this.createDuplicateCollection(this.model));

        if (_.isNull(this.dupecheckList)) {
            this.dupecheckList = app.view.createLayout({
                context: this.context,
                name: 'create-dupecheck',
                module: this.module
            });
            this.addToLayoutComponents(this.dupecheckList);
        }

        this.$('.headerpane').after(this.dupecheckList.$el);
        this.dupecheckList.hide();
        this.dupecheckList.render();
    },

    /**
     * Add component to layout's component list so it gets cleaned up properly on dispose
     *
     * @param component
     */
    addToLayoutComponents: function (component) {
        this.layout._components.push(component);
    },

    /**
     * Clear out duplicate list
     */
    hideDuplicates: function () {
        this.dupecheckList.hide();
    },

    /**
     * Change the behavior of buttons depending on the state that they are in
     * @param state
     */
    setButtonStates: function (state) {
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'setButtonStates', args:[state]});
        var $saveButtonEl = this.buttons[this.saveButtonName];
        if ($saveButtonEl) {
            switch (state) {
                case this.STATE.CREATE:
                case this.STATE.SELECT:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_SAVE_BUTTON_LABEL', this.module));
                    break;

                case this.STATE.DUPLICATE:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_IGNORE_DUPLICATE_AND_SAVE', this.module));
                    break;
            }
        }
    },

    /**
     * Disable buttons
     */
    disableButtons: function () {
        this.toggleButtons(false);
    },

    /**
     * Enable buttons
     */
    enableButtons: function () {
        this.toggleButtons(true);
    },

    /**
     * Enable or disable buttons
     * @param {boolean} enable
     */
    toggleButtons: function(enable) {
        _.each(this.buttons, function(button) {
            switch (button.type) {
                case 'button':
                case 'rowaction':
                    button.getFieldElement().toggleClass('disabled', !enable);
                    break;
                case 'actiondropdown':
                    button.$('a.dropdown-toggle').toggleClass('disabled', !enable);
                    break;
            }
        });
    },

    alerts: {
        showInvalidModel: function () {
            app.alert.show('invalid-data', {
                level: 'error',
                messages: 'ERR_RESOLVE_ERRORS',
                autoClose: true
            });
        },
        showServerError: function () {
            app.alert.show('server-error', {
                level: 'error',
                messages: 'ERR_GENERIC_SERVER_ERROR',
                autoClose: false
            });
        },
        showSuccessButDeniedAccess: function() {
            app.alert.show('invalid-data', {
                level: 'warning',
                messages: 'LBL_RECORD_SAVED_ACCESS_DENIED',
                autoClose: true,
                autoCloseDelay: 9000
            });
        }
    }

})
