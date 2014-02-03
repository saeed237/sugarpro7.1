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
        app.view.View.prototype.initialize.call(this, options);

        if (this.meta && this.meta.title) {
            this.title = this.meta.title;
        }

        this.context.on("headerpane:title",function(title){
            this.title = title;
            if (!this.disposed) this.render();
        }, this);
    },

    _renderHtml: function() {
        var title = this.title || this.module;
        this.title = app.lang.get(title, this.module);

        app.view.View.prototype._renderHtml.call(this);
    }
})
