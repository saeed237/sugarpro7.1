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
    extendsFrom: 'ActivitystreamLayout',

    _previewOpened: false, //is the preview pane open?

    /**
     * Fetch and render activities when 'preview:render' event has been fired.
     */
    initialize: function(options) {
        app.view.invokeParent(this, {type: 'layout', name: 'activitystream', method: 'initialize', args:[options]});
        app.events.on("preview:render", this.fetchActivities, this);
        app.events.on('preview:open', function() {
            this._previewOpened = true;
        }, this);
        app.events.on('preview:close', function() {
            this._previewOpened = false;
            this.disposeAllActivities();
        }, this);
    },

    /**
     * Fetch and render activities.
     *
     * @param model
     * @param collection
     * @param fetch
     * @param previewId
     */
    fetchActivities: function(model, collection, fetch, previewId) {
        this.disposeAllActivities();
        this.collection.dataFetched = false;
        this.$el.hide();
        this.collection.reset();
        this.collection.resetPagination();
        this.collection.fetch({
            /*
             * Retrieve activities for the model that the user wants to preview
             */
            endpoint: function(method, collection, options, callbacks) {
                var url = app.api.buildURL(model.module, 'activities', {id: model.get('id'), link: true}, options.params);

                return app.api.call('read', url, null, callbacks);
            },
            /*
             * Render activity stream
             */
            success: _.bind(this.renderActivities, this)
        });
    },

    /**
     * Render activity stream once the preview pane opens. Hide it when there are no activities.
     * @param collection
     */
    renderActivities: function(collection) {
        var self = this;
        if (this.disposed) {
            return;
        }

        if (this._previewOpened) {
            if (collection.length === 0) {
                this.$el.hide();
            } else {
                this.$el.show();
                collection.each(function(activity) {
                    self.renderPost(activity, true);
                });
            }
        } else {
            _.delay(function(){
                self.renderActivities(collection);
            }, 500);
        }
    },

    /**
     * No need to set collectionOptions.
     */
    setCollectionOptions: function() {},

    /**
     * No need to expose data transfer object since this activity stream is readonly.
     */
    exposeDataTransfer: function() {},

    /**
     * Don't load activity stream until 'preview:render' event has been fired.
     */
    loadData: function() {},

    /**
     * No need to bind events here because this activity stream is readonly.
     */
    bindDataChange: function() {
        this.collection.on('add', function(activity) {
            if (!this.disposed) {
                this.renderPost(activity);
            }
        }, this);
    }
})
