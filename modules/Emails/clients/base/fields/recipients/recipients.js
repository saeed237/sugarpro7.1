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
({
    /**
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    events: {
        "click .btn": "_showAddressBook"
    },

    fieldTag: 'input.select2',

    tooltips: [], //initialized tooltips

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);
        // initialize the value to an empty collection
        this.model.set(this.name, new Backbone.Collection);
    },

    /**
     * Sets up event handlers for syncing between the model and the recipients field.
     *
     * @see RecipientsField::format() For the acceptable formats for recipients.
     */
    bindDataChange: function() {
        /**
         * Sets the value of the Select2 element and rebuilds the tooltips for all recipients.
         * @param {Array} recipients @see the return value for RecipientsField::format().
         */
        var updateTheDom = _.bind(function(recipients) {
            // put the formatted recipients in the DOM
            this.getFieldElement().select2('data', recipients);
            // rebuild the tooltips
            this._initializeTooltips();
        }, this);
        /**
         * Sets up event handlers that allow external forces to manipulate the contents of the collection, while
         * maintaining the requirement for storing formatted recipients.
         */
        var bindCollectionChange = _.bind(function() {
            var value = this.model.get(this.name);
            if (value instanceof Backbone.Collection) {
                // on "add" we want to force the collection to be reset to guarantee that all models in the collection
                // have been properly formatted for use in this field
                value.on('add', function(models, collection) {
                    // Backbone destroys the models currently in the collection on reset, so we must clone the
                    // collection in order to add the same models again
                    collection.reset(collection.clone().models);
                }, this);
                // on "remove" the requisite models have already been removed, so we only need to bother updating the
                // value in the DOM
                value.on('remove', function(models, collection) {
                    // format the recipients and put them in the DOM
                    updateTheDom(this.format(this.model.get(this.name)));
                }, this);
                // on "reset" we want to replace all models in the collection with their formatted versions
                value.on('reset', function(collection) {
                    var recipients = this.format(collection.models);
                    // do this silently so we don't trigger another reset event and end up in an infinite loop
                    collection.reset(recipients, {silent: true});
                    // put the newly formatted recipients in the DOM
                    updateTheDom(recipients);
                }, this);
            }
        }, this);

        // set up collection event handlers for the initial collection (initialized during this.initialize)
        bindCollectionChange();

        // handle the value on the model being changed to something other than the initial collection
        this.model.on("change:" + this.name, function(model, recipients) {
            var value = this.model.get(this.name);
            if (!(value instanceof Backbone.Collection)) {
                // whoa! someone changed the value to be something other than a collection
                // stick that new value inside a collection and reset the value, so we're always dealing with a
                // collection... another change event will be triggered, so we'll end up in the else block right after
                // this
                this.model.set(this.name, new Backbone.Collection(value));
            } else {
                // phew! the value is a collection
                // but it's not the initial collection, so we'll have to set up collection event handlers for this
                // instance
                bindCollectionChange();
                // you never know what data someone sticks on the field, so we better reset the values in the collection
                // so that the recipients become formatted as we expect
                value.reset(recipients.clone().models);
            }
        }, this);
    },

    /**
     * Remove events from the field value if it is a collection
     */
    unbindData: function() {
        var value = this.model.get(this.name);
        if (value instanceof Backbone.Collection) {
            value.off(null, null, this);
        }

        app.view.Field.prototype.unbindData.call(this);
    },

    /**
     * Render field with select2 widget
     *
     * @private
     */
    _render: function() {
        app.view.Field.prototype._render.call(this);

        var $recipientsField = this.getFieldElement();

        if ($recipientsField.length > 0) {
            $recipientsField.select2({
                allowClear:          true,
                multiple:            true,
                width:               'off',
                containerCssClass:   'select2-choices-pills-close',
                containerCss:        {'width':'100%'},
                minimumInputLength:  1,
                query:               _.bind(function(query) {this.loadOptions(query);}, this),
                createSearchChoice:  _.bind(this.createOption, this),
                formatSelection:     _.bind(this.formatSelection, this),
                formatResult:        _.bind(this.formatResult, this),
                formatSearching:     _.bind(this.formatSearching, this),
                formatInputTooShort: _.bind(this.formatInputTooShort, this),
                selectOnBlur:        true
            });

            if (!!this.def.disabled) {
                $recipientsField.select2('disable');
            }
        }
    },

    /**
     * Fetch additional recipients from the server.
     *
     * @see http://ivaynberg.github.io/select2/#doc-query
     * @param {Object} query Possible attributes can be found in select2's documentation.
     */
    loadOptions: _.debounce(function(query) {
        var self = this,
            data = {
                results: [],
                // only show one page of results
                // if more results are needed, then the address book should be used
                more: false
            },
            options = {},
            callbacks = {};

        // add the search term to the URL params
        options.q = query.term;
        // add the allowed modules to the URL params
        options.module_list = 'Accounts,Contacts,Leads,Prospects,Users';
        // add the necessary fields to the URL params
        options.fields = 'name,email';
        // the first 10 results should be enough
        // if more results are needed, then the address book should be used
        options.max_num = 10;
        // create the callbacks
        callbacks.success = function(result) {
            // the api returns objects formatted such that sidecar can convert them to beans
            // we need the records to be in a standard object format (@see RecipientsField::format) and the records
            // need to be converted into beans before we can format them
            var records = app.data.createMixedBeanCollection(result.records);
            // format and add the recipients that were found via the select2 callback
            data.results = self.format(records);
        };
        callbacks.error = function() {
            // don't add any recipients via the select2 callback
            data.results = [];
        };
        callbacks.complete = function() {
            // execute the select2 callback to add any new recipients
            query.callback(data);
        };
        app.api.search(options, callbacks);
    }, 300),

    /**
     * Create additional select2 options when loadOptions returns no matches for the search term.
     *
     * @see http://ivaynberg.github.io/select2/#documentation
     * @param {String} term
     * @param {Array} data The options in the select2 drop-down after the query callback has been executed.
     * @returns {Object}
     */
    createOption: function(term, data) {
        if (data.length === 0) {
            return {id: term, email: term};
        }
    },

    /**
     * Formats a recipient object for displaying selected recipients.
     *
     * @see http://ivaynberg.github.io/select2/#documentation
     * @param {Object} recipient
     * @return {String}
     */
    formatSelection: function(recipient) {
        return recipient.name ? recipient.name : recipient.email;
    },

    /**
     * Formats a recipient object for displaying items in the recipient options list.
     *
     * @see http://ivaynberg.github.io/select2/#documentation
     * @param {Object} recipient
     * @return {String}
     */
    formatResult: function(recipient) {
        return this.formatSelection(recipient); // do the same as formatSelection by default
    },

    /**
     * Returns the localized message indicating that a search is in progress
     *
     * @see http://ivaynberg.github.io/select2/#documentation
     * @returns {String}
     */
    formatSearching: function() {
        return app.lang.get("LBL_LOADING", this.module);
    },

    /**
     * Suppresses the message indicating the number of characters remaining before a search will trigger
     *
     * @see http://ivaynberg.github.io/select2/#documentation
     * @param term
     * @param min
     * @returns {String}
     */
    formatInputTooShort: function(term, min) {
        return "";
    },

    /**
     * Formats a set of recipients into an array of objects that select2 understands.
     *
     * @param {*} data A Backbone collection, a single Backbone model or standard JavaScript object, or an array of
     *                 Backbone models or standard JavaScript objects.
     * @returns {Array}
     * @see RecipientsField::_formatRecipient() For the acceptable/expected attributes to be found on each recipient.
     */
    format: function(data) {
        var formattedRecipients = [];
        // the lowest common denominator of potential inputs is an array of objects
        // force the parameter to be an array of either objects or Backbone models so that we're always dealing with
        // one data-structure type
        if (data instanceof Backbone.Collection) {
            // get the raw array of models
            data = data.models;
        } else if (data instanceof Backbone.Model || (_.isObject(data) && !_.isArray(data))) {
            // wrap the single model in an array so the code below behaves the same whether it's a model or a collection
            data = [data];
        }
        if (_.isArray(data)) {
            _.each(data, function(recipient) {
                var formattedRecipient;
                if (!(recipient instanceof Backbone.Model)) {
                    // force the object to be a Backbone.Model to allow for certain assumptions to be made
                    // there is no harm in this because the recipient will not be added to the return value if no email
                    // address is found on the model
                    recipient = new Backbone.Model(recipient);
                }
                formattedRecipient = this._formatRecipient(recipient);
                // only add the recipient if there is an email address
                if (!_.isEmpty(formattedRecipient.email)) {
                    formattedRecipients.push(formattedRecipient);
                }
            }, this);
        }
        return formattedRecipients;
    },

    /**
     * Synchronize the recipient field value with the model and setup tooltips for email pills.
     *
     * NOTE: In Select2 v3.4.0, the event names are namespaced (prefixed with "select2-"). So it is expected that the
     * event handlers defined in this method for the Select2 field will break upon upgrading.
     */
    bindDomChange: function() {
        var self = this;
        this.getFieldElement()
            .on("change", function() {
                var value = $(this).select2('data');
                self.model.get(self.name).reset(value);
            })
            .on("change", function(event) {
                self._initializeTooltips();
            }).
            on("selected", _.bind(this._handleEventOnSelected, this));
    },

    /**
     * Event handler for the Select2 "selected" event.
     *
     * NOTE: In Select2 v3.4.0, the event names are namespaced (prefixed with "select2-"). So "selected" event will no
     * longer exist; it will become the "select2-selecting" event.
     *
     * @param event
     * @returns {boolean}
     * @private
     */
    _handleEventOnSelected: function (event) {
        // only allow the user to select an option if it is determined to be a valid email address
        // returning true will select the option; false will prevent the option from being selected
        var isValidChoice = false;

        // since this event is fired twice, we only want to perform validation on the first event
        // event.object is not available on the second event
        if (event.object) {
            // the id and email address will not match when the email address came from the database and
            // we are assuming that email addresses stored in the database have already been validated
            if (event.object.id == event.object.email) {
                // this option must be a new email address that the application does not recognize
                // so validate it
                isValidChoice = this._validateEmailAddress(event.object.email);
            } else {
                // the application should recognize the email address, so no need to validate it again
                // just assume it's a valid choice and we'll deal with the consequences later (server-side)
                isValidChoice = true;
            }
        }

        return isValidChoice;
    },

    /**
     * Destroy all select2 and tooltip plugins
     */
    unbindDom: function() {
        this._destroyTooltips();
        this.getFieldElement().select2('destroy');
        app.view.Field.prototype.unbindDom.call(this);
    },

    /**
     * When in edit mode, the field includes an icon button for opening an address book. Clicking the button will
     * trigger an event to open the address book, which calls this method to do the dirty work. The selected recipients
     * are added to this field upon closing the address book.
     *
     * @private
     */
    _showAddressBook: function() {
        /**
         * Callback to add recipients, from a closing drawer, to the target Recipients field.
         * @param {undefined|Backbone.Collection} recipients
         */
        var addRecipients = _.bind(function(recipients) {
            if (recipients && recipients.length > 0) {
                this.model.get(this.name).add(recipients.models);
            }
        }, this);
        app.drawer.open(
            {
                layout:  "compose-addressbook",
                context: {
                    module: "Emails",
                    mixed:  true
                }
            },
            function(recipients) {
                addRecipients(recipients);
            }
        );
    },

    /**
     * update ul.select2-choices data attribute which prevents underrun of pills by
     * using a css definition for :before {content:''} set to float right
     *
     * @param content {String}
     */
    setContentBefore: function(content) {
        this.$('.select2-choices').attr('data-content-before', content);
    },

    /**
     * Gets the recipients DOM field
     *
     * @returns {Object} DOM Element
     */
    getFieldElement: function() {
        return this.$(this.fieldTag);
    },

    /**
     * Tooltip should show when hovering over the recipient pill
     * @private
     */
    _initializeTooltips: function() {
        var self = this;
        this._destroyTooltips();
        this.$('.select2-search-choice').each(function() {
            $(this).tooltip({
                container: 'body',
                title: $(this).data('select2Data').email
            });
            self.tooltips.push($(this).data('tooltip'));
        });
    },

    /**
     * Destroy all tooltips
     * @private
     */
    _destroyTooltips: function() {
        _.each(this.tooltips, function(tooltip) {
            tooltip.destroy();
        });
        this.tooltips = [];
    },

    /**
     * Format a recipient from a Backbone.Model to a standard JavaScript object with id, module, email, and name
     * attributes. Only id and email are required for the recipient to be considered valid
     * (@see RecipientsField::format()).
     *
     * All attributes are optional. However, if the email attribute is not present, then a primary email address should
     * exist on the bean. Without an email address that can be resolved, the recipient is considered to be invalid. The
     * bean attribute must be a Backbone.Model and it is likely to be a Bean. Data found in the bean is considered to be
     * secondary to the attributes found on its parent model. The bean is a mechanism for collecting additional
     * information about the recipient that may not have been explicitly set when the recipient was passed in.
     * @param {Backbone.Model} recipient
     * @returns {Object}
     * @private
     */
    _formatRecipient: function(recipient) {
        var formattedRecipient = {};
        if (recipient instanceof Backbone.Model) {
            var bean = recipient.get('bean');
            // if there is a bean attribute, then more data can be extracted about the recipient to fill in any holes if
            // attributes are missing amongst the primary attributes
            // so follow the trail using recursion
            if (bean) {
                formattedRecipient = this._formatRecipient(bean);
            }
            // prioritize any values found on recipient over those already extracted from bean
            formattedRecipient = {
                id:     recipient.get('id') || formattedRecipient.id || recipient.get('email'),
                module: recipient.get('module') || recipient.module || recipient.get('_module') || formattedRecipient.module,
                email:  recipient.get('email') || formattedRecipient.email,
                name:   recipient.get('name') || recipient.get('full_name') || formattedRecipient.name
            };
            // don't bother with the recipient unless an id is present
            if (!_.isEmpty(formattedRecipient.id)) {
                // extract the primary email address for the recipient
                if (_.isArray(formattedRecipient.email)) {
                    var primaryEmailAddress = _.findWhere(formattedRecipient.email, {primary_address: true});

                    if (!_.isUndefined(primaryEmailAddress) && !_.isEmpty(primaryEmailAddress.email_address)) {
                        formattedRecipient.email = primaryEmailAddress.email_address;
                    }
                }
                // drop any values that are empty or non-compliant
                _.each(formattedRecipient, function(val, key) {
                    if (_.isEmpty(formattedRecipient[key]) || !_.isString(formattedRecipient[key])) {
                        delete formattedRecipient[key];
                    }
                });
            } else {
                // drop all values if an id isn't present
                formattedRecipient = {};
            }
        }
        return formattedRecipient;
    },

    /**
     * Validates an email address on the server.
     *
     * @param {String} emailAddress
     * @returns {boolean}
     * @private
     */
    _validateEmailAddress: function(emailAddress) {
        var isValid   = false,
            callbacks = {},
            options   = {
                // execute the api call synchronously so that the method doesn't return before the response is known
                async: false
            },
            url       = app.api.buildURL("Mail", "address/validate");

        callbacks.success = function(result) {
            isValid = result[emailAddress];
        };
        callbacks.error = function() {
            isValid = false;
        };
        app.api.call("create", url, [emailAddress], callbacks, options);

        return isValid;
    }
})
