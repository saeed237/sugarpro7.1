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
    extendsFrom: 'FieldsetField',

    /**
     * {@inheritdoc}
     */
    _render: function() {
        if (_.isEmpty(this.fields)) {
            this._createFields();
            this._renderNewFields();
        } else {
            this._renderExistingFields();
        }

        // Adds classes to the component based on the metadata.
        if(this.def && this.def.css_class) {
            this.getFieldElement().addClass(this.def.css_class);
        }

        return this;
    },

    /**
     * Load fieldset template and create fields
     * @private
     */
    _createFields: function() {
        this._loadTemplate();
        this.$el.html(this.template(this));
    },

    /**
     * Render fields that have not been rendered previously
     * @private
     */
    _renderNewFields: function() {
        _.each(this.def.fields, function(fieldDef) {
            var field = this.view.getField(fieldDef.name);
            this.fields.push(field);
            field.setElement(this.$("span[sfuuid='" + field.sfId + "']"));
            field.render();
        }, this);
    },

    /**
     * Re-render fields
     * @private
     */
    _renderExistingFields: function() {
        _.each(this.fields, function(field) {
            field.render();
        }, this);
    },

    /**
     * {@inheritdoc}
     */
    getPlaceholder: function() {
        return app.view.Field.prototype.getPlaceholder.call(this);
    },

    /**
     * {@inheritdoc}
     */
    setMode: function(name) {
        this.tplName = name;
        app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: 'setMode', args:[name]});
    }
})
