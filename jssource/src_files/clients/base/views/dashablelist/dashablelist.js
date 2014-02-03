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
/**
 * Dashablelist is a dashlet representation of a module list view. Users can
 * build dashlets of this type for any accessible and approved module with
 * their choice of columns from the list view for their chosen module.
 *
 * Options:
 * {String}  module             The module from which the records are
 *                              retrieved.
 * {String}  label              The string (i18n or hard-coded) representing
 *                              the dashlet name that the user sees.
 * {Array}   display_columns    The field names of the columns to include in
 *                              the list view.
 * {String}  my_items           Allows for limiting results to only records
 *                              assigned to the user. If '0' or undefined, then
 *                              all records may be returned. If '1', then
 *                              records assigned to the user will be returned.
 * {String}  favorites          Allows for limiting the results to only records
 *                              the user has favorited. If '0' or undefined,
 *                              then all records may be returned. If '1', then
 *                              records the user has favorited will be
 *                              returned.
 * {Integer} limit              The number of records to retrieve for the list
 *                              view.
 * {Integer} auto_refresh       How frequently (in minutes) that the dashlet
 *                              should refresh its data collection.
 *
 * Example:
 * <pre><code>
 * // ...
 * array(
 *     'module'          => 'Accounts',
 *     'label'           => 'LBL_MODULE_NAME',
 *     'display_columns' => array(
 *         'name',
 *         'phone_office',
 *         'billing_address_country',
 *     ),
 *     'my_items'        => '0',
 *     'favorites'       => '1',
 *     'limit'           => 15,
 *     'auto_refresh'    => 5,
 * ),
 * //...
 * </code></pre>
 *
 * @class View.BaseDashablelistView
 * @alias SUGAR.App.view.views.BaseDashablelistView
 * @extends View.BaseListView
 */
