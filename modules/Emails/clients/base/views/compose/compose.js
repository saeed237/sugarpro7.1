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

/**
 * View for the email composition layout that contains the HTML editor.
 */
({
    extendsFrom: 'RecordView',

    _lastSelectedSignature: null,
    ATTACH_TYPE_SUGAR_DOCUMENT: 'document',
    ATTACH_TYPE_TEMPLATE: 'template',
    MIN_EDITOR_HEIGHT: 300,
    EDITOR_RESIZE_PADDING: 5,

    initialize: function(options) {
        _.bindAll(this);
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'initialize', args:[options]});
        this.events = _.extend({}, this.events, {
            'click .cc-option': 'showSenderOptionField',
            'click .bcc-option': 'showSenderOptionField',
            'click [name=draft_button]': 'saveAsDraft',
            'click [name=send_button]': 'send',
            'click [name=cancel_button]': 'cancel'
        });
        this.context.on('actionbar:template_button:clicked', this.launchTemplateDrawer, this);
        this.context.on('actionbar:attach_sugardoc_button:clicked', this.launchDocumentDrawer, this);
        this.context.on("actionbar:signature_button:clicked", this.launchSignatureDrawer, this);
        this.context.on('attachments:updated', this.toggleAttachmentVisibility, this);
        this.context.on('tinymce:oninit', this.handleTinyMceInit, this);
        this.on('more-less:toggled', this.handleMoreLessToggled, this);
        app.drawer.on('drawer:resize', this.resizeEditor, this);

        this._lastSelectedSignature = app.user.getPreference("signature_default");
    },

    _render: function () {
        var toAddressesField;

        app.view.invokeParent(this, {type: 'view', name: 'record', method: '_render'});
        if (this.createMode) {
            this.setTitle(app.lang.get('LBL_COMPOSEEMAIL', this.module));
        }

        if (this.model.isNotEmpty) {
            var prepopulateValues = this.context.get("prepopulate");
            if (!_.isEmpty(prepopulateValues)) {
                this.prepopulate(prepopulateValues);
            }

            this.renderSenderOptions();

            if (this.model.isNew()) {
                this._updateEditorWithSignature(this._lastSelectedSignature);
            }
        }

        toAddressesField = this.getField('to_addresses');
        if (toAddressesField) {
            toAddressesField.on('render', _.bind(function(){
                this.setRecipientContentBefore();
            }, this));
        }
    },

    /**
     * Prepopulate fields on the email compose screen that are passed in on the context when opening this view
     *
     * @param values
     */
    prepopulate: function(values) {
        var self = this;
        _.defer(function() {
            _.each(values, function(value, fieldName) {
                switch(fieldName) {
                    case 'related':
                        self.populateRelated(value);
                        break;
                    default:
                        self.model.set(fieldName, value);
                }
            });
        });
    },

    /**
     * Populate the parent_name (type: parent) with the related record passed in
     *
     * @param relatedModel
     */
    populateRelated: function(relatedModel) {
        var setParent = _.bind(function(model) {
            model.value = model.get('name');
            this.getField('parent_name').setValue(model);
        }, this);

        if (!_.isEmpty(relatedModel.get('id')) && !_.isEmpty(relatedModel.get('name'))) {
            setParent(relatedModel);
        } else if (!_.isEmpty(relatedModel.get('id'))) {
            relatedModel.fetch({
                showAlerts: false,
                success: function(relatedModel) {
                    setParent(relatedModel);
                },
                fields: ['name']
            });
        }
    },

    /**
     * Enable/disable the page action dropdown menu based on whether email is sendable
     * @param disabled
     */
    setMainButtonsDisabled: function(disabled) {
        this.getField('main_dropdown').setDisabled(disabled);
    },

    /**
     * Check if CC or BCC fields have values - if not, hide the fields and inject a link to show it
     */
    renderSenderOptions: function() {
        var showCCLink = false,
            showBCCLink = false,
            toCC = this.model.get('cc_addresses') || [],
            toBCC = this.model.get('bcc_addresses') || [];

        if (toCC.length == 0) {
            this.hideField('cc_addresses');
            showCCLink = true;
        }

        if (toBCC.length == 0) {
            this.hideField('bcc_addresses');
            showBCCLink = true;
        }

        this.toggleSenderOptions('to_addresses', showCCLink, showBCCLink);
    },

    /**
     * Run the sender option template to toggle whether CC or BCC show links are injected
     *
     * @param container
     * @param showCCLink
     * @param showBCCLink
     */
    toggleSenderOptions: function(container, showCCLink, showBCCLink) {
        var field = this.getField(container),
            ccField,
            senderOptionTemplate;

        if (field) {
            ccField = field.$el.closest('.row-fluid.panel_body');
            senderOptionTemplate = app.template.getView("compose-senderoptions", this.module);

            $(senderOptionTemplate({
                'module' : this.module,
                'showCC': showCCLink,
                'showBCC': showBCCLink,
                'showSeperator': showCCLink && showBCCLink
            })).insertAfter(ccField.find('div span.normal'));
        }
    },

    /**
     * Event Handler for showing the CC or BCC options on the page.
     *
     * @param evt click event
     */
    showSenderOptionField: function(evt) {
        var ccOption = $(evt.target),
            fieldName = ccOption.data('ccfield'),
            field = this.getField(fieldName),
            ccSeperator = this.$('.compose-sender-options .cc-seperator');

        ccOption.addClass('hide');
        ccSeperator.toggleClass('hide', true);

        field.$el.closest('.row-fluid.panel_body').removeClass('hide');

        this.setRecipientContentBefore();

        //check to see if both fields are hidden then hide the whole thing
        if (this.$('.cc-option').hasClass('hide') && this.$('.bcc-option').hasClass('hide')){
            this.$('.compose-sender-options').addClass('hide');
        }

        this.resizeEditor();
    },

    /**
     * Creates virtual block on to_address select2 ul to wrap pills
     *
     * @param fieldName name of the field to hide
     */
    setRecipientContentBefore: function() {
        var toAddressesField = this.getField('to_addresses');
        if (toAddressesField) {
            toAddressesField.setContentBefore(this.$('.compose-sender-options a').not('.hide').text());
        }
    },

    /**
     * Hides a field section on the form
     *
     * @param fieldName name of the field to hide
     */
    hideField: function(fieldName) {
        var field = this.getField(fieldName);
        if (field) {
            field.$el.closest('.row-fluid.panel_body').addClass('hide');
        }
    },

    /**
     * Cancel and close the drawer
     */
    cancel: function() {
        app.drawer.close();
    },

    /**
     * Get the attachments from the model and format for the API
     *
     * @returns array of attachments or empty array if none found
     */
    getAttachmentsForApi: function() {
        var attachments = this.model.get('attachments') || [];

        if (!_.isArray(attachments)) {
            attachments = [attachments];
        }

        return attachments;
    },

    /**
     * Get the individual related object fields from the model and format for the API
     *
     * @returns API related argument as array with appropriate fields set
     */
    getRelatedForApi: function() {
        var related = {};
        var id   = this.model.get('parent_id');
        var type;

        if (!_.isUndefined(id)) {
            id = id.toString();
            if (id.length > 0) {
                related['id'] = id;
                type = this.model.get('parent_type');
                if (!_.isUndefined(type)) {
                    type = type.toString();
                }
                related.type = type;
            }
        }

        return related;
    },

    /**
     * Get the team information from the model and format for the API
     *
     * @returns API teams argument as array with appropriate fields set
     */
    getTeamsForApi: function() {
        var teamName = this.model.get('team_name') || [];
        var teams = {};
        teams.others = [];

        if (!_.isArray(teamName)) {
            teamName = [teamName];
        }

        _.each(teamName, function(team) {
            if (team.primary) {
                teams.primary = team.id.toString();
            } else if (!_.isUndefined(team.id)) {
                teams.others.push(team.id.toString());
            }
        }, this);

        if (teams.others.length == 0) {
            delete teams.others;
        }

        return teams;
    },

    /**
     * Build a backbone model that will be sent to the Mail API
     */
    initializeSendEmailModel: function() {
        var sendModel = new Backbone.Model(_.extend({}, this.model.attributes, {
            to_addresses: this.model.get('to_addresses'),
            cc_addresses: this.model.get('cc_addresses'),
            bcc_addresses: this.model.get('bcc_addresses'),
            attachments: this.getAttachmentsForApi(),
            related: this.getRelatedForApi(),
            teams: this.getTeamsForApi()
        }));
        return sendModel;
    },

    /**
     * Save the email as a draft for later sending
     */
    saveAsDraft: function() {
        this.saveModel(
            'draft',
            app.lang.get('LBL_DRAFT_SAVING', this.module),
            app.lang.get('LBL_DRAFT_SAVED', this.module),
            app.lang.get('LBL_ERROR_SAVING_DRAFT', this.module)
        );
    },

    /**
     * Send the email immediately or warn if user did not provide subject or body
     */
    send: function() {
        var sendEmail = _.bind(function() {
            this.saveModel(
                'ready',
                app.lang.get('LBL_EMAIL_SENDING', this.module),
                app.lang.get('LBL_EMAIL_SENT', this.module),
                app.lang.get('LBL_ERROR_SENDING_EMAIL', this.module)
            );
        }, this);

        if (!this.isFieldPopulated('to_addresses') && !this.isFieldPopulated('cc_addresses') && !this.isFieldPopulated('bcc_addresses')) {
            this.model.trigger('error:validation:to_addresses');
            app.alert.show('send_error', {
                level: 'error',
                messages: 'LBL_EMAIL_COMPOSE_ERR_NO_RECIPIENTS'
            });
        } else if (!this.isFieldPopulated('subject') && !this.isFieldPopulated('html_body')) {
            app.alert.show('send_confirmation', {
                level: 'confirmation',
                messages: app.lang.get('LBL_NO_SUBJECT_NO_BODY_SEND_ANYWAYS', this.module),
                onConfirm: sendEmail
            });
        } else if (!this.isFieldPopulated('subject')) {
            app.alert.show('send_confirmation', {
                level: 'confirmation',
                messages: app.lang.get('LBL_SEND_ANYWAYS', this.module),
                onConfirm: sendEmail
            });
        } else if (!this.isFieldPopulated('html_body')) {
            app.alert.show('send_confirmation', {
                level: 'confirmation',
                messages: app.lang.get('LBL_NO_BODY_SEND_ANYWAYS', this.module),
                onConfirm: sendEmail
            });
        } else {
            sendEmail();
        }
    },

    /**
     * Build the backbone model to be sent to the Mail API with the appropriate status
     * Also display the appropriate alerts to give user indication of what is happening.
     *
     * @param status (draft or ready)
     * @param pendingMessage message to display while Mail API is being called
     * @param successMessage message to display when a successful Mail API response has been received
     * @param errorMessage message to display when Mail API call fails
     */
    saveModel: function(status, pendingMessage, successMessage, errorMessage) {
        var myURL,
            sendModel = this.initializeSendEmailModel();

        this.setMainButtonsDisabled(true);
        app.alert.show('mail_call_status', {level: 'process', title: pendingMessage});

        sendModel.set('status', status);
        myURL = app.api.buildURL('Mail');
        app.api.call('create', myURL, sendModel, {
            success: function() {
                app.alert.dismiss('mail_call_status');
                app.alert.show('mail_call_status', {autoClose: true, level: 'success', messages: successMessage});
                app.drawer.close();
            },
            error: function(error) {
                var msg = {autoClose: false, level: 'error'};
                if (error && _.isString(error.message)) {
                    msg.messages = error.message;
                }
                app.alert.dismiss('mail_call_status');
                app.alert.show('mail_call_status', msg);
            },
            complete:_.bind(function() {
                if (!this.disposed) {
                    this.setMainButtonsDisabled(false);
                }
            }, this)
        });
    },

    /**
     * Is this field populated?
     * @param fieldName
     * @return {Boolean}
     */
    isFieldPopulated: function(fieldName) {
        return ($.trim(this.model.get(fieldName)) !== '');
    },

    /**
     * Open the drawer with the EmailTemplates selection list layout. The callback should take the data passed to it
     * and replace the existing editor contents with the selected template.
     */
    launchTemplateDrawer: function() {
        app.drawer.open({
                layout:'selection-list',
                context:{
                    module:'EmailTemplates'
                }
            },
            this.templateDrawerCallback
        );
    },

    /**
     * Receives the selected template to insert and begins the process of confirming the operation and inserting the
     * template into the editor.
     *
     * @param model
     */
    templateDrawerCallback: function(model) {
        if (model) {
            var emailTemplate = app.data.createBean('EmailTemplates', { id: model.id });
            emailTemplate.fetch({
                success: this.confirmTemplate,
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Presents the user with a confirmation prompt indicating that inserting the template will replace all content
     * in the editor. If the user confirms "yes" then the template will inserted.
     *
     * @param template
     */
    confirmTemplate: function(template) {
        if (this.disposed === true) return; //if view is already disposed, bail out
        app.alert.show('delete_confirmation', {
            level:'confirmation',
            messages:app.lang.get('LBL_EMAILTEMPLATE_MESSAGE_SHOW_MSG', this.module),
            onConfirm:_.bind(function() {
                this.insertTemplate(template);
            }, this)
        });
    },

    /**
     * Inserts the template into the editor.
     *
     * @param template
     */
    insertTemplate: function(template) {
        var subject,
            notes;

        if (_.isObject(template)) {
            subject = template.get('subject');

            if (subject) {
                this.model.set('subject', subject);
            }

            //TODO: May need to move over replaces special characters.
            if (template.get('text_only') === 1) {
                this.model.set("html_body", template.get("body"));
            } else {
                this.model.set("html_body", template.get("body_html"));
            }

            notes = app.data.createBeanCollection("Notes");

            notes.fetch({
                'filter':{
                    "filter":[
                        {"parent_id":{"$equals":template.id}}
                    ]
                },
                success:_.bind(function(data) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    if (!_.isEmpty(data.models)) {
                        this.insertTemplateAttachments(data.models);
                    }
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });

            // currently adds the html signature even when the template is text-only
            this._updateEditorWithSignature(this._lastSelectedSignature);
        }
    },

    /**
     * Inserts attachments associated with the template by triggering an "add" event for each attachment to add to the
     * attachments field.
     *
     * @param attachments
     */
    insertTemplateAttachments: function(attachments) {
        this.context.trigger("attachments:remove-by-tag", 'template');
        _.each(attachments, function(attachment) {
            var filename = attachment.get('filename');
            this.context.trigger("attachment:add", {
                id: attachment.id,
                name: filename,
                nameForDisplay: filename,
                tag: 'template',
                type: this.ATTACH_TYPE_TEMPLATE
            });
        }, this);
    },

    /**
     * Open the drawer with the SugarDocuments attachment selection list layout. The callback should take the data
     * passed to it and add the document as an attachment.
     */
    launchDocumentDrawer: function() {
        app.drawer.open({
                layout: 'selection-list',
                context: {module: 'Documents'}
            },
            this.documentDrawerCallback);
    },

    /**
     * Fetches the selected SugarDocument using its ID and triggers an "add" event to add the attachment to the
     * attachments field.
     *
     * @param model
     */
    documentDrawerCallback: function(model) {

        if (model) {
            var sugarDocument = app.data.createBean('Documents', { id: model.id });
            sugarDocument.fetch({
                success:_.bind(function (model) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    this.context.trigger("attachment:add", {
                        id:model.id,
                        name:model.get('filename'),
                        nameForDisplay:model.get('filename'),
                        type: this.ATTACH_TYPE_SUGAR_DOCUMENT
                    });
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Hide attachment field row if no attachments, show when added
     *
     * @param attachments
     */
    toggleAttachmentVisibility: function(attachments) {
        var $row = this.$('.attachments').closest('.row-fluid');
        if (attachments.length > 0) {
            $row.removeClass('hidden');
            $row.addClass('single');
        } else {
            $row.addClass('hidden');
            $row.removeClass('single');
        }
        this.resizeEditor();
    },

    /**
     * Open the drawer with the signature selection layout. The callback should take the data passed to it and insert
     * the signature in the correct place.
     *
     * @private
     */
    launchSignatureDrawer: function() {
        app.drawer.open(
            {
                layout: "selection-list",
                context: {
                    module: 'UserSignatures'
                }
            },
            this._updateEditorWithSignature
        );
    },

    /**
     * Fetches the signature content using its ID and updates the editor with the content.
     *
     * @param model
     */
    _updateEditorWithSignature: function(model) {
        if (model && model.id) {
            var signature = app.data.createBean('UserSignatures', { id: model.id });

            signature.fetch({
                success:_.bind(function (model) {
                    if (this.disposed === true) return; //if view is already disposed, bail out
                    if (this._insertSignature(model)) {
                        this._lastSelectedSignature = model;
                    }
                }, this),
                error: _.bind(function(error) {
                    this._showServerError(error);
                }, this)
            });
        }
    },

    /**
     * Inserts the signature into the editor.
     *
     * @param signature
     * @return {Boolean}
     * @private
     */
    _insertSignature: function(signature) {
        if (_.isObject(signature) && signature.get('signature_html')) {
            var signatureContent          = this._formatSignature(signature.get('signature_html')),
                emailBody                 = this.model.get("html_body") || "",
                signatureOpenTag          = '<br class="signature-begin" />',
                signatureCloseTag         = '<br class="signature-end" />',
                signatureOpenTagForRegex  = '(<br\ class=[\'"]signature\-begin[\'"].*?\/?>)',
                signatureCloseTagForRegex = '(<br\ class=[\'"]signature\-end[\'"].*?\/?>)',
                signatureOpenTagMatches   = emailBody.match(new RegExp(signatureOpenTagForRegex, "gi")),
                signatureCloseTagMatches  = emailBody.match(new RegExp(signatureCloseTagForRegex, "gi")),
                regex                     = new RegExp(signatureOpenTagForRegex + ".*?" + signatureCloseTagForRegex, "gi");

            if (signatureOpenTagMatches && !signatureCloseTagMatches) {
                // there is a signature, but no close tag; so the signature runs from open tag until EOF
                emailBody = this._insertSignatureTag(emailBody, signatureCloseTag, false); // append the close tag
            } else if (!signatureOpenTagMatches && signatureCloseTagMatches) {
                // there is a signature, but no open tag; so the signature runs from BOF until close tag
                emailBody = this._insertSignatureTag(emailBody, signatureOpenTag, true); // prepend the open tag
            } else if (!signatureOpenTagMatches && !signatureCloseTagMatches) {
                // there is no signature, so add the tag to the correct location
                emailBody = this._insertSignatureTag(
                    emailBody,
                    signatureOpenTag + signatureCloseTag, // insert both tags as one
                    (app.user.getPreference("signature_prepend") == "true"));
            }

            this.model.set("html_body", emailBody.replace(regex, "$1" + signatureContent + "$2"));

            return true;
        }

        return false;
    },

    /**
     * Inserts a tag into the editor to surround the signature so the signature can be identified again.
     *
     * @param body
     * @param tag
     * @param prepend
     * @return {String}
     * @private
     */
    _insertSignatureTag: function(body, tag, prepend) {
        var preSignature  = "",
            postSignature = "";

        prepend = prepend || false;

        if (prepend) {
            var bodyOpenTag    = "<body>",
                bodyOpenTagLoc = body.indexOf(bodyOpenTag);

            if (bodyOpenTagLoc > -1) {
                preSignature  = body.substr(0, bodyOpenTagLoc + bodyOpenTag.length);
                postSignature = body.substr(bodyOpenTagLoc + bodyOpenTag.length, body.length);
            } else {
                postSignature = body;
            }
        } else {
            var bodyCloseTag    = "</body>",
                bodyCloseTagLoc = body.indexOf(bodyCloseTag);

            if (bodyCloseTagLoc > -1) {
                preSignature  = body.substr(0, bodyCloseTagLoc);
                postSignature = body.substr(bodyCloseTagLoc, body.length);
            } else {
                preSignature = body;
            }
        }

        return preSignature + tag + postSignature;
    },

    /**
     * Formats HTML signatures to replace select HTML-entities with their true characters.
     *
     * @param signature
     */
    _formatSignature: function(signature) {
        signature = signature.replace(/&lt;/gi, "<");
        signature = signature.replace(/&gt;/gi, ">");

        return signature;
    },

    /**
     * Show a generic alert for server errors resulting from custom API calls during Email Compose workflows. Logs
     * the error message for system administrators as well.
     *
     * @param error
     * @private
     */
    _showServerError: function(error) {
        app.alert.show("server-error", {
            level: "error",
            messages: "ERR_GENERIC_SERVER_ERROR",
            autoClose: false
        });
        app.error.handleHttpError(error);
    },

    /**
     * When toggling to show/hide hidden panel, resize editor accordingly
     */
    handleMoreLessToggled: function() {
        this.resizeEditor();
    },

    /**
     * When TinyMCE has been completely initialized, go ahead and resize the editor
     */
    handleTinyMceInit: function() {
        this.resizeEditor();
    },

    _dispose: function() {
        if (app.drawer) {
            app.drawer.off(null, null, this);
        }
        app.view.invokeParent(this, {type: 'view', name: 'record', method: '_dispose'});
    },

    /**
     * Resize the html editor based on height of the drawer it is in
     *
     * @param drawerHeight current height of the drawer or height the drawer will be after animations
     */
    resizeEditor: function(drawerHeight) {
        var $editor, headerHeight, recordHeight, showHideHeight, diffHeight, editorHeight, newEditorHeight;

        $editor = this.$('.mceLayout .mceIframeContainer iframe');
        //if editor not already rendered, cannot resize
        if ($editor.length === 0) {
            return;
        }

        drawerHeight = drawerHeight || app.drawer.getHeight();
        headerHeight = this.$('.headerpane').outerHeight(true);
        recordHeight = this.$('.record').outerHeight(true);
        showHideHeight = this.$('.show-hide-toggle').outerHeight(true);
        editorHeight = $editor.height();

        //calculate the space left to fill - subtracting padding to prevent scrollbar
        diffHeight = drawerHeight - headerHeight - recordHeight - showHideHeight - this.EDITOR_RESIZE_PADDING;

        //add the space left to fill to the current height of the editor to get a new height
        newEditorHeight = editorHeight + diffHeight;

        //maintain min height
        if (newEditorHeight < this.MIN_EDITOR_HEIGHT) {
            newEditorHeight = this.MIN_EDITOR_HEIGHT;
        }

        //set the new height for the editor
        $editor.height(newEditorHeight);
    }
})
