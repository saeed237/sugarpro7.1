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
     * Places all components within this layout inside btn-toolbar div
     * @param component
     * @private
     */
    _placeComponent: function(component) {
        this.$el.find('.btn-toolbar').append(component.$el);
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this.logoUrl = app.metadata.getLogoUrl();
        //For a layout we need to
        this.$el.html(this.template(this));
        _.each(this._components, function(component) {
            this._placeComponent(component);
        }, this);
        app.view.Layout.prototype._render.call(this);
    }
})
