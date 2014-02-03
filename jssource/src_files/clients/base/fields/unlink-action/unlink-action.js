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
     * Unlink row action used in Subpanels.
     * Triggers 'list:unlinkrow:fire' event on context on click.
     *
     * @class View.Fields.UnlinkActionField
     * @alias SUGAR.App.view.fields.UnlinkActionField
     * @extends View.Fields.RowactionField
     */
    extendsFrom: 'RowactionField',
    /**
     * @param options
     * @override
     */
    initialize: function(options) {
        options.def.event =  options.def.event || 'list:unlinkrow:fire';  // default event
        options.def.acl_action =  options.def.acl_action || 'delete';  // default ACL
        app.view.invokeParent(this, {type: 'field', name: 'rowaction', method: 'initialize', args:[options]});
        this.type = 'rowaction';
    },
    /**
     * We cannot unlink one-to-many relationships where the relationship is a required field.
     * Returns false if relationship is required otherwise calls parent for additional ACL checks
     * @return {Boolean} true if allow access, false otherwise
     * @override
     */
    hasAccess: function() {
        var link = this.context.get("link");
        var parentModule = this.context.get("parentModule");
        var required = app.utils.isRequiredLink(parentModule, link);
        if(required){
            return false;
        }
        return app.view.invokeParent(this, {type: 'field', name: 'rowaction', method: 'hasAccess'});
    }
})
