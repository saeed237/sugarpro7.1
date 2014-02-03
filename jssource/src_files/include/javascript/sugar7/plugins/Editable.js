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

(function (app) {
    app.events.on("app:init", function () {
        /**
         * Editable plug-in will help the view controller's fields switching in edit mode
         *
         * This plugin register two main features
         *
         * - toggleFields: switching mode within array of fields
         * - toggleField: switching mode a single field.
         *                In this case, key and mouse listerer will be enabled.
         *                This plugin automatically back from the editable mode
         *                when user clicks escape key or mouse key in out of the field area
         *                (editableHandleMouseDown, editableHandleKeyDown will take care of this feature)
         * To override more key event handler, bind this.on("editable:keydown", function(evt, field))
         * The trigger will pass two parameters([mouse event], [field])
         *
         * Once the attached view contains unsaved changes, it will warn the message to user for confirming
         * (this.hasUnsavedChanges must return true when the view contains unsaved changes)
         */
        app.plugins.register('Editable', ['view'], {
            onAttach: function(component, plugin) {
                this.editableKeyDowned = _.bind(function(evt) {
                    this.editableHandleKeyDown.call(this, evt, evt.data.field);
                }, this);

                this.editableMouseClicked = _.debounce(_.bind(function(evt) {
                    this.editableHandleMouseDown.call(this, evt, evt.data.field);
                }, this), 0);

                this.on("init", function() {
                    //event register for preventing actions
                    // when user escapes the page without saving unsaved changes
                    app.routing.before("route", this.beforeRouteChange, this, true);
                    $(window).on("beforeunload." + this.cid, _.bind(this.warnUnsavedChangesOnRefresh, this));

                    this.before("unsavedchange", this.beforeViewChange, this, true);
                    //If drawer is initialized, bind addtional before handler to prevent closing creation view
                    if (_.isEmpty(app.additionalComponents['drawer'])) {
                        return;
                    }
                    app.drawer.before("reset", this.beforeRouteChange, this, true);

                    this._currentUrl = Backbone.history.getFragment();
                });
            },

            /**
             * Pre-event handler before current router is changed
             *
             * Pass onConfirmRoute as callback to continue navigating after confirmation
             *
             * @param {Object} parameters that is passed from caller
             * @return {Boolean} true only if it contains unsaved changes
             */
            beforeRouteChange: function (params) {
                var onConfirm = _.bind(this.onConfirmRoute, this);
                return this.warnUnsavedChanges(onConfirm);
            },


            /**
             * Pre-event handler before custom unsaved logic is passed
             *
             * Pass custom callback to continue the following logic after confirmation
             *
             * @param {Object} parameters that is passed from caller. Must contains 'callback'
             * @return {Boolean} true only if it contains unsaved changes
             */
            beforeViewChange: function(param) {
                if (!(param && _.isFunction(param.callback))) {
                    app.logger.error('Custom unsavedchange must contain callback function.');
                    return true;
                }
                var onConfirm = _.bind(function() {
                    if(param.callback && _.isFunction(param.callback)) {
                        param.callback.call(this);
                    }
                }, this);
                return this.warnUnsavedChanges(onConfirm, param.message);
            },

            /**
             * Popup dialog message to confirm the unsaved changes
             *
             * View must override hasUnsavedChanges and return true to active the warning dialog
             *
             * @param {Function} callback function which is executed once user clicks "ok"
             * @param {String} custom warning message
             * @return {Boolean} true only if it contains unsaved changes
             */
            warnUnsavedChanges: function (onConfirm, customMessage) {
                //When we reload the page after retrying a save, never block it
                if (this.resavingAfterMetadataSync) {
                    return false;
                }
                this.$(":focus").trigger("change");
                if (_.isFunction(this.hasUnsavedChanges) && this.hasUnsavedChanges()) {
                    this._targetUrl = Backbone.history.getFragment();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(this._currentUrl, {trigger: false, replace: true});

                    app.alert.show('leave_confirmation', {
                        level: 'confirmation',
                        messages: app.lang.get(customMessage || 'LBL_WARN_UNSAVED_EDITS', this.module),
                        onConfirm: onConfirm,
                        templateOptions: {
                            cancelContLabel: 'LBL_CANCEL_BUTTON_LABEL_UNSAVED_CONT',
                            confirmContLabel: 'LBL_CONFIRM_BUTTON_LABEL_UNSAVED_CONT'
                        }
                    });
                    return false;
                }
                return true;
            },

            /**
             * Popup browser dialog message to confirm the unsaved changes
             */
            warnUnsavedChangesOnRefresh: function() {
                //After a 412, prevent navigating away until after the save, but don't show a warning.
                if (this.resavingAfterMetadataSync) {
                    return false;
                }
                if (_.isFunction(this.hasUnsavedChanges) && this.hasUnsavedChanges()) {
                    return app.lang.get('LBL_WARN_UNSAVED_EDITS', this.module);
                }
                return;
            },

            /**
             * Continue navigating target location once user confirms the discard changes
             */
            onConfirmRoute: function() {
                this.unbindBeforeHandler();
                app.router.navigate(this._targetUrl, {trigger: true});
            },

            /**
             * Switches entire fields between detail and edit modes.
             *
             * @param {Array} Fields that needs to be toggled
             * @param {Boolean} true if it force into edit mode
             */
            toggleFields: function(fields, isEdit) {
                var viewName = (isEdit) ? 'edit' : this.action;
                _.each(fields, function(field) {
                    if (field.action === viewName){
                        return; //don't toggle if it's the same
                    }
                    var meta = this.getFieldMeta(field.name);
                    if (meta && isEdit && meta.readonly) {
                        return;
                    }

                    //defer the rendering entire toggling fields asynchronized to enhance the performace.
                    //If it executes the process synchronized, the browser is stuck until all performance is complete.
                    _.defer(function(field){
                        if (field.disposed !== true) {
                            field.setMode(viewName);
                        }
                    }, field);

                    field.$(field.fieldTag).off("keydown.record", this.editableKeyDowned);
                    $(document).off("mousedown.record" + field.name, this.editableMouseClicked);
                }, this);
            },

            /**
             * Switches each individual field between detail and edit modes.
             *
             * It is specially designed for inline edit.
             * Bind default escape key handler for cancelling inline edit mode.
             *
             * @param {View.Field} Field that needs to be toggled
             * @param {Boolean} true if it force into edit mode
             */
            toggleField: function(field, isEdit) {
                var viewName;

                if (_.isUndefined(isEdit)) {
                    viewName = (field.tplName === this.action) ? "edit" : this.action;
                } else {
                    viewName = (isEdit) ? "edit" : this.action;
                }

                if (!field.triggerBefore('toggleField', viewName)) {
                    return false;
                }

                field.setMode(viewName);

                if (viewName === "edit") {

                    if (_.isFunction(field.focus)) {
                        field.focus();
                    } else {
                        var $el = field.$(field.fieldTag + ":first");
                        $el.focus().val($el.val());
                    }
                    if (_.isFunction(field.bindKeyDown)) {
                        field.bindKeyDown(this.editableKeyDowned);
                    } else {
                        field.$(field.fieldTag).on("keydown.record", {field: field}, this.editableKeyDowned);
                    }
                    if (_.isFunction(field.bindDocumentMouseDown)) {
                        field.bindDocumentMouseDown(this.editableMouseClicked);
                    } else {
                        $(document).on("mousedown.record" + field.name, {field: field}, this.editableMouseClicked);
                    }
                } else {
                    field.$(field.fieldTag).off("keydown.record");
                    $(document).off("mousedown.record" + field.name);
                }
            },

            /**
             * Bind default mouse click handler for inline edit mode.
             *
             * Once user clicks the out of the field area, it will cancel the inilne edit mode.
             *
             * @param {Window.Event}
             * @param {View.Field} Field that is in inline edit mode
             */
            editableHandleMouseDown: function(evt, field) {
                if (field.tplName === this.action) {
                    return;
                }

                var currFieldParent = field.$el,
                    targetPlaceHolder = this.$(evt.target).parents("span[sfuuid='" + field.sfId + "']"),
                    preventPlaceholder = this.$(evt.target).closest('.prevent-mousedown');

                // When mouse clicks the document, it should maintain the edit mode within the following cases
                // - Some fields (like email) may have buttons and the mousedown event will fire before the one
                //   attached to the button is fired. As a workaround we wrap the buttons with .prevent-mousedown
                var inPreventPlaceholder = (preventPlaceholder.length > 0);
                // - If mouse is clicked within the same field placeholder area
                var inTargetPlaceholder = (targetPlaceHolder.length > 0);
                // - If cursor is focused among the field's input elements
                var isFocusInField = (currFieldParent.find(":focus").length > 0);
                var drawerOpened = !_.isEmpty(app.drawer._components);
                if (inPreventPlaceholder || inTargetPlaceholder || isFocusInField || drawerOpened) {
                    return;
                }
                this.toggleField(field, false);
                this.trigger("editable:mousedown", evt, field);
            },

            /**
             * Bind key handlers for inline edit mode.
             *
             * Attach default escape key handler for cancelling inline edit mode.
             * Custom handlers that is attached on current view's "editable:keydown" will be triggered in order.
             *
             * @param {Window.Event}
             * @param {View.Field} Field that is in inline edit mode
             */
            editableHandleKeyDown: function(evt, field) {
                if (evt.which == 27) { // If esc
                    this.toggleField(field, false);
                }
                this.trigger("editable:keydown", evt, field);
            },

            /**
             * Detach the event handlers for warning unsaved changes
             */
            unbindBeforeHandler: function() {

                app.routing.offBefore("route", this.beforeRouteChange, this);
                $(window).off("beforeunload." + this.cid);

                if (_.isEmpty(app.additionalComponents['drawer'])) {
                    return;
                }
                app.drawer.offBefore("reset", this.beforeRouteChange, this);
                this.offBefore("unsavedchange");
            },

            /**
             * @inheritdoc
             * Unbind anonymous functions for key and mouse handlers
             * Unbind beforeHandlers
             */
            onDetach: function() {
                $(document).off("mousedown", this.editableMouseClicked);
                this.editableKeyDowned = null;
                this.editableMouseClicked = null;
                this.unbindBeforeHandler();
            }
        });
    });
})(SUGAR.App);
