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
    events: {
        'mouseenter tr': 'showActions',
        'mouseleave tr': 'hideActions'
    },

    initialize: function(options) {
        this.collections = {
            today: app.data.createBeanCollection('Meetings', []),
            tomorrow: app.data.createBeanCollection('Meetings', []),
            upcoming: app.data.createBeanCollection('Meetings', [])
        };

        _.each(this.collections, function(collection) {
            collection.on("change", this.render, this);
        }, this);

        app.view.View.prototype.initialize.call(this, options);

        this.loadData();
    },

    loadData: function() {
        var self = this;

        app.api.call('read', app.api.buildURL('Meetings/Agenda'), null, {
            success: function(data) {
                var models = {'today': [], 'tomorrow': [], 'upcoming': []};

                for (var modelType in models) {
                    for (var i = 0; i < data[modelType].length; i++) {
                        models[modelType][models[modelType].length] = app.data.createBean('Meetings', data[modelType][i]);
                    }
                    self.collections[modelType].add(models[modelType]);
                }

                self.render();
            }});
    },

    showActions: function(e) {
        this.$(e.currentTarget).children("td").children("span").children(".btn-group").show();
    },
    hideActions: function(e) {
        this.$(e.currentTarget).children("td").children("span").children(".btn-group").hide();
    },

    unbindData: function() {
        _.each(this.collections, function(collection) {
            collection.off();
        });
        app.view.View.prototype.unbindData.call(this);
    }
})
