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
    fieldSelector: '.attachments',
    fileInputSelector: '.fileinput',
    $node: null,
    fileCounter: 0,

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        var launchUploadEvent = options.def.uploadEvent || 'attachment:upload';

        this.events = _.extend({}, this.events, options.def.events, {
            'change .fileinput': 'uploadFile'
        });
        app.view.Field.prototype.initialize.call(this, options);

        this.context.on('attachment:add', this.addAttachment, this);
        this.context.on(launchUploadEvent, this.launchFilePicker, this);
        this.context.on('attachment:upload:remove', this.removeUploadedAttachment, this);
        this.context.on('attachments:remove-by-tag', this.removeAttachmentsByTag, this);
        this.context.on('attachments:remove-by-id', this.removeAttachmentsById, this);

        this.clearUserAttachmentCache();
    },

    /**
     * Allow Backspace and Delete Keys for attachments (Select2) and disable all other keys
     * @param e
     * @return {Boolean}
     * @private
     */
    _keyHandler: function(e) {
        // if key is backspace or delete ...
        if ((event.keyCode == 8 || event.keyCode == 46)) {
            return true; // Allow
        }
        return false; // Ignore Any other Keyboard Input
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        var result = app.view.Field.prototype._render.call(this);

        this.$node = this.$(this.fieldSelector);

        this.$node.select2({
            allowClear:          true,
            multiple:            true,
            containerCssClass:   'select2-choices-pills-close',
            containerCss:        {'width':'100%'},
            tags: [],
            formatSelection: this.formatSelection,
            width: 'off',
            escapeMarkup: function(m) { return m; }
        });

        var inp = this.$el.find('.attachments.select2-container .select2-choices .select2-search-field .select2-input');
        if (inp && inp[0]) {
            $(inp[0]).keypress(this._keyHandler);
            $(inp[0]).keyup(this._keyHandler);
            $(inp[0]).keydown(this._keyHandler);
        }

        //handle case where attachments are pre-populated on the model
        this.refreshFromModel();

        return result;
    },

    /**
     * Add attachment to the select2 field and update the model explicitly (because select2 does not fire change on add)
     *
     * @param attachment object containing at least guid and nameForDisplay attributes
     */
    addAttachment: function(attachment) {
        this.addAttachmentToContainer(attachment);
        this.updateModel();
    },

    /**
     * Just add the attachment to the container - useful for upload progress items
     * @param attachment
     */
    addAttachmentToContainer: function(attachment) {
        var attachments = this.getDisplayedAttachments();

        if (attachment.replaceId) {
            attachments = _.map(attachments, function(existing) {
                return (existing.id == attachment.replaceId) ? attachment : existing;
            });
            delete attachment.replaceId;
        } else {
            attachments.push(attachment);
        }

        this.setDisplayedAttachments(attachments);
    },

    /**
     * {@inheritdoc}
     * Update model if attachments are removed (change event only fires when attachment removed)
     * Prevent dropdown from opening on this field (its a container only)
     */
    bindDomChange: function() {
        this.$node = this.$(this.fieldSelector);
        this.$node.on("change", _.bind(this.handleChange, this));
        this.$node.on("opening", function(event) {
            event.preventDefault();
        });
    },

    /**
     * Before handling any attachment uploads, need to clear the user's attachment cache.
     */
    clearUserAttachmentCache: function() {
        var clearCacheUrl = app.api.buildURL('Mail/attachment', "cache");
        app.api.call('delete', clearCacheUrl);
    },

    /**
     * Format how the attachment should be displayed in the pill
     *
     * @param attachment
     * @return {String}
     */
    formatSelection: function(attachment) {
        var item = '<span data-id="'+attachment.id+'">'+attachment.nameForDisplay+'</span>';
        if (attachment.showProgress) {
            item += ' <i class="icon-refresh icon-spin"></i>';
        }
        return item;
    },

    /**
     * Get the attachments displayed in select2
     *
     * @return {array} of attachments
     */
    getDisplayedAttachments: function() {
        return this.$node.select2('data');
    },

    /**
     * Handle change event fired by select2 - this is really just remove attachment events
     * @param event
     */
    handleChange: function(event) {
        this.updateModel();

        if (event && event.removed && event.removed.type) {
            this.notifyAttachmentRemoved(event.removed);
        }
        this.notifyAttachmentsChanged();
    },

    /**
     * Fire event when attachment is removed
     * (useful for attachment types that require cleanup)
     *
     * @param attachment
     */
    notifyAttachmentRemoved: function(attachment) {
        this.context.trigger('attachment:' + attachment.type + ':remove', attachment);
    },

    /**
     * Fire event when attachments displayed has changed
     *
     * @param attachments
     */
    notifyAttachmentsChanged: function(attachments) {
        attachments = attachments || this.getDisplayedAttachments();
        this.context.trigger('attachments:updated', attachments);
    },

    /**
     * Launches the browse window where the user can choose a file to upload
     */
    launchFilePicker: function() {
        this.$(this.fileInputSelector).click();
    },

    /**
     * Refresh select2 from model
     */
    refreshFromModel: function() {
        var attachments = [];
        if (this.model.has(this.name)) {
            attachments = this.model.get(this.name);
        }
        this.setDisplayedAttachments(attachments);
    },

    /**
     * Remove attachments in list based on a given truth test iterator
     * Removes from select2 and then updates the model
     *
     * @param iterator
     */
    removeAttachmentsByIterator: function(iterator) {
        var attachments = this.getDisplayedAttachments();
        attachments = _.reject(attachments, iterator);
        this.setDisplayedAttachments(attachments);
        this.updateModel();
    },

    /**
     * Remove attachments in list based on a given guid
     *
     * @param id
     */
    removeAttachmentsById: function(id) {
        this.removeAttachmentsByIterator(_.bind(function(attachment) {
            if (attachment.id && attachment.id === id) {
                this.notifyAttachmentRemoved(attachment);
                return true;
            }
        }, this));
    },

    /**
     * Remove attachments in list based on a given tag
     *
     * @param tag
     */
    removeAttachmentsByTag: function(tag) {
        this.removeAttachmentsByIterator(_.bind(function(attachment) {
            if (attachment.tag && attachment.tag === tag) {
                this.notifyAttachmentRemoved(attachment);
                return true;
            }
        }, this));
    },

    /**
     * Remove the given attachment from the server, if there is a problem doing this, no big deal (hence no error alert)
     * @param attachment
     */
    removeUploadedAttachment: function(attachment) {
        var deleteUrl = app.api.buildURL('Mail/attachment', "delete", {id:attachment.id});
        app.api.call('delete', deleteUrl);
    },

    /**
     * Sets the attachments on select2
     */
    setDisplayedAttachments: function(attachments) {
        this.$node.select2('data', attachments);
        this.notifyAttachmentsChanged(attachments);
    },

    /**
     * Update the model from the data stored in select2
     */
    updateModel: function() {
        this.model.set(this.name, this.getDisplayedAttachments());
    },

    /**
     * Upload the file and define callbacks for success & failure
     */
    uploadFile: function() {
        var $fileInput = this.$(this.fileInputSelector),
            ajaxParams = {
                files: $fileInput,
                iframe: true
            },
            fileId;

        //don't do anything if user cancels out of picking a file
        if (_.isEmpty(this.getFileInputVal())) {
            return;
        }

        //Notify user of progress uploading by adding a placeholder pill
        this.fileCounter++;
        fileId = 'upload'+this.fileCounter;
        this.addAttachmentToContainer({
            id: fileId,
            nameForDisplay: this.getFileInputVal().split('\\').pop(),
            showProgress: true
        });

        var myURL = app.api.buildURL('Mail/attachment', null, null, {oauth_token:app.api.getOAuthToken()});
        app.api.call('create', myURL, null,{
                success: _.bind(function (result) {
                    if (this.disposed === true) return; //if field is already disposed, bail out
                    if (!result.guid) {
                        this.handleUploadError(fileId);
                        app.logger.error('Attachment Upload Failed - no guid returned from API');
                        return;
                    }

                    //add attachment to container, replacing placeholder pill from above
                    result.id = result.guid;
                    delete result.guid;
                    result.type = 'upload';
                    result.replaceId = fileId;
                    this.context.trigger('attachment:add', result);

                    //clear out the file input so we can detect the next change, even if it is the same file
                    $fileInput.val(null);
                }, this),

                error: _.bind(function(e) {
                    if (this.disposed === true) return; //if field is already disposed, bail out
                    this.handleUploadError(fileId);
                    app.logger.error('Attachment Upload Failed: ' + e);
                }, this)
            },
            ajaxParams
        );
    },

    /**
     * Retrieve the val from the file input element (return null if not there)
     */
    getFileInputVal: function($fileInput) {
        $fileInput = $fileInput || this.$(this.fileInputSelector);
        if (_.isUndefined($fileInput)) {
            return null;
        }
        return $fileInput.val();
    },

    /**
     * When upload fails, display an error alert and remove the placeholder pill
     * @param fileId
     */
    handleUploadError: function(fileId) {
        var errorMessage = app.lang.getAppString('LBL_EMAIL_ATTACHMENT_UPLOAD_FAILED');
        this.context.trigger('attachments:remove-by-id', fileId);
        app.alert.show('upload_error', errorMessage);
    },

    /**
     * Turn off re-rendering of field when model changes - let select2 handle how the field looks
     */
    bindDataChange:$.noop,

    _dispose: function() {
        this.$node.select2('destroy');
        app.view.Field.prototype._dispose.call(this);
    }
})
