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
     * Layout for filtering a collection.
     * Composed of a module dropdown(optional), a filter dropdown and an input
     *
     * @class BaseFilterLayout
     * @extends Layout
     */
    className: 'filter-view search',

    plugins: ['QuickSearchFilter'],

    events: {
        'click .add-on.icon-remove': function() { this.trigger('filter:clear:quicksearch'); }
    },

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        var filterLayout = app.view._getController({type:'layout',name:'filter'});
        filterLayout.loadedModules = filterLayout.loadedModules || {};
        app.view.Layout.prototype.initialize.call(this, opts);

        this.layoutType = this.context.get('layout') || this.context.get('layoutName') || app.controller.context.get('layout');

        this.aclToCheck = (this.layoutType === 'record')? 'view' : 'list';
        this.filters = app.data.createBeanCollection('Filters');

        this.emptyFilter = app.data.createBean('Filters', {
            id: 'all_records',
            name: app.lang.get('LBL_FILTER_ALL_RECORDS'),
            filter_definition: [],
            editable: false
        });

        // Can't use getRelevantContextList here, because the context may not
        // have all the children we need.
        if (this.layoutType === 'records') {
            // filters will handle data fetching so we skip the standard data fetch
            this.context.set('skipFetch', true);
        } else {
            if(this.context.parent) {
                this.context.parent.set('skipFetch', true);
            }
            this.context.on('context:child:add', function(childCtx) {
                if (childCtx.get('link')) {
                    // We're in a subpanel.
                    childCtx.set('skipFetch', true);
                }
            }, this);
        }

        /**
         * bind events
         */
        this.on('filter:apply', this.applyFilter, this);

        this.on('filter:create:close', function() {
            this.layout.editingFilter = null;
            this.layout.trigger('filter:create:close');
        }, this);

        this.on('filter:create:open', function(filterModel) {
            this.layout.editingFilter = filterModel;
            this.layout.trigger('filter:create:open', filterModel);
        }, this);

        this.on('subpanel:change', function(linkName) {
            this.layout.trigger('subpanel:change', linkName);
        }, this);

        this.on('filter:get', this.initializeFilterState, this);

        this.on('filter:change:filter', this.handleFilterChange, this);

        this.layout.on('filter:apply', function(query, def) {
            this.trigger('filter:apply', query, def);
        }, this);

        this.layout.on('filterpanel:change', this.handleFilterPanelChange, this);
        this.layout.on('filterpanel:toggle:button', this.toggleFilterButton, this);

        //When a filter is saved, update the cache and set the filter to be the currently used filter
        this.layout.on('filter:add', this.addFilter, this);

        // When a filter is deleted, update the cache and set the default filter
        // to be the currently used filter.
        this.layout.on('filter:remove', this.removeFilter, this);

        this.layout.on('filter:reinitialize', function() {
            this.initializeFilterState(this.layout.currentModule, this.layout.currentLink);
        }, this);
    },
    /**
     * handles filter removal
     * @param model
     */
    removeFilter: function(model){
        this.filters.remove(model);
        app.user.lastState.set(app.user.lastState.key("saved-" + this.layout.currentModule, this), this.filters.toJSON());
        this.layout.trigger('filter:reinitialize');
    },
    /**
     * saves last filter to app cache
     * @param {String} baseModule
     * @param {String} filterModule
     * @param {String} layoutName
     * @param {*} value
     * @returns {*}
     */
    setLastFilter: function(filterModule, layoutName, value) {
        var key = app.user.lastState.key("last-" + filterModule + "-" + layoutName, this);
        return app.user.lastState.set(key, value);
    },
    /**
     * gets last filter from cache
     * @param {String} baseModule
     * @param {String} filterModule
     * @param {String} layoutName
     * @returns {*}
     */
    getLastFilter: function(filterModule, layoutName) {
        var key = app.user.lastState.key("last-" + filterModule + "-" + layoutName, this);
        return app.user.lastState.get(key);
    },
    /**
     * clears last filter from cache
     * @param {String} baseModule
     * @param {String} filterModule
     * @param {String} layoutName
     * @returns {*}
     */
    clearLastFilter:function(filterModule, layoutName) {
        var key = app.user.lastState.key("last-" + filterModule + "-" + layoutName, this);
        return app.user.lastState.remove(key);
    },
    /**
     * handles filter additionF
     * @param model
     */
    addFilter: function(model){
        this.filters.add(model);
        app.user.lastState.set(app.user.lastState.key("saved-" + this.layout.currentModule, this), this.filters.toJSON());
        this.setLastFilter(this.layout.currentModule, this.layoutType, model.get("id"));
        this.layout.trigger('filter:reinitialize');
    },

    /**
     * Enables or disables a filter toggle button (e.g. activity or subpanel toggle buttons)
     * @param {String} toggleDataView the string used in `data-view` attribute for that toggle element (e.g. 'subpanels', 'activitystream')
     * @param {Boolean} on pass true to enable, false to disable
     */
    toggleFilterButton: function (toggleDataView, on) {
        var toggleButtons = this.layout.$('.toggle-actions a.btn');

        // Loops toggle buttons for 'data-view' that corresponds to `toggleDataView` and enables/disables per `on`
        _.each(toggleButtons, function(btn) {
            if($(btn).data('view') === toggleDataView) {
                if(on) {
                    $(btn).removeAttr('disabled').removeClass('disabled');
                } else {
                    $(btn).attr('disabled', 'disabled').addClass('disabled');
                    $(btn).attr('title', app.lang.get('LBL_NO_DATA_AVAILABLE'));
                }
            }
        });
    },

    /**
     * Handles filter panel changes between activity and subpanels
     * @param {String} name Name of panel
     * @param {Boolean} silent Whether to trigger filter events
     * @param {Boolean} setLastViewed Whether to set last viewed to `name` panel
     */
    handleFilterPanelChange: function(name, silent, setLastViewed) {
        this.showingActivities = name === 'activitystream';
        var module = this.showingActivities ? "Activities" : this.module;
        var link;

        if(this.layoutType === 'record' && !this.showingActivities) {
            module = link = app.user.lastState.get(app.user.lastState.key("subpanels-last", this)) || 'all_modules';
            if (link !== 'all_modules') {
                module = app.data.getRelatedModule(this.module, link);
            }
        } else {
            link = null;
        }
        if (!silent) {
            this.trigger("filter:render:module");
            this.trigger("filter:change:module", module, link);
        }
        if (setLastViewed) {
            // Asks filterpanel to update user.lastState with new panel name as last viewed
            this.layout.trigger('filterpanel:lastviewed:set', name);
        }
    },
    /**
     * handles filter change
     * @param id
     * @param preventCache
     */
    handleFilterChange: function(id, preventCache) {
        if (id && id != 'create' && !preventCache) {
            this.setLastFilter(this.layout.currentModule, this.layoutType, id);
        }
        var filter = this.filters.get(id) || this.emptyFilter,
            ctxList = this.getRelevantContextList();
        var clear = false;
        //Determine if we need to clear the collections
        _.each(ctxList, function(ctx) {
            var filterDef = filter.get('filter_definition');
            var orig = ctx.get('collection').origFilterDef;
            ctx.get('collection').origFilterDef = filterDef;  //Set new filter def on each collection
            if (_.isUndefined(orig) || !_.isEqual(orig, filterDef)) {
                clear = true;
            }
        });
        //If so, reset collections and trigger quicksearch to repopulate
        if (clear) {
            _.each(ctxList, function(ctx) {
                ctx.get('collection').resetPagination();
                // Silently reset the collection otherwise the view is re-rendered.
                // It will be re-rendered on request response.
                ctx.get('collection').reset(null, { silent: true });
            });
            this.trigger('filter:clear:quicksearch');
        }
    },
    /**
     * Applies filter on current contexts
     * @param {String} query search string
     * @param {Object} dynamicFilterDef(optional)
     */
    applyFilter: function(query, dynamicFilterDef) {
        //If the quicksearch field is not empty, append a remove icon so the user can clear the search easily
        this._toggleClearQuickSearchIcon(!_.isEmpty(query));
        // reset the selected on filter apply
        var massCollection = this.context.get('mass_collection');
        if (massCollection && massCollection.models && massCollection.models.length > 0) {
            massCollection.reset([],{silent: true});
        }
        var self = this,
            ctxList = this.getRelevantContextList();
        _.each(ctxList, function(ctx) {
            var ctxCollection = ctx.get('collection'),
                origFilterDef = dynamicFilterDef || ctxCollection.origFilterDef || [],
                filterDef = self.buildFilterDef(origFilterDef, query, ctx),
                options = {
                    //Show alerts for this request
                    showAlerts: true,
                    success: function(collection, response, options) {
                        // Close the preview pane to ensure that the preview
                        // collection is in sync with the list collection.
                        app.events.trigger('preview:close');
                    }};

            ctxCollection.filterDef = filterDef;
            ctxCollection.origFilterDef = origFilterDef;
            ctxCollection.resetPagination();

            options = _.extend(options, ctx.get('collectionOptions'));

            ctx.resetLoadFlag(false);
            if (!_.isEmpty(ctx._recordListFields)) {
                ctx.set('fields', ctx._recordListFields);
            }
            ctx.set('skipFetch', false);
            ctx.loadData(options);
        });
    },

    /**
     * Look for the relevant contexts. It can be
     * - the activity stream context
     * - the list view context on records layout
     * - the selection list view context on records layout
     * - the contexts of the subpanels on record layout
     * @returns {Array} array of contexts
     */
    getRelevantContextList: function() {
        var contextList = [];
        if (this.showingActivities) {
            _.each(this.layout._components, function(component) {
                var ctx = component.context;
                if (component.name == 'activitystream' && !ctx.get('modelId') && ctx.get('collection')) {
                    //FIXME: filter layout's _components array has multiple references to same activitystreams layout object
                    contextList.push(ctx);

                }
            });
        } else {
            if (this.layoutType === 'records') {
                var ctx = this.context.parent || this.context;
                if (!ctx.get('modelId') && ctx.get('collection')) {
                    contextList.push(ctx);
                }
            } else {
                //Locate and add subpanel contexts
                _.each(this.context.children, function(ctx) {
                    if (ctx.get('isSubpanel') && !ctx.get('hidden') && !ctx.get('modelId') && ctx.get('collection')) {
                        contextList.push(ctx);
                    }
                });
            }
        }
        return _.uniq(contextList);
    },

    /**
     * Builds the filter definition based on preselected filter and module quick search fields
     * @param {Object} oSelectedFilter
     * @param {String} searchTerm
     * @param {Context} context
     * @returns {Array} array containing filter def
     */
    buildFilterDef: function(oSelectedFilter, searchTerm, context) {
        var selectedFilter = app.utils.deepCopy(oSelectedFilter),
            isSelectedFilter = _.size(selectedFilter) > 0,
            module = context.get('module'),
            searchFilter = this.getFilterDef(module, searchTerm),
            isSearchFilter = _.size(searchFilter) > 0;

        if (isSelectedFilter && isSearchFilter) {
            selectedFilter = _.isArray(selectedFilter) ? selectedFilter : [selectedFilter];
            selectedFilter.push(searchFilter[0]);
            return [{'$and': selectedFilter }];
        } else if (isSelectedFilter) {
            return selectedFilter;
        } else if (isSearchFilter) {
            return searchFilter;
        }

        return [];
    },

    /**
     * Reset the filter to the previous state
     * @param {String} moduleName
     * @param {String} linkName
     */
    initializeFilterState: function(moduleName, linkName) {
        moduleName = moduleName || this.module;

        var lastFilter = this.getLastFilter(moduleName, this.layoutType),
            filterData;
        if (!(this.filters.get(lastFilter)))
            lastFilter = null;
        if (this.layoutType === 'record' && !this.showingActivities) {
            linkName = app.user.lastState.get(app.user.lastState.key("subpanels-last", this)) || linkName;
            filterData = {
                link: lastFilter || 'all_modules',
                filter: lastFilter || 'all_records'
            };
        } else {
            filterData = {
                filter: lastFilter || null
            };
        }
        this.applyPreviousFilter(moduleName, linkName, filterData);
    },
    /**
     * applies previous filter
     * @param {String} moduleName
     * @param {String} linkName
     * @param {Object} data
     */
    applyPreviousFilter: function (moduleName, linkName, data) {
        var module = moduleName || this.module,
            link = linkName || data.link;
        if (this.showingActivities) module = "Activities";
        if (this.layoutType === 'record' && link !== 'all_modules' && !this.showingActivities) {
            var moduleMeta = app.metadata.getModule(module);
            // only switch modules if this link actually exists on the module
            if (!_.isUndefined(moduleMeta.fields[link])) {
                module = app.data.getRelatedModule(module, link) || module;
            }

        }

        this.trigger('filter:change:module', module, link, true);
        this.getFilters(module, data.filter);
    },

    /**
     * Retrieves the appropriate list of filters from the server.
     * @param  {String} moduleName
     * @param  {String} defaultId
     */
    getFilters: function(moduleName, defaultId) {
        var filter = [
            {'created_by': app.user.id},
            {'module_name': moduleName}
        ], self = this;
        // TODO: Add filtering on subpanel vs. non-subpanel filters here.
        var filterLayout = app.view._getController({type:'layout',name:'filter'});
        if (filterLayout.loadedModules[moduleName] && !_.isEmpty(app.user.lastState.get(app.user.lastState.key("saved-" + moduleName, this))))
        {
            this.filters.reset();
            var filters = app.user.lastState.get(app.user.lastState.key("saved-" + moduleName, this));
            _.each(filters, function(f){
                self.filters.add(app.data.createBean("Filters", f));
            });
            self.handleFilterRetrieve(moduleName, defaultId);
        }
        else {
            this.filters.fetch({
                //Don't show alerts for this request
                showAlerts: false,
                filter: filter,
                success:function(){
                    if (self.disposed) return;
                    filterLayout.loadedModules[moduleName] = true;
                    app.user.lastState.set(app.user.lastState.key("saved-" + moduleName, self), self.filters.toJSON());
                    self.handleFilterRetrieve(moduleName, defaultId);
                }
            });
        }
    },
    /**
     * handles return from filter retrieve per module
     * @param moduleName
     * @param defaultId
     */
    handleFilterRetrieve: function(moduleName, defaultId) {
        var lastFilter = this.getLastFilter(moduleName, this.layoutType);
        var defaultFilterFromMeta,
            possibleFilters = [],
            filterMeta = this.getModuleFilterMeta(moduleName);

        if (filterMeta) {
            _.each(filterMeta, function(value) {
                if (_.isObject(value)) {
                    if (_.isObject(value.meta.filters)) {
                        this.filters.add(value.meta.filters);
                    }
                    if (value.meta.default_filter) {
                        defaultFilterFromMeta = value.meta.default_filter;
                    }
                }
            }, this);

            possibleFilters = [defaultId, defaultFilterFromMeta, 'all_records'];
            possibleFilters = _.filter(possibleFilters, this.filters.get, this.filters);
        }

        if (lastFilter && !(this.filters.get(lastFilter))){
            this.clearLastFilter(moduleName, this.layoutType);
        }
        this.layout.trigger('filterpanel:change:module', moduleName);
        this.trigger('filter:render:filter');
        this.trigger('filter:change:filter', this.getLastFilter(moduleName, this.layoutType) ||  _.first(possibleFilters) || 'all_records', true);
    },

    /**
     * Utility function to know if the create filter panel is opened.
     * @returns {Boolean} true if opened
     */
    createPanelIsOpen: function() {
        return !this.layout.$(".filter-options").is(":hidden");
    },

    /**
     * Determines whether a user can create a filter for the current module.
     * @return {Boolean} true if creatable
     */
    canCreateFilter: function() {
        // Check for create in meta and make sure that we're only showing one
        // module, then return false if any is false.
        var contexts = this.getRelevantContextList(),
            creatable = app.acl.hasAccess("create", "Filters"),
            meta;
        // Short circuit if we don't have the ACLs to create Filter beans.

        if (creatable && contexts.length === 1) {
            meta = app.metadata.getModule(contexts[0].get("module"));
            if (_.isObject(meta.filters)) {
                _.each(meta.filters, function(value) {
                    if (_.isObject(value)) {
                        creatable = creatable && value.meta.create !== false;
                    }
                });
            }
        }

        return creatable;
    },

    /**
     * Get filters metadata from module metadata for a module
     * @param {String} moduleName
     * @returns {Object} filters metadata
     */
    getModuleFilterMeta: function(moduleName) {
        var meta;
        if (moduleName !== 'all_modules') {
            meta = app.metadata.getModule(moduleName);
            if (_.isObject(meta)) {
                meta = meta.filters;
            }
        }

        return meta;
    },

    /**
     * Append or remove an icon to the quicksearch input so the user can clear the search easily
     * @param {Boolean} addIt TRUE if you want to add it, FALSO to remove
     */
    _toggleClearQuickSearchIcon: function(addIt) {
        if (addIt && !this.$('.add-on.icon-remove')[0]) {
            this.$el.append('<i class="add-on icon-remove"></i>');
        } else if (!addIt) {
            this.$('.add-on.icon-remove').remove();
        }
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        if (app.acl.hasAccess(this.aclToCheck, this.module)) {
            app.view.Layout.prototype._render.call(this);
            this.initializeFilterState();
        }
    },

    /**
     * @override
     */
    unbind: function() {
        this.filters.off();
        this.filters = null;
        app.view.Layout.prototype.unbind.call(this);
    }

})
