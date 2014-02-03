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
     * View for doing a quick search.
     * Part of BaseFilterLayout
     *
     * @class BaseFilterQuicksearchView
     * @extends View
     */

    events: {
        'keyup': 'throttledSearch',
        'paste': 'throttledSearch'
    },

    plugins: ['QuickSearchFilter'],

    // Defining tagName, className and attributes allows us to avoid a template and an extra element
    tagName: 'input',
    className: 'search-name',
    attributes: {
        'type': 'text'
    },

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);
        this.listenTo(this.layout, 'filter:clear:quicksearch', this.clearInput);
        this.listenTo(this.layout, 'filter:change:module', this.updatePlaceholder);
    },

    /**
     * Fire quick search
     * @param {Event} e
     */
    throttledSearch: _.debounce(function(e) {
        var newSearch = this.$el.val();
        if(this.currentSearch !== newSearch) {
            this.currentSearch = newSearch;
            this.layout.trigger('filter:apply', newSearch);
        }
    }, 400),

    /**
     * Retrieve the field labels
     *
     * @param {String} moduleName
     * @param {Array} field names
     * @returns {Array} field labels
     */
    getFieldLabels: function(moduleName, fields) {
        var moduleMeta = app.metadata.getModule(moduleName);
        var labels = [];
        _.each(fields, function(fieldName) {
            var fieldMeta = moduleMeta.fields[fieldName];
            labels.push(app.lang.get(fieldMeta.vname, moduleName).toLowerCase());
        });
        return labels;
    },

    /**
     * Update quick search placeholder to Search by Field1, Field2, Field3 when the module changes
     * @param string linkModuleName
     * @param string linkModule
     */
    updatePlaceholder: function(linkModuleName, linkModule) {
        var label;
        this.toggleInput();
        if (!this.$el.hasClass('hide') && linkModule !== 'all_modules') {
            var fields = this.getModuleQuickSearchFields(linkModuleName),
                fieldLabels = this.getFieldLabels(linkModuleName, fields);
            label = app.lang.get('LBL_SEARCH_BY') + ' ' + fieldLabels.join(', ') + '...';
        } else {
            label = app.lang.get('LBL_BASIC_QUICK_SEARCH');
        }
        this.$el.attr('placeholder', label);
    },

    /**
     * Hide input if on Activities
     */
    toggleInput: function() {
        this.$el.toggleClass('hide', !!this.layout.showingActivities);
    },

    /**
     * Clear input
     */
    clearInput: function() {
        this.toggleInput();
        this.$el.val('');
        this.currentSearch = '';
        this.layout.trigger('filter:apply');
    }
})
