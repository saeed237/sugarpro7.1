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
    extendsFrom: 'RowactionField',

    initialize: function (options) {
        app.view.invokeParent(this, {type: 'field', name: 'rowaction', method: 'initialize', args: [options]});
        this.type = 'rowaction';
    },

    /**
     * Downloads the vCard from the Rest API.
     *
     * First we do an ajax call to the `ping` API. This will check if the token
     * hasn't expired before we append it to the URL of the VCardDownload.
     *
     */
    rowActionSelect: function () {
        var self = this;

        app.api.call('read', app.api.buildURL('ping'), {}, {
            success: function (data) {

                var uri = app.api.buildURL('VCardDownload', 'read', {}, {
                    module: self.model.module,
                    id: self.model.id,
                    oauth_token: app.api.getOAuthToken()
                });
                if (_.isEmpty(uri)) {
                    app.logger.error('Unable to get the vCard download uri.');
                    return;
                }
                window.location.href = uri;
            },
            error: function (data) {
                app.error.handleHttpError(data, self.model);
            }
        });
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on("change", this.render, this);
        }
    }
})
