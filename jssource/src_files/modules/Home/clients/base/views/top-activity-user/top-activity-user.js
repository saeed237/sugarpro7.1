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
    plugins: ['Dashlet', 'GridBuilder'],
    events: {
        'change select[name=filter_duration]': 'filterChanged'
    },
    initDashlet: function(viewName) {
        this.collection = new app.BeanCollection();
        if(!this.meta.config) {
            this.collection.on("reset", this.render, this);
        } else {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            app.view.invokeParent(this, {type: 'view', name: 'record', method: '_buildGridsFromPanelsMetadata', args: [this.meta.panels]});
        }
    },
    _mapping: {
        meetings: {
            icon: 'icon-comments',
            label: 'LBL_MOST_MEETING_HELD'
        },
        inbound_emails: {
            icon: 'icon-envelope',
            label: 'LBL_MOST_EMAILS_RECEIVED'
        },
        outbound_emails: {
            icon: 'icon-envelope-alt',
            label: 'LBL_MOST_EMAILS_SENT'
        },
        calls: {
            icon: 'icon-phone',
            label: 'LBL_MOST_CALLS_MADE'
        }
    },
    loadData: function(params) {
        if(this.meta.config) {
            return;
        }
        var url = app.api.buildURL('mostactiveusers', null, null, {days: this.settings.get("filter_duration")}),
            self = this;
        app.api.call("read", url, null, {
            success: function(data) {
                if(self.disposed) {
                    return;
                }
                var models = [];
                _.each(data, function(attributes, module){
                    if(_.isEmpty(attributes)) {
                        return;
                    }
                    var model = new app.Bean(_.extend({
                        id: _.uniqueId('aui')
                    }, attributes));
                    model.module = module;
                    model.set("name", model.get("first_name") + ' ' + model.get("last_name"));
                    model.set("icon", self._mapping[module]['icon']);
                    var template = Handlebars.compile(app.lang.get(self._mapping[module]['label'], self.module));
                    model.set("label", template({
                        count: model.get("count")
                    }));
                    model.set("pictureUrl", app.api.buildFileURL({
                        module: "Users",
                        id: model.get("user_id"),
                        field: "picture"
                    }));
                    models.push(model);
                }, this);
                self.collection.reset(models);
            },
            complete: params ? params.complete : null
        });
    },
    filterChanged: function(evt) {
        this.loadData();
    },

    _dispose: function() {
        if(this.collection) {
            this.collection.off("reset", null, this);
        }
        app.view.View.prototype._dispose.call(this);
    }
})
