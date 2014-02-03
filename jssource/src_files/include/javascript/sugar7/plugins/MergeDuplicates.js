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

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('MergeDuplicates', ['view'], {

            /**
             * Minimum number of records for merging.
             *
             * @property
             */
            _minRecordsToMerge: 2,

            /**
             * Maximum number of records for merging.
             *
             * @property
             */
            _maxRecordsToMerge: 5,

            /**
             * Merge records handler.
             *
             * @param {Backbone.Collection} mergeCollection Set of merging records.
             * @param {Backbone.Model} primaryRecord (Optional) Default Primary Model.
             */
            mergeDuplicates: function(mergeCollection, primaryRecord) {
                if (_.isEmpty(mergeCollection)) {
                    return;
                }
                var primaryRecordId = null;
                if (!_.isEmpty(primaryRecord)) {
                    mergeCollection.add(primaryRecord, {silent: true});
                    primaryRecordId = primaryRecord.id;
                }
                var models = this.validateModelsForMerge(mergeCollection);

                if (this.validateSize(models) === false) {
                    return;
                }

                app.drawer.open({
                    layout: 'merge-duplicates',
                    context: {
                        primaryRecord: primaryRecord ? primaryRecord : null,
                        selectedDuplicates: models
                    }
                }, _.bind(function(refresh, primaryRecord) {
                    if (refresh) {
                        this.trigger('mergeduplicates:complete', primaryRecord);
                        mergeCollection.reset();
                    } else {
                        mergeCollection.remove(primaryRecordId);
                    }
                }, this));
            },

            /**
             * Check size for models selected for merge.
             *
             * @param {Array} models Array of merging record set.
             * @return {Boolean} True only if it contains valid size of collection.
             */
            validateSize: function(models) {
                var isValidSize = models.length && models.length >= this._minRecordsToMerge &&
                    models.length <= this._maxRecordsToMerge;

                if (isValidSize) {
                    return true;
                }

                var msg = app.lang.get('TPL_MERGE_INVALID_NUMBER_RECORDS',
                    this.module,
                    {
                        minRecords: this._minRecordsToMerge,
                        maxRecords: this._maxRecordsToMerge
                    }
                );

                app.alert.show('invalid-record-count', {
                    level: 'error',
                    messages: msg,
                    autoClose: true
                });

                return false;
            },

            /**
             * Check access for models selected for merge.
             *
             * @param {Data.Collection} Merge Collection to check access for merge.
             * @return {Array} Models with access.
             */
            validateModelsForMerge: function(mergeCollection) {
                return _.filter(mergeCollection.models, function(model) {
                    return _.every(['view', 'edit', 'delete'], function(acl) {
                        return app.acl.hasAccessToModel(acl, model);
                    });
                }, this);
            }
        });
    });
})(SUGAR.App);
