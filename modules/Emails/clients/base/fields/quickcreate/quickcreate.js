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
    extendsFrom: 'QuickcreateField',

    initialize: function(options) {
        // determine if the app should send email according to the use_sugar_email_client user preference
        var useSugarEmailClient = app.user.getPreference("use_sugar_email_client");
        if (useSugarEmailClient !== "true") {
            options.def.href = "mailto:"; // use the user's default mail client instead of email compose view
        } else {
            options.def.href = null;
        }

        app.view.invokeParent(this, {type: 'field', name: 'quickcreate', method: 'initialize', args:[options]});
    }
})
