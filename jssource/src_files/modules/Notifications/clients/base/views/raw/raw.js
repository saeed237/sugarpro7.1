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
    plugins: ['Timeago'],

    events: {
        'click span.name': 'toggleName'
    },

    /**
     * {@inheritdoc}
     */
    initialize: function (options) {
        var meta = app.metadata.getView(options.module, 'raw') || {};
        options.meta = _.extend({}, meta, options.meta || {});

        this._super('initialize', [options]);

        this._initCollection();
    },

    /**
     * Initialize collection.
     *
     * @return {View.Raw} Instance of this view.
     * @protected
     */
    _initCollection: function () {
        this.collection.options = {params: {order_by: 'date_entered:desc'}};

        this.collection.filterDef = [];
        this.collection.filterDef.push({'$owner': ''});

        // FIXME: the code bellow should be replaced by filter definitions usage
        // on metadata when Filter API has a better support for handling this
        // kind of date operations.
        if (_.isUndefined(this.meta.filter_type)) {
            return this;
        }

        var startDate = new Date();
        startDate.setHours(0, 0, 0);
        startDate.toISOString();

        var endDate = new Date();
        endDate.setHours(23, 59, 59);
        endDate.toISOString();

        var defaultFilters = {
            today: {date_entered: {$dateBetween: [startDate, endDate]}},
            recent: {date_entered: {$lt: startDate}}
        };

        this.collection.filterDef.push(defaultFilters[this.meta.filter_type]);

        return this;
    },

    /**
     * {@inheritdoc}
     */
    bindDataChange: function () {
        if (this.collection) {
            this.collection.on('reset', function() {
                this.render();
            }, this);
        }
    },

    /**
     * Expand/collapse name column.
     */
    toggleName: function (e) {
        this.$(e.currentTarget).toggleClass('expanded');
    }
})
