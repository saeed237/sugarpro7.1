/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

({
    /**
     * Widget for changing a password
     * It does not require old password confirmation
     *
     * @class View.Fields.ChangePasswordField
     * @alias SUGAR.App.view.fields.ChangePasswordField
     * @extends View.Field
     */
    fieldTag: 'input:not(:disabled)',

    events: {
        'click .togglePasswordFields': 'togglePasswordFields'
    },

    /**
     * @override
     * @param options
     */
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);
        /**
         * Manually adds the validation error label to errorName2Keys
         * @type {string}
         */
        app.error.errorName2Keys['confirm_password'] = 'ERR_REENTER_PASSWORDS';
        this._extendModel();
    },

    /**
     * Extends the model
     * - adds a validation task _doValidatePasswordConfirmation : handle the password confirmation validation
     * - revertAttributes : to unset temporary attributes _new_password and _confirm_password
     */
    _extendModel: function() {
        // _hasChangePasswordModifs is a flag to make sure model methods are overriden only once
        if (this.model && !this.model._hasChangePasswordModifs) {
            // Make a copy of the model
            var _proto = _.clone(this.model);

            // This is the flag to make sure we do extend model only once
            this.model._hasChangePasswordModifs = true;

            /**
             * Validates new password and confirmation match
             *
             * @param {Object} fields Hash of field definitions to validate.
             * @param {Object} errors Error validation errors
             * @param {Function} callback Async.js waterfall callback
             */
            this.model._doValidatePasswordConfirmation = function(fields, errors, callback) {
                // Find any change password field
                var changePasswordFields = _.filter(fields, function(field) {
                    return field.type === 'change-password' || field.type === 'change-my-password';
                });
                _.each(changePasswordFields, function(field) {
                    // Get the new password and the confirmation
                    var password = this.get(field.name + '_new_password'),
                        confirmation = this.get(field.name + '_confirm_password');

                    /**
                     * Passwords don't match
                     */
                    if (password !== confirmation) {
                        // Adds the validation error
                        // confirm_password is added to errorName2Keys on initialize
                        errors[field.name] = errors[field.name] || {};
                        errors[field.name]['confirm_password'] = true;
                    } else if (!errors[field.name]) {
                        /**
                         * Passwords match
                         */
                        this.unset(field.name + '_current_password'); //Needs to be cleared for change-my-password
                        if (password !== '') {
                            this.unset(field.name + '_new_password');
                            this.unset(field.name + '_confirm_password');
                            this.set(field.name, password);
                        }
                    }
                }, this);

                callback(null, fields, errors);
            };

            /**
             * Adds the validation task to the model
             * @override
             * @param options
             */
            this.model.addValidationTask('password_confirmation', _.bind(this.model._doValidatePasswordConfirmation, this.model));

            /**
             * Unsets new password and confirmation values on revertAttributes
             * @override
             * @param options
             */
            this.model.revertAttributes = function(options) {
                // Find any change password field
                var attrs = _.clone(this.attributes);
                _.each(attrs, function(value, attr) {
                    if (attr.match('_new_password') || attr.match('_confirm_password')) {
                        this.unset(attr);
                    }
                }, this);
                // Call the old method
                _proto.revertAttributes.call(this, options);
            };
        }
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        if (this.model) {
            this.newPassword = this.model.get(this.name + '_new_password');
            this.confirmPassword = this.model.get(this.name + '_confirm_password');
            // Decides to display inputs or the link
            this.showPasswordFields = this.showPasswordFields ||
                //Show password fields if the formatted value is empty
                !this.format(this.value) ||
                //Show password fields if they aren't empty
                !!(this.newPassword || this.confirmPassword);
        }
        app.view.Field.prototype._render.call(this);
        this.showPasswordFields = false;
        this.$inputs = this.$(this.fieldTag);
        this.focusIndex = 0;
        return this;
    },

    /**
     * Sets an arbitrary value just to display stars on detail view
     * @override
     * @param {Boolean} value
     * @returns {String} value
     */
    format: function(value) {
        if (value === true) return 'value_setvalue_set';
        return value;
    },

    /**
     * Reset the arbitrary value
     * @override
     * @param {String} value
     * @returns {*} value boolean is the value is not set
     */
    unformat: function(value) {
        if (value === 'value_setvalue_set') return true;
        return value;
    },

    /**
     * @override
     */
    bindDomChange: function() {
        if (!(this.model instanceof Backbone.Model)) return;

        var self = this;
        var el = this.$(self.fieldTag);
        el.on("change", function() {
            /**
             * The only change is here.
             * We want to set <field.name>_new_password and <field.name>_current_password instead of <field.name>
             */
            self.model.set(self.name + '_' + $(this).attr('name'), self.unformat($(this).val()));
        });
    },

    /**
     * @override
     * @see View.Fields.Email
     * @returns {boolean}
     */
    focus: function() {
        if (!this.$inputs.length) {
            this.togglePasswordFields();
        }
        // this should be zero but lets make sure
        if (this.focusIndex < 0) {
            this.focusIndex = 0;
        }

        if (this.focusIndex >= this.$inputs.length) {
            // done focusing our inputs return false
            this.focusIndex = -1;
            return false;
        } else {
            // focus the next item in our list of inputs
            this.$inputs[this.focusIndex].focus();
            this.focusIndex++;
            return true;
        }
    },

    /**
     * Displays inputs for the new password and the confirmation
     * @param event
     */
    togglePasswordFields: function(event) {
        this.showPasswordFields = true;
        this.render();
    }
})
