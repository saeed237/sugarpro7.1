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
    /**
     * View that displays a list of models pulled from the context's collection.
     * @class View.Views.ListViewBottom
     * @alias SUGAR.App.layout.ListViewBottom
     * @extends View.View
     */
    // We listen to event and keep track if search filter is toggled open/close
    filterOpened: false,
    events: {
        'click [data-action="show-more"]': 'showMoreRecords'
    },

    initialize: function(opts) {
        opts.meta = _.extend({}, {showMoreLabel: "LBL_SHOW_MORE_MODULE"}, opts.meta || {});

        app.view.View.prototype.initialize.call(this, opts);

        this.showMoreLabel = app.lang.get(this.options.meta.showMoreLabel, this.module, {
            module: app.lang.get('LBL_MODULE_NAME', this.module).toLowerCase()
        });
    },

    _renderHtml: function() {
        // Dashboard layout injects shared context with limit: 5.
        // Otherwise, we don't set so fetches will use max query in config.
        if(this.context.get('limit')){
            this.limit = this.context.get('limit');
        }

        app.view.View.prototype._renderHtml.call(this);

        // We listen for if the search filters are opened or not. If so, when 
        // user clicks show more button, we treat this as a search, otherwise,
        // normal show more for list view.
        this.layout.off("list:filter:toggled", null, this);
        this.layout.on("list:filter:toggled", this.filterToggled, this);
    },
    filterToggled: function(isOpened) {
        this.context.set('filterOpened', isOpened);
    },
    showMoreRecords: function(evt) {
        var self = this, options;
        // Mark current models as old, in order to animate the new one
        _.each(this.collection.models, function(model) {
            model.old = true;
        });

        // save current screen position
        var screenPosition = $('html').offset().top;

        // If in "search mode" (the search filter is toggled open) set q:term param
        options = this.context.get('filterOpened') ? self.getSearchOptions() : {};

        //Show alerts for this request
        options.showAlerts = true;

        // Indicates records will be added to those already loaded in to view
        options.add = true;

        options.success = function() {
            self.layout.trigger("list:paginate:success");
            if(!self.disposed){
                self.render();
                // retrieve old screen position
                window.scrollTo(0, -1*screenPosition);

                // Animation for new records
                self.layout.$('tr.new').animate({
                    opacity:1
                }, 500, function () {
                    $(this).removeAttr('style class');
                });
            }
        };
        if(this.limit){
            options.limit = this.limit;
        }
        // Override default collection options if they exist
        options = _.extend({}, this.context.get('collectionOptions'), options);
        this.collection.paginate(options);
    },
    getSearchOptions: function() {
        var collection, options, previousTerms, term = '';
        collection = this.context.get('collection');

        // If we've made a previous search for this module grab from cache
        if(app.cache.has('previousTerms')) {
            previousTerms = app.cache.get('previousTerms');
            if(previousTerms) {
                term = previousTerms[this.module];
            }
        }
        // build search-specific options and return
        options = {
            params: {
                q: term
            },
            fields: collection.fields ? collection.fields : this.collection
        };
        return options;
    },

    bindDataChange: function() {
        if(this.collection) {
            this.collection.on("reset sync", function() {
                this.render();
            }, this);
        }
    }
})
