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
    plugins: ['Dropdown', 'Tooltip'],
    initialize: function(options) {
        app.events.on("app:sync:complete", this.render, this);
        app.user.on("change:module_list", this.render, this);
        app.view.View.prototype.initialize.call(this, options);
    },

    _renderHtml: function() {
        if (!app.api.isAuthenticated() || app.config.appStatus == 'offline') return;

        // loadAdditionalComponents fires render before the private metadata is ready, check for this
        if( !(_.isEmpty(app.metadata.getStrings("mod_strings"))) ) {
            var moduleList = app.metadata.getModuleNames(true, "create");
            this.createMenuItems = this._getMenuMeta(moduleList);
            app.view.View.prototype._renderHtml.call(this);
        }
    },

    /**
     * Retrieve the quickcreate metadata from each module in the list
     * Uses the visible flag on the metadata to determine if admin has elected to hide the module from the list
     *
     * @param {Array} moduleList
     * @return {Array} list of visible menu item metadata
     */
    _getMenuMeta: function(moduleList) {
        var meta, menuItem, returnList = [];
        _.each(moduleList, function(module) {
            meta = app.metadata.getModule(module);
            if (meta && meta.menu && meta.menu.quickcreate) {
                menuItem = meta.menu.quickcreate.meta;
                if (_.isUndefined(menuItem.visible) || menuItem.visible === true) {
                    menuItem.module = module;
                    menuItem.type = menuItem.type || 'quickcreate';
                    //TODO: refactor sidecar field hbs helper so it can accept the module name directly
                    menuItem.model = app.data.createBean(module);
                    returnList.push(menuItem);
                }
            }
        }, this);
        return returnList;
    },

    _dispose: function(){
        app.user.off("change:module_list", this.render);
        app.view.View.prototype._dispose.call(this);
    }
})