({
    extendsFrom: 'ListView',

    /**
     * The plugins used by this view.
     */
    plugins: ['Dashlet'],

    /**
     * The default settings for a list view dashlet.
     *
     * @property {Object}
     */
    _defaultSettings: {
        limit: 5,
        my_items: '1',
        favorites: '0'
    },

    /**
     * Modules that are permanently blacklisted so users cannot configure a
     * dashlet for these modules.
     *
     * @property {Array}
     */
    moduleBlacklist: ['Home'],

    /**
     * Cache of the modules a user is allowed to see.
     *
     * The keys are the module names and the values are the module names after
     * resolving them against module and/or app strings. The cache logic can be
     * seen in {@link BaseDashablelistView#_getAvailableModules}.
     *
     * @property {Object}
     */
    _availableModules: {},

    /**
     * Cache of the fields found in each module's list view definition.
     *
     * This hash is multi-dimensional. The first set of keys are the module
     * names and the values are objects where the keys are the field names and
     * the values are the field names after resolving them against module
     * and/or app strings. The cache logic can be seen in
     * {@link BaseDashablelistView#_getAvailableColumns}.
     *
     * @property {Object}
     */
    _availableColumns: {},

    /**
     * {@inheritDoc}
     *
     * Append lastStateID on metadata in order to active user cache.
     */
    initialize: function(options) {
        options.meta = _.extend({}, options.meta, {
            last_state: {
                id: 'dashable-list'
            }
        });
        this._super('initialize', [options]);
    },

    /**
     * Must implement this method as a part of the contract with the Dashlet
     * plugin. Kicks off the various paths associated with a dashlet:
     * Configuration, preview, and display.
     *
     * @param {String} view The name of the view as defined by the `oninit`
     *   callback in {@link DashletView#onAttach}.
     */
    initDashlet: function(view) {
        if (this.meta.config) {
            // keep the display_columns and label fields in sync with the selected module when configuring a dashlet
            this.settings.on('change:module', function(model, moduleName) {
                var label = (model.get('my_items') == '1') ? 'TPL_DASHLET_MY_MODULE' : 'LBL_MODULE_NAME';
                model.set('label', app.lang.get(label, moduleName, {module: moduleName}));
                this._updateDisplayColumns();
            }, this);
        }
        this._initializeSettings();
        // the pivot point for the various dashlet paths
        if (this.meta.config) {
            this._configureDashlet();
        } else {
            this._displayDashlet();
        }
    },

    /**
     * Returns a custom label for this dashlet.
     *
     * @returns {String}
     */
    getLabel: function() {
        var module = this.settings.get('module') || this.context.get('module');
        return app.lang.get(this.settings.get('label'), module, {module: module});
    },

    /**
     * Certain dashlet settings can be defaulted.
     *
     * Builds the available module cache by way of the
     * {@link BaseDashablelistView#_setDefaultModule} call. The module is set
     * after "my_items" because the value of "my_items" could impact the value
     * of "label" when the label is set in response to the module change while
     * in configuration mode (see the "module:change" listener in
     * {@link BaseDashablelistView#initDashlet}).
     *
     * @private
     */
    _initializeSettings: function() {
        if (!this.settings.get('limit')) {
            this.settings.set('limit', this._defaultSettings.limit);
        }
        if (!this.settings.get('my_items')) {
            this.settings.set('my_items', this._defaultSettings.my_items);
        }
        if (!this.settings.get('favorites')) {
            this.settings.set('favorites', this._defaultSettings.favorites);
        }
        this._setDefaultModule();
        if (!this.settings.get('label')) {
            this.settings.set('label', 'LBL_MODULE_NAME');
        }
    },

    /**
     * Sets the default module when a module isn't defined in the dashlet's
     * view definition.
     *
     * If the module was defined but it is not in the list of available
     * modules, then the first available module will be used.
     *
     * @private
     */
    _setDefaultModule: function() {
        var availableModules = _.keys(this._getAvailableModules()),
            definedModule = this.settings.get('module'),
            module = definedModule || this.context.get('module');
        if (!_.contains(availableModules, module)) {
            module = _.first(availableModules);
        }
        if (definedModule !== module) {
            this.settings.set('module', module);
        }
    },

    /**
     * Update the display_columns attribute based on the current module defined
     * in settings.
     *
     * This will mark, as selected, all fields in the module's list view
     * definition. Any existing options will be replaced with the new options
     * if the "display_columns" DOM field ({@link EnumField}) exists.
     *
     * @private
     */
    _updateDisplayColumns: function() {
        var availableColumns = this._getAvailableColumns(),
            columnsFieldName = 'display_columns',
            columnsField = this.getField(columnsFieldName);
        if (columnsField) {
            columnsField.items = availableColumns;
        }
        this.settings.set(columnsFieldName, _.keys(availableColumns));
    },

    /**
     * Perform any necessary setup before the user can configure the dashlet.
     *
     * Modifies the dashlet configuration panel metadata to allow it to be
     * dynamically primed prior to rendering.
     *
     * @private
     */
    _configureDashlet: function() {
        var availableModules = this._getAvailableModules(),
            availableColumns = this._getAvailableColumns();
        _.each(this.getFieldMetaForView(this.meta), function(field) {
            switch(field.name) {
                case 'module':
                    // load the list of available modules into the metadata
                    field.options = availableModules;
                    break;
                case 'display_columns':
                    // load the list of available columns into the metadata
                    field.options = availableColumns;
                    break;
            }
        });
    },

    /**
     * Gets all of the modules the current user can see.
     *
     * This is used for populating the module select and list view columns
     * fields. Filters any modules that are blacklisted.
     *
     * @return {Object} {@link BaseDashablelistView#_availableModules}
     * @private
     */
    _getAvailableModules: function() {
        if (_.isEmpty(this._availableModules) || !_.isObject(this._availableModules)) {
            this._availableModules = {};
            var allowedModules = _.difference(app.user.get('module_list'), this.moduleBlacklist);
            _.each(allowedModules, function(module) {
                var hasListView = !_.isEmpty(this.getFieldMetaForView(app.metadata.getView(module, 'list')));
                if (hasListView) {
                    this._availableModules[module] = app.lang.get('LBL_MODULE_NAME', module);
                }
            }, this);
        }
        return this._availableModules;
    },

    /**
     * Gets the correct list view metadata.
     *
     * This function takes into account if the chosen module is in backwards
     * compatibility mode, and returns the converted metadata.
     *
     * @param  {String} module
     * @return {Object}
     */
    _getListMeta: function(module) {
        var listMeta;
        if (app.metadata.getModule(module).isBwcEnabled) {
            listMeta = app.bwc.getLegacyMetadata(module, 'listviewdefs');
        } else {
            listMeta = app.metadata.getView(module, 'list');
        }
        return listMeta;
    },

    /**
     * Gets all of the fields from the list view metadata for the currently
     * chosen module.
     *
     * This is used for the populating the list view columns field and
     * displaying the list.
     *
     * @return {Object} {@link BaseDashablelistView#_availableColumns}
     * @private
     */
    _getAvailableColumns: function() {
        var columns = {},
            module = this.settings.get('module');
        if (!module) {
            return columns;
        }
        if (!_.isEmpty(this._availableColumns[module])) {
            return this._availableColumns[module];
        }

        _.each(this.getFieldMetaForView(this._getListMeta(module)), function(field) {
            columns[field.name] = app.lang.get(field.label || field.name, module);
        });
        this._availableColumns[module] = columns;
        return columns;
    },

    /**
     * Perform any necessary setup before displaying the dashlet.
     *
     * @private
     */
    _displayDashlet: function() {
        this.context.set('skipFetch', false);
        this.context.set('limit', this.settings.get('limit'));
        this._intializeFilter();
        // get the columns that are to be displayed and update the panel metadata
        var columns = this._getColumnsForDisplay();
        this.meta.panels = [{fields: columns}];
        this._startAutoRefresh();
    },

    /**
     * Sets the filter definition on the collection for retrieving the records
     * for the list view.
     *
     * A filter will be added if the dashlet is configured to only return
     * records assigned to the user or favorited by the user. The filters will
     * be collapsed with an `$and` clause if both filter options are on. Custom
     * filters are not supported.
     *
     * @private
     */
    _intializeFilter: function() {
        var filter = [];
        if (this.settings.get('my_items') === '1') {
            filter.push({'$owner': ''});
        }
        if (this.settings.get('favorites') === '1') {
            filter.push({'$favorite': ''});
        }
        this.context.get('collection').filterDef = (filter.length > 1) ? {'$and': filter} : filter;
    },

    /**
     * Gets the columns chosen for display for this dashlet list.
     *
     * The display_columns setting might not have been defined when the dashlet
     * is being displayed from a metadata definition, like is the case for
     * preview and the default dashablelist's that are defined. All columns for
     * the selected module are shown in these cases.
     *
     * @returns {Object[]} Array of objects defining the field metadata for
     *                     each column.
     * @private
     */
    _getColumnsForDisplay: function() {
        var columns = [],
            fields = this.getFieldMetaForView(this._getListMeta(this.settings.get('module')));
        if (!this.settings.get('display_columns')) {
            this._updateDisplayColumns();
        }
        _.each(this.settings.get('display_columns'), function(name) {
            var field = _.find(fields, function(field) {
                return field.name === name;
            }, this);
            var column = _.extend({name: name, sortable: true}, field || {});
            columns.push(column);
        }, this);
        return columns;
    },

    /**
     * Starts the automatic refresh of the dashlet.
     *
     * @private
     */
    _startAutoRefresh: function() {
        var refreshRate = parseInt(this.settings.get('auto_refresh'), 10);
        if (refreshRate) {
            this._stopAutoRefresh();
            this._timerId = setInterval(_.bind(function() {
                this.context.resetLoadFlag();
                this.layout.loadData();
            }, this), refreshRate * 1000 * 60);
        }
    },

    /**
     * Cancels the automatic refresh of the dashlet.
     * 
     * @private
     */
    _stopAutoRefresh: function() {
        if (this._timerId) {
            clearInterval(this._timerId);
        }
    },

    /**
     * {@inheritDoc}
     *
     * Calls {@link BaseDashablelistView#_stopAutoRefresh} so that the refresh will
     * not continue after the view is disposed.
     *
     * @private
     */
    _dispose: function() {
        this._stopAutoRefresh();
        this._super('_dispose');
    },

    /**
     * Gets the fields metadata from a particular view's metadata.
     * 
     * @param {Object} meta The view's metadata.
     * @return {Object[]} The fields metadata or an empty array.
     */
    getFieldMetaForView: function(meta) {
        meta = _.isObject(meta) ? meta : {};
        return !_.isUndefined(meta.panels) ? _.flatten(_.pluck(meta.panels, 'fields')) : [];
    }
})
