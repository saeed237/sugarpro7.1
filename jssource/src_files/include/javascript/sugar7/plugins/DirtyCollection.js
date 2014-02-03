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
(function(app) {
    app.events.on("app:init", function() {

        /**
         * This plugin enables tracking of models that are dirty in a collection
         *
         * This is currently only used in the Forecasts Module
         */
        app.plugins.register('DirtyCollection', ['view'], {

            /**
             * A Collection to keep track of all the dirty models
             */
            dirtyModels: new Backbone.Collection(),

            /**
             * If the timeperiod is changed and we have dirtyModels, keep the previous one to use if they save the models
             */
            dirtyTimeperiod: undefined,

            /**
             * If the User is changed and we have dirtyModels, keep the previous one to use if they save the models
             */
            dirtyUser: undefined,

            /**
             * Can we edit the dirtyUser worksheet
             */
            dirtyCanEdit: undefined,

            /**
             * Attach code for when the plugin is registered on a view
             *
             * @param component
             * @param plugin
             */
            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.attachListeners();
                }, this);
            },

            onDetach: function() {
                this.dirtyModels.off(null, null, this);
            },

            /**
             * Attach the Listeners
             */
            attachListeners: function() {
                this.collection.on('reset', this.cleanUpDirtyModels, this);
                this.collection.on("change", this._collectionChangeAddToDirtyModels, this);
            },

            _collectionChangeAddToDirtyModels: function(model) {
                if (_.isUndefined(this.dirtyTimeperiod) || _.isUndefined(this.dirtyUser)) {
                    var ctx = this.context.parent || this.context;
                    this.dirtyTimeperiod = ctx.get('selectedTimePeriod');
                    this.dirtyUser = ctx.get('selectedUser');
                    this.dirtyCanEdit = (this.dirtyUser.id == app.user.get('id'));;
                }
                this.dirtyModels.add(model);
            },

            /**
             * Is this worksheet dirty or not?
             * @return {boolean}
             */
            isDirty: function() {
                return (this.dirtyModels.length > 0);
            },

            /**
             * Clean Up the Dirty Modules Collection and dirtyVariables
             */
            cleanUpDirtyModels: function() {
                // clean up the dirty records and variables
                this.dirtyModels.reset();
                this.dirtyTimeperiod = undefined;
                this.dirtyUser = undefined;
                this.dirtyCanEdit = undefined;

                // TODO: add an event here to trigger when this happens, for a possible undo support
            }
        });
    });
})(SUGAR.App);
