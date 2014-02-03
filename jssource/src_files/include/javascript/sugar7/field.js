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

(function (app) {

    /**
     * Field widgets to use Required labels with because they don't use select or input fields
     * @private
     */
    var _useRequiredLabels = {
        /**
         * It's nonsensical to make a bool field required since it is always has a value (TRUE or FALSE),
         * but it's possible to define it as required in vardefs.
         */
        "bool": true,
        /**
         * Only really needed on edit template where we use radio buttons.
         * For list-edit template, we don't use radio buttons but select2 widget.
         */
        "radioenum": 'edit'
    };

    app.events.on("app:init", function () {

        var _fieldProto = _.clone(app.view.Field.prototype);
        _.extend(app.view.Field.prototype, {

            /**
             * Template for the exclamation mark icon added when decorating errors
             */
            exclamationMarkTemplate: Handlebars.compile(
                '<span class="error-tooltip add-on" data-container="body" rel="tooltip" title="{{arrayJoin this ", "}}"><i class="icon-exclamation-sign"></i></span>'
            ),

            /**
             * Handle validation errors
             * Set to edit mode and decorates the field
             * @param {Object} errors The validation error(s) affecting this field
             */
            handleValidationError: function (errors) {
                this.clearErrorDecoration();
                _.defer(function (field) {
                    field._errors = errors;
                    field.setMode('edit');
                    // As we're now "post form submission", if `no_required_placeholder`, we need to
                    // manually decorateRequired (as we only omit required on form's initial render)
                    if (!field._shouldRenderRequiredPlaceholder()) {
                        field.decorateRequired();
                    }
                    field.decorateError(errors);
                }, this);

                this.$el.off("keydown.record");
                $(document).off("mousedown.record" + this.name);
            },

            /**
             * Remove the old view's css class (e.g. detail, edit)
             * currently maps the action directly to the css class name
             * but may be overridden in the future.
             *
             * @param {String} action the name of the action to remove
             * @protected
             */
            _removeViewClass: function (action) {
                // in case our getFieldElement has been overridden, use this.$el directly
                this.$el.removeClass(action);
            },

            /**
             * Add the new view's css class (e.g. detail, edit)
             * currently maps the action directly to the css class name
             * but may be overridden in the future.
             *
             * @param {String} action the name of the action to remove
             * @protected
             */
            _addViewClass: function (action) {
                // in case our getFieldElement has been overridden, use this.$el directly
                this.$el.addClass(action);
            },

            /**
             * Returns true if it's readonly and has no data.
             *
             * Override this function for special logic or property to
             * determine nodata property.
             *
             * You can also specify that a certain field doesn't support
             * `showNoData` or always return either `true` or `false`.
             * Example for controller with `showNoData` always set to false:
             * <pre><code>
             * ({
             *     showNoData: false,
             *     // ...
             *     initialize: function(options) {
             *     // ...
             * })
             * </code></pre>
             *
             * @return {Boolean} `true` if it is readonly and it has no data
             * otherwise `false`.
             */
            showNoData: function() {
                return this.def.readonly && this.name && !this.model.has(this.name);
            },

            /**
             * {@inheritDoc}
             * Checks fallback actions first and then follows ACLs checking
             * after that.
             *
             * First, check whether the action belongs to the fallback actions
             * and no more chaining fallback map.
             * Second, the field should fallback to 'nodata' if current field
             * requires to display nodata.
             * Finally, checks ACLs to see if the current user has access to
             * action.
             *
             * @param {String} action name.
             * @return {Boolean} true if accessable otherwise false.
             */
            _checkAccessToAction: function(action) {

                if (_.contains(this.fallbackActions, action) && _.isUndefined(this.viewFallbackMap[action])) {
                    return true;
                }

                if (_.result(this, 'showNoData') === true) {
                    return action === 'nodata';
                }

                return app.acl.hasAccessToModel(action, this.model, this.name);
            },

            /**
             * Defines fallback rules for ACL checking.
             */
            viewFallbackMap: {
                'list': 'detail',
                'edit': 'detail',
                'detail': 'noaccess',
                'noaccess' : 'nodata'
            },
            /**
             * List of view names that directly fallback to base template
             * instead of 'detail'.
             */
            fallbackActions: [
                'noaccess', 'nodata'
            ],

            /**
             * {@inheritdoc}
             */
            _getFallbackTemplate: function(viewName) {
                if (_.contains(this.fallbackActions, viewName)) {
                    return viewName;
                }
                return (this.isDisabled() && viewName === 'disabled') ? 'edit' :
                    (this.view.fallbackFieldTemplate || 'detail');
            },
            /**
             * Override _render to redecorate fields if field is on error state
             * and to add view action CSS class.
             */
            _render: function () {
                // Tooltips are appended to body and when the field rerenders we lose control of shown tooltips.
                var $tooltip = this.$('.error-tooltip');
                if (_.isFunction($tooltip.tooltip)) {
                    $tooltip.tooltip('destroy');
                }

                var isErrorState = this.$('.add-on.error-tooltip').length > 0;

                _fieldProto._render.call(this);

                // handle rendering the action class if disabled
                if (this._previousAction) {
                    this._addViewClass(this._previousAction);
                }
                this._addViewClass(this.action);
                if (isErrorState) {
                    this.decorateError(this._errors);
                }
                if (this.def.required) {
                    this.clearRequiredLabel();
                    if ((this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName)) && this._shouldRenderRequiredPlaceholder()) {
                        this.decorateRequired();
                    }
                }
                if (this.def.help) {
                    this.clearHelper();
                    if (this.action === 'edit' || -1 !== _.indexOf(['edit', 'list-edit'], this.tplName)) {
                        this.decorateHelper();
                    }
                }
            },

            /**
             * Remove helper tooltip
             */
            clearHelper: function() {
                this.$el.closest('.record-cell').attr({
                    'rel': ''
                });
            },
            /**
             * Default implementation for field helper
             */
            decorateHelper: function() {
                this.$el.closest('.record-cell').attr({
                    'rel': 'tooltip',
                    'data-title': this.def['help'],
                    'data-placement': 'bottom'
                });
            },
            /**
             * Helper to determine if we should call decorateRequired. Primarily for pages like Login
             * where we don't want to have (Required) in the placeholder on initial render. This gets
             * called on `this._render`. Since we DO want required in placeholder "post submission" we
             * check this again in `this.handleValidationError` and manually add back (Required) if set.
             *
             * @return {Boolean} Whether we should attempt to render required placeholder or not
             */
            _shouldRenderRequiredPlaceholder: function () {
                return !this.def.no_required_placeholder;
            },

            /**
             * Default implementation of Required decoration
             */
            decorateRequired: function () {
                var useLabels = _useRequiredLabels[this.type];
                useLabels = _.isString(useLabels) ? (useLabels === this.tplName) : useLabels;
                if (useLabels) {
                    this.setRequiredLabel();
                } else {
                    // Most fields use Placeholder
                    this.setRequiredPlaceholder();
                }

            },

            /**
             * Add Required placeholder for input, select kinds of fields
             * @param element (Optional) element to attach placeholder
             */
            setRequiredPlaceholder: function (element) {
                var el = element || this.$(this.fieldTag).first();
                var old = el.attr("placeholder");
                var requiredPlaceholder = app.lang.get("LBL_REQUIRED_FIELD", this.module);
                var newPlaceholder = requiredPlaceholder;
                if (old) {
                    // If there is an existing placeholder then add required label after it
                    newPlaceholder = old + " (" + requiredPlaceholder + ")";
                }
                el.attr("placeholder", newPlaceholder).addClass("required");
            },

            /**
             * Add Required label to field's label for fields that don't support placeholders
             * @param element (Optional) any element that is enclosed by field's record-cell
             */
            setRequiredLabel: function (element) {
                var ele = element || this.$el;
                var $label = ele.closest('.record-cell').find(".record-label");
                $label.append(' <span data-required="required">(' + app.lang.get("LBL_REQUIRED_FIELD", this.module) + ')</span>');
            },

            /**
             * Remove default Required label from field labels
             * @param element (Optional) any element that is enclosed by field's record-cell
             */
            clearRequiredLabel: function (element) {
                var ele = element || this.$el;
                var $label = ele.closest('.record-cell').find('span[data-required]');
                $label.remove();
            },

            /**
             * {@inheritdoc}
             *
             * Override setMode to remove any stale view action CSS classes.
             * @override
             */
            setMode: function (name) {
                // if we are disabled, we want to remove the previous view action, not the disabled class
                var oldAction = this._previousAction || this.action;
                this._removeViewClass(oldAction);

                _fieldProto.setMode.call(this, name);
            },

            /**
             * {@inheritdoc}
             *
             * Override setMode to remove the stale disabled CSS class.
             * @override
             */
            setDisabled: function (disable) {

                if (!this._checkAccessToAction('disabled')) {
                    return;
                }

                disable = _.isUndefined(disable) ? true : disable;

                // remove the stale disabled CSS class (this.action === 'disabled')
                if (disable === false && this.isDisabled()) {
                    this._removeViewClass(this.action);
                }
                _fieldProto.setDisabled.call(this, disable);
            },
            /**
             * Decorate error gets called when this Field has a validation error.  This function applies custom error
             * styling appropriate for this field.
             * The field is put into 'edit' mode prior to this this being called.
             *
             * Fields should override/implement this when they need to provide custom error styling for different field
             * types (like e-mail, etc).  You can also override clearErrorDecoration.
             *
             * @param {Object} errors The validation error(s) affecting this field
             */
            decorateError: function (errors) {
                var ftag = this.fieldTag || '',
                    $ftag = this.$(ftag),
                    errorMessages = [],
                    $tooltip;

                // Add error styling
                this.$el.closest('.record-cell').addClass('error');
                this.$el.addClass('error');
                if(_.isString(errors)){
                    // A custom validation error was triggered for this field
                    errorMessages.push(errors);
                } else {
                    // For each error add to error help block
                    _.each(errors, function (errorContext, errorName) {
                        errorMessages.push(app.error.getErrorString(errorName, errorContext));
                    });
                }
                $ftag.wrap('<div class="input-append error ' + ftag + '">');
                $tooltip = this.exclamationMarkTemplate(errorMessages);
                $ftag.after($tooltip);
                if (_.isFunction($tooltip.tooltip)) {
                    var tooltipOpts = {placement: 'top', trigger: 'click' };
                    $tooltip.tooltip(tooltipOpts);
                }
                // Select2 sometimes has hidden fields, this prevents errors for said fields from showing on screen
                $ftag.each(function() {
                    if($(this).hasClass("select2-offscreen")) {
                        $(this).parent("div.input-append.error").addClass("select2-offscreen");
                    }
                });

            },

            /**
             * Remove error decoration from field if it exists.
             */
            clearErrorDecoration: function () {
                var ftag = this.fieldTag || '',
                    $ftag = this.$(ftag);
                // Remove previous exclamation then add back.
                this.$('.add-on').remove();
                var isWrapped = $ftag.parent().hasClass('input-append');
                if (isWrapped) {
                    $ftag.unwrap();
                }
                this.$el.removeClass(ftag);
                this.$el.removeClass("error");
                this.$el.closest('.record-cell').removeClass("error");
            },

            /**
             * Adding additional events for links with bad `href` attribute
             * @param {Array} events Events for the field
             */
            delegateEvents: function(events) {
                events = events || this.events || (this.def ? this.def.events : null);
                if (!events) {
                    return;
                }
                events['click a[href="javascript:void(0)"]'] = '_handleBadLinkHref';
                events['click a[href="javascript:void(0);"]'] = '_handleBadLinkHref';
                _fieldProto.delegateEvents.call(this, events);
            },

            /**
             * Handle click event for bad links
             * @param {Object} evt Click event
             * @private
             */
            _handleBadLinkHref: function(evt) {
                evt.preventDefault();
            }
        });
    });

})(SUGAR.App);
