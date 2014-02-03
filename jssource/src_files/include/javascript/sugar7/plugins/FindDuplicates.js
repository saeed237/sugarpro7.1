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
        var createDuplicateCollection = function(dupeCheckModel, module) {
            var collection = app.data.createBeanCollection(module || this.module),
                collectionSync = collection.sync;
            _.extend(collection, {
                /**
                 * Duplicate check model.
                 *
                 * @property
                 */
                dupeCheckModel: dupeCheckModel,

                /**
                 * {@inheritDoc}
                 *
                 * Override endpoint in order to fetch custom api.
                 */
                sync: function(method, model, options) {
                    options = options || {};
                    if (_.isEmpty(model.filterDef)) {
                        options.endpoint = _.bind(this.endpoint, this);
                    }
                    collectionSync(method, model, options);
                },

                /**
                 * {@inheritDoc}
                 *
                 * Custom endpoint for duplicate check.
                 */
                endpoint: function(method, model, options, callbacks) {
                    //Dupe Check API requires POST
                    var url = app.api.buildURL(this.module, 'duplicateCheck');
                    return app.api.call('create', url, this.dupeCheckModel.attributes, callbacks);
                }
            });
            return collection;
        };

        app.plugins.register('FindDuplicates', ['view'], {
            /**
             * {@inheritDoc}
             *
             * Bind the find duplicate button handler.
             */
            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.context.on('button:find_duplicates_button:click', this.findDuplicatesClicked, this);
                });
            },

            /**
             * Handles the click event, and open the duplicate list view in the drawer.
             */
            findDuplicatesClicked: function() {
                this.findDuplicates(this.model);
            },

            /**
             * Open duplicate list view on drawer with duplicates collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             */
            findDuplicates: function(dupeCheckModel) {
                app.drawer.open({
                    layout: 'find-duplicates',
                    context: {
                        layoutName: 'records',
                        dupelisttype: 'dupecheck-list-multiselect',
                        collection: this.createDuplicateCollection(dupeCheckModel),
                        model: app.data.createBean(this.module)
                    }
                }, _.bind(function(refresh, primaryRecord) {
                    if (refresh && dupeCheckModel.id === primaryRecord.id) {
                        app.router.refresh();
                    } else if (refresh) {
                        app.navigate(this.context, primaryRecord);
                    }
                }, this));
            },

            /**
             * Create Duplicates list collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             * @return {Backbone.Collection} Duplicate check collection.
             */
            createDuplicateCollection: createDuplicateCollection,

            /**
             * {@inheritDoc}
             *
             * Clean up associated event handlers.
             */
            onDetach: function(component, plugin) {
                this.context.off('button:find_duplicates_button:click', this.findDuplicatesClicked, this);
            }
        });

        app.plugins.register('FindDuplicates', ['layout'], {
            /**
             * Create Duplicates list collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             * @return {Backbone.Collection} Duplicate check collection.
             */
            createDuplicateCollection: createDuplicateCollection
        });
    });
})(SUGAR.App);
