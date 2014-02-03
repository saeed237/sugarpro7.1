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
 * View that displays edit view on a model
 * @class View.Views.EditView
 * @alias SUGAR.App.layout.EditView
 * @extends View.View
 */
({
    initialize: function(options) {

        app.view.View.prototype.initialize.call(this, options);
        this.customTheme = "default";
        this.context.on("change:colors", this.reloadIframeBootstrap, this);
    },
    reloadIframeBootstrap: function() {
        var self = this;
        var params = {
                    preview: new Date().getTime(),
                    platform: app.config.platform,
                    themeName: this.customTheme
                };
        _.extend(params, this.context.attributes.colors);
        var cssLink = app.api.buildURL('css/preview', '', {}, params);
        $('iframe#previewTheme').hide();
        self.$(".ajaxLoading").show();
        $.get(cssLink)
            .success(function(data) {
                $('iframe#previewTheme').contents().find('style').html(data);
                self.$(".ajaxLoading").hide();
                $('iframe#previewTheme').show();
            });
        $('iframe').contents().find('body').css("backgroundColor", "transparent");
    },
    _renderHtml: function() {
        if (!app.acl.hasAccess('admin', 'Administration')) {
            return;
        }
        this._super('_renderHtml');
    }
})
