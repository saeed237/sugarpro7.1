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
    extendsFrom:"PanelLayout",

    /**
     * @override
     */
    initialize: function(opts) {
        opts.type = "panel";
        //Check for the override_subpanel_list_view from the parent layout metadata and replace the list view if found.
        if (opts.meta && opts.def && opts.def.override_subpanel_list_view) {
            _.each(opts.meta.components, function(def){
                if (def.view && def.view == "subpanel-list") {
                    def.view = opts.def.override_subpanel_list_view;
                }
            });
            // override last_state.id with "override_subpanel_list_view" for unique state name.
            if(opts.meta.last_state.id) {
                opts.meta.last_state.id = opts.def.override_subpanel_list_view;
            }
        }
        app.view.invokeParent(this, {type: 'layout', name: 'panel', method: 'initialize', args:[opts]});
    }
})
