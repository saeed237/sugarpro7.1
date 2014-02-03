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
    inlineEditMode: false,

    createMode: false,

    plugins: [
        'SugarLogic',
        'ErrorDecoration',
        'GridBuilder',
        'Editable',
        'Audit',
        'FindDuplicates',
        'ToggleMoreLess'
    ],

    enableHeaderButtons: true,

    enableHeaderPane: true,

    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
        'click a[name=cancel_button]': 'cancelClicked',
        'click [data-action=scroll]': 'paginateRecord'
    },

    /**
     * Button fields defined in view definition.
     */
    buttons: null,

    /**
     * Button states.
     */
    STATE: {
        EDIT: 'edit',
        VIEW: 'view'
    },

    // current button states
    currentState: null,

    // fields that should not be editable
    noEditFields: null,

    // width of the layout that contains this view
    _containerWidth: 0,

    initialize: function (options) {
        _.bindAll(this);
        options.meta = _.extend({}, app.metadata.getView(null, 'record'), options.meta);
        app.view.View.prototype.initialize.call(this, options);
        this.buttons = {};
        this.createMode = this.context.get("create") ? true : false;

        // Even in createMode we want it to start in detail so that we, later, respect
        // this.editableFields (the list after pruning out readonly fields, etc.)
        this.action = 'detail';

        this.context.on("change:record_label", this.setLabel, this);
        this.context.set("viewed", true);
        this.model.on("duplicate:before", this.setupDuplicateFields, this);
        this.on("editable:keydown", this.handleKeyDown, this);
        this.on("editable:mousedown", this.handleMouseDown, this);

        //event register for preventing actions
        // when user escapes the page without confirming deleting
        app.routing.before("route", this.beforeRouteDelete, this, true);
        $(window).on("beforeunload.delete" + this.cid, _.bind(this.warnDeleteOnRefresh, this));

        this.delegateButtonEvents();

        if (this.createMode) {
            this.model.isNotEmpty = true;
        }

        this.noEditFields = [];
        // properly namespace SHOW_MORE_KEY key
        this.MORE_LESS_KEY = app.user.lastState.key(this.MORE_LESS_KEY, this);

        this.adjustHeaderpane = _.bind(_.debounce(this.adjustHeaderpane, 50), this);
        $(window).on('resize.' + this.cid, this.adjustHeaderpane);
    },

    /**
     * Compare with last fetched data and return true if model contains changes
     *
     * @return true if current model contains unsaved changes
     * @link {app.plugins.view.editable}
     */
    hasUnsavedChanges: function() {
        if (this.resavingAfterMetadataSync)
            return false;

        var changedAttributes = this.model.changedAttributes(this.model.getSyncedAttributes());

        if (_.isEmpty(changedAttributes)) {
            return false;
        }
        // if model contains changed attributes,
        // check whether those are among the editable fields or not
        var formFields = _.compact(_.pluck(this.editableFields, 'name')),
            unsavedFields = _.intersection(_.keys(changedAttributes), formFields);

        return !_.isEmpty(unsavedFields);
    },

    /**
     * Called when current record is being duplicated to allow customization of fields
     * that will be copied into new record.
     *
     * Override to setup the fields on this bean prior to being displayed in Create dialog
     *
     * @param {Object} prefill Bean that will be used for new record
     */
    setupDuplicateFields: function (prefill) {

    },

    setLabel: function (context, value) {
        this.$(".record-label[data-name=" + value.field + "]").text(value.label);
    },

    /**
     * Called each time a validation pass is completed on the model
     * @param {boolean} isValid TRUE if model is valid
     */
    validationComplete: function(isValid){
        if (isValid) {
            this.setButtonStates(this.STATE.VIEW);
            this.handleSave();
        }
    },

    delegateButtonEvents: function () {
        this.context.on('button:edit_button:click', this.editClicked, this);
        this.context.on('button:save_button:click', this.saveClicked, this);
        this.context.on('button:delete_button:click', this.deleteClicked, this);
        this.context.on('button:duplicate_button:click', this.duplicateClicked, this);
    },

    _render: function () {
        this._buildGridsFromPanelsMetadata(this.meta.panels);

        app.view.View.prototype._render.call(this);

        var record_label = this.context.get("record_label");
        if(record_label) {
            this.setLabel(this.context, record_label);
        }

        // Field labels in headerpane should be hidden on view but displayed in edit and create
        _.each(this.fields, function (field) {
            var toggleLabel = _.bind(function () {
                this.toggleLabelByField(field);
            }, this);

            field.off('render', toggleLabel);
            if (field.$el.closest('.headerpane').length > 0) {
                field.on('render', toggleLabel);
            }
            // some fields like 'favorite' is readonly by default, so we need to remove edit-link-wrapper
            if (field.def.readonly && field.name && -1 ==  _.indexOf(this.noEditFields, field.name)) {
                this.$('.record-edit-link-wrapper[data-name=' + field.name + ']').remove();
            }
        }, this);

        this.toggleHeaderLabels(this.createMode);
        this.initButtons();
        this.setButtonStates(this.STATE.VIEW);
        this.setEditableFields();

        if (this.createMode) {
            // RecordView starts with action as detail; once this.editableFields has been set (e.g.
            // readonly's pruned out), we can call toggleFields - so only fields that should be are editable
            this.toggleFields(this.editableFields, true);
        }
    },

    setEditableFields: function () {
        delete this.editableFields;
        this.editableFields = [];

        var previousField, firstField;
        _.each(this.fields, function (field, index) {
            //Exclude read only fields
            if (field.def.readonly || _.indexOf(this.noEditFields, field.def.name) >= 0 || field.parent || (field.name && this.buttons[field.name])) {
                return;
            }
            if (previousField) {
                previousField.nextField = field;
                field.prevField = previousField;
            } else {
                firstField = field;
            }
            previousField = field;
            this.editableFields.push(field);
        }, this);
        if (previousField) {
            previousField.nextField = firstField;
            firstField.prevField = previousField;
        }
    },
    initButtons: function () {
        if (this.options.meta && this.options.meta.buttons) {
            _.each(this.options.meta.buttons, function (button) {
                this.registerFieldAsButton(button.name);
                if (button.buttons) {
                    var dropdownButton = this.getField(button.name);
                    if(!dropdownButton) {
                        return;
                    }
                    _.each(dropdownButton.fields, function (ddButton) {
                        this.buttons[ddButton.name] = ddButton;
                    }, this);
                }
            }, this);
        }
    },
    showPreviousNextBtnGroup: function () {
        var listCollection = this.context.get('listCollection') || new app.data.createBeanCollection(this.module);
        var recordIndex = listCollection.indexOf(listCollection.get(this.model.id));
        if (listCollection && listCollection.models && listCollection.models.length <= 1) {
            this.showPrevNextBtnGroup = false;
        } else {
            this.showPrevNextBtnGroup = true;
        }
        if (this.collection && listCollection.length !== 0) {
            this.showPrevious = listCollection.hasPreviousModel(this.model);
            this.showNext = listCollection.hasNextModel(this.model);
        }
    },

    registerFieldAsButton: function (buttonName) {
        var button = this.getField(buttonName);
        if (button) {
            this.buttons[buttonName] = button;
        }
    },

    _renderHtml: function () {
        this.showPreviousNextBtnGroup();
        app.view.View.prototype._renderHtml.call(this);
        this.adjustHeaderpane();
    },

    bindDataChange: function () {
        this.model.on("change", function (fieldType) {
            if (this.inlineEditMode) {
                this.setButtonStates(this.STATE.EDIT);
            }
            if (this.model.isNotEmpty !== true && fieldType !== 'image') {
                this.model.isNotEmpty = true;
                if (!this.disposed) {
                    this.render();
                }
            }
        }, this);
    },

    duplicateClicked: function () {
        var self = this,
            prefill = app.data.createBean(this.model.module);

        prefill.copy(this.model);
        self.model.trigger("duplicate:before", prefill);
        prefill.unset("id");
        app.drawer.open({
            layout: 'create-actions',
            context: {
                create: true,
                model: prefill
            }
        }, function (context, newModel) {
            if (newModel && newModel.id) {
                app.router.navigate("#" + self.model.module + "/" + newModel.id, {trigger: true});
            }
        });
    },

    editClicked: function () {
        this.setButtonStates(this.STATE.EDIT);
        this.toggleEdit(true);
    },

    saveClicked: function () {
        this.model.doValidate(this.getFields(this.module), _.bind(this.validationComplete, this));
    },

    cancelClicked: function () {
        this.handleCancel();
        this.setButtonStates(this.STATE.VIEW);
        this.clearValidationErrors(this.editableFields);
    },

    deleteClicked: function () {
        this.warnDelete();
    },

    /**
     * Render fields into either edit or view mode.
     * @param isEdit
     */
    toggleEdit: function (isEdit) {
        this.$('.record-edit-link-wrapper').toggle(!isEdit);
        this.$('.headerpane .record-label').toggle(isEdit);
        this.toggleFields(this.editableFields, isEdit);
        this.toggleViewButtons(isEdit);
        this.adjustHeaderpane();
    },

    /**
     * Handler for intent to edit. This handler is called both as a callback from click events, and also
     * triggered as part of tab focus event.
     * @param e {Event} jQuery Event object (should be from click)
     * @param cell {jQuery Node} cell of the target node to edit
     */
    handleEdit: function (e, cell) {
        var target,
            cellData,
            field;

        if (e) { // If result of click event, extract target and cell.
            target = this.$(e.target);
            cell = target.parents(".record-cell");
        }

        cellData = cell.data();
        field = this.getField(cellData.name);

        // Set Editing mode to on.
        this.inlineEditMode = true;

        this.setButtonStates(this.STATE.EDIT);

        this.toggleField(field);

        if (cell.closest('.headerpane').length > 0) {
            this.toggleViewButtons(true);
            this.adjustHeaderpaneFields();
        }
    },

    /**
     * Hide/show all field labels in headerpane
     * @param isEdit
     */
    toggleHeaderLabels: function (isEdit) {
        this.$('.headerpane .record-label').toggle(isEdit);
        this.toggleViewButtons(isEdit);
        this.adjustHeaderpane();
    },

    /**
     * Hide view specific button during edit
     * @param isEdit
     */
    toggleViewButtons: function(isEdit) {
        this.$('.headerpane span[data-type="badge"]').toggleClass('hide', isEdit);
        this.$('.headerpane span[data-type="favorite"]').toggleClass('hide', isEdit);
        this.$('.headerpane span[data-type="follow"]').toggleClass('hide', isEdit);
        this.$('.headerpane .btn-group-previous-next').toggleClass('hide', isEdit);
    },

    /**
     * Hide/show field label given a field
     * @param field
     */
    toggleLabelByField: function (field) {
        if (field.action === 'edit') {
            field.$el.closest('.record-cell')
                .addClass('edit')
                .find('.record-label')
                .show();
        } else {
            field.$el.closest('.record-cell')
                .removeClass('edit')
                .find('.record-label')
                .hide();
        }
    },

    handleSave: function() {
        var self = this;
        self.inlineEditMode = false;

        var options = {
            showAlerts: true,
            success: _.bind(function() {
                // Loop through the visible subpanels and have them sync. This is to update any related
                // fields to the record that may have been changed on the server on save.
                _.each(this.context.children, function(child) {
                    if (!_.isUndefined(child.attributes) && !_.isUndefined(child.attributes.isSubpanel)) {
                        if (child.attributes.isSubpanel && !child.attributes.hidden) {
                            child.attributes.collection.fetch();
                        }
                    }
                });
                if (this.createMode) {
                    app.navigate(this.context, this.model);
                } else if (!this.disposed) {
                    this.render();
                }
            }, this),
            error: _.bind(function(error) {
                if (error.status == 412 && !error.request.metadataRetry) {
                    this.handleMetadataSyncError(error);
                }
                else {
                    this.editClicked();
                }
            }, this),
            viewed: true
        };

        options = _.extend({}, options, self.getCustomSaveOptions(options));

        app.file.checkFileFieldsAndProcessUpload(self, {
                success: function() {
                    self.model.save({}, options);
                }
            }, {
                deleteIfFails: false
            }
        );

        self.$('.record-save-prompt').hide();
        if (!self.disposed) {
            self.render();
        }
    },

    handleMetadataSyncError: function(error){
        var self = this;
       //On a metadata sync error, retry the save after the app is synced
       self.resavingAfterMetadataSync = true;
       app.once("app:sync:complete", function(){
           error.request.metadataRetry = true;
           self.model.once("sync", function(){
               self.resavingAfterMetadataSync = false;
               //self.model.changed = {};
               app.router.refresh();
           });
           //add a new sucess callback to refresh the page after the save completes
           error.request.execute(null, app.api.getMetadataHash());
       });
    },

    getCustomSaveOptions: function(options) {
        return {};
    },

    handleCancel: function () {
        this.model.revertAttributes();
        this.toggleEdit(false);
        this.inlineEditMode = false;
    },

    /**
     * Pre-event handler before current router is changed
     *
     * @return {Boolean} true to continue routing, false otherwise
     */
    beforeRouteDelete: function () {
        if (this._modelToDelete) {
            this.warnDelete();
            return false;
        }
        return true;
    },

    /**
     * Format the message displayed in the alert
     * @returns {Object} confirmation and success messages
     */
    getDeleteMessages: function() {
        var messages = {},
            model = this.model,
            name = model.get('name') || (model.get('first_name') + ' ' + model.get('last_name')) || '',
            context = app.lang.get('LBL_MODULE_NAME_SINGULAR', model.module).toLowerCase() + ' ' + name.trim();

        messages.confirmation = app.lang.get('NTC_DELETE_CONFIRMATION') + context + '?';
        messages.success = app.lang.get('NTC_DELETE_SUCCESS') + context + '.';
        return messages;
    },

    /**
     * Popup dialog message to confirm delete action
     */
    warnDelete: function() {
        var self = this;
        this._modelToDelete = true;

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(self._currentUrl, {trigger: false, replace: true});
        }

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: self.getDeleteMessages().confirmation,
            onConfirm: _.bind(self.deleteModel, self),
            onCancel: function() {
                self._modelToDelete = false;
            }
        });
    },

    /**
     * Popup browser dialog message to confirm delete action
     *
     * @return {String} the message to be displayed in the browser dialog
     */
    warnDeleteOnRefresh: function() {
        if (this._modelToDelete) {
            return this.getDeleteMessages().confirmation;
        }
    },

    /**
     * Delete the model once the user confirms the action
     */
    deleteModel: function() {
        var self = this;

        self.model.destroy({
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': {
                    messages: self.getDeleteMessages().success
                }
            },
            success: function() {
                var redirect = self._targetUrl !== self._currentUrl;
                self._modelToDelete = false;
                
                self.context.trigger("record:deleted");
                if (redirect) {
                    self.unbindBeforeRouteDelete();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(self._targetUrl, {trigger: true});
                    return;
                }

                app.router.navigate("#" + self.module, {trigger: true});
            }
        });

    },

    /**
     * {@inheritdoc}
     * Attach tab handler to jump into the next target field
     */
    handleKeyDown: function (e, field) {
        if (e.which === 9) { // If tab
            e.preventDefault();
            field.$(field.fieldTag).trigger("change");
            var direction = e.shiftKey ? 'prevField' : 'nextField',
                nextField = field[direction];

            if (!nextField) {
                return;
            }

            var hasHiddenPanel = nextField.$el.closest('.panel_hidden').hasClass('hide') &&
                _.isFunction(this.toggleMoreLess);
            if (hasHiddenPanel) {
                this.toggleMoreLess();
            }
            this.toggleField(field, false);
            this.toggleField(nextField, true);
            // the field we need to toggle until we reach one that's not
            if (nextField.isDisabled()) {
                var curField = nextField;
                while (curField.isDisabled()) {
                    if (curField[direction]) {
                        this.toggleField(curField[direction], true);
                        curField = curField[direction];
                    } else {
                        break;
                    }

                }
            }

            this.adjustHeaderpane();
        }
    },

    /**
     * Adjust headerpane fields when they change to view mode
     */
    handleMouseDown: function() {
        this.toggleViewButtons(false);
        this.adjustHeaderpaneFields();
    },

    /**
     * Show/hide buttons depending on the state defined for each buttons in the metadata
     * @param state
     */
    setButtonStates: function (state) {
        this.currentState = state;

        _.each(this.buttons, function (field) {
            var showOn = field.def.showOn;
            if (_.isUndefined(showOn) || (showOn === state)) {
                field.show();
            } else {
                field.hide();
            }
        }, this);
    },

    /**
     * Set the title in the header pane
     * @param title
     */
    setTitle: function (title) {
        var $title = this.$('.headerpane .module-title');
        if ($title.length > 0) {
            $title.text(title);
        } else {
            this.$('.headerpane h1').prepend('<div class="record-cell"><span class="module-title">' + title + '</span></div>');
        }
    },

    /**
     * Detach the event handlers for warning delete
     */
    unbindBeforeRouteDelete: function() {
        app.routing.offBefore("route", this.beforeRouteDelete, this);
        $(window).off("beforeunload.delete" + this.cid);
    },

    _dispose: function () {
        this.unbindBeforeRouteDelete();
        _.each(this.editableFields, function(field) {
            field.nextField = null;
            field.prevField = null;
        });
        this.buttons = null;
        this.editableFields = null;
        this.off("editable:keydown", this.handleKeyDown, this);
        $(window).off('resize.' + this.cid);
        app.view.View.prototype._dispose.call(this);
    },

    _buildGridsFromPanelsMetadata: function(panels) {
        var lastTabIndex  = 0;
        this.noEditFields = [];

        _.each(panels, function(panel) {
            // it is assumed that a field is an object but it can also be a string
            // while working with the fields, might as well take the opportunity to check the user's ACLs for the field
            _.each(panel.fields, function(field, index) {
                if (_.isString(field)) {
                    panel.fields[index] = field = {name: field};
                }
                // disable the pencil icon if the user doesn't have ACLs
                if (field.type === "fieldset") {
                    if (field.readonly || _.every(field.fields, function(field) {
                        return !app.acl.hasAccessToModel('edit', this.model, field.name);
                    }, this)) {
                        this.noEditFields.push(field.name);
                    }
                } else if (field.readonly || !app.acl.hasAccessToModel('edit', this.model, field.name)) {
                    this.noEditFields.push(field.name);
                }
            }, this);

            // Set flag so that show more link can be displayed to show hidden panel.
            if (panel.hide) {
                this.hiddenPanelExists = true;
            }

            // labels: visibility for the label
            if (_.isUndefined(panel.labels)) {
                panel.labels = true;
            }

            if (_.isFunction(this.getGridBuilder)) {
                var options = {
                        fields:      panel.fields,
                        columns:     panel.columns,
                        labels:      panel.labels,
                        labelsOnTop: panel.labelsOnTop,
                        tabIndex:    lastTabIndex
                    },
                    gridResults = this.getGridBuilder(options).build();

                panel.grid   = gridResults.grid;
                lastTabIndex = gridResults.lastTabIndex;
            }
        }, this);
    },

    /**
     * Handles click event on next/previous button of record.
     * @param {Event} evt
     */
    paginateRecord: function(evt) {
        var el = $(evt.currentTarget),
            data = el.data();
        if (data.id) {
            var list = this.context.get('listCollection'),
                model = list.get(data.id);
            switch (data.actionType) {
                case 'next':
                    list.getNext(model, this.navigateModel);
                    break;
                case 'prev':
                    list.getPrev(model, this.navigateModel);
                    break;
                default:
                    this._disablePagination(el);
            }
        }
    },

    /**
     * Callback for navigate to new model.
     * @param model {Data.Bean} model New model to navigate.
     * @param actionType {String} actionType Side of navigation (prev/next).
     */
    navigateModel: function(model, actionType) {
        if (model && model.id) {
            app.router.navigate(app.router.buildRoute(this.module, model.id), {trigger: true});
        } else {
            var el = this.$el.find('[data-action=scroll][data-action-type=' + actionType + ']');
            this._disablePagination(el);
        }
    },

    /**
     * Disabling pagination if we can't paginate.
     * @param {Object} el Element to disable pagination on.
     */
    _disablePagination: function(el) {
        app.logger.error('Wrong data for record pagination. Pagination is disabled.');
        el.addClass('disabled');
        el.data('id', '');
    },

    /**
     * Adjust headerpane such that certain fields can be shown with ellipsis
     */
    adjustHeaderpane: function() {
        this.setContainerWidth();
        this.adjustHeaderpaneFields();
    },

    /**
     * Get the width of the layout container
     */
    getContainerWidth: function() {
        return this._containerWidth;
    },

    /**
     * Set the width of the layout container
     */
    setContainerWidth: function() {
        this._containerWidth = this._getParentLayoutWidth(this.layout);
    },

    /**
     * Get the width of the parent layout that contains getPaneWidth() method.
     * @param layout
     * @returns {number}
     * @private
     */
    _getParentLayoutWidth: function(layout) {
        if (!layout) {
            return 0;
        } else if (_.isFunction(layout.getPaneWidth)) {
            return layout.getPaneWidth(this);
        }

        return this._getParentLayoutWidth(layout.layout);
    },

    /**
     * Adjust headerpane fields such that the first field is ellipsified and the last field
     * is set to 100% on view.  On edit, the first field is set to 100%.
     */
    adjustHeaderpaneFields: function() {
        if (!this.disposed && !_.isEmpty($recordCells) && this.getContainerWidth() > 0) {
            var ellipsisCellWidth,
                $recordCells = this.$('.headerpane h1').children('.record-cell, .btn-toolbar'),
                $ellipsisCell = $(this._getCellToEllipsify($recordCells));

                if (!_.isEmpty($ellipsisCell)) {
                if ($ellipsisCell.hasClass('edit')) {
                    // make the ellipsis cell widen to 100% on edit
                    $ellipsisCell.css({'width': '100%'});
                } else {
                    ellipsisCellWidth = this._calculateEllipsifiedCellWidth($recordCells, $ellipsisCell);
                    this._setMaxWidthForEllipsifiedCell($ellipsisCell, ellipsisCellWidth);
                    this._widenLastCell($recordCells);
                }
            }
        }
    },

    /**
     * Get the first cell for the field that can be ellipsified.
     * @param {jQuery} $cells
     * @returns {jQuery}
     * @private
     */
    _getCellToEllipsify: function($cells) {
        var fieldTypesToEllipsify = ['fullname', 'name', 'text', 'base', 'enum', 'url', 'dashboardtitle'];

        return _.find($cells, function(cell) {
            return (_.indexOf(fieldTypesToEllipsify, $(cell).data('type')) !== -1);
        });
    },

    /**
     * Calculate the width for the cell that needs to be ellipsified.
     * @param {jQuery} $cells
     * @param {jQuery} $ellipsisCell
     * @returns {number}
     * @private
     */
    _calculateEllipsifiedCellWidth: function($cells, $ellipsisCell) {
        var width = this.getContainerWidth();

        _.each($cells, function(cell) {
            var $cell = $(cell);

            if ($cell.is($ellipsisCell)) {
                width -= (parseInt($ellipsisCell.css('padding-left'), 10)
                         + parseInt($ellipsisCell.css('padding-right'), 10));
            } else if ($cell.is(':visible')) {
                $cell.css({'width': 'auto'});
                width -= $cell.outerWidth();
            }
            $cell.css({'width': ''});
        });

        return width;
    },

    /**
     * Set the max-width for the specified cell.
     * @param {jQuery} $ellipsisCell
     * @param {number} width
     * @private
     */
    _setMaxWidthForEllipsifiedCell: function($ellipsisCell, width) {
        var ellipsifiedCell,
            fieldType = $ellipsisCell.data('type');

        if (fieldType === 'fullname' || fieldType === 'dashboardtitle') {
            ellipsifiedCell = this.getField($ellipsisCell.data('name'));
            width -= ellipsifiedCell.getCellPadding();
            ellipsifiedCell.setMaxWidth(width);
        } else {
            $ellipsisCell.css({'max-width': width});
        }
    },

    /**
     * Widen the last cell to 100%.
     * @param {jQuery} $cells
     * @private
     */
    _widenLastCell: function($cells) {
        var $cellToWiden;

        _.each($cells, function(cell) {
            var $cell = $(cell);
            if ($cell.hasClass('record-cell') && (!$cell.hasClass('hide') || $cell.is(':visible'))) {
                $cellToWiden = $cell;
            }
        });

        if ($cellToWiden) {
            $cellToWiden.css({'width': '100%'});
        }
    },

    /**
     * Adds the favorite field to app.view.View.getFieldNames() if `favorite` field is within a panel
     * so my_favorite is part of the field list and is fetched
     */
    getFieldNames: function(module) {
        var fields = app.view.View.prototype.getFieldNames.call(this, module);
        var favorite = _.find(this.meta.panels, function(panel) {
             return _.find(panel.fields, function(field) {
                 return field.type === 'favorite';
             });
        });
        if (favorite) {
            fields = _.union(fields, ['my_favorite']);
        }
        return fields;
    }
})
