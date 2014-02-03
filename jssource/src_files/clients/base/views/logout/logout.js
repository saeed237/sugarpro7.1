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
     * Login form view.
     * @class View.Views.LogoutView
     * @alias SUGAR.App.view.views.LogoutView
     */
    events: {
        "click [name=login_button]": "login",
        "click [name=login_form_button]": "login_form",
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this.logoUrl = app.metadata.getLogoUrl();
        app.view.View.prototype._render.call(this);
        this.refreshAddtionalComponents();
        return this;
    },

    /**
     * Refresh additional components
     */
    refreshAddtionalComponents: function() {
        _.each(app.additionalComponents, function(component) {
            component.render();
        });
    },

    /**
     * Process Login
     */
    login: function() {
    	app.router.login();
    },
    
    /**
     * Show Login form
     */
    login_form: function() {
        app.controller.loadView({
            module: "Login",
            layout: "login",
            create: true
        });
    }
})
