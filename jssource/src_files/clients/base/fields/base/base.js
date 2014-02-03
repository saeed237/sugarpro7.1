/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
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
    plugins: ['EllipsisInline', 'Tooltip'],

    _render: function() {
        var action = "view";
        if (this.def.link && this.def.route) {
            action = this.def.route.action;
        }
        if (!app.acl.hasAccessToModel(action, this.model)) {
            this.def.link = false;
        }
        if (this.def.link) {
            this.href = this.buildHref();
        }
        app.view.Field.prototype._render.call(this);
    },

    /**
     * Takes care of building href for when there's a def.link and also if is
     * bwc enabled.
     *
     * Deprecated functionality:
     * If `this.def.bwcLink` is set to `true` on metadata, we force the href
     * to be in BWC.
     *
     * TODO remove this from the base field
     */
    buildHref: function() {
        var defRoute = this.def.route ? this.def.route : {},
            module = this.model.module || this.context.get('module');
        // FIXME remove this.def.bwcLink functionality (not yet removed due to Portal need for Documents)
        return '#' + app.router.buildRoute(module, this.model.id, defRoute.action, this.def.bwcLink);
    },
    /**
     * Trim whitespace from value if it is a String
     * @param value
     * @return {*}
     */
    unformat: function(value){
        return _.isString(value) ? value.trim() : value;
    }
})
