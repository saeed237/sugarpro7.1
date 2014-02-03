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
    /**
     * @class View.DupecheckListView
     * @alias SUGAR.App.view.views.DupecheckListView
     * @extends View.FlexListView
     */
    extendsFrom: 'FlexListView',
    plugins: ['ListColumnEllipsis', 'ListDisableSort', 'ListRemoveLinks'],
    collectionSync: null,
    displayFirstNColumns: 4,
    additionalTableClasses: null,

    /**
     * {@inheritDoc}
     *
     * Use dupecheck-list metadata by default - subviews will just extend.
     */
    initialize: function(options) {
        var dupeListMeta = app.metadata.getView(options.module, 'dupecheck-list') || {};
        options.meta = _.extend({}, dupeListMeta, options.meta || {});

        this._super('initialize', [options]);
        this.context.on('dupecheck:fetch:fire', this.fetchDuplicates, this);
    },

    bindDataChange: function() {
        this.collection.on('reset', function() {
            this.context.trigger('dupecheck:collection:reset');
        }, this);
        this._super('bindDataChange');
   },

    _renderHtml: function() {
        var classesToAdd = 'duplicates highlight';
        app.view.invokeParent(this, {type: 'view', name: 'flex-list', method: '_renderHtml'});
        if (this.additionalTableClasses) {
            classesToAdd = classesToAdd + ' ' + this.additionalTableClasses;
        }
        this.$('table.table-striped').addClass(classesToAdd);
    },

    /**
     * Fetch the duplicate collection.
     *
     * @param {Backbone.Model} model Duplicate check model.
     * @param {Object} options Fetch options.
     */
    fetchDuplicates: function(model, options) {
        this.collection.dupeCheckModel = model;
        this.collection.fetch(options);
    }
})
