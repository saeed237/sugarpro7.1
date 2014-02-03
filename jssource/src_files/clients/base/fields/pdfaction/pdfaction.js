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
    events: {
        'click [data-action=link]': 'linkClicked',
        'click [data-action=download]': 'downloadClicked',
        'click [data-action=email]': 'emailClicked'
    },

    /**
     * PDF Template collection.
     *
     * @property
     */
    templateCollection: null,

    /**
     * Visibility property for available template links.
     *
     * @property
     */
    fetchCalled: false,

    /**
     * {@inheritDoc}
     * Create PDF Template collection in order to get available template list.
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.templateCollection = app.data.createBeanCollection('PdfManager');
    },

    /**
     * {@inheritDoc}
     *
     * Prevents the "Email PDF" button from rendering if the user
     * doesn't have a valid email configuration or the user chooses to use an
     * external email client. RFC 2368 suggests only the "subject" and "body"
     * headers are safe headers and that other, unsafe headers do not need to
     * be supported by the "mailto" implementation. We cannot guarantee that
     * the "mailto" implementation for the user will allow for adding a PDF
     * attachment. To be consistent with existing application behavior, the
     * "Email PDF" option should be hidden for users when they cannot use the
     * internal email client.
     *
     * @private
     */
    _render: function() {
        if (this.def.action === 'email' && app.user.getPreference('use_sugar_email_client') !== 'true') {
            this.hide();
        } else {
            this._super('_render');
        }
    },

    /**
     * Define proper filter for PDF template list.
     * Fetch the collection to get available template list.
     * @private
     */
    _fetchTemplate: function() {
        this.fetchCalled = true;
        var collection = this.templateCollection;
        collection.filterDef = {'$and': [{
            'base_module': this.module
        }, {
            'published': 'yes'
        }]};
        collection.fetch();
    },

    /**
     * Build download link url.
     *
     * @param {String} templateId PDF Template id.
     * @return {string} Link url.
     * @private
     */
    _buildDownloadLink: function(templateId) {
        var urlParams = $.param({
            'action': 'sugarpdf',
            'module': this.module,
            'sugarpdf': 'pdfmanager',
            'record': this.model.id,
            'pdf_template_id': templateId
        });
        return '?' + urlParams;
    },

    /**
     * Build email pdf link url.
     *
     * @param {String} templateId PDF Template id.
     * @return {string} Email pdf url.
     * @private
     */
    _buildEmailLink: function(templateId) {
        return '#' + app.bwc.buildRoute(this.module, null, 'sugarpdf', {
            'sugarpdf': 'pdfmanager',
            'record': this.model.id,
            'pdf_template_id': templateId,
            'to_email': '1'
        });
    },

    /**
     * Handle the button click event.
     * Stop event propagation in order to keep the dropdown box.
     *
     * @param {Event} evt Mouse event.
     */
    linkClicked: function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        if (this.templateCollection.dataFetched) {
            this.fetchCalled = !this.fetchCalled;
        } else {
            this._fetchTemplate();
        }
        this.render();
    },

    /**
     * Handles email pdf link.
     *
     * @param {Event} evt Mouse event.
     */
    emailClicked: function(evt) {
        var templateId = this.$(evt.currentTarget).data('id');
        app.router.navigate(this._buildEmailLink(templateId), {
            trigger: true
        });
    },

    /**
     * Handles download pdf link.
     *
     * @param {Event} evt Mouse event.
     */
    downloadClicked: function(evt) {
        var templateId = this.$(evt.currentTarget).data('id');
        app.api.fileDownload(this._buildDownloadLink(templateId), {
            error: function(data) {
                // refresh token if it has expired
                app.error.handleHttpError(data, {});
            }
        }, {iframe: this.$el});
    },

    /**
     * {@inheritDoc}
     * Bind listener for template collection.
     */
    bindDataChange: function() {
        this.templateCollection.on('reset', this.render, this);
        this._super('bindDataChange');
    },

    /**
     * {@inheritDoc}
     * Dispose safe for templateCollection listeners.
     */
    unbindData: function() {
        this.templateCollection.off(null, null, this);
        this.templateCollection = null;
        this._super('unbindData');
    },

    /**
     * {@inheritDoc}
     * Check additional access for PdfManager Module.
     */
    hasAccess: function() {
        var pdfAccess = app.acl.hasAccess('view', 'PdfManager');
        return pdfAccess && this._super('hasAccess');
    }
})
