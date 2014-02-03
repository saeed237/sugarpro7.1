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
     * Share row action.
     *
     * This allows an user to share a record that is currently mapped with this
     * field context
     *
     * @class View.Fields.ShareActionField
     * @alias SUGAR.App.view.fields.ShareActionField
     * @extends View.Fields.RowactionField
     */
    extendsFrom: 'RowactionField',

    /**
     * Share template for subject.
     * @see _initShareTemplates()
     */
    shareTplSubject: null,

    /**
     * Share template for body.
     * @see _initShareTemplates()
     */
    shareTplBody: null,

    /**
     * Share template for body in HTML format.
     * @see _initShareTemplates()
     */
    shareTplBodyHtml: null,

    /**
     * {@inheritDoc}
     *
     * Adds the share on click event to call the share action.
     */
    initialize: function(options) {
        options.def = options.def || {};

        this.events = _.extend({}, this.events, options.def.events || {}, {
            'click a[name="share"][data-event="true"]': 'share'
        });

        app.view.invokeParent(this, {type: 'field', name: 'rowaction', method: 'initialize', args: [options]});
        this._initShareTemplates();

        // FIXME this preference shouldn't be a string
        if (app.user.getPreference('use_sugar_email_client') !== 'true') {
            options.def.href = this._shareWithMailTo();
        }
    },

    /**
     * Initializes the sharing feature templates.
     *
     * This will get the templates from either the current module (since we
     * might want to customize it per module) or from core templates.
     *
     * Please define your templates on:
     *
     * - `custom/clients/{platform}/view/share/subject.hbs`
     * - `custom/clients/{platform}/view/share/body.hbs`
     * - `custom/clients/{platform}/view/share/body-html.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/subject.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/body.hbs`
     * - `{custom/,}modules/{module}/clients/{platform}/view/share/body-html.hbs`
     *
     * @template
     * @protected
     */
    _initShareTemplates: function() {
        this.shareTplSubject = app.template.getView('share.subject', this.module) ||
            app.template.getView('share.subject');
        this.shareTplBody = app.template.getView('share.body', this.module) ||
            app.template.getView('share.body');
        this.shareTplBodyHtml = app.template.getView('share.body-html', this.module) ||
            app.template.getView('share.body-html');
    },

    /**
     * Get the params required by the templates defined on
     * {@link _initShareTemplates}.
     *
     * Override this if your templates need more information to be sent on the
     * share email.
     *
     * @template
     * @protected
     */
    _getShareParams: function() {
        var moduleString = app.lang.getAppListStrings('moduleListSingular');

        return _.extend({}, this.model.attributes, {
            module: moduleString[this.module] || this.module,
            appId: app.config.appId,
            url: window.location.href,
            name: this.model.attributes.name || this.model.attributes.full_name
        });
    },

    /**
     * Share button event triggered.
     *
     * Check if we can use email compose (from within Sugar) or else use the
     * `mailto` default browser feature to deliver a pre-filled email message
     * (subject and body), based on the templates initialized in
     * {@link _initShareTemplates}.
     *
     * @see _shareWithSugarEmailClient()
     * @see _shareWithMailTo()
     */
    share: function() {
        this._shareWithSugarEmailClient();
    },

    /**
     * Share a record using internal SugarEmailClient.
     *
     * This will try to use the bodyHtml template and if its empty then it will
     * fallback to body template.
     *
     * @private
     */
    _shareWithSugarEmailClient: function() {
        var subject = this.shareTplSubject(this._getShareParams()),
            body = this.shareTplBody(this._getShareParams()),
            bodyHtml = this.shareTplBodyHtml(this._getShareParams());

        app.drawer.open({
            layout: 'compose',
            context: {
                create: true,
                module: 'Emails',
                model: app.data.createBean('Emails', {
                    subject: subject,
                    html_body: bodyHtml || body
                })
            }
        });
    },

    /**
     * Share a record by using the default `mailto` browser feature.
     *
     * This will not use the bodyHtml template, since it isn't supported by the
     * `mailto` feature.
     *
     * @private
     */
    _shareWithMailTo: function() {
        var subject = this.shareTplSubject(this._getShareParams()),
            body = this.shareTplBody(this._getShareParams());

        return 'mailto:?' + [
            'subject=' + encodeURIComponent(subject),
            'body=' + encodeURIComponent(body)
        ].join('&');
    }
})
