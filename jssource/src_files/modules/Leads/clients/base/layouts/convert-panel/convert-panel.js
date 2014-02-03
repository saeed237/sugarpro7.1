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
    extendsFrom: 'ToggleLayout',

    TOGGLE_DUPECHECK: 'dupecheck',
    TOGGLE_CREATE: 'create',

    availableToggles: {
        'dupecheck': {},
        'create': {}
    },

    //selectors
    accordionHeading: '.accordion-heading',
    accordionBody: '.accordion-body',

    initialize:function (options) {
        var convertPanelEvents;

        this.meta = options.meta;
        this._setModuleSpecificValues();

        convertPanelEvents = {};
        convertPanelEvents['click .accordion-heading.enabled'] = 'togglePanel';
        convertPanelEvents['click [name="associate_button"]'] = 'handleAssociateClick';
        convertPanelEvents['click [name="reset_button"]'] = 'handleResetClick';
        this.events = _.extend({}, this.events, convertPanelEvents);
        this.plugins = _.union(this.plugins || [], [
            'FindDuplicates'
        ]);

        this.currentState = {
            complete: false,
            dupeSelected: false
        };

        app.view.invokeParent(this, {type: 'layout', name: 'toggle', method: 'initialize', args: [options]});

        this.addSubComponents();

        this.context.on('lead:convert:populate', this.handlePopulateRecords, this);
        this.context.on('lead:convert:'+this.meta.module+':enable', this.handleEnablePanel, this);
        this.context.on('lead:convert:'+this.meta.moduleNumber+':open', this.handleOpenRequest, this);
        this.context.on('lead:convert:exit', this.turnOffUnsavedChanges, this);

        //if this panel is dependent on others - listen for changes and react accordingly
        this.addDependencyListeners();

        //open the first module upon the first dupe check completion
        if (this.meta.moduleNumber === 1) {
            this.once('lead:convert-dupecheck:complete', this.openPanel, this);
        }
    },

    /**
     * Retrieve module specific values (like modular singular name and whether dupe check is enabled at a module level
     * @private
     */
    _setModuleSpecificValues: function() {
        var module = this.meta.module;
        this.meta.modulePlural = app.lang.getAppListStrings("moduleList")[module] || module;
        this.meta.moduleSingular = app.lang.getAppListStrings("moduleListSingular")[module] || this.meta.modulePlural;

        //enable or disable duplicate check
        var moduleMetadata = app.metadata.getModule(module);
        this.meta.enableDuplicateCheck = (moduleMetadata && moduleMetadata.dupCheckEnabled) || this.meta.enableDuplicateCheck || false;
        this.meta.duplicateCheckOnStart = this.meta.enableDuplicateCheck && this.meta.duplicateCheckOnStart;
    },

    /**
     * Used by toggle layout to determine where to place sub-components
     * @param component
     * @returns {*}
     */
    getContainer: function(component) {
        if (component.name === 'convert-panel-header') {
            return this.$('[data-container="header"]');
        } else {
            return this.$('[data-container="inner"]');
        }
    },

    /**
     * Add all sub-components of the panel
     */
    addSubComponents: function() {
        this.addHeaderComponent();
        this.addDupeCheckComponent();
        this.addRecordCreateComponent();
    },

    /**
     * Add the panel header view
     */
    addHeaderComponent: function() {
        var header = app.view.createView({
            context: this.context,
            name: 'convert-panel-header',
            layout: this,
            meta: this.meta
        });
        this.addComponent(header);
    },

    /**
     * Add the dupe check layout along with events to listen for changes to dupe view
     */
    addDupeCheckComponent: function() {
        var leadsModel = this.context.get('leadsModel'),
            context = this.context.getChildContext({
            'module': this.meta.module,
            'forceNew': true,
            'skipFetch': true,
            'dupelisttype': 'dupecheck-list-select',
            'collection': this.createDuplicateCollection(leadsModel, this.meta.module)
        });
        context.prepare();

        this.duplicateView = app.view.createLayout({
            context: context,
            name: this.TOGGLE_DUPECHECK,
            layout: this,
            module: context.module
        });
        this.duplicateView.context.on('change:selection_model', this.handleDupeSelectedChange, this);
        this.duplicateView.collection.once('reset', this.dupeCheckComplete, this);
        this.addComponent(this.duplicateView);
    },

    /**
     * Add the create view
     */
    addRecordCreateComponent: function() {
        var context = this.context.getChildContext({
            'module': this.meta.module,
            forceNew: true,
            create: true
        });
        context.prepare();

        this.createView = app.view.createView({
            context: context,
            name: this.TOGGLE_CREATE,
            module: context.module,
            layout: this
        });

        this.createView.meta = this.removeFieldsFromMeta(this.createView.meta, this.meta);
        this.createView.enableHeaderButtons = false;
        this.addComponent(this.createView);
    },

    /**
     * Sets the listeners for changes to the dependent modules.
     */
    addDependencyListeners: function () {
        _.each(this.meta.dependentModules, function(details, module) {
            this.context.on('lead:convert:'+module+':complete', this.updateFromDependentModuleChanges, this);
            this.context.on('lead:convert:'+module+':reset', this.resetFromDependentModuleChanges, this);
        }, this);
    },

    /**
     * When duplicate results are received (or dupe check did not need to be run) toggle to the appropriate view
     */
    dupeCheckComplete: function() {
        this.currentState.dupeCount = this.duplicateView.collection.length;
        if (this.currentState.dupeCount !== 0) {
            this.showComponent(this.TOGGLE_DUPECHECK);
        } else {
            this.showComponent(this.TOGGLE_CREATE);
        }
        this.trigger('lead:convert-dupecheck:complete', this.currentState.dupeCount);
    },

    /**
     * Removes fields from the meta and replaces with empty html container based on the modules config option - hiddenFields.
     * For example.  Account name drop-down should not be available on contact and opportunity module.
     * @param meta
     * @param moduleMeta
     * @return {*}
     */
    removeFieldsFromMeta: function(meta, moduleMeta){
        _.each(meta.panels, function(panel){
            _.each(panel.fields, function(field, index, list){
                if (_.isString(field)) {
                    field = {name: field};
                }
                if (_.contains(moduleMeta.hiddenFields, field.name || field)) {
                    field.readonly = true;
                    field.required = false;
                    list[index] = field;
                }
            });
        }, this);
        return meta;
    },

    /**
     * Open/close the accordion body for this panel
     */
    togglePanel: function() {
        this.$(this.accordionBody).collapse('toggle');
    },

    /**
     * When one panel is completed it notifies the next panel to open
     * This function handles that request...
     * - passing along the request to the next if already complete or is not enabled
     * - opening the panel otherwise
     */
    handleOpenRequest: function() {
        if (this.currentState.complete || !this.isPanelEnabled()) {
            //already complete, pass along to the next guy
            this.requestNextPanelOpen();
        } else {
            this.openPanel();
        }
    },

    /**
     * Check if the the current panel is enabled
     * @returns {Boolean}
     */
    isPanelEnabled: function() {
        return this.$(this.accordionHeading).hasClass('enabled');
    },

    /**
     * Open the body of the panel if enabled
     */
    openPanel: function () {
        //only open the panel if it is enabled
        if (this.isPanelEnabled()) {
            this.$(this.accordionBody).collapse('show');
        }
    },

    /**
     * Close the body of the panel
     */
    closePanel: function() {
        this.$(this.accordionBody).collapse('hide');
    },

    /**
     * Handle click of Associate button - running validation if on create view or marking complete if on dupe view
     * @param event
     */
    handleAssociateClick: function(event) {
        //ignore clicks if button is disabled
        if (!$(event.currentTarget).hasClass('disabled')) {
            if (this.currentToggle === this.TOGGLE_CREATE) {
                this.runCreateValidation();
            } else {
                this.markPanelComplete(this.duplicateView.context.get('selection_model'));
            }
        }
        event.stopPropagation();
    },

    /**
     * Run validation, report errors as appropriate, mark panel complete if success
     */
    runCreateValidation: function() {
        var view = this.createView,
            model = view.model;

        model.doValidate(view.getFields(view.module), _.bind(function(isValid) {
            if (isValid) {
                this.markPanelComplete(model);
            }
        }, this));
    },

    /**
     * Mark the panel as complete, close the panel body, and tell the next panel to open
     * @param model
     */
    markPanelComplete: function(model) {
        var displayMessage = (this.currentToggle === this.TOGGLE_CREATE) ? 'LBL_CONVERT_MODULE_ASSOCIATED_NEW_SUCCESS' : 'LBL_CONVERT_MODULE_ASSOCIATED_SUCCESS';

        this.currentState.associatedName = this.getDisplayName(model);
        this.currentState.complete = true;
        this.context.trigger('lead:convert-panel:complete', this.meta.module, model);
        this.trigger('lead:convert-panel:complete', this.currentState.associatedName);
        app.alert.show('panel_associate_complete', {
            level: 'success',
            title: app.lang.get('LBL_CONVERT_MODULE_ASSOCIATED', this.module, {moduleName:this.meta.moduleSingular}),
            messages: app.lang.get(
                displayMessage,
                this.module,
                {moduleNameLower:this.meta.moduleSingular.toLowerCase(),recordName:this.currentState.associatedName}
            ),
            autoClose: true
        });

        //disable sub-panel until reset
        this.$(this.accordionBody).addClass('disabled');

        this.closePanel();

        //now tell the next panel to open
        this.requestNextPanelOpen();
    },

    requestNextPanelOpen: function() {
        this.context.trigger('lead:convert:'+(this.meta.moduleNumber+1)+':open');
    },

    /**
     * Special logic for grabbing the display name for a module
     * using the name fields if they exist or a 'name' field if it exists
     *
     * @param model
     * @return {String}
     */
    getDisplayName: function(model) {
        var moduleFields = app.metadata.getModule(this.meta.module).fields,
            displayName = '';

        if (model.has('name')) {
            displayName = model.get('name');
        } else if (moduleFields.name && moduleFields.name['db_concat_fields']) {
            _.each(moduleFields.name['db_concat_fields'], function(field) {
                if (model.has(field)) {
                    displayName += model.get(field) + ' ';
                }
            });
        }
        return displayName.trim();
    },

    /**
     * When reset button is clicked - reset this panel and open it
     * @param event
     */
    handleResetClick: function(event) {
        this.resetPanel();
        this.openPanel();
        event.stopPropagation();
    },

    /**
     * Reset the panel back to a state the user can modify associated values
     */
    resetPanel: function() {
        this.$(this.accordionBody).removeClass('disabled');
        this.currentState.complete = false;
        this.context.trigger('lead:convert-panel:reset', this.meta.module);
        this.trigger('lead:convert-panel:reset');
    },

    /**
     * Track when a duplicate has been selected and notify the panel so it can enable the Associate button
     */
    handleDupeSelectedChange: function() {
        this.currentState.dupeSelected = this.duplicateView.context.has('selection_model');
        this.trigger('lead:convert:duplicate-selection:change');
    },

     /**
     * Wrapper to check whether to fire the duplicate check event
     */
    triggerDuplicateCheck: function() {
        if (this.shouldDupeCheckBePerformed(this.createView.model)) {
            this.trigger('lead:convert-dupecheck:pending');
            this.duplicateView.context.trigger("dupecheck:fetch:fire", this.createView.model, {
                //Show alerts for this request
                showAlerts: true
            });
        } else {
            this.dupeCheckComplete();
        }
    },

    /**
     * Check if duplicate check should be performed
     * dependent on enableDuplicateCheck setting and required dupe check fields
     * @param model
     */
    shouldDupeCheckBePerformed: function(model) {
        var performDuplicateCheck = this.meta.enableDuplicateCheck;

        if (this.meta.duplicateCheckRequiredFields) {
            _.each(this.meta.duplicateCheckRequiredFields, function (field) {
                if (_.isEmpty(model.get(field))) {
                    performDuplicateCheck = false;
                }
            });
        }
        return performDuplicateCheck;
    },

    /**
     * Populates the record view from the passed in model and then kick off the dupe check
     *
     * @param model
     */
    handlePopulateRecords: function(model) {
        this.populateRecords(model, this.meta.fieldMapping);
        if(this.meta.duplicateCheckOnStart) {
            this.triggerDuplicateCheck();
        }
    },

    /**
     * Use the convert metadata to determine how to map the lead fields to module fields
     *
     * @param model
     * @param fieldMapping
     * @return {Boolean} whether the create view model has changed
     */
    populateRecords:function (model, fieldMapping) {
        var hasChanged = false;
        _.each(fieldMapping, function (sourceField, targetField) {
            if (model.has(sourceField) && model.get(sourceField) !== this.createView.model.get(targetField)) {
                this.createView.model.set(targetField, model.get(sourceField));
                hasChanged = true;
            }
        }, this);
        return hasChanged;
    },

    /**
     * Enable the panel
     *
     * @param isEnabled add/remove the enabled flag on the header
     */
    handleEnablePanel: function(isEnabled) {
        var $header = this.$(this.accordionHeading);
        if (isEnabled) {
            if (!this.currentState.complete) {
                this.triggerDuplicateCheck();
            }
            $header.addClass('enabled');
        } else {
            $header.removeClass('enabled');
        }
    },

    /**
     * Updates the attributes on the model based on the changes from dependent modules duplicate view.
     * Uses dependentModules property - fieldMappings
     *
     * @param moduleName
     * @param model
     */
    updateFromDependentModuleChanges: function(moduleName, model) {
        var dependencies = this.meta.dependentModules,
            modelChanged = false;
        if (dependencies && dependencies[moduleName] && dependencies[moduleName].fieldMapping) {
            modelChanged = this.populateRecords(model, dependencies[moduleName].fieldMapping);
            if (modelChanged) {
                this.triggerDuplicateCheck();
            }
        }
    },

    /**
     * Resets the state of the panels based on a dependent module being reset
     */
    resetFromDependentModuleChanges: function(moduleName) {
        var dependencies = this.meta.dependentModules;
        if (dependencies && dependencies[moduleName]) {
            //if dupe check has already been run, reset but don't run again yet - just update status
            if (this.currentState.dupeCount) {
                this.duplicateView.collection.reset();
            }
            this.resetPanel();
        }
    },

    turnOffUnsavedChanges: function() {
        this.createView.model.changed = {};
    },

    _dispose: function() {
        this.duplicateView.context.off(null, null, this);
        this.duplicateView.collection.off(null, null, this);
        app.view.invokeParent(this, {type: 'layout', name: 'toggle', method: '_dispose'});
    }
})
