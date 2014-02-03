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
    app.events.on("app:init", function() {
        /**
         * We register two plug-ins here.
         *
         * CteTabbing
         * This is a view plugin that enable a view (specifcly recordlist) to listen for events from the
         * 'ClickToEdit' plugin to support moving the editable to the next editable field or the previous one
         * depending on if shift+tab is pressed
         *
         * ClickToEdit
         * This is a field plugin that allows the field to become editable on click.  Current types that are supported:
         *  - Int
         *  - Currency
         *  - Enum
         *  - Date
         * Others may work work but have not been tested or inline validation written for them.
         */
        app.plugins.register('CteTabbing', ['view'], {
            /**
             * Attach code for when the plugin is regisred on a view
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.context.on('field:editable:tabkey', this.handleTabbing, this);
                }, this);
            },

            /**
             * Handle moving depending on which way the event goes
             * @param event         The event that was fired
             * @param shiftKey      Was the shift key pressed
             * @param field         The field that the event came from
             */
            handleTabbing: function(event, shiftKey, field) {
                event.preventDefault();

                var indexFound = false,
                    nextField = {};

                _.find(this.$el.find('div.clickToEdit'), function(el, idx, list) {
                    var $el = $(el);
                    if (indexFound === false && $el.data('cid') == field.cid) {
                        indexFound = true;
                        var nextIndex = (shiftKey === true) ? idx - 1 : idx + 1;
                        if (nextIndex === list.length) {
                            nextIndex = 0;
                        }
                        nextField = list.splice(nextIndex, 1);
                    }

                    return indexFound;
                });

                $(nextField).click();
            }
        });

        app.plugins.register('ClickToEdit', ['field'], {

            /**
             * Custom Events for making the ClickToEdit work on a field
             */
            events: {
                'mouseenter div.clickToEdit': 'showClickToEdit',
                'mouseleave div.clickToEdit': 'hideClickToEdit',
                'click div.clickToEdit': 'handleFieldClick'
            },

            /**
             * Can the field be edited
             */
            _canEdit: false,

            /**
             * are we currently in edit mode
             */
            _isInEdit: false,

            /**
             * Error Message
             */
            errorMessage: '',

            /**
             * Is an error currently being displayed for a field
             */
            isErrorState: false,

            /**
             * Register the plugin on a field
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.on('init', _.bind(function() {
                    if (this.checkIfCanEdit()) {
                        this.bindPluginEvents();
                    }
                }, this));
            },

            /**
             * Bind plugin events
             */
            bindPluginEvents: function() {
                this.context.on('field:editable:open', function(cid) {
                    // another CTE field has been opened
                    if (this.isErrorState) {
                        // I am open with an error, send the message
                        this.context.trigger('field:editable:error', this.cid);
                    } else if (this._isInEdit == true && this.cid !== cid) {
                        if (this.type == 'enum') {
                            this.$("select").select2("close");
                        }

                        // for the date field, this is handled when the date field gets removed below
                        if (this.type != 'date') {
                            this.setMode('detail');
                        }
                    }
                }, this);
                this.context.on('field:editable:error', function(cid) {
                    if (!_.isEqual(cid, this.cid) && this.options.viewName == 'edit') {
                        // some other field is open with an error, close this
                        this.setMode('detail');
                    }
                }, this);
            },

            /**
             * Logic to make sure that we can actually edit the field
             *
             * @returns {boolean}
             */
            checkIfCanEdit: function() {
                if (!_.isUndefined(this.def.click_to_edit) && this.def.click_to_edit === true) {
                    // only worksheet owner can edit
                    // make sure we get the correct context, if we are in the forecast module
                    // its this.context.parent otherwise, its this.context
                    var ctx = this.context.parent || this.context;
                    var selectedUser = ctx.get('selectedUser') || app.user.toJSON();
                    this._canEdit = _.isEqual(app.user.get('id'), selectedUser.id);
                    // lets make sure we can actually write to the field
                    this._canEdit = (this._canEdit &&
                                        app.acl.hasAccess('write', this.module, app.user.get('id'), this.name));

                    // only they have write access to the field and if sales stage is won/lost can edit
                    if (this._canEdit && this.model.has('sales_stage')) {
                        var salesStage = this.model.get('sales_stage'),
                            disableIfSalesStageIs = _.union(
                                app.metadata.getModule('Forecasts', 'config').sales_stage_won,
                                app.metadata.getModule('Forecasts', 'config').sales_stage_lost
                            );
                        if (salesStage && _.indexOf(disableIfSalesStageIs, salesStage) != -1) {
                            this._canEdit = false;
                        }
                    }

                    if (this._canEdit) {
                        // add a css_class to the def
                        this.on('render', function() {
                            var cteClass = 'clickToEdit';
                            if (this.action === 'edit') {
                                cteClass += ' active'
                                this.$el.addClass("active");
                            } else {
                                this.$el.removeClass("active")
                            }
                            this.$el.addClass("isEditable");
                            this.$el.wrapInner('<div class="' + cteClass + '" data-cid="' + this.cid + '" />');
                        }, this);
                    }
                }

                return this._canEdit;
            },

            /**
             * Overwrite the default bindDomChange since we need to do inline validation
             */
            bindDomChange: function() {

                if (this.type === 'date') return;   // we need to ignore the date field here

                if (!(this.model instanceof Backbone.Model)) return;

                var self = this;
                var el = this.$el.find(this.fieldTag);
                el.on("change", function() {
                    var value = self.validateField(self, self.unformat(el.val()));
                    if (value !== false) {
                        // field is valid, save it
                        self.isErrorState = false;
                        self.errorMessage = '';
                        // save to model
                        self.model.set(self.name, value);
                    } else {
                        // invalid display error
                        var hb = Handlebars.compile("{{str key module context}}"),
                            args = {field_name: app.lang.get(self.def.label, self.module)};

                        self.errorMessage = hb({'key': 'LBL_EDITABLE_INVALID', 'module': self.module, 'context': args});

                        self.showErrors();
                        el.select();
                    }
                });
                // Focus doesn't always change when tabbing through inputs on IE9 (Bug54717)
                // This prevents change events from being fired appropriately on IE9
                if ($.browser.msie && el.is("input")) {
                    el.on("input", function() {
                        // Set focus on input element receiving user input
                        el.focus().select();
                    });
                }

            },

            /**
             * Show an error message if not already display
             */
            showErrors: function() {
                if (this.isErrorState === false) {
                    this.isErrorState = true;
                    this.$el.addClass('error');
                    this.$el.find('.error-tooltip').addClass('add-on local').removeClass('hide').css('display', 'inline-block');
                    this.$el.find('input').addClass('local-error');
                    // we want to show the tooltip message, but hide the add-on (exclamation)
                    this.$el.find("[rel=tooltip]").tooltip('destroy'); // so the title is not cached
                    this.$el.find("[rel=tooltip]").tooltip({container: 'body', placement: 'top', title: this.errorMessage}).tooltip('show').hide();
                }
            },


            /**
             * Show the click to edit icon.
             *
             * @param event
             */
            showClickToEdit: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    var target = $(event.currentTarget);
                    var icon = '<span class="edit-icon"><i class="icon-pencil icon-sm"></i></span>';

                    // use case for currency field that show transactional value + the converted to base currency
                    if (target.has('label.original').length == 1) {
                        target = target.find('label.original').next();
                    }

                    // use case for the ellipsis_inline div
                    if (target.has('div.ellipsis_inline').length == 1) {
                        target = target.find('div.ellipsis_inline');
                    }

                    target.prepend(icon);
                }
            },

            /**
             * Hide the click to edit icon.
             *
             * @param event
             */
            hideClickToEdit: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    $(event.currentTarget).find('span.edit-icon').remove();
                }
            },

            /**
             * Handle when a click event is triggered
             *
             * @param event
             */
            handleFieldClick: function(event) {
                if (this._canEdit && !this._isInEdit) {
                    this.setMode('edit');
                    if (_.isFunction(this.focus)) {
                        this.focus();
                    } else {
                        var $el = this.$(this.fieldTag + ":first");
                        $el.focus().val($el.val()).select();
                    }

                    if (this.type !== 'image') {
                        if (_.isFunction(this.bindKeyDown)) {
                            this.bindKeyDown(_.bind(this.keyDowned, this));
                        } else {
                            this.$(this.fieldTag).on("keydown.record" + this.cid, {field: this}, _.bind(this.keyDowned, this));
                        }

                        $(document).on("mousedown.record" + this.cid, {field: this}, _.bind(this.mouseClicked, this));
                    }

                    if (this.type === "enum") {
                        this.model.once('change:' + this.name, function() {
                            this.setMode('detail');
                        }, this);
                    }

                    if (this.type === "date") {
                        this.$el.closest('td').addClass('td-inline-edit');
                    }
                }
            },

            /**
             * Key Down Handler
             * @param evt
             */
            keyDowned: function(evt) {
                this.handleKeyDown.call(this, evt, evt.data.field);
            },

            /**
             * Mouse Click Handler
             *
             */
            mouseClicked: _.debounce(function(evt) {
                this.fieldClose.call(this, evt, evt.data.field);
            }, 0),


            /**
             * Close out the field from a mouse click
             *
             * @param evt
             * @param field
             */
            fieldClose: function(evt, field) {
                var currFieldParent = field.$el,
                    targetPlaceHolder = this.$(evt.target).parents("span[sfuuid='" + field.sfId + "']"),
                    preventPlaceholder = this.$(evt.target).closest('.prevent-mousedown');

                // When mouse clicks the document, it should maintain the edit mode within the following cases
                // - Some fields (like email) may have buttons and the mousedown event will fire before the one
                //   attached to the button is fired. As a workaround we wrap the buttons with .prevent-mousedown
                // - If mouse is clicked within the same field placeholder area
                // - If cursor is focused among the field's input elements
                if (preventPlaceholder.length > 0
                    || targetPlaceHolder.length > 0
                    || currFieldParent.find(":focus").length > 0
                    || !_.isEmpty(app.drawer._components)) {
                    return;
                }

                if (this.isErrorState) {
                    this.$el.find(this.fieldTag).focus().select();
                    return;
                }

                this.isErrorState = false;
                this.setMode('detail');
            },

            /**
             * Logic behind a key down event
             *
             * @param e
             * @param field
             */
            handleKeyDown: function(e, field) {
                if (e.which == 27) { // If esc
                    this.isErrorState = false;
                    this.setMode('detail');
                } else if (e.which == 13) {
                    if (this.fieldValueChanged(field)) {
                        this.model.once('change:' + field.name, function() {
                            this.setMode('detail');
                        }, this);
                    } else {
                        this.setMode('detail');
                    }
                } else if (e.which == 9) {
                    // on tab being presses, fire an event, and pass up the following
                    // e: current event
                    // e.shiftKey: was the shift key pressed
                    // field: the field we are currently on

                    if (field.type !== 'date' && field.type !== 'enum' && this.fieldValueChanged((field))) {
                        field.$el.find(field.fieldTag).change();
                    }

                    // this errors out when tabbing off a change of the commit_stage field, since it auto hides
                    if (this.context) {
                        // this even will be listened by the cte-tab plugin on the layout
                        this.context.trigger('field:editable:tabkey', e, e.shiftKey, field);
                    }

                    if (field.type === 'date') {
                        this.hideDatepicker();
                    }
                }
            },

            /**
             * Did the field value change?
             * @param field
             * @returns {boolean}
             */
            fieldValueChanged: function(field) {
                // get the field value
                var elVal = field.$el.find(field.fieldTag).val();

                if (field.type == 'currency') {
                    // for currency we want to make sure the value didn't actually change so get the difference
                    // and multiple it by 100 (2 decimals out), if it's not equal to 0, then it changed.
                    var diff = Math.abs(this.unformat(elVal) - this.unformat(field.value));
                    return ((Math.round(diff * 100)) != 0)
                } else {
                    return !_.isEqual(this.unformat(elVal), this.unformat(field.value));
                }


            },

            /**
             * Change the mode of the field
             * @param name
             */
            setMode: function(name) {
                if (name === "detail") {
                    // remove handlers
                    this.$(this.fieldTag).off("keydown.record" + this.cid);
                    $(document).off("mousedown.record" + this.cid);
                }
                app.view.Field.prototype.setMode.call(this, name);
                this._isInEdit = (this.action === 'edit');

                if (this._isInEdit) {
                    // trigger the event
                    this.context.trigger('field:editable:open', this.cid);
                } else {
                    this.$el.removeClass('error');
                }

                if (this.action !== 'edit' && this.type == 'date') {
                    this.$el.closest('td').removeClass('td-inline-edit');
                }
            },

            /**
             * Main validate method.
             *
             * @param field
             * @param newValue
             * @returns {*}
             */
            validateField: function(field, newValue) {

                if (_.isUndefined(newValue) || _.isEmpty(newValue)) {
                    // try to get the value again
                    newValue = this.$el.find(this.fieldTag).val();
                }

                if (field.type === 'int') {
                    // check for percentages
                    newValue = this._parsePercentage(newValue, 0);
                    if (this._verifyIntValue(newValue)) {
                        return newValue;
                    }
                } else if (field.type === 'currency') {
                    newValue = this._parsePercentage(newValue, 2);
                    if (this._verifyCurrencyValue(newValue)) {
                        return newValue;
                    }
                } else if (field.type === 'date') {
                    if (this._verifyDateString(newValue)) {
                        return newValue;
                    }
                } else {
                    return newValue;
                }

                return false;
            },

            /**
             * Verify a currency value
             *
             * @param value
             * @returns {boolean}
             * @private
             */
            _verifyCurrencyValue: function(value) {
                // trim off any whitespace
                value = value.toString().trim();

                // matches a valid positive decimal number
                    reg = new RegExp("^\\d+(\\.\\d+)?$");

                // always make sure that we have a string here, since match only works on strings
                if (value.length == 0 || _.isNull(value.match(reg))) {
                    return false;
                }

                // the value passed all validation, return true
                return true;
            },

            /**
             * Verify an Int Value
             * @param value
             * @returns {*}
             * @private
             */
            _verifyIntValue: function(value) {
                var regex = new RegExp("^\\d+$"),
                    match = value.toString().match(regex);

                // always make sure that we have a string here, since match only works on strings
                if (_.isNull(match)) {
                    return false;
                }

                if (!_.isUndefined(this.def.validation) && this.def.validation.type == 'range') {
                    // we have digits, lets make sure it's int a valid range is one is specified
                    if (!_.isUndefined(this.def.validation.min) && !_.isUndefined(this.def.validation.max)) {
                        // we have a min and max value
                        if (value < this.def.validation.min || value > this.def.validation.max) {
                            return false
                        }
                    }
                }

                // the value passed all validation, return true
                return true;
            },

            /**
             * overridden from date.js -- Forecasts must validate date before setting the model
             * whereas the base date.js field sets the model, then does validation when you save
             *
             * @param value
             * @return {Boolean}
             * @private
             */
            _verifyDateString: function(value) {
                var dateFormat = (this.usersDatePrefs) ? app.date.toDatepickerFormat(this.usersDatePrefs) : 'mm-dd-yyyy',
                    isValid = true;

                //First try generic date parse (since we might have an ISO). This should generally work with the
                //ISO date strings we get from server.
                if (_.isNaN(Date.parse(value))) {
                    isValid = false;
                    //Safari chokes on '.', '-', so retry replacing with '/'
                    if (_.isNaN(value.replace(/[\.\-]/g, '/'))) {
                        //Use datepicker plugin to verify datepicker format
                        isValid = $.prototype.DateVerifier(value, dateFormat);
                    }
                }
                return isValid;
            },

            /**
             * Check the value to see if it's a percentage, if it is, then adjust the value
             *
             * @param {String} value        The value we are parsing.
             * @param {Integer} decimals        How far to round to.
             * @return {*}
             */
            _parsePercentage: function(value, decimals) {
                var orig = this.model.get(this.name),
                    parts = value.toString().match(/^([+-])(\d+(\.\d+)?)(\%?)$/);
                if (parts) {
                    // use original number to apply calculations
                    if (parts[4] == '%') {
                        // percentage calculation
                        value = app.math.mul(app.math.div(parts[2], 100), orig);
                    } else {
                        // add/sub calculation
                        value = parts[2];
                    }
                    if (parts[1] == '+') {
                        value = app.math.add(orig, value);
                    } else if (parts[1] == '-') {
                        value = app.math.sub(orig, value);
                    }
                    value = app.math.round(value, decimals);
                }
                return value.toString();
            },

            /**
             * overridden from date.js -- Forecasts must validate date before setting the model
             * whereas the base date.js field sets the model, then does validation when you save
             *
             * @param ev
             */
            hideDatepicker: function(ev) {
                var hrsMins = {
                    hours: '00',
                    minutes: '00'
                };

                this.datepickerVisible = false;

                // sets this.dateValue
                this._getDatepickerValue();

                if (this._verifyDateString(this.dateValue)) {
                    // sidecar field validation stuff we don't use, but setting to maintain compatibility
                    this.leaveDirty = false;

                    // set the field model with the new valid dateValue
                    this.model.set(this.name, this._buildUnformatted(this.dateValue, hrsMins.hours, hrsMins.minutes));

                    // find the date picker and hide it
                    $('.datepicker').datepicker().hide();
                    // trigger the onBlur function to set the field back to detail view and render
                    this.setMode('detail');
                } else {
                    var hb = Handlebars.compile("{{str key module context}}"),
                        args = {field_name: app.lang.get(this.def.label, this.module)};

                    // sidecar field validation stuff we don't use, but setting to maintain compatibility
                    this.leaveDirty = true;

                    // set the proper error message
                    this.errorMessage = hb({'key': 'LBL_EDITABLE_INVALID', 'module': this.module, 'context': args});

                    // display rad error tooltipz!
                    this.showErrors();
                }
            }
        });
    });
})(SUGAR.App);
