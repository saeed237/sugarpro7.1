/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
({
    events: {
        'click .addPost': 'addPost',
        'keyup .sayit': '_handleContentChange',
        'change div[data-placeholder]': '_handleContentChange',
        'input div[data-placeholder]': '_handleContentChange'
    },

    className: "omnibar",

    plugins: ['DragdropAttachments', 'QuickSearchFilter', 'Taggable', 'Tooltip'],

    initialize: function(options) {
        // regular expression to find all non-breaking spaces
        this.nbspRegExp = new RegExp(String.fromCharCode(160), 'g');

        app.view.View.prototype.initialize.call(this, options);

        // Assets for the activity stream post avatar
        this.user_id = app.user.get('id');
        this.full_name = app.user.get('full_name');
        this.picture_url = app.user.get('picture') ? app.api.buildFileURL({
            module: 'Users',
            id: this.user_id,
            field: 'picture'
        }) : '';

        this.toggleSubmitButton = _.debounce(this.toggleSubmitButton, 200);
        this.on('attachments:add attachments:remove', this.toggleSubmitButton, this);
    },

    /**
     * Initialize Taggable plugin so that it knows which record the tags are
     * associated with.
     */
    bindDataChange: function() {
        if (this.context.parent) {
            this.context.parent.on('change', function(context) {
                var moduleName = context.get('module'),
                    modelId = context.get('model').get('id');

                this.setTaggableRecord(moduleName, modelId);
            }, this);
        }
        app.view.View.prototype.bindDataChange.call(this);
    },

    /**
     * Remove events added in bindDataChange().
     */
    unbindData: function() {
        if (this.context.parent) {
            this.context.parent.off(null, null, this);
        }
        app.view.View.prototype.unbindData.call(this);
    },

    /**
     * Creates a new post.
     */
    addPost: function() {
        var self = this,
            parentId = this.context.parent.get("model").id,
            parentType = this.context.parent.get("model").module,
            attachments = this.$('.activitystream-pending-attachment'),
            $submitButton = this.$('button.addPost'),
            payload = {
                activity_type: "post",
                parent_id: parentId || null,
                parent_type: parentType !== "Activities" ? parentType : null,
                data: {}
            },
            bean;

        if (!$submitButton.hasClass('disabled')) {
            payload.data = this.getPost();

            if (payload.data.value && (payload.data.value.length > 0)) {
                $submitButton.addClass('disabled');
                bean = app.data.createBean('Activities');
                bean.save(payload, {
                    success: function(model) {
                        self.$('div.sayit')
                            .empty()
                            .trigger('change')
                            .focus();

                        model.set('picture', app.user.get('picture'));
                        self.collection.add(model);
                        self.context.trigger('activitystream:post:prepend', model);
                    },
                    complete: function() {
                        $submitButton.removeClass('disabled');
                    },
                    showAlerts: true
                });
            }

            this.trigger("attachments:process");
        }
    },

    /**
     * Retrieve the post entered inside content editable and translate any tags into text format
     * so that it can be saved in the database as JSON string.
     *
     * @returns {String}
     */
    getPost: function() {
        var post = this.unformatTags(this.$('div.sayit'));

        // Need to replace all non-breaking spaces with a regular space because the EmbedLinkService.php
        // treats spaces and non-breaking spaces differently. Having non-breaking spaces causes to parse
        // URLs incorrectly.
        post.value = post.value.replace(this.nbspRegExp, ' ');

        return post;
    },

    /**
     * Check to see if the Submit button should be disabled/enabled.
     */
    toggleSubmitButton: function() {
        var post = this.getPost(),
            attachments = this.getAttachments();

        if ((post.value.length === 0) && (_.size(attachments) === 0)) {
            this.$('.addPost').addClass('disabled');
        } else {
            this.$('.addPost').removeClass('disabled');
        }
    },

    /**
     * Show or hide the placeholder and toggle the submit button in response to
     * a content change in the input field.
     *
     * @param e
     * @private
     */
    _handleContentChange: function(e) {
        // We can't use any of the jQuery methods or use the dataset property to
        // set this attribute because they don't seem to work in IE 10. Dataset
        // isn't supported in IE 10 at all.
        var el = e.currentTarget;
        if (el.textContent) {
            el.setAttribute('data-hide-placeholder', 'true');
        } else {
            el.removeAttribute('data-hide-placeholder');
        }
        this.toggleSubmitButton();
    }
})
