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
    extendsFrom: 'ListeditableField',
    useSugarEmailClient: false,
    events: {
        'change .existingAddress': 'updateExistingAddress',
        'click  .btn-edit':        'toggleExistingAddressProperty',
        'click  .removeEmail':     'removeExistingAddress',
        'click  .addEmail':        'addNewAddress',
        'change .newEmail':        'addNewAddress',
        'click  .composeEmail':    'composeEmail'
    },
    _flag2Deco: {
        primary_address: {lbl: "LBL_EMAIL_PRIMARY", cl: "primary"},
        opt_out: {lbl: "LBL_EMAIL_OPT_OUT", cl: "opted-out"},
        invalid_email: {lbl: "LBL_EMAIL_INVALID", cl: "invalid"}
    },
    plugins: ['EllipsisInline', 'Tooltip'],
    initialize: function(options) {
        options     = options || {};
        options.def = options.def || {};

        if (_.isUndefined(options.def.link)) {
            options.def.link = true;
        }

        app.view.Field.prototype.initialize.call(this, options);

        // determine if the app should send email according to the use_sugar_email_client user preference
        this.useSugarEmailClient = (app.user.getPreference("use_sugar_email_client") === "true");
    },
    /**
     * Event handlers
     */
    addNewAddress: function(evt){
        if (!evt) return;
        //This event can either be triggered by the newEmail input or the newEmail button
        var email = this.$(evt.currentTarget).val() || this.$('.newEmail').val();

        if (email !== "") {
            this._addNewAddress(email);
        }
    },
    updateExistingAddress: function(evt) {
        if (!evt) return;

        var $inputs = this.$('input'),
            $input = this.$(evt.currentTarget),
            index = $inputs.index($input),
            newEmail = $input.val();
        if (newEmail === "") {
            this._removeExistingAddress(index);
        } else {
            this._updateExistingAddress(index, newEmail);
        }
    },
    removeExistingAddress: function(evt) {
        if (!evt) return;

        var $deleteButtons = this.$('.removeEmail'),
            $deleteButton = this.$(evt.currentTarget),
            index = $deleteButtons.index($deleteButton);
        this._removeExistingAddress(index);
    },
    toggleExistingAddressProperty: function(evt) {
        if (!evt) return;

        var $property = this.$(evt.currentTarget),
            property = $property.data('emailproperty'),
            $properties = this.$('[data-emailproperty='+property+']'),
            index = $properties.index($property);
        this._toggleExistingAddressProperty(index, property);
    },
    /**
     * Manipulations of the emails object
     */
    _addNewAddress: function(email) {
        var dupeAddress;
        var existingAddresses = _.clone(this.model.get(this.name)) || [];
        var oldAddresses = this.model.get(this.name) || [];
        dupeAddress = _.find(oldAddresses, function(address){
            if (address.email_address == email) {
                return true;
            }
        });

        if (dupeAddress) {
            this.render();
            return false;
        }

        var newObj = {email_address:email};
        //If no address exists, set this one as the primary
        if (existingAddresses.length < 1) {
            newObj.primary_address = true;
        }
        existingAddresses.push(newObj);

        this.updateModel(existingAddresses);
    },
    _updateExistingAddress: function(index, newEmail) {
        var existingAddresses = _.clone(this.model.get(this.name));
        //Simply update the email address
        existingAddresses[index].email_address = newEmail;
        this.updateModel(existingAddresses);
    },
    _toggleExistingAddressProperty: function(index, property) {
        var existingAddresses = _.clone(this.model.get(this.name));
        //If property is primary_address, we want to make sure one and only one primary email is set
        //As a consequence we reset all the primary_address properties to 0 then we toggle property for this index.
        if (property === 'primary_address') {
            existingAddresses[index][property] = false;
            _.find(existingAddresses, function(email, i) {
                if (email[property]) {
                    existingAddresses[i][property] = false;
                }
            });
        }
        // Toggle property for this email
        if (existingAddresses[index][property]) {
            existingAddresses[index][property] = false;
        } else {
            existingAddresses[index][property] = true;
        }
        this.updateModel(existingAddresses);
    },
    _removeExistingAddress: function(index) {
        var existingAddresses = _.clone(this.model.get(this.name)),
            wasPrimary = existingAddresses[index]['primary_address'];

        //Reject this index from existing addresses
        existingAddresses = _.reject(existingAddresses, function (emailInfo, i) { return i == index; });

        // If a removed address was the primary email, we still need at least one address to be set as the primary email
        if (wasPrimary) {
            //Let's pick the first one
            var address = _.first(existingAddresses);
            if (address) {
                address.primary_address = true;
            }
        }
        this.updateModel(existingAddresses);
    },
    /**
     * Updates model and triggers appropriate change events;
     * @param value
     */
    updateModel: function(value) {
        this.model.set(this.name, value);
        this.model.trigger('change');
        this.model.trigger('change:'+this.name);
    },
    /**
     * Mass updates a property for all email addresses
     * @param {Array} emails emails array off a model
     * @param {String} propName
     * @param {Mixed} value
     * @return {Array}
     */
    massUpdateProperty: function(emails, propName, value) {
        _.each(emails, function (emailInfo, index) {
            emails[index][propName] = value;
        });
        return emails;
    },
    /**
     * Custom error styling for the e-mail field
     * @param {Object} errors
     * @override BaseField
     */
    decorateError: function(errors){
        var emails;

        this.$el.closest('.record-cell').addClass("error");

        //Select all existing emails
        emails = this.$('input:not(.newEmail)');

        _.each(errors, function(errorContext, errorName) {
            //For `email` validator the error is specific to an email
            if (errorName === 'email' || errorName === 'duplicateEmail') {

                // For each of our `sub-email` fields
                _.each(emails, function(e) {
                    var $email = this.$(e),
                        email = $email.val();

                    var isError = _.find(errorContext, function(emailError) { return emailError === email; });
                    // if we're on an email sub field where error occurred, add error styling
                    if(!_.isUndefined(isError)) {
                        this._addErrorDecoration($email, errorName, [isError]);
                    }
                }, this);
            //For required or primaryEmail we want to decorate only the first email
            } else {
                var $email = this.$('input:first');
                this._addErrorDecoration($email, errorName, errorContext);
            }
        }, this);
    },
    _addErrorDecoration: function($input, errorName, errorContext) {
        var isWrapped = $input.parent().hasClass('input-append');
        if (!isWrapped)
            $input.wrap('<div class="input-append error '+this.fieldTag+'">');
        $input.next('.error-tooltip').remove();
        $input.after(this.exclamationMarkTemplate([app.error.getErrorString(errorName, errorContext)]));
        var $tooltip = $input.next('.error-tooltip');
        if (_.isFunction($tooltip.tooltip)) {
            $tooltip.tooltip({
                container:'body',
                placement:'top',
                trigger:'click'
            });
        }
    },
    /**
     * Binds DOM changes to set field value on model.
     * @param {Backbone.Model} model model this field is bound to.
     * @param {String} fieldName field name.
     */
    bindDomChange: function() {
        if(this.tplName === 'list-edit') {
            app.view.Field.prototype.bindDomChange.call(this);
        }
    },

    /**
     * To API representation
     * @param {String|Array} value single email address or set of email addresses
     */
    format: function(value) {
        value = app.utils.deepCopy(value);
        if (_.isArray(value) && value.length > 0) {
            // got an array of email addresses
            _.each(value, function(email) {
                // On render, determine which e-mail addresses need anchor tag included
                // Needed for handlebars template, can't accomplish this boolean expression with handlebars
                email.hasAnchor = this.def.link && !email.opt_out && !email.invalid_email;
            }, this);
        } else if ((_.isString(value) && value !== "") || this.view.action === 'list') {
            // expected an array with a single address but got a string or an empty array
            value = [{
                email_address:value,
                primary_address:true,
                hasAnchor:false,
                _wasNotArray:true
            }];
        }

        value = this.addFlagLabels(value);
        return value;
    },
    addFlagLabels: function(value) {
        var flagStr = "", flagClassStr = "", flagArray, flagClass;
        _.each(value, function(emailObj) {
            flagStr = "";
            flagArray = _.map(emailObj, function (flagValue, key) {
                if (!_.isUndefined(this._flag2Deco[key]) && this._flag2Deco[key].lbl && flagValue) {
                    return app.lang.get(this._flag2Deco[key].lbl);
                }
            }, this);
            flagArray = _.without(flagArray, undefined);
            if (flagArray.length > 0) {
                flagStr = flagArray.join(", ");
            }
            flagClassStr = "";
            flagClass = _.map(emailObj, function (flagValue, key) {
                if (!_.isUndefined(this._flag2Deco[key]) && this._flag2Deco[key].cl && flagValue) {
                    return app.lang.get(this._flag2Deco[key].cl);
                }
            }, this);
            flagClass = _.without(flagClass, undefined);
            if (flagClass.length > 0) {
                flagClassStr = flagClass.join(", ");
            }
            emailObj.flagLabel = flagStr;
            emailObj.flagClass = flagClassStr;
        }, this);
        return value;
    },
    /**
     * To display representation
     * @param {String|Array} value single email address or set of email addresses
     */
    unformat: function(value) {
        var originalNonArrayValue = null;
        if(this.view.action === 'list') {
            var emails = this.model.get(this.name),
                changed = false;
            if(!_.isArray(emails)){ // emails is empty, initialize array
                emails = [];
            }
            _.each(emails, function(email, index) {
                if(email.primary_address) {
                    if(email.email_address !== value) {
                        changed = true;
                        emails[index].email_address = value;
                    }
                }
            }, this);

            // Adding a new email
            if (emails.length == 0) {
                emails.push({
                    email_address:   value,
                    primary_address: true,
                    hasAnchor:       false,
                    _wasNotArray:    true
                });
                changed = true;
            }

            if(changed) {
                this.updateModel(emails);
            }
            return emails;
        }

        _.each(value, function(email, index) {
            if (email._wasNotArray) {
                // copy the original string representation
                originalNonArrayValue = email.email_address;
            } else {
                // Remove handlebars cruft from e-mails so we only send valid fields back on save
                value[index] = _.pick(email, 'email_address', 'primary_address', 'opt_out', 'invalid_email');
            }
        }, this);

        if (!_.isNull(originalNonArrayValue)) {
            // reformat the value back to the original string representation
            value = originalNonArrayValue;
        }

        return value;
    },
    focus: function() {
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
    _render: function() {
        app.view.Field.prototype._render.call(this);
        this.$inputs = this.$('input');
        this.focusIndex = 0;
    },
    composeEmail: function(evt) {
        evt.stopPropagation();
        evt.preventDefault();

        var model = app.data.createBean(this.model.module);
        model.copy(this.model);
        model.set('id', this.model.id);

        app.drawer.open({
            layout : 'compose',
            context: {
                create: 'true',
                module: 'Emails',
                prepopulate: {
                    to_addresses: [
                        {
                            email: this.$(evt.currentTarget).text(),
                            bean: model
                        }
                    ],
                    related: model
                }
            }
        });
    }
})
