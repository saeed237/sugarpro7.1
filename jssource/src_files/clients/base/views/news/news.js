/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
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
    plugins: ['Dashlet'],
    initDashlet: function() {
        if(this.meta.config) {
            var limit = this.settings.get("limit") || "5";
            this.settings.set("limit", limit);
        }
    },
    loadData: function (options) {
        var name, limit;

        if(_.isUndefined(this.model)){
            return;
        }
        var name = this.model.get("account_name") || this.model.get('name') || this.model.get('full_name'),
            limit = parseInt(this.settings.get('limit') || 5, 10);
        if (_.isEmpty(name)) {
            return;
        }
        $.ajax({
            url: 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=' +
                name.toLowerCase() + '&rsz=' + limit,
            dataType: 'jsonp',
            success: function (data) {
                if (this.disposed) {
                    return;
                }
                _.extend(this, data);
                this.render();
            },
            context: this,
            complete: options ? options.complete : null
        });
    }
})
