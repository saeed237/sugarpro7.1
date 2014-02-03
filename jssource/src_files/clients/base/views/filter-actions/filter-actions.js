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
    /**
     * Actions for BaseFilterRowsViews
     * Part of BaseFilterpanelLayout
     *
     * @class BaseFilterActionsView
     * @extends View
     */
    events: {
        "change input": "filterNameChanged",
        "keyup input": "filterNameChanged",
        "click a.filter-close": "triggerClose",
        "click a.save_button:not(.disabled)": "triggerSave",
        "click a.delete_button:not(.hide)": "triggerDelete"
    },

    tagName: "article",
    className: "filter-header",
    /**
     * row disabled state
     */
    rowState: false,

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);

        this.layout.on("filter:create:open", function(model) {
            var self = this,
                name = model ? model.get("name") : '';
            this.setFilterName(name);
            if (!name) {
                // We are creating a new filter.
                _.defer(function() {
                    self.$("input").focus();
                });
            }
        }, this);

        this.listenTo(this.layout, "filter:create:rowsValid", this.toggleRowState);
        this.listenTo(this.layout, "filter:set:name", this.setFilterName);
    },

    /**
     * Get input val
     * @returns {String}
     */
    getFilterName: function() {
        return this.$("input").val();
    },

    /**
     * Set input val and hides the delete button if we're clearing the name
     * @param name
     */
    setFilterName: function(name) {
        this.$("input").val(name);
        // We have this.layout.editingFilter if we're setting the name.
        this.toggleDelete(!name);
    },

    /**
     * Fired when the filter name changed
     * @param {Event} event
     */
    filterNameChanged: _.debounce(function(event) {
        this.layout.trigger('filter:create:validate');
    }, 400),

    /**
     * Toggle delete button
     * @param {Boolean} t true to hide the button
     */
    toggleDelete: function(t) {
        this.$(".delete_button").toggleClass("hide", t);
    },

    /**
     * Toggle save button
     */
    toggleDisabled: function() {
        this.$(".save_button").toggleClass('disabled', !(this.getFilterName() && this.rowState));
    },

    /**
     * Toggle row state
     * @param {*} t
     */
    toggleRowState: function(t) {
        this.rowState = _.isUndefined(t) ? !this.rowState : !!t;
        this.toggleDisabled();
    },

    /**
     * Trigger "filter:create:close" to close the filter create panel
     */
    triggerClose: function() {
        var id = this.layout.editingFilter.get('id');
        this.layout.trigger("filter:create:close", true, id);
    },

    /**
     * Trigger "filter:create:save" to save the created filter
     */
    triggerSave: function() {
        var filterName = this.getFilterName();
        this.layout.trigger("filter:create:save", filterName);
    },

    /**
     * Trigger "filter:create:delete" to delete the created filter
     */
    triggerDelete: function() {
        this.layout.trigger("filter:create:delete");
    }
})
