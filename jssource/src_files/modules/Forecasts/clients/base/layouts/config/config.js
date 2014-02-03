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
     * {@inheritdocs}
     */
    initialize: function(options) {
        var acls = app.user.getAcls().Forecasts,
            hasAccess = (!_.has(acls, 'access') || acls.access == 'yes'),
            isSysAdmin = (app.user.get('type') == 'admin'),
            isDev = (!_.has(acls, 'developer') || acls.developer == 'yes');
        // if user has access AND is a System Admin OR has a Developer role
        if(hasAccess && (isSysAdmin || isDev)) {
            // initialize
            app.view.Layout.prototype.initialize.call(this, options);
            // load the data
            app.view.Layout.prototype.loadData.call(this);
        } else {
            this.codeBlockForecasts('LBL_FORECASTS_NO_ACCESS_TO_CFG_TITLE', 'LBL_FORECASTS_NO_ACCESS_TO_CFG_MSG');
        }
    },

    /**
     * Blocks forecasts from continuing to load
     */
    codeBlockForecasts: function(title, msg) {
        var alert = app.alert.show('no_access_to_forecasts', {
            level: 'error',
            autoClose: false,
            title: app.lang.get(title, "Forecasts") + ":",
            messages: [app.lang.get(msg, "Forecasts")]
        });

        alert.getCloseSelector().on('click', function() {
            alert.getCloseSelector().off();
            app.router.navigate('#Home', {trigger: true});
        });
    },

    /**
     * Overrides loadData to defer it running until we call it in _onceInitSelectedUser
     *
     * @override
     */
    loadData: function() {
    }
})
