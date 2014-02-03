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
    initialize:function (options) {
        this.convertPanels = {};
        this.associatedModels = {};
        this.dependentModules = {};
        this.noAccessRequiredModules = [];

        app.view.Layout.prototype.initialize.call(this, options);

        //create and place all the accordion panels
        this.initializePanels(this.meta.modules);

        //listen for panel status updates
        this.context.on('lead:convert-panel:complete', this.handlePanelComplete, this);
        this.context.on('lead:convert-panel:reset', this.handlePanelReset, this);

        //listen for Save button click in headerpane
        this.context.on('lead:convert:save', this.handleSave, this);

        this.before('render', this.checkRequiredAccess);
    },

    /**
     * Iterate over the modules defined in convert-main.php
     * Create a convert panel for each module defined there
     *
     * @param modulesMetadata
     */
    initializePanels: function(modulesMetadata) {
        var moduleNumber = 1;

        _.each(modulesMetadata, function (moduleMeta, key, modulesList) {
            //strip out modules that user does not have create access to
            if (!app.acl.hasAccess('create', moduleMeta.module)) {
                if (moduleMeta.required === true) {
                    this.noAccessRequiredModules.push(moduleMeta.module);
                }
                delete modulesList[key];
                return;
            }

            moduleMeta.moduleNumber = moduleNumber++;
            var view = app.view.createLayout({
                context: this.context,
                name: 'convert-panel',
                layout: this,
                meta: moduleMeta,
                type: 'convert-panel',
                platform: this.options.platform
            });

            //This is because backbone injects a wrapper element.
            view.$el.addClass('accordion-group');
            view.$el.data('module', moduleMeta.module);

            this.addComponent(view);
            this.convertPanels[moduleMeta.module] = view;
            if (moduleMeta.dependentModules) {
                this.dependentModules[moduleMeta.module] = moduleMeta.dependentModules;
            }
        }, this);
    },

    /**
     * Check if user is missing access to any required modules
     * @returns {boolean}
     */
    checkRequiredAccess: function() {
        //user is missing access to required modules - kick them out
        if (this.noAccessRequiredModules.length > 0) {
            this.denyUserAccess(this.noAccessRequiredModules);
            return false;
        }
        return true;
    },

    /**
     * Close lead convert and notify the user that they are missing required access
     * @param noAccessRequiredModules
     */
    denyUserAccess: function(noAccessRequiredModules) {
        var translatedModuleNames = [];

        _.each(noAccessRequiredModules, function(module) {
            translatedModuleNames.push(this.getModuleSingular(module));
        }, this);

        app.alert.show('convert_access_denied', {
            level: 'error',
            messages: app.lang.get('LBL_CONVERT_ACCESS_DENIED', this.module, {requiredModulesMissing:translatedModuleNames.join(', ')}),
            autoClose: false
        });
        app.drawer.close();
    },

    /**
     * Retrieve the translated module name
     * @param module
     * @returns {string}
     */
    getModuleSingular: function(module) {
        var modulePlural = app.lang.getAppListStrings("moduleList")[module] || module;
        return (app.lang.getAppListStrings("moduleListSingular")[module] || modulePlural);
    },

    _render: function () {
        app.view.Layout.prototype._render.call(this);

        //This is because backbone injects a wrapper element.
        this.$el.addClass('accordion');
        this.$el.attr('id','convert-accordion');

        //apply the accordion to this layout
        this.$(".collapse").collapse({toggle:false, parent:'#convert-accordion'});
        this.$(".collapse").on('shown hidden', _.bind(this.handlePanelCollapseEvent, this));

        //copy lead data down to each module when we get the lead data
        this.context.get('leadsModel').fetch({
            success: _.bind(function(model) {
                this.context.trigger("lead:convert:populate", model);
            }, this)
        });
    },

    /**
     * Catch collapse shown/hidden events and notify the panels via the context
     * @param event
     */
    handlePanelCollapseEvent: function(event) {
        //only respond to the events directly on the collapse (was getting events from tooltip propagated up
        if (event.target !== event.currentTarget) {
            return;
        }
        var module = $(event.currentTarget).data('module');
        this.context.trigger('lead:convert:' + module + ':' + event.type);
    },

    /**
     * When a panel is complete, add the model to the associatedModels array and notify any dependent modules
     * @param module that was completed
     * @param model
     */
    handlePanelComplete: function(module, model) {
        this.associatedModels[module] = model;
        this.handlePanelUpdate();
        this.context.trigger('lead:convert:'+module+':complete', module, model);
    },

    /**
     * When a panel is reset, remove the model from the associatedModels array and notify any dependent modules
     * @param module
     */
    handlePanelReset: function(module) {
        delete this.associatedModels[module];
        this.handlePanelUpdate();
        this.context.trigger('lead:convert:'+module+':reset', module);
    },

    /**
     * When a panel has been updated, check if any module's dependencies are met
     * and/or if all required modules have been completed
     */
    handlePanelUpdate: function() {
        this.checkDependentModules();
        this.checkRequired();
    },

    /**
     * Check if each module's dependencies are met and enable the panel if they are.
     * Dependencies are defined in the convert-main.php
     */
    checkDependentModules: function() {
        _.each(this.dependentModules, function (dependencies, dependentModuleName) {
            var isEnabled = _.all(dependencies, function(module, moduleName) {
                return (this.associatedModels[moduleName]);
            }, this);
            this.context.trigger("lead:convert:" + dependentModuleName + ":enable", isEnabled);
        }, this);
    },

    /**
     * Checks if all required modules have been completed
     * Enables the Save button if all are complete
     */
    checkRequired: function() {
        var showSave = _.all(this.meta.modules, function(module){
            if (module.required) {
                if (!this.associatedModels[module.module]) {
                    return false;
                }
            }
            return true;
        }, this);

        this.context.trigger('lead:convert-save:toggle', showSave);
    },

    /**
     * When save button is clicked, call the Lead Convert API
     */
    handleSave: function() {
        var convertModel, myURL;

        //disable the save button to prevent double click
        this.context.trigger('lead:convert-save:toggle', false);

        app.alert.show('processing_convert', {level: 'process', title: app.lang.getAppString('LBL_SAVING')});

        convertModel = new Backbone.Model(_.extend({}, {'modules' : this.associatedModels}));
        myURL = app.api.buildURL('Leads', 'convert', {id: this.context.get('leadsModel').id});
        app.api.call('create', myURL, convertModel, {
            success: _.bind(this.uploadAssociatedRecordFiles, this),
            error: _.bind(this.convertError, this)
        });
    },

    /**
     * After successfully converting a lead, loop through all modules and attempt to upload file input fields
     * All modules are done asynchronously and the last one to complete calls the appropriate completion callback
     *
     * @param convertResults
     */
    uploadAssociatedRecordFiles: function(convertResults) {
        if (this.disposed) return;

        var modulesToProcess = _.keys(this.associatedModels).length,
            failureCount = 0;

        var completeFn = _.bind(function() {
            modulesToProcess--;
            if (modulesToProcess === 0) {
                if (failureCount > 0) {
                    this.convertWarning();
                } else {
                    this.convertSuccess();
                }
            }
        }, this);

        _.each(this.associatedModels, function(associatedModel, associatedModule) {
            var moduleResult = _.find(convertResults.modules, function(result) {
                return (associatedModule === result._module);
            }, this);

            //if associatedModel has no id, then it came from createView on convertPanel and may need file uploads
            if (moduleResult && _.isEmpty(associatedModel.get('id'))) {
                associatedModel.set('id', moduleResult.id);
                app.file.checkFileFieldsAndProcessUpload(
                    this.convertPanels[associatedModule].createView,
                    {
                        success: function() { completeFn(); },
                        error: function() { failureCount++; completeFn(); }
                    },
                    {deleteIfFails:false},
                    false
                );

            } else {
                //no files to upload because an existing record was selected for this module, just run complete
                completeFn();
            }
        }, this);
    },

    /**
     * Lead was successfully converted
     */
    convertSuccess: function() {
        this.convertComplete('success', 'LBL_CONVERTLEAD_SUCCESS', true);
    },

    /**
     * Lead was converted, but some files failed to upload
     */
    convertWarning: function() {
        this.convertComplete('warning', 'LBL_CONVERTLEAD_FILE_WARN', true);
    },

    /**
     * There was a problem converting the lead
     */
    convertError: function() {
        this.convertComplete('error', 'LBL_CONVERTLEAD_ERROR', false);

        if (!this.disposed) {
            this.context.trigger('lead:convert-save:toggle', true);
        }
    },

    /**
     * Based on success of lead conversion, display the appropriate messages and optionally close the drawer
     * @param level
     * @param message
     * @param doClose
     */
    convertComplete: function(level, message, doClose) {
        var leadsModel = this.context.get('leadsModel');
        app.alert.dismiss('processing_convert');
        app.alert.show('convert_complete', {
            level: level,
            messages: app.lang.get(message, this.module, {leadName:leadsModel.get('first_name')+' '+leadsModel.get('last_name')}),
            autoClose: (level === 'success')
        });
        if (!this.disposed && doClose) {
            this.context.trigger('lead:convert:exit');
            app.drawer.close();
            app.navigate(this.context, leadsModel, 'record');
        }
    },

    /**
     * Clean up the jquery events that were added
     * @private
     */
    _dispose: function() {
        this.$(".collapse").off();
        app.view.Layout.prototype._dispose.call(this);
    }
})
