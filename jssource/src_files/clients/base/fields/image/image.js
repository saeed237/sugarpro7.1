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
    /**
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    events: {
        "click .delete": "delete",
        "change input[type=file]": "selectImage"
    },

    plugins: ['File'],

    /**
     * @override
     */
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);

        if (!this.model.hasImageRequiredValidator) {
            this.model.hasImageRequiredValidator = true;
            this.model.addValidationTask('image_required', _.bind(this._doValidateImageField, this));
        }
    },

    /**
     * @override
     * @private
     */
    _dispose: function() {
        //Remove specific validation task from the model
        this.model.hasImageRequiredValidator = false;
        this.model._validationTasks = _.omit(this.model._validationTasks, 'image_required');
        app.view.Field.prototype._dispose.call(this);
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this.model.fileField = this.name;
        app.view.Field.prototype._render.call(this);

        //Define default sizes
        if (this.tplName === 'list') {
            this.width = this.height = this.$el.parent().innerHeight() || 42;
            this.def.width = this.def.height = undefined;
        } else {
            this.width = parseInt(this.def.width || this.def.height, 10) || 50;
            this.height = parseInt(this.def.height, 10) || this.width;
        }
        //Resize widget before the image is loaded
        this.resizeWidth(this.width);
        this.resizeHeight(this.height);
        this.$('.image_field').removeClass('hide');
        //Resize widget once the image is loaded
        this.$('img').addClass('hide').on('load', $.proxy(this.resizeWidget, this));
        return this;
    },

    /**
     * @override
     * @param value
     * @returns value
     */
    format: function(value) {
        if (value) {
            value = this.buildUrl() + "&_hash=" + value;
        }
        return value;
    },

    /**
     * @override
     */
    bindDataChange: function() {
        //Keep empty for edit because you cannot set a value of an input type `file`
        var viewType = this.view.name || this.options.viewName;
        var ignoreViewType = ["edit", "create", "create-actions"];
        if (_.indexOf(ignoreViewType, viewType) < 0 && this.view.action !== "edit") {
            app.view.Field.prototype.bindDataChange.call(this);
        }
    },

    /**
     * @override
     */
    bindDomChange: function() {
        //Override default behavior
    },

    /**
     * This is the custom implementation of bindDomChange. Here we upload the image to give a preview to the user.
     * @param e
     */
    selectImage: function(e) {
        var self = this,
            $input = self.$('input[type=file]');

        //Set flag to indicate we are previewing an image
        self.preview = true;

        //Remove error message
        self.clearErrorDecoration();

        // Upload a temporary file for preview
        self.model.uploadFile(
            self.name,
            $input,
            {
                field: self.name,
                //Callbacks
                success: function(rsp) {
                    //read the guid
                    var fileId = (rsp[self.name]) ? rsp[self.name]['guid'] : null;
                    var url = app.api.buildFileURL({
                        module: self.module,
                        id: 'temp',
                        field: self.name,
                        fileId: fileId
                    });
                    // show image
                    var image = $('<img>').addClass('hide').attr('src', url).on('load', $.proxy(self.resizeWidget, self));
                    self.$('.image_preview').html(image);

                    //Trigger a change event with param "image" so the view can detect that the dom changed.
                    self.model.trigger("change", "image");
                },
                error: function(error) {
                    var fieldError = {},
                        errors = {};
                    fieldError[error.responseText] = {};
                    errors[self.name] = fieldError;
                    self.model.trigger('error:validation:' + this.field, fieldError);
                    self.model.trigger('error:validation', errors);
                }
            },
            { temp: true }); //for File API to understand we upload a temporary file
    },

    /**
     * Calls when deleting the image or canceling the preview
     * @param e
     */
    'delete': function(e) {
        var self = this;
        //If we are previewing a file and want to cancel
        if (this.preview === true) {
            self.preview = false;
            self.clearErrorDecoration();
            self.render();
        } else {
            var confirmMessage = app.lang.get('LBL_IMAGE_DELETE_CONFIRM', self.module);
            if (confirm(confirmMessage)) {
                //Otherwise delete the image
                app.api.call('delete', self.buildUrl({htmlJsonFormat: false}), {}, {
                        success: function() {
                            //Need to fire the change event twice so model.previous(self.name) is also changed.
                            self.model.unset(self.name);
                            self.model.set(self.name, null);
                            if (!self.disposed) self.render();
                        },
                        error: function(data) {
                            // refresh token if it has expired
                            app.error.handleHttpError(data, {});
                        }}
                );
            }
        }
    },

    /**
     * Build URI for File API
     * @param options
     */
    buildUrl: function(options) {
        return app.api.buildFileURL({
            module: this.module,
            id: this.model.id,
            field: this.name
        }, options);
    },

    /**
     * Resize widget based on field defs and image size
     */
    resizeWidget: function() {
        var image = this.$('.image_preview img, .image_detail img');

        if (!image[0]) return;

        var isDefHeight = !_.isUndefined(this.def.height) && this.def.height > 0,
            isDefWidth = !_.isUndefined(this.def.width) && this.def.width > 0;

        //set width/height defined in field defs
        if (isDefWidth) {
            image.css('width', this.width);
        }
        if (isDefHeight) {
            image.css('height', this.height);
        }

        if (!isDefHeight && !isDefWidth)
            image.css({
                'height': this.height,
                'width': this.width
            });

        //now resize widget
        //we resize the widget based on current image height
        this.resizeHeight(image.height());
        //if height was defined but not width, we want to resize image width to keep
        //proportionality: this.height/naturalHeight = newWidth/naturalWidth
        if (isDefHeight && !isDefWidth) {
            var newWidth = Math.floor((this.height / image[0].naturalHeight) * image[0].naturalWidth);
            image.css('width', newWidth);
            this.resizeWidth(newWidth);
        }

        image.removeClass('hide');
        this.$('.delete').remove();
        var icon = this.preview === true ? 'remove' : 'trash';
        image.closest('label, a').after('<span class="image_btn delete icon-' + icon + ' " />');
    },

    /**
     * Utility function to append px to an integer
     *
     * @param size
     * @returns {string}
     */
    formatPX: function(size) {
        size = parseInt(size, 10);
        return size + 'px';
    },

    /**
     * Resize the elements carefully to render a pretty input[type=file]
     * @param height (in pixels)
     */
    resizeHeight: function(height) {
        var $image_field = this.$('.image_field'),
            isEditAndIcon = this.$('.icon-plus').length > 0;

        if (isEditAndIcon) {
            var $image_btn = $image_field.find('.image_btn');
            var edit_btn_height = parseInt($image_btn.css('height'), 10);

            var previewHeight = parseInt(height, 10);
            //Remove the edit button height in edit view so that the icon is centered.
            previewHeight -= edit_btn_height ? edit_btn_height : 0;
            previewHeight = this.formatPX(previewHeight);

            $image_field.find('.icon-plus').css({lineHeight: previewHeight});
        }


        var totalHeight = this.formatPX(height);
        $image_field.css({'height': totalHeight, minHeight: totalHeight, lineHeight: totalHeight});
        $image_field.find('label').css({lineHeight: totalHeight});
    },

    /**
     * Resize the elements carefully to render a pretty input[type=file]
     * @param width (in pixels)
     */
    resizeWidth: function(width) {
        var $image_field = this.$('.image_field'),
            width = this.formatPX(width),
            isInHeaderpane = $(this.el).closest('.headerpane').length > 0,
            isInRowFluid = $(this.el).closest('.row-fluid').closest('.record').length > 0;

        if (isInHeaderpane || !isInRowFluid) {
            //Need to fix width
            $image_field.css({'width': width});
        } else {
            //Width will be the biggest possible
            $image_field.css({'maxWidth': width});
        }
    },

    /****
     * Custom requiredValidator for image field because we need to check if the input inside the view is empty or not.
     *
     + @param {Object} fields Hash of field definitions to validate.
     + @param {Object} errors Error validation errors
     + @param {Function} callback Async.js waterfall callback
     */
    _doValidateImageField: function(fields, errors, callback) {
        var $input = this.$('input[type=file]');
        if (this.def.required && (_.isEmpty($input) || _.isEmpty($input.val()))) {
            errors[this.name] = errors[this.name] || {};
            errors[this.name].required = true;
        }
        callback(null, fields, errors);
    },

    /**
     * Handles errors message
     *
     * @override
     * @param errors
     */
    handleValidationError: function(errors) {
        var errorMessages = [],
            $tooltip;

        if (this.action === 'detail') {
            this.setMode('edit');
        }

        //Change the preview of the image widget
        this.$('.image_preview').html('<i class="icon-remove"></i>');
        //Put the cancel icon
        this.$('label').after('<span class="image_btn delete icon-remove" />');

        this.$el.closest('.record-cell').addClass("error");
        this.$el.addClass('input-append error');

        _.each(errors, function(errorContext, errorName) {
            errorMessages.push(app.error.getErrorString(errorName, errorContext));
        });
        this.$('.image_field').append(this.exclamationMarkTemplate(errorMessages));
        $tooltip = this.$('.error-tooltip');
        if (_.isFunction($tooltip.tooltip)) {
            var tooltipOpts = { container: 'body', placement: 'right', trigger: 'click' };
            $tooltip.tooltip(tooltipOpts);
        }
    },

    /**
     * @override
     */
    clearErrorDecoration: function() {
        //Remove the current icon
        this.$('.delete').remove();
        //Remove error message
        this.$('.error-tooltip').remove();
        this.$el.closest('.record-cell').removeClass('error');
        this.$el.removeClass('input-append error');
    }
})
