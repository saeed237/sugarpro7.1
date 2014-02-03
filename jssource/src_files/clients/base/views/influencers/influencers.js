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
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this,options);
        this.collections = {};
    },

    loadData: function() {
        var self = this,
            url = app.api.buildURL(this.module, "influencers", {"id": app.controller.context.get("model").id});

        app.api.call("read", url, null, { success: function(data) {
            _.each(data, function(key, value) {
                data[value]["picture_url"] = data[value]["picture"] ? app.api.buildFileURL({
                    module: "Users",
                    id: data[value]["id"],
                    field: "picture"
                }) : "../styleguide/assets/img/profile.png";
            });

            self.collections = data;
            self.render();
        }});
    }
})