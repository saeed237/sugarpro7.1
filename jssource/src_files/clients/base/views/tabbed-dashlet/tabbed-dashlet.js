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
/**
 * Tabbed dashlet is an abstraction that allows new tabbed dashlets to be
 * easily created based on a metadata driven configurable set of tabs, where
 * each new tab is created under a tabs array, where a specific set of
 * properties can be defined.
 *
 * Supported properties:
 *
 * - {Boolean} active If specific tab should be active by default.
 * - {String} filter_applied_to Date field to be used on date switcher, defaults
 *   to date_entered.
 * - {Array} filters Array of filters to be applied.
 * - {String} label Tab label.
 * - {Array} labels Array of labels (singular/plural) to be applied when
 *   LBL_MODULE_NAME_SINGULAR and LBL_MODULE_NAME aren't available or there's a
 *   need to use custom labels depending on the number of records available.
 * - {String} link Relationship link to be used if we're on a record view
 *   context, leading to only associated records being shown.
 * - {String} module Module from which the records are retrieved.
 * - {String} order_by Sort records by field.
 * - {String} record_date Date field to be used to print record date, defaults
 *   to 'date_entered' if none supplied.
 *
 * Example:
 * <pre><code>
 * // ...
 * 'tabs' => array(
 *     array(
 *         'filter_applied_to' => 'date_entered',
 *         'filters' => array(
 *             'type' => array('$equals' => 'out'),
 *         ),
 *         'labels' => array(
 *             'singular' => 'LBL_DASHLET_EMAIL_OUTBOUND_SINGULAR',
 *             'plural' => 'LBL_DASHLET_EMAIL_OUTBOUND_PLURAL',
 *         ),
 *         'link' => 'emails',
 *         'module' => 'Emails',
 *     ),
 *     //...
 * ),
 * //...
 * </code></pre>
 *
 * @class View.Views.BaseTabbedDashletView
 * @alias SUGAR.App.view.views.BaseTabbedDashletView
 */
