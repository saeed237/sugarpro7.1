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
 * View that displays search results.
 * @class View.Views.ResultsView
 * @alias SUGAR.App.layout.ResultsView
 * @extends View.View
 */
    _meta: {
        "buttons": [
            {
                "name": "show_more_button",
                "type": "button",
                "label": "Show More",
                "class": "loading wide"
            }
        ]
    },
    fallbackFieldTemplate: "detail",
    events: {
        'click [name=name]': 'gotoDetail',
        'click .icon-eye-open': 'loadPreview',
        'click [name=show_more_button]': 'showMoreResults'
    },
    initialize: function(options) {
        this.options.meta = this._meta;
        app.view.View.prototype.initialize.call(this, options);
    },
    /**
     * Uses query in context and fires a search request thereafter rendering
     */
    _render: function() {
        var self = this;
        self.lastQuery = self.context.get('query');

        self.fireSearchRequest(function(collection) {
            // Bug 57853: Will brute force dismiss search dropdown if still present.
            $('.search-query').searchahead('hide');

            // Add the records to context's collection
            if(collection && collection.length) {
                app.view.View.prototype._render.call(self);
                self.renderSubnav();
            } else {
                self.renderSubnav(app.lang.getAppString('LNK_SEARCH_NO_RESULTS'));
            }
        });
    },

    /**
     * Renders subnav based on search message appropriate for query term.
     */
    renderSubnav: function(overrideMessage) {
        if (this.context.get('subnavModel')) {
            this.context.get('subnavModel').set({
                'title': overrideMessage
                    || app.utils.formatString(app.lang.get('LBL_PORTAL_SEARCH_RESULTS_TITLE'),{'query' : this.lastQuery})
            });
        }
    },

    /**
     * Uses MixedBeanCollection to fetch search results.
     */
    fireSearchRequest: function (cb, offset) {
        var mlist = null, self = this, options;
        mlist = app.metadata.getModuleNames(true); // visible
        options = {
            //Show alerts for this request
            showAlerts: true,
            query: self.lastQuery,
            success:function(collection) {
                cb(collection);
            },
            module_list: mlist,
            error:function(error) {
                cb(null); // lets callback know to dismiss the alert
            }
        };
        if (offset) options.offset = offset;
        this.collection.fetch(options);
    },
    /**
     * Show more search results
     */
    showMoreResults: function() {
        var self = this, options = {};
        options.add = true;
        //Show alerts for this request
        options.showAlerts = true;
        options.success = function() {
            app.view.View.prototype._render.call(self);
            window.scrollTo(0, document.body.scrollHeight);
        };
        this.collection.paginate(options);
    },
    gotoDetail: function(evt) {
        var href = this.$(evt.currentTarget).parent().parent().attr('href');
        window.location = href;
    },
    /**
     * Loads the right side preview view when clicking icon for a particular search result.
     */
    loadPreview: function(e) {
        var localGGrandparent, correspondingResultId, model;
        localGGrandparent = this.$(e.currentTarget).parent().parent().parent();

        // Remove previous 'on' class on lists <li>'s; add to clicked <li>
        $(localGGrandparent).parent().find('li').removeClass('on');
        $(localGGrandparent).addClass("on");
        correspondingResultId = $(localGGrandparent).find('p a').attr('href').split('/')[1];

        // Grab search result model corresponding to preview icon clicked
        model = this.collection.get(correspondingResultId);

        // Fire on parent layout .. works nicely for relatively simple page ;=)
        this.layout.layout.trigger("search:preview", model);
    }
})
