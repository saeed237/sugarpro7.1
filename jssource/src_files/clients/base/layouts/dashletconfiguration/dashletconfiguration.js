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
        var meta = app.metadata.getLayout(options.module, options.name),
            main_panel;

        _.each(meta.components, function(component) {
            main_panel = _.find(component.layout.components, function(childComponent) {
                return childComponent.layout && childComponent.layout.name === 'main-pane';
            }, this);
        }, this);
        if(main_panel){
            main_panel.layout.components = _.union(main_panel.layout.components, options.meta.components);
        }
        options.meta = meta;
        app.view.Layout.prototype.initialize.call(this, options);
    }
})
