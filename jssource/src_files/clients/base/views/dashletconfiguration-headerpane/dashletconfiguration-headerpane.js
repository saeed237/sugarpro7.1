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
        "click a[name=cancel_button]": "close",
        "click a[name=save_button]":   "save"
    },

    save: function() {
        app.drawer.close(this.model);
    },

    close: function() {
        app.drawer.close();
    },

    /**
     * {@inheritdoc}
     *
     * Translate model label before render using model attributes.
     */
    _renderHtml: function() {
        var label;
        this.model = this.layout.context.get("model");
        label = app.lang.get(
            this.model.get('label'),
            this.model.get('module') || this.module,
            this.model.attributes
        );
        this.model.set('label', label);
        app.view.View.prototype._renderHtml.call(this);
    }
})
