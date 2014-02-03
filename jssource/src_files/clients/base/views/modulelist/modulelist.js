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
    className: 'module-list',
    recentRowTemplate: Handlebars.compile(
        '{{#each models}}<li><a tabindex="-1" class="recentLink actionLink" href="#{{buildRoute model=this}}" data-route="#{{buildRoute model=this}}"><i class="icon-time active"></i>{{getFieldValue this "name"}}</a></li>{{/each}}'
    ),
    plugins: ['Dropdown'],
    events: {
        'click [data-toggle=dropdown]': 'getRecentlyViewedAndFavoriteRecords',
        'click .actionLink' : 'handleMenuEvent',
        "click a[data-route]": "handleRouteEvent"
    },
    handleRouteEvent: function (event) {
        var currentFragment,
            currentTarget = this.$(event.currentTarget),
            route = currentTarget.data("route");

        if (route) {
            if ((!_.isUndefined(event.button) && event.button !== 0) || event.ctrlKey || event.metaKey) {
                event.stopPropagation();
                window.open(route, '_blank');
                // FIXME remove this hack once the drawer doesn't popup even after stopPropagation() is called.
                return false;
            }
            event.preventDefault();
            currentFragment = Backbone.history.getFragment();
            if (("#" + currentFragment) === route) {
                app.router.refresh();
            } else {
                app.router.navigate(route, {trigger: true});
            }
        }
    },
    handleMenuEvent:function (evt) {
        var $currentTarget = this.$(evt.currentTarget);
        if ($currentTarget.data('event')) {
            var module = $currentTarget.closest('li.dropdown').data('module');
            app.events.trigger($currentTarget.data('event'), module, evt);
        }
    },

    initialize: function(options) {
        this.activeModule = this._setActiveModule(this);
        app.events.on("app:sync:complete", this.render, this);
        app.events.on("app:view:change", this.handleViewChange, this);
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on("view:resize", this.resize, this);
        }
    },
    _dispose: function(){
        app.view.View.prototype._dispose.call(this);
    },
    handleViewChange: function() {
        this.activeModule.set(app.controller.context.get("module"));
        this.layout.trigger("header:update:route");
    },
    /**
     * Populates the recently viewed and favorite records
     * @param event
     */
    getRecentlyViewedAndFavoriteRecords:function (event) {
        var $currentTarget = $(event.currentTarget),
            module = $currentTarget.parent().parent().data('module'),
            moduleMeta = app.metadata.getModule(module);

        if (!$currentTarget.parent().parent().hasClass('more-drop-container') && !$currentTarget.hasClass('actionLink')) {
            if (module == 'Home') {
                this.populateDashboards();
            }
            else if (moduleMeta && moduleMeta.fields && !_.isArray(moduleMeta.fields)) {
                this.clearFavoritesRecents(module);
                if(moduleMeta.favoritesEnabled){
                    this.populateFavorites(module);
                }
                this.populateRecents(module);
            }
        }
    },
    clearFavoritesRecents: function(module){
        this.$('[data-module=' + module + '] .recentContainer').html('');
        this.$('[data-module=' + module + '] .favoritesContainer').html('');
    },
    /**
     * Populates favorites on open menu
     * @param {Object} module Module name
     * @param {Function} populateCallback Called on successful api request
     */
    populateFavorites: function(module, populateCallback) {
        var self = this;
        var filter = {
            "filter":[
                {
                    "$favorite":""
                }
            ],
            "max_num":3
        };
        var url = app.api.buildURL(module, 'read', {id:"filter"});
        app.api.call('create', url, filter, {
            limit:3,
            success:function (data) {
                if (data.records && data.records.length > 0) {
                    if (_.isFunction(populateCallback)) {
                        populateCallback();
                    }
                    var beans = [];
                    _.each(data.records, function (recordData) {
                        beans.push(app.data.createBean(module, recordData));
                    });
                    var collection = app.data.createBeanCollection(module, beans);
                    self.$('[data-module=' + module + '] .favoritesAnchor').show();
                    var favoritesTemplate = app.template.getView('modulelist.favorites', module) ||
                        app.template.getView('modulelist.favorites');
                    self.$('[data-module=' + module + '] .favoritesContainer')
                        .show()
                        .html(favoritesTemplate(collection));
                }
           }
        });
    },
    /**
     * Populates recents on open menu
     * @param {String} module Module name
     * @param {Function} populateCallback Called on successful api request
     */
    populateRecents:function (module, populateCallback) {
        var self = this;
        var filter = {
            "filter":[
                {
                    "$tracker":"-7 DAY"
                }
            ],
            "max_num":3
        };
        var url = app.api.buildURL(module, 'read', {id:"filter"});
        app.api.call('create', url, filter, {
            success:function (data) {
                if (data.records && data.records.length > 0) {
                    if (_.isFunction(populateCallback)) {
                        populateCallback();
                    }
                    var beans = [];
                    _.each(data.records, function (recordData) {
                        beans.push(app.data.createBean(module, recordData));
                    });
                    var collection = app.data.createBeanCollection(module, beans);
                    self.$('[data-module=' + module + '] .recentAnchor').show();
                    self.$('[data-module=' + module + '] .recentContainer').show().html(self.recentRowTemplate(collection));
                }

            }});
    },
    /**
     * Populates recently created dashboards on open menu
     */

    populateDashboards:function () {
        var self = this,
            sync = function(method, model, options) {
                options       = app.data.parseOptionsForSync(method, model, options);
                var callbacks = app.data.getSyncCallbacks(method, model, options);
                app.api.records(method, this.apiModule, model.attributes, options.params, callbacks);
            },
            Dashboard = app.Bean.extend({
                sync: sync,
                apiModule: 'Dashboards',
                module: 'Home'
            }),
            DashboardCollection = app.BeanCollection.extend({
                sync: sync,
                apiModule: 'Dashboards',
                module: 'Home',
                model: Dashboard
            });
        var dashCollection = new DashboardCollection();
        dashCollection.fetch({
            //Don't show alerts for this request
            showAlerts: false,
            success: function(data) {
                var pattern = /^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/;
                _.each(dashCollection.models, function(model) {
                    if (pattern.test(model.get('name'))) {
                        model.set('name', app.lang.get(model.get('name'), dashCollection.module || null));
                    }
                });
                self.$('[data-module=Home] .dashboardContainer').html(self.recentRowTemplate(dashCollection));
            }
        });
    },
    /**
     * Render list of modules
     * @private
     */
    _renderHtml: function() {
        if (!app.api.isAuthenticated() || app.config.appStatus == 'offline') return;

        // loadAdditionalComponents fires render before the private metadata is ready, check for this
        if( !(_.isEmpty(app.metadata.getStrings("mod_strings"))) ) {
            var self = this;
            this.module_list = {};
            if (app.metadata.getModuleNames(true, "read")) {
                _.each(app.metadata.getModuleNames(true, "read"), function(val) {
                    self.module_list[val] = val;
                });
            }
            this.module_list = this.completeMenuMeta(this.module_list);
            app.view.View.prototype._renderHtml.call(this);
            this.resetMenu();
            this.activeModule.set(app.controller.context.get("module"));
        }
    },

    completeMenuMeta: function(module_list) {
        var actions, meta, returnList = [], self = this, listLength,
            fullModuleList = app.metadata.getFullModuleList();
        _.each(module_list, function(value, key) {
            if (!_.isString(fullModuleList[value])) {
                return;
            }
            actions = {
                label: app.lang.get('LBL_MODULE_NAME', value),
                name: key
            };
            meta = app.metadata.getModule(key);
            if (meta && meta.menu && meta.menu.header) {
                actions.menu = self.filterAvailableMenuActions(meta.menu.header.meta);
            } else {
                actions.menu = [];
            }
            listLength = returnList.push(actions);
            actions.menuIndex = listLength - 1;
        });
        return returnList;
    },
    /**
     * Filters menu metadata by acls
     * @param Array menuMeta
     * @return {Array}
     */
    filterAvailableMenuActions: function(menuMeta){
        var result = [];
        _.each(menuMeta, function(menuItem){
            if(app.acl.hasAccess(menuItem.acl_action, menuItem.acl_module)) {
                result.push(menuItem);
            }
        });
        return result;
    },
    /**
     * Reset the module list to the full list
     */
    resetMenu: function() {
        this.$('.more').before(this.$('#module_list .more-drop-container').children());
    },
    /**
     * Resize the module list to the specified width and move the extra module names to the dropdown.
     * We first clone the module list, make adjustments, and then replace.
     * @param width
     */
    resize: function (width) {
        if (width <= 0) {
            return;
        }
        this.activeModule.set(app.controller.context.get("module"));

        var $activeInMore = this.$('.more').find('.dropdown.active');
        if ($activeInMore.length >0){
            //show the drop down toggle and hide the more link
            $activeInMore.find('.btn-group').show();
            $activeInMore.find('.moreLink').hide();
            this.$el.find('.dropdown.more').before($activeInMore);
        }

        var $moduleList = this.$el.find('#module_list'),
            $moduleListClone = $moduleList.clone(),
            $cloneContainer = $('<div></div>');
        // make the cloned module list visible but away from user's view to accurately calculate width
        $cloneContainer
            .css({
                position: 'absolute',
                top: '-9999px',
                display: 'block'
            })
            .append($moduleListClone);

        this.$el.append($cloneContainer);

        //TODO: ie Compatible, scrollable dropdown for low-res. window
        //TODO: Theme Compatible, Filtered switching menu
        //TODO: User preferences maximum menu count
        if($moduleListClone.outerWidth(true) >= width){
            this.removeModulesFromList($moduleListClone, width);
        } else {
            this.addModulesToList($moduleListClone, width);
        }

        // replace the module list with the modified cloned list
        $moduleList.remove();
        this.$el.append($moduleListClone);
        $cloneContainer.remove();
    },

    /**
     * Move modules from the dropdown to the list to fit the specified width
     * @param $modules
     * @param width
     */
    addModulesToList: function($modules, width) {
        var $dropdown = $modules.find('.more-drop-container'),
            $moduleToInsert = $dropdown.children("li:first"),
            $more = $modules.find('.more'),
            $lastModuleInList, $nextModule,
            currentWidth = $modules.outerWidth(true);

        while ((currentWidth < width) && ($dropdown.children().length > 0)){
            $nextModule = $moduleToInsert.next();

            //show the drop down toggle and hide the more link
            $moduleToInsert.find('.btn-group').show();
            $moduleToInsert.find('.moreLink').hide();

            // add the modules in order
            $lastModuleInList = $more.prev();
            if (this.activeModule.isActive($lastModuleInList) && !this.activeModule.isNext($moduleToInsert)) {
                $lastModuleInList.before($moduleToInsert);
            } else {
                $more.before($moduleToInsert);
            }

            currentWidth = $modules.outerWidth(true);
            $moduleToInsert = $nextModule;

            // remove the last added module if the width is wider than desired
            if (currentWidth >= width) {
                this.removeModulesFromList($modules, width);
                break;
            }
        }

        if( $dropdown.children().length === 0 && $modules.find('.dropdown').is(":visible") ) {
            this.$('.more').hide();
        }
    },

    /**
     * Move modules from the list to the dropdown to fit the specified width
     * @param $modules
     * @param width
     */
    removeModulesFromList: function($modules, width) {
        var $dropdown = $modules.find('.more-drop-container'),
            $module = $modules.find('.more').prev(),
            $next, currentWidth = $modules.outerWidth(true),

            // If we have an active module, # of persistent tabs = active module + sugarcube + "more" button
            persistentTabs = this.activeModule.isActive($module) ? 3 : 2;

        while (currentWidth >= width && ($modules.children().length - persistentTabs) > 0) {
            // home and currently active module should not be removed from the list
            if (this.activeModule.isActive($module) || $module.hasClass('Home')) {
                $module = $module.prev();
            }

            $next = $module.prev();
            $dropdown.prepend($module);
            //hide the drop down toggle and show the more link
            $module.find('.btn-group').hide();
            $module.find('.moreLink').show();

            currentWidth = $modules.outerWidth(true);
            $module = $next;
        }
        if( $dropdown.children().length !== 0 && $modules.find('.dropdown').is(":visible") ) {
            this.$('.more').show();
        }
    },

    _setActiveModule:function (parent) {
        return {
            _class:'active', //class to indicate the active module
            _next:null, //the module next to the active module
            _moduleList:parent,

            /**
             * Set the specified module as the active module
             * @param module
             */
            set:function (module) {
                var $modules, $module, $next,
                    updateNav = true,
                    // Name of the module this module is mapped to, if it exists
                    mapped;
                if (app.controller && app.controller.layout && app.controller.layout.meta && !_.isUndefined(app.controller.layout.meta.updateNav)) {
                    updateNav = app.controller.layout.meta.updateNav;
                }
                if (module) {
                    this.reset();

                    $modules = this._moduleList.$('#module_list');
                    $module = $modules.find("[data-module='" + module + "']");
                    // If this module doesn't have a menu see if there is a tab mapping
                    if ($module.length < 1) {
                        mapped = app.metadata.getTabMappedModule(module);

                        // If the mapped module is different from the module, get
                        // the mapped module element if it exists
                        if (mapped !== module) {
                            $module = $modules.find("[data-module='" + mapped + "']");
                            updateNav = $module.length === 0;
                        }
                        if (updateNav) {
                            module = mapped;
                            // create the menu and add it
                            var moduleList = {};
                            moduleList[module] = app.metadata.getFullModuleList()[module];

                            var meta = this._moduleList.completeMenuMeta(moduleList);
                            if (!_.isUndefined(meta[0])) {
                                meta[0].menuIndex = -1;
                                var singleMenuTemplate = app.template.get(this._moduleList.name + '.singlemenuPartial');
                                this._moduleList.$el.find('.dropdown.more').before(singleMenuTemplate(meta[0]));
                                $module = $modules.find("[data-module='" + module + "']");
                            }
                        }
                    }

                    $module.addClass(this._class);

                    // remember which module is supposed to be next to the active module so that
                    // ordering can be preserved while modules are removed and added to the list
                    if (!this._next) {
                        $next = $module.next();
                        if ($next.hasClass('more')) {
                            $next = $modules.find('.more-drop-container li:first');
                        }
                        this._next = $next.attr('class');
                    }
                }
            },

            /**
             * Is this module the active module?
             * @param $module
             * @return {Boolean}
             */
            isActive:function ($module) {
                return $module.hasClass(this._class);
            },

            /**
             * Is this module supposed to be next to the the active module?
             * @param $module
             * @return {Boolean}
             */
            isNext:function ($module) {
                return (this._next === $module.attr('class'));
            },

            /**
             * Clear active modules and move anything out of order back to where it belongs
             */
            reset:function () {
                this.resetActive();
                this._next = null;
                this._moduleList.$('.dropdown.' + this._class).removeClass(this._class);
            },
            /**
             * This function returns active module nodes in the wrong place back to where they belong
             * and deactivates them
             */
            resetActive:function () {
                var $activeNode = this._moduleList.$('.dropdown.' + this._class);
                // no point in moving
                if ($activeNode.length < 1) return;
                var beforeIndex = $activeNode.prev().data('menuindex');
                var activeIndex = $activeNode.data('menuindex');
                var $afterNode = this._moduleList.$('[data-menuindex=' + (activeIndex + 1) + ']');

                if (activeIndex == -1) {
                    // this doesn't belong in the list at all normally so remove it
                    $activeNode.remove();
                }
                if (beforeIndex != activeIndex - 1 && activeIndex !== 1) {
                    $afterNode.before($activeNode);
                    // this node needs to go into the more so toggle its styles
                    if ($activeNode.parents().hasClass('more')) {
                        // hide the drop down toggle and show the more link
                        $activeNode.find('.btn-group').hide();
                        $activeNode.find('.moreLink').show();
                        $activeNode.find('.moreLink').css('display', 'block');
                    }
                }
            }
        };
    }
})
