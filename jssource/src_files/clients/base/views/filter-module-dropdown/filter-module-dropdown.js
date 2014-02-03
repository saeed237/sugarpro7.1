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
     * View for the module dropdown
     * Part of BaseFilterLayout
     *
     * @class BaseFilterModuleDropdown
     * @extends View
     */

    //Override default Backbone tagName
    tagName: "span",

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);

        //Load partials
        this._select2formatSelectionTemplate = app.template.get("filter-module-dropdown.selection-partial");
        this._select2formatResultTemplate = app.template.get("filter-module-dropdown.result-partial");

        this.listenTo(this.layout, "filter:change:module", this.handleChange);
        this.listenTo(this.layout, "filter:render:module", this._render);
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        app.view.View.prototype._render.call(this);

        if (this.layout.showingActivities) {
            this.filterList = this.getModuleListForActivities();
        } else if (this.layout.layoutType === "record") {
            this.filterList = this.getModuleListForSubpanels();
        } else {
            this.$el.hide();
            return this;
        }

        this._renderDropdown(this.filterList);
    },

    /**
     * Render select2 dropdown
     * @private
     */
    _renderDropdown: function(data) {
        var self = this;

        this.filterNode = this.$(".related-filter");

        this.filterNode.select2({
            data: data,
            multiple: false,
            minimumResultsForSearch: 7,
            formatSelection: _.bind(this.formatSelection, this),
            formatResult: _.bind(this.formatResult, this),
            dropdownCss: {width: 'auto'},
            dropdownCssClass: 'search-related-dropdown',
            initSelection: _.bind(this.initSelection, this),
            escapeMarkup: function(m) {
                return m;
            },
            width: 'off'
        });

        // Disable the module filter dropdown.
        if (this.layout.layoutType !== "record" || this.layout.showingActivities) {
            this.filterNode.select2("disable");
        }

        this.filterNode.off("change");
        this.filterNode.on("change", function(e) {
            /**
             * Called when the user selects a module in the dropdown
             * Triggers filter:change:module on filter layout
             * @param {Event} e
             */
            var linkModule = e.val;
            if (self.layout.layoutType === "record" && linkModule !== "all_modules") {
                linkModule = app.data.getRelatedModule(self.module, linkModule);
            }
            self.layout.trigger("filter:change:module", linkModule, e.val);
        });
    },

    /**
     * Trigger events when a change happens
     * @param {String} linkModuleName
     * @param {String} linkName
     * @param {Boolean} silent
     */
    handleChange: function(linkModuleName, linkName, silent) {
        if (linkName === "all_modules") {
            this.layout.trigger("subpanel:change");
            // Fixes SP-836; esentially, we need to clear subpanel:last:<module> anytime 'All' selected
            app.cache.cut("subpanels:last:" + this.module);
        } else if (linkName && linkName !=='all_modules') {
            this.layout.trigger("filter:create:close");
            this.layout.trigger("subpanel:change", linkName);
            app.cache.set("subpanels:last:"+ app.controller.context.get('module'), linkName);
        }

        if (this.filterNode) {
            this.filterNode.select2("val", linkName || linkModuleName);
        }
        if (!silent) {
            this.layout.layout.trigger("filter:change", linkModuleName, linkName);
            this.layout.trigger("filter:get", linkModuleName, linkName);
            //Clear the search input and apply filter
            this.layout.trigger('filter:clear:quicksearch');
        }
    },

    /**
     * For record layout,
     * Populate the module dropdown by reading the subpanel relationships
     */
    getModuleListForSubpanels: function() {
        var filters = [];
        filters.push({id: "all_modules", text: app.lang.get("LBL_TABGROUP_ALL")});

        var subpanels = this.pullSubpanelRelationships();
        subpanels = this._pruneHiddenModules(subpanels);
        _.each(subpanels, function(value, key) {
            var module = app.data.getRelatedModule(this.module, value);
            if (app.acl.hasAccess("list", module)) {
                filters.push({id: value, text: app.lang.get(key, this.module)});
            }
        }, this);
        return filters;
    },

    /**
     * For Activity Stream,
     * Populate the module dropdown with a single item
     */
    getModuleListForActivities: function() {
        var filters = [], label;
        if (this.module == "Activities") {
            label = app.lang.get("LBL_TABGROUP_ALL");
        } else {
            label = app.lang.get('LBL_MODULE_NAME', this.module);
        }
        filters.push({id: 'Activities', text: label});
        return filters;
    },

    /**
     * Pull the list of related modules from the subpanel metadata
     * @returns {Object}
     */
    pullSubpanelRelationships: function() {
        // Subpanels are retrieved from the global module and not the
        // subpanel module, therefore we use this.module instead of
        // this.currentModule.
        return app.utils.getSubpanelList(this.module);
    },

    /**
     * Prunes hidden modules from related dropdown list
     * @param {Object} subpanels List of candidate subpanels to display
     * @return {Object} pruned list of subpanels
     * @private
     */
    _pruneHiddenModules: function(subpanels){
        var hiddenSubpanels = _.map(app.metadata.getHiddenSubpanels(), function(subpanel) { return subpanel.toLowerCase(); });
        var pruned = _.reduce(subpanels, function(obj, value, key) {
            var relatedModule = app.data.getRelatedModule(this.module, value);
            if (!_.contains(hiddenSubpanels, relatedModule.toLowerCase())) {
                obj[key] = value;
            }
            return obj;
        }, {}, this);
        return pruned;
    },

    /**
     * Get the dropdown labels for the module dropdown
     * @param {Object} el
     * @param {Function} callback
     */
    initSelection: function(el, callback) {
        var selection, label;
        if (el.val() === "all_modules") {
            label = (this.layout.layoutType === "record") ? app.lang.get("LBL_TABGROUP_ALL") : app.lang.get("LBL_MODULE_NAME", this.module);
            selection = {id: "all_modules", text: label};
        } else if (_.findWhere(this.filterList, {id: el.val()})) {
            selection = _.findWhere(this.filterList, {id: el.val()});
        } else if(this.filterList && this.filterList.length > 0)  {
            selection = this.filterList[0];
        }
        callback(selection);
    },

    /**
     * Update the text for the selected module and returns template
     *
     * @param {Object} item
     * @returns {string}
     */
    formatSelection: function(item) {
        var selectionLabel, safeString;

        //Escape string to prevent XSS injection
        safeString = Handlebars.Utils.escapeExpression(item.text);
        // Update the text for the selected module.
        this.$('.choice-related').html(safeString);

        if (this.layout.layoutType !== "record" || this.layout.showingActivities) {
            selectionLabel = app.lang.get("LBL_MODULE");
        } else {
            selectionLabel = app.lang.get("LBL_RELATED") + '<i class="icon-caret-down"></i>';
        }


        return this._select2formatSelectionTemplate(selectionLabel);
    },

    /**
     * Returns template
     * @param {Object} option
     * @returns {string}
     */
    formatResult: function(option) {
        // TODO: Determine whether active filters should be highlighted in bold in this menu.
        return this._select2formatResultTemplate(option.text);
    },

    /**
     * @override
     * @private
     */
    _dispose: function() {
        if (!_.isEmpty(this.filterNode)) {
            this.filterNode.select2('destroy');
        }
        app.view.View.prototype._dispose.call(this);
    }
})
