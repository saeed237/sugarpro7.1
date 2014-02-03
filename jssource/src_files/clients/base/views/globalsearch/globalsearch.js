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
    // FIXME this needs to be removed so that we can be able to reuse this view
    id: 'searchForm',
    preTag: '<strong>',
    postTag: '</strong>',

    plugins: ['Dropdown'],
    searchModules: [],
    events: {
        'click .typeahead a': 'clearSearch',
        'click [data-action=search]': 'showResults',
        'click [data-advanced=options]': 'persistMenu',
        'click [data-action="select-module"]': 'selectModule'
    },
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        app.events.on('app:sync:complete', this.populateModules, this);
    },
    /**
     * Handle module 'select/unselect' event.
     * @param event
     */
    selectModule: function(event) {
        var module = this.$(event.currentTarget).data('module'),
            searchAll = this.$('input:checkbox[data-module="all"]'),
            searchAllLabel = searchAll.closest('label'),
            checkedModules = this.$('input:checkbox:checked[data-module!="all"]');

        if (module === 'all') {
            searchAll.attr('checked', true);
            searchAllLabel.addClass('active');
            checkedModules.removeAttr('checked');
            checkedModules.closest('label').removeClass('active');
        } else {
            var currentTarget = this.$(event.currentTarget),
                currentTargetLabel = currentTarget.closest('label');

            currentTarget.attr('checked') ? currentTargetLabel.addClass('active') : currentTargetLabel.removeClass('active');

            if (checkedModules.length) {
                searchAll.removeAttr('checked');
                searchAllLabel.removeClass('active');
            }
            else {
                searchAll.attr('checked', true);
                searchAllLabel.addClass('active');
            }
        }
        // This will prevent the module selection dropdown from disappearing.
        event.stopPropagation();
    },
    /**
     * Create the dropdown for the user to select which modules to search.
     */
    populateModules: function() {
        if (this.disposed) {
            return;
        }
        this.searchModules = [];
        var modules = app.metadata.getModules() || {};
        this.searchModules = this.populateSearchableModules({
            modules: modules,
            acl: app.acl,
            checkFtsEnabled: true,
            checkGlobalSearchEnabled: true
        });
        this.render();
    },
    /**
     * Helper that can be called from here in base, or, from derived globalsearch views. Called internally,
     * so please ensure that you have passed in any required options or results may be undefined
     * @param {Object} options An object literal with the following properties:
     * - modules: our current modules (required)
     * - acl: app.acl that has the hasAccess function (required) (we DI this for testability)
     * - moduleNames: displayed modules; an array of white listed string names. If used, only modules within
     * this white list will be added (optional)
     * - checkFtsEnabled: whether we should check meta.ftsEnabled (optional defaults to false)
     * - checkGlobalSearchEnabled: whether we should check meta.globalSearchEnabled (optional defaults to false)
     * @return {Array} An array of searchable modules
     */
    populateSearchableModules: function(options) {
        var modules = options.modules,
            moduleNames = options.moduleNames || null,
            acl = options.acl,
            searchModules = [];

        _.each(modules, function(meta, module) {
            var goodToAdd = true;
            // First check if we have a "white list" of displayed module names (e.g. portal)
            // If so, check if it contains the current module we're checking
            if (moduleNames && !_.contains(moduleNames, module)) {
                goodToAdd = false;
            }
            // First check access the, conditionally, check fts and global search enabled properties
            if (goodToAdd && acl.hasAccess.call(acl, 'view', module)) {
                // Check global search enabled if relevant to caller
                if (options.checkGlobalSearchEnabled && !meta.globalSearchEnabled) {
                    goodToAdd = false;
                }
                // Check global search enabled if relevant to caller
                if (goodToAdd && options.checkFtsEnabled && !meta.ftsEnabled) {
                    goodToAdd = false;
                }
                // If we got here we've passed all checks so push module to search modules
                if (goodToAdd) {
                    searchModules.push(module);
                }
            }
        }, this);
        return searchModules;
    },
    _renderHtml: function() {
        if (!app.api.isAuthenticated() || app.config.appStatus == 'offline') return;

        app.view.View.prototype._renderHtml.call(this);

        // Search ahead drop down menu stuff
        var self = this,
            menuTemplate = app.template.getView(this.name + '.result');

        this.$('.search-query').searchahead({
            request: function(term) {
                self.fireSearchRequest.call(self, term, this);
            },
            compiler: menuTemplate,
            throttleMillis: (app.config.requiredElapsed || 500),
            throttle: function(callback, millis) {
                if(!self.debounceFunction) {
                    self.debounceFunction = _.debounce(function(){
                        callback();
                    }, millis || 500);
                }
                self.debounceFunction();
            },
            onEnterFn: function(hrefOrTerm, isHref) {
                // FIXME there is a bug on searchahead lib that even if the
                // menu is hidden triggers isHref = true
                if (isHref && this.$menu.is(':visible')) {
                    app.router.navigate(hrefOrTerm, {trigger: true});
                } else {
                    // It's the term only (user didn't select from drop down
                    // so this is essentially the term typed
                    var term = $.trim(self.$('.search-query').attr('value'));
                    if (!_.isEmpty(term)) {
                        self.fireSearchRequest.call(self, term, this);
                    }
                }
            }
        });
        // Prevent the form from being submitted
        this.$('.navbar-search').submit(function() {
            return false;
        });
    },

    /**
     * Escapes the highlighted result from Elasticsearch for any potential XSS.
     * @param  {String} html
     * @return {Handlebars.SafeString}
     */
    _escapeSearchResults: function(html) {
        // Change this regex if server-side preTag and postTag change.
        var highlightedSpanRe = /<strong>.*?<\/strong>/g,
            higlightSpanTagsRe = /(<strong>)|(<\/strong>)/g,
            escape = Handlebars.Utils.escapeExpression,
            // First, all of the HTML is escaped.
            result = escape(html),
            // Then, we find all pieces highlighted by the server.
            highlightedSpan = html.match(highlightedSpanRe),
            highlightedContent,
            self = this;

        // For each highlighted part:
        _.each(highlightedSpan, function(part){
            highlightedContent = part.replace(higlightSpanTagsRe, '');
            // We escape the content of each highlight returned from Elastic.
            highlightedContent = escape(highlightedContent);
            // And then, we inject the escaped content with our own unescaped
            // highlighting tags (self.preTag/self.postTag).
            result = result.replace(escape(part), self.preTag + highlightedContent + self.postTag);
        });

        return new Handlebars.SafeString(result);
    },

    /**
     * Get the modules that current user selected for search.
     * Empty array for all.
     * @returns {Array}
     */
    _getSearchModuleNames: function() {
        if (this.$('input:checkbox[data-module="all"]').attr('checked')) {
            return [];
        }
        else {
            var searchModuleNames = [],
                checkedModules = this.$('input:checkbox:checked[data-module!="all"]');
            _.each(checkedModules, function(val,index) {
                searchModuleNames.push(val.getAttribute('data-module'));
            }, this);
            return searchModuleNames;
        }
    },
    /**
     * Callback for the searchahead plugin .. note that
     * 'this' points to the plugin (not the header view!)
     */
    fireSearchRequest: function (term, plugin) {
        var searchModuleNames = this._getSearchModuleNames(),
            moduleList = searchModuleNames.join(','),
            self = this,
            maxNum = app.config && app.config.maxSearchQueryResult ? app.config.maxSearchQueryResult : 5,
            params = {
                q: term,
                fields: 'name, id',
                module_list: moduleList,
                max_num: maxNum
            };
        app.api.search(params, {
            success:function(data) {
                var formattedRecords = [];
                _.each(data.records, function(record) {
                    if (!record.id) {
                        return; // Elastic Search may return records without id and record names.
                    }
                    var formattedRecord = {
                        id: record.id,
                        name: record.name,
                        module: record._module,
                        link: '#' + app.router.buildRoute(record._module, record.id)
                    };

                    if ((record._search.highlighted)) { // full text search
                        _.each(record._search.highlighted, function(val, key) {
                            var safeString = self._escapeSearchResults(val.text);
                            if (key !== 'name') { // found in a related field
                               formattedRecord.field_name = app.lang.get(val.label, val.module);
                               formattedRecord.field_value = safeString;
                            } else { // if it is a name that is found, we need to replace the name with the highlighted text
                                formattedRecord.name = safeString;
                            }
                        });
                    }
                    formattedRecords.push(formattedRecord);
                });
                plugin.provide({next_offset: data.next_offset, records: formattedRecords, module_list: moduleList});
            },
            error:function(error) {
                app.error.handleHttpError(error, plugin);
                app.logger.error("Failed to fetch search results in search ahead. " + error);
            }
        });
    },

    /**
     * Show results when the search button is clicked.
     *
     * @param {Event} evt The event that triggered the search.
     */
    showResults: function(evt) {

        var $searchBox = this.$('[data-provide=typeahead]');

        if (!$searchBox.is(':visible')) {
            this.$el.addClass('active');
            $('body').on('click.globalsearch.data-api', _.bind(function(event) {
                if (!$.contains(this.el, event.target)) {
                    this.$el.removeClass('active');
                    $('body').off('click.globalsearch.data-api');
                }
            }, this));
            $searchBox.focus();
            return;
        }

        // Simulate 'enter' keyed so we can show searchahead results
        var e = jQuery.Event('keyup', { keyCode: $.ui.keyCode.ENTER });
        $searchBox.focus();
        $searchBox.trigger(e);
    },

    /**
     * Clears out search upon user following search result link in menu
     */
    clearSearch: function() {
        this.$('.search-query').val('');
    },

    /**
     * This will prevent the dropup menu from closing when clicking anywhere on it
     */
    persistMenu: function(e) {
        e.stopPropagation();
    },

    unbind: function() {
        $('body').off('click.globalsearch.data-api');
        this._super('unbind');
    }
})
