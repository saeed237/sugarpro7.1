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

({
    plugins: ['ToggleMoreLess'],
    fallbackFieldTemplate: 'detail',
    /**
     * Events related to the preview view:
     *  - preview:open                  indicate we must show the preview panel
     *  - preview:render                indicate we must load the preview with a model/collection
     *  - preview:collection:change     indicate we want to update the preview with the new collection
     *  - preview:close                 indicate we must hide the preview panel
     *  - preview:pagination:fire       (on layout) indicate we must switch to previous/next record
     *  - preview:pagination:update     (on layout) indicate the preview header needs to be refreshed
     *  - list:preview:fire             indicate the user clicked on the preview icon
     *  - list:preview:decorate         indicate we need to update the highlighted row in list view
     */

    // "binary semaphore" for the pagination click event, this is needed for async changes to the preview model
    switching: false,
    hiddenPanelExists: false,
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        this.action = 'detail';
        app.events.on("preview:render", this._renderPreview, this);
        app.events.on("preview:collection:change", this.updateCollection, this);
        app.events.on("preview:close", this.closePreview,  this);

        // TODO: Remove when pagination on activity streams is fixed.
        app.events.on("preview:module:update", this.updatePreviewModule,  this);

        if(this.layout){
            this.layout.on("preview:pagination:fire", this.switchPreview, this);
        }
        this.collection = app.data.createBeanCollection(this.module);
    },
    updateCollection: function(collection) {
        if( this.collection ) {
            this.collection.reset(collection.models);
            this.showPreviousNextBtnGroup();
       }
    },

    // TODO: Remove when pagination on activity streams is fixed.
    updatePreviewModule: function(module) {
        this.previewModule = module;
    },

    filterCollection: function() {
        this.collection.remove(_.filter(this.collection.models, function(model){
            return !app.acl.hasAccessToModel("view", model);
        }, this), { silent: true });
    },

    _renderHtml: function(){
        this.showPreviousNextBtnGroup();
        app.view.View.prototype._renderHtml.call(this);
    },

    /**
     * Show previous and next buttons groups on the view.
     *
     * This gets called everytime the collection gets updated. It also depends
     * if we have a current model or layout.
     *
     * TODO we should check if we have the preview open instead of doing a bunch
     * of if statements.
     */
    showPreviousNextBtnGroup: function () {
        if (!this.model || !this.layout || !this.collection) {
            return;
        }
        var collection = this.collection;
        if (!collection.size()) {
            this.layout.hideNextPrevious = true;
        }
        var recordIndex = collection.indexOf(collection.get(this.model.id));
        this.layout.previous = collection.models[recordIndex-1] ? collection.models[recordIndex-1] : undefined;
        this.layout.next = collection.models[recordIndex+1] ? collection.models[recordIndex+1] : undefined;
        this.layout.hideNextPrevious = _.isUndefined(this.layout.previous) && _.isUndefined(this.layout.next);

        // Need to rerender the preview header
        this.layout.trigger("preview:pagination:update");
    },

    /**
     * Renders the preview dialog with the data from the current model and collection.
     * @param model Model for the object to preview
     * @param collection Collection of related objects to the current model
     * @param {Boolean} fetch Optional Indicates if model needs to be synched with server to populate with latest data
     * @param {Number|String} previewId Optional identifier use to determine event origin. If event origin is not the same
     * but the model id is the same, preview should still render the same model.
     * @private
     */
    _renderPreview: function(model, collection, fetch, previewId){
        var self = this;

        // If there are drawers there could be multiple previews, make sure we are only rendering preview for active drawer
        if(app.drawer && !app.drawer.isActive(this.$el)){
            return;  //This preview isn't on the active layout
        }

        // Close preview if we are already displaying this model
        if(this.model && model && (this.model.get("id") == model.get("id") && previewId == this.previewId)) {
            // Remove the decoration of the highlighted row
            app.events.trigger("list:preview:decorate", false);
            // Close the preview panel
            app.events.trigger('preview:close');
            return;
        }

        if (app.metadata.getModule(model.module).isBwcEnabled) {
            app.events.trigger('preview:close');
            app.alert.show('preview_bwc_error', {level:'error', messages: app.lang.getAppString('LBL_PREVIEW_BWC_ERROR'), autoClose: true});
            return;
        }

        if (model) {
            // Get the corresponding detail view meta for said module.
            // this.meta needs to be set before this.getFieldNames is executed.
            this.meta = _.extend({}, app.metadata.getView(model.module, 'record'), app.metadata.getView(model.module, 'preview'));
            this.meta = this._previewifyMetadata(this.meta);
        }

        if (fetch) {
            model.fetch({
                //Show alerts for this request
                showAlerts: true,
                success: function(model) {
                    self.renderPreview(model, collection);
                },
                fields: this.getFieldNames(model.module)
            });
        } else {
            this.renderPreview(model, collection);
        }

        this.previewId = previewId;
    },
    bindUpdates: function(sourceModel) {
        if (this.sourceModel) {
            this.stopListening(this.sourceModel);
        }
        this.sourceModel = sourceModel;
        // If we've just sync'd, use sync'd model and re-render preview
        this.listenTo(this.sourceModel, 'sync', function(model) {
            if (!this.model) {
                return;
            }
            this.model = model;
            this.renderPreview(this.model);
        }, this);
        this.listenTo(this.sourceModel, 'change', function() {
            if (!this.model) {
                return;
            }
            this.model.set(this.sourceModel.attributes);
        }, this);
        // Close preview when model destroy
        this.listenTo(this.sourceModel, 'destroy', function(model) {
            if (model && this.model && (this.model.get("id") == model.get("id"))) {
                // Remove the decoration of the highlighted row
                app.events.trigger("list:preview:decorate", false);
                // Close the preview panel
                app.events.trigger('preview:close');
                return;
            }

        }, this);
    },
    /**
     * Renders the preview dialog with the data from the current model and collection
     * @param model Model for the object to preview
     * @param collection Collection of related objects to the current model
     */
    renderPreview: function(model, newCollection) {
        if(newCollection) {
            this.collection.reset(newCollection.models);
        }

        if (model) {
            this.bindUpdates(model);

            // FIXME why can't we reuse the model that we have on the collection. We should fix this in SP-1483.
            this.model = app.data.createBean(model.module, model.toJSON());

            this.listenTo(this.model, 'change', function() {
                this.sourceModel.set(this.model.attributes);
            }, this);

            this.render();

            // TODO: Remove when pagination on activity streams is fixed.
            if (this.previewModule && this.previewModule === "Activities") {
                this.layout.hideNextPrevious = true;
                this.layout.trigger("preview:pagination:update");
            }
            // Open the preview panel
            app.events.trigger("preview:open",this);
            // Highlight the row
            app.events.trigger("list:preview:decorate", this.model, this);
            if(!this.$el.is(":visible")) {
                this.context.trigger("openSidebar",this);
            }
        }
    },

    /**
     * Normalizes the metadata, and removes favorite/follow fields that gets
     * shown in Preview dialog.
     *
     * @param meta Layout metadata to be trimmed
     * @return Returns trimmed metadata
     * @private
     */
    _previewifyMetadata: function(meta){
        this.hiddenPanelExists = false; // reset
        _.each(meta.panels, function(panel){
            if(panel.header){
                panel.header = false;
                panel.fields = _.filter(panel.fields, function(field){
                    //Don't show favorite or follow in Preview, it's already on list view row
                    return field.type != 'favorite' && field.type != 'follow';
                });
            }
            //Keep track if a hidden panel exists
            if(!this.hiddenPanelExists && panel.hide){
                this.hiddenPanelExists = true;
            }
        }, this);
        return meta;
    },
    /**
     * Switches preview to left/right model in collection.
     * @param {String} data.direction Direction that we are switching to, either 'left' or 'right'.
     * @param index Optional current index in list
     * @param id Optional
     * @param module Optional
     */
    switchPreview: function(data, index, id, module) {
        var self = this,
            currID = id || this.model.get("id"),
            currIndex = index || _.indexOf(this.collection.models, this.collection.get(currID));

        if( this.switching || this.collection.models.length < 2) {
            // We're currently switching previews or we don't have enough models, so ignore any pagination click events.
            return;
        }
        this.switching = true;

        if( data.direction === "left" && (currID === _.first(this.collection.models).get("id")) ||
            data.direction === "right" && (currID === _.last(this.collection.models).get("id")) ) {
            this.switching = false;
            return;
        } else {
            // We can increment/decrement
            data.direction === "left" ? currIndex -= 1 : currIndex += 1;

            //  If module not specified we need select module from model in collection by current index.
            var currModule = module || this.collection.models[currIndex].module;
            var moduleMeta = app.metadata.getModule(currModule);
            this.model = app.data.createBean(currModule);
            this.bindUpdates(this.collection.models[currIndex]);
            this.model.set("id", this.collection.models[currIndex].get("id"));
            this.model.fetch({
                //Show alerts for this request
                showAlerts: true,
                success: function(model) {
                    model.module = currModule;
                    self.model = null;
                    //Reset the preview
                    app.events.trigger("preview:render", model, null, false);
                    self.switching = false;
                }
            });
        }
    },

    closePreview: function() {
        if(_.isUndefined(app.drawer) || app.drawer.isActive(this.$el)){
            this.switching = false;
            delete this.model;
            this.collection.reset();
            this.$el.empty();
        }
    },
    bindDataChange: function() {
        if(this.collection) {
            this.collection.on("reset", this.filterCollection, this);
            // when remove active model from collection then close preview
            this.collection.on("remove", function(model) {
                if (model && this.model && (this.model.get("id") == model.get("id"))) {
                    // Remove the decoration of the highlighted row
                    app.events.trigger("list:preview:decorate", false);
                    // Close the preview panel
                    app.events.trigger('preview:close');
                }
            }, this);
        }
    }
})
