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
({
    extendsFrom: 'ListView',

    /**
     * Filtered and sorted collection set.
     * @property
     */
    filteredCollection: [],

    /**
     * Typed search keyword.
     * @property
     */
    searchTerm: '',

    /**
     * Convert the available filter to the regular expression.
     * @property
     */
    _patternToReg: {
        startsWith: '^(term)',
        endsWith: '(term)$',
        contains: '(term)'
    },

    /**
     * Filter the metadata in order to initiate the searchable fields.
     * @protected
     */
    _initFilter: function() {
        var filter = this._filter || _.chain(this.getFields())
            .filter(function(field) {
                return field.filter;
            })
            .map(function(field) {
                return {
                    name: field.name,
                    label: app.lang.get(field.label, this.module),
                    filter: field.filter
                };
            }, this)
            .value();
        this.context.trigger('filteredlist:filter:set', _.pluck(filter, 'label'));

        if (_.isEmpty(filter)) {
            return;
        }
        this._filter = filter;
    },

    /**
     * Filtering collection that matches with search term.
     * In order to activate filtering on the field,
     * the filter term should be defined in the metadata.
     * There are three type of filter type (startsWith, contains, endsWith).
     *
     * Examples:
     *
     * <pre><code>
     * array(
     *     'type' => 'base',
     *     'name' => 'field_name',
     *     'filter' => 'startsWith',
     *     ),
     * array(
     *     'type' => 'base',
     *     'name' => 'before_field_value',
     *     'filter' => 'contains',
     *     ),
     * array(
     *     'type' => 'base',
     *     'name' => 'datetime',
     *     'filter' => 'endsWith',
     *     ),
     * </code></pre>
     */
    filterCollection: function() {
        var term = this.searchTerm,
            filter = this._filter;

        if (!_.isEmpty(term) && _.isString(term)) {
            this.filteredCollection = this.collection.filter(function(model) {
                return _.some(filter, function(params) {
                    var pattern = this._patternToReg[params.filter].replace('term', term),
                        tester = new RegExp(pattern, 'i');
                    return tester.test(model.get(params.name));
                }, this);
            }, this);
        }
    },

    /**
     * Set the current search term and then reload the table.
     * @param {String} term Search term.
     */
    setSearchTerm: function(term) {
        this.searchTerm = term;
        this._renderData();
    },

    /**
     * {@inheritDoc}
     *
     * Sort the collection based on user input.
     * In order to activate sorting on the field,
     * 'sortable' should be defined in the metadata.
     *
     * <pre><code>
     * array(
     *     'type' => 'base',
     *     'name' => 'field_name',
     *     'sortable' => true,
     *     ),
     * </code></pre>
     */
    setOrderBy: function(event) {
        this._super('setOrderBy', [event]);
        this.collection.comparator = function(model) {
            return model.get(this.orderBy.field);
        };
        if (this.orderBy.direction === 'desc') {
            this.collection.sort({silent: true});
            this.collection.models.reverse();
            this.collection.trigger('sort', this.collection);
        } else {
            this.collection.sort();
        }
    },

    /**
     * {@inheritDoc}
     */
    bindDataChange: function() {
        this.on('render', this._initFilter, this);
        if (this.collection) {
            this.collection.on('reset sort', this._renderData, this);
        }
        this.context.on('filteredlist:search:fired', this.setSearchTerm, this);
    },

    /**
     * Refresh the filtered collection and then refresh the html.
     * @protected
     */
    _renderData: function() {
        this.filteredCollection = this.collection.models;
        this.filterCollection();
        this.render();
    }
})
