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
    fields: null,

    /**
     * Initializes the fieldset field component.
     *
     * Initializes the fields property.
     *
     * @param {Object} options
     *
     * @see app.view.Field.initialize
     */
    initialize: function (options) {
        app.view.Field.prototype.initialize.call(this, options);

        this.fields = [];
    },

    /**
     * {@inheritdoc}
     */
    getPlaceholder: function () {

        var placeholder = '<span sfuuid="' + this.sfId + '">';
        _.each(this.def.fields, function (fieldDef) {
            if (this.def.readonly) {
                fieldDef.readonly = true;
            }
            var field = app.view.createField({
                def: fieldDef,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            field.parent = this;
            placeholder += field.getPlaceholder();
        }, this);
        placeholder += '</span>';

        return new Handlebars.SafeString(placeholder);
    },

    /**
     * {@inheritDoc}
     *
     * If current fieldset is not readonly, it always falls back to false
     * (nodata unsupportable).
     * If current fieldset is readonly and all dependant fields contains empty
     * data set, then it falls back to true.
     *
     * @return {Boolean} true if this fieldset is readonly and all the data
     * fields are empty.
     */
    showNoData: function() {

        if (!this.def.readonly) {
            return false;
        }

        return !_.some(this.fields, function(field) {
            return field.name && field.model.has(field.name);
        });
    },

    /**
     * {@inheritDoc}
     *
     * We only render the child fields for this fieldset and for now there is
     * no support for templates on fieldset widgets except nodata.
     * If fieldset is in fallbackactions, DOM will be replaced with fallback
     * template.
     */
    _render: function() {
        this._loadTemplate();

        //If fieldset is in fallbackactions, dom will be replaced with fallback template
        if (_.contains(this.fallbackActions, this.action)) {
            this.$el.html(this.template(this) || '');
        }

        // Adds classes to the component based on the metadata.
        if (this.def && this.def.css_class) {
            this.getFieldElement().addClass(this.def.css_class);
        }
        this.focusIndex = 0;

        this._addViewClass(this.action);

        return this;
    },
    focus: function () {
        // this should be zero but lets make sure
        if (this.focusIndex < 0 || !this.focusIndex) {
            this.focusIndex = 0;
        }

        if (this.focusIndex >= this.fields.length) {
            // done focusing our inputs return false
            this.focusIndex = -1;
            return false;
        } else {
            // this field is disabled skip ahead
            if (this.fields[this.focusIndex] && this.fields[this.focusIndex].isDisabled()) {
                this.focusIndex++;
                return this.focus();
            }
            // if the next field returns true its not done focusing so don't
            // increment to the next field
            if (_.isFunction(this.fields[this.focusIndex].focus) && this.fields[this.focusIndex].focus()) {
            } else {
                var field = this.fields[this.focusIndex];
                var $el = field.$(field.fieldTag + ":first");
                $el.focus().val($el.val());
                this.focusIndex++;
            }
            return true;
        }
    },
    setDisabled: function (disable) {
        disable = _.isUndefined(disable) ? true : disable;
        app.view.Field.prototype.setDisabled.call(this, disable);
        _.each(this.fields, function (field) {
            field.setDisabled(disable);
        }, this);
    },

    setViewName: function (view) {
        app.view.Field.prototype.setViewName.call(this, view);
        _.each(this.fields, function (field) {
            field.setViewName(view);
        }, this);
    },

    /**
     * {@inheritDoc}
     *
     * Set action name of child fields of this field set.
     * Reset current focus index to the first item when it switches to different mode.
     * @override
     */
    setMode: function(name) {
        this.focusIndex = 0;
        app.view.Field.prototype.setMode.call(this, name);
        _.each(this.fields, function(field) {
            field.setMode(name);
        }, this);
    },

    /**
     * {@inheritdoc}
     *
     * We need this empty so it won't affect the nested fields that have the
     * same `fieldTag` of this fieldset due the usage of `find()` method.
     */
    bindDomChange: function () {
    },

    /**
     * {@inheritdoc}
     *
     * Keep empty because you cannot set a value of a type `fieldset`.
     */
    bindDataChange: function () {
    },

    /**
     * {@inheritdoc}
     *
     * We need this empty so it won't affect the nested fields that have the
     * same `fieldTag` of this fieldset due the usage of `find()` method.
     */
    unbindDom: function() {
    },

    _dispose: function() {
        //fields inside fieldset need to be disposed before the fielset itself is disposed.
        _.each(this.fields, function(field) {
            field.parent = null;
            field.dispose();
        });
        this.fields = null;
        app.view.Field.prototype._dispose.call(this);
    }
})