({
    plugins: ['Dashlet', 'Timeago'],

    events: {
        'click [data-action=show-more]': 'showMore',
        'click [data-action=tab-switcher]': 'tabSwitcher',
        'click [data-action=visibility-switcher]': 'visibilitySwitcher'
    },

    /**
     * {@inheritDoc}
     */
    initDashlet: function() {
        if (this.meta.config) {
            return;
        }

        this.collection = new Backbone.Collection();

        this._initMaxHeightTarget();
        this._initEvents();
        this._initTabs();
        this._initTemplates();
    },

    /**
     * Initialize max height target element by overriding it's value and
     * setting it to a specific tab inner element.
     *
     * @return {View.Views.BaseTabbedDashletView} Instance of this view.
     * @template
     * @protected
     */
    _initMaxHeightTarget: function() {
        this.maxHeightTarget = this.meta.max_height_target || 'div.tab-content';

        return this;
    },

    /**
     * Initialize events.
     *
     * @return {View.Views.BaseTabbedDashletView} Instance of this view.
     * @template
     * @protected
     */
    _initEvents: function() {
        this.settings.on('change:filter', this.loadData, this);

        return this;
    },

    /**
     * Initialize tabs.
     *
     * @return {View.Views.BaseTabbedDashletView} Instance of this view.
     * @protected
     */
    _initTabs: function() {
        this.tabs = [];

        _.each(this.dashletConfig.tabs, function(tab, index) {
            if (tab.active) {
                this.settings.set('activeTab', index);
            }

            var collection = this._createCollection(tab);
            if (_.isNull(collection)) {
                return;
            }

            this.tabs[index] = tab;
            this.tabs[index].collection = collection;
            this.tabs[index].relate = _.isObject(collection.link);
            this.tabs[index].record_date = tab.record_date || 'date_entered';

            if (tab.include_child_items) {
                // FIXME: this logic should be dynamic instead of depending on
                // specific modules
                this.tabs[index].include_child_items = this.module === 'Accounts' && _.contains(['Calls', 'Meetings'], tab.module);
            }

        }, this);

        return this;
    },

    /**
     * Initialize templates.
     *
     * This will get the templates from either the current module (since we
     * might want to customize it per module) or from core templates.
     *
     * Please define your templates on:
     *
     * - `custom/clients/{platform}/view/tabbed-dashlet/tabs.hbs`
     * - `custom/clients/{platform}/view/tabbed-dashlet/toolbar.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/tabbed-dashlet/tabs.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/tabbed-dashlet/toolbar.hbs`
     *
     * @return {View.Views.BaseTabbedDashletView} Instance of this view.
     * @template
     * @protected
     */
    _initTemplates: function() {
        this._tabsTpl = app.template.getView(this.name + '.tabs', this.module) ||
            app.template.getView(this.name + '.tabs') ||
            app.template.getView('tabbed-dashlet.tabs', this.module) ||
            app.template.getView('tabbed-dashlet.tabs');

        this._toolbarTpl = app.template.getView(this.name + '.toolbar', this.module) ||
            app.template.getView(this.name + '.toolbar') ||
            app.template.getView('tabbed-dashlet.toolbar', this.module) ||
            app.template.getView('tabbed-dashlet.toolbar');

        return this;
    },

    /**
     * Retrieve records template.
     *
     * This will get the template from either the active tab associated module,
     * from the current module (since we might want to customize it per module)
     * or from core templates.
     *
     * Please define your template on:
     *
     * - `custom/clients/{platform}/view/tabbed-dashlet/records.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/tabbed-dashlet/records.hbs`
     *
     * @param {String} module Module name.
     * @return {Function} Template function.
     * @protected
     */
    _getRecordsTemplate: function(module) {
        this._recordsTpl = this._recordsTpl || {};

        if (!this._recordsTpl[module]) {
            this._recordsTpl[module] = app.template.getView(this.name + '.records', module) ||
                app.template.getView(this.name + '.records', this.module) ||
                app.template.getView(this.name + '.records') ||
                app.template.getView('tabbed-dashlet.records', this.module) ||
                app.template.getView('tabbed-dashlet.records');
        }

        return this._recordsTpl[module];
    },

    /**
     * Create collection based on tab properties and current context,
     * furthermore if supplied tab has a valid 'link' property a related
     * collection will be created instead.
     *
     * @param {Object} tab Tab properties.
     * @return {Data.BeanCollection} A new instance of bean collection or null
     *   if we cannot access module metadata.
     * @protected
     */
    _createCollection: function(tab) {
        if (this.context.parent) {
            var module = this.context.parent.get('module');
        } else {
            var module = this.module;
        }

        var meta = app.metadata.getModule(module);

        if (_.isUndefined(meta)) {
            return null;
        }

        var options = {};
        if (meta.fields[tab.link] && meta.fields[tab.link].type === 'link') {
            options = {
                link: {
                    name: tab.link,
                    bean: this.model
                }
            };
        }

        var collection = app.data.createBeanCollection(tab.module, null, options);

        return collection;
    },

    /**
     * Retrieves collection options for a specific tab.
     *
     * @param {Integer} index Tab index.
     * @return {Object} Collection options.
     * @protected
     */
    _getCollectionOptions: function(index) {
        var tab = this.tabs[index],
            options = {
                limit: this.settings.get('limit'),
                offset: 0,
                params: {
                    order_by: tab.order_by || null,
                    include_child_items: tab.include_child_items || null
                }
            };

        if (tab.module != 'Meetings' && tab.module != 'Calls') {
            options.myItems = this.settings.get('visibility') === 'user';
        }
        
        return options;
    },

    /**
     * Retrieves collection filters for a specific tab.
     *
     * @param {Integer} index Tab index.
     * @return {Array} Collection filters.
     * @protected
     */
    _getCollectionFilters: function(index) {
        var tab = this.tabs[index],
            filters = [];

        _.each(tab.filters, function(condition, field) {
            var filter = {};
            filter[field] = condition;

            filters.push(filter);
        });

        if ((tab.module === 'Meetings' || tab.module === 'Calls')
            && this.settings.get('visibility') === 'user') {
            filters.push({
                "$or":[{"assigned_user_id":app.user.id},
                       {"users.id":app.user.id}]
            });
        }
        
        return filters;
    },

    /**
     * Override this method to provide custom filters.
     *
     * @param {Integer} index Tab index.
     * @return {Array} Custom filters.
     * @template
     * @protected
     */
    _getFilters: function(index) {
        return [];
    },

    /**
     * Fetch data for view tabs based on selected options and filters.
     *
     * @param {Object} options Options that are passed to collection/model's
     *   fetch method.
     */
    loadData: function(options) {
        options = options || {};

        if (this.disposed || this.meta.config) {
            return;
        }

        var self = this,
            totalFetches = 0;

        _.each(this.tabs, function(tab, index) {
            tab.collection.options = this._getCollectionOptions(index);
            tab.collection.filterDef = _.union(
                this._getCollectionFilters(index),
                this._getFilters(index)
            );

            tab.collection.fetch({
                relate: tab.relate,
                complete: function() {
                    totalFetches++;

                    tab.collection.dataFetched = true;

                    if (self.disposed || totalFetches < _.size(self.tabs)) {
                        return;
                    }

                    self.collection = self.tabs[self.settings.get('activeTab')].collection;
                    self.render();

                    if (_.isFunction(options.complete)) {
                        options.complete.call(this);
                    }
                }
            });
        }, this);
    },

    /**
     * Show more records for current collection.
     */
    showMore: function() {
        var self = this;

        this.collection.paginate({
            limit: this.settings.get('limit'),
            add: true,
            success: function() {
                if (!self.disposed) {
                    self.render();
                }
            }
        });
    },

    /**
     * Event handler for tab switcher.
     *
     * @param {Event} event Click event.
     */
    tabSwitcher: function(event) {
        var index = this.$(event.currentTarget).data('index');
        if (index === this.settings.get('activeTab')) {
            return;
        }

        this.settings.set('activeTab', index);
        this.collection = this.tabs[index].collection;
        this.render();
    },

    /**
     * Event handler for visibility switcher.
     *
     * @param {Event} event Click event.
     */
    visibilitySwitcher: function(event) {
        var visibility = this.$(event.currentTarget).val();
        if (visibility === this.settings.get('visibility')) {
            return;
        }

        this.settings.set('visibility', visibility);
        this.layout.loadData();
    },

    /**
     * {@inheritDoc}
     *
     * New model related properties are injected into each model:
     *
     * - {String} record_date Date field to be used to print record
     *   date, defaults to date_entered, though it can be overridden on
     *   metadata.
     */
    _renderHtml: function() {
        if (this.meta.config) {
            this._super('_renderHtml');
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];

        _.each(this.collection.models, function(model) {
            model.set('record_date', model.get(tab.record_date));
        }, this);

        var recordsTpl = this._getRecordsTemplate(tab.module);

        this.toolbarHtml = this._toolbarTpl(this);
        this.tabsHtml = this._tabsTpl(this);
        this.recordsHtml = recordsTpl(this);

        this._super('_renderHtml');
    },

    /**
     * {@inheritDoc}
     */
    _dispose: function() {
        _.each(this.tabs, function(tab) {
            tab.collection.off(null, null, this);
        });

        this._super('_dispose');
    }
})
