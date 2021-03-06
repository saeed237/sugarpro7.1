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

/**
 * Layout displays a list of duplicate records found along with a count
 * Note: Next step will be to add ability to switch to a filter list (and back).
 *       This is why this is in a layout.
 * @class View.Layouts.DupecheckLayout
 */
({
    initialize: function(options) {
        if(options.context.has('dupelisttype')) {
            options.meta = this.switchListView(options.meta, options.context.get('dupelisttype'));
        }
        app.view.Layout.prototype.initialize.call(this, options);
    },

    switchListView: function(meta, dupelisttype) {
        var listView = _.find(meta.components, function(component) {
            return (component.name === 'dupecheck-list');
        });
        listView.view = dupelisttype;
        return meta;
    }
})
