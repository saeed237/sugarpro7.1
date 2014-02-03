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
    tagName: 'iframe',
    className: 'bwc-frame',
    // TODO check if we need to support multiple bwc views
    id: 'bwc-frame',
    // Precompiled regex (note-regex literal causes errors but RegExp doesn't)
    moduleRegex: new RegExp('module=([^&]*)'),
    idRegex: new RegExp('record=([^&]*)'),
    actionRegex: new RegExp('action=([^&]*)'),

    plugins: ['Editable'],

    /**
     * Enabled actions for warning unsaved changes.
     */
    warnEnabledBwcActions: [
        'editview', 'config'
    ],

    initialize: function(options) {
        // If (for some reason) we're trying to directly access old Home/Dashboards, for redirect to sidecar #Home
        var url = options.context.get('url');
        if (url && (url.search(/module=Home.*action=index/) > -1 || url.search(/action=index.*module=Home/) > -1)) {
            app.router.navigate('#Home', {trigger: true});
            return;
        }
        this.$el.attr('src', app.utils.addIframeMark(options.context.get('url') || 'index.php?module=' + this.options.module + '&action=index'));

        app.view.View.prototype.initialize.call(this, options);
        this.bwcModel = app.data.createBean('bwc');
    },

    /**
     * {@inheritDoc}
     *
     * Inspect changes on current HTML input elements with initial values.
     */
    hasUnsavedChanges: function() {
        var bwcWindow = this.$el.get(0).contentWindow;
        //if bwcModel is empty, then it should return false (since it's not in enabled actions)
        if (_.isEmpty(this.bwcModel.attributes)) {
            return false;
        }
        var newAttributes = this.serializeObject(bwcWindow.EditView);
        return !_.isEmpty(this.bwcModel.changedAttributes(newAttributes));
    },

    /**
     * Retrieves form's input values in object format
     *
     * @param {HTMLElement} theForm form element.
     * @return {Object} key-value paired object.
     */
    serializeObject: function(theForm) {
        var formArray = $(theForm).serializeArray();
        return _.reduce(formArray, function(acc, field) {
            acc[field.name] = field.value;
            return acc;
        }, {});
    },

    /**
     * {@inheritDoc}
     *
     * Override {@link View.View#_render} method to
     * extend ACL check for Administration module in BWC mode.
     * Allow access to Administration if user has admin access to any
     * module only, if not - show error message and navigate to home.
     */
    _render: function() {
        if (this.module === 'Administration' &&
            !app.acl.hasAccessToAny('admin') &&
            !app.acl.hasAccessToAny('developer')
        ) {
            app.logger.info(
                'Current user does not have access to this module view. name: ' +
                    this.name + ' module:' + this.module
            );
            app.error.handleRenderError(this, 'view_render_denied');
            app.router.navigate('#Home', {trigger: true});
            return;
        }
        app.view.View.prototype._render.call(this);
        return this;
    },

    /**
     * Render the iFrame and listen for content changes on it.
     *
     * Every time there is an update on the iFrame, we:
     * <li>update the controller context to mach our bwc module (if exists)</li>
     * <li>update our url to match the current iFrame location in bwc way</li>
     * <li>rewrite links for sidecar modules</li>
     * <li>rewrite links that go for new windows</li>
     * <li>memorize the form input elements in order to warn unsaved changes</li>
     *
     * @private
     */
    _renderHtml: function() {
        var self = this;

        app.view.View.prototype._renderHtml.call(this);

        this.$el.load(function() {
            self._setModule(this.contentWindow);
            self._setBwcModel(this.contentWindow);

            //In order to update current location once bwc link is clicked.
            var url = '#bwc/index.php' + this.contentWindow.location.search;
            self._setCurrentUrl(url);

            if (this.contentWindow.$ === undefined) {
                // no jQuery available, graceful fallback
                return;
            }
            self._rewriteLinksForSidecar(this.contentWindow);
            self._rewriteNewWindowLinks(this.contentWindow);
            self._cloneBodyClasses(this.contentWindow);
            self._resizeIframe(this.contentWindow);
        });
    },

    /**
     * Clone classes, added by Modernizr, "top frame" into "bwc frame";
     * necessary for various overrides on iPhone and Android.
     */
    _cloneBodyClasses: function(contentWindow) {
        contentWindow.$('html').addClass($('html').prop('class'));
    },
    /**
     * Update the controller context to mach our bwc module.
     *
     * @param {HTMLElement} contentWindow iframe window.
     * @private
     */
    _setModule: function(contentWindow) {
        var module = this.moduleRegex.exec(contentWindow.location.search);
        module = (_.isArray(module)) ? module[1] : null;

        if (!module) {
            // try and strip module off the page if its not set on location
            if (contentWindow.$ && contentWindow.$('input[name="module"]') && contentWindow.$('input[name="module"]').val()) {
                module = contentWindow.$('input[name="module"]').val();
            } else {
                return;
            }

        }
        // on BWC import we want to try and take the import module as the module
        if (module === 'Import') {
            var importModule = /import_module=([^&]*)/.exec(contentWindow.location.search);
            if (!_.isNull(importModule) && !_.isEmpty(importModule[1])) {
                module = importModule[1];
            }
        }
        // update bwc context
        var app = window.parent.SUGAR.App;
        app.controller.context.set('module', module);
        app.events.trigger('app:view:change', this.layout, {module: module});
    },

    /**
     * Dynamically adjust height of IFRAME, iOS hack, UIUX-1165
     */
    _resizeIframe: function(contentWindow) {
        if (Modernizr.touch) {
            $('.bwc-frame').css('height', contentWindow.$("#main").height());
        }
    },

    /**
     * Memorize the form input elements if current page contains edit form.
     *
     * @param {HTMLElement} contentWindow iframe window.
     * @private
     */
    _setBwcModel: function(contentWindow) {
        var action = this.actionRegex.exec(contentWindow.location.search);
        action = (_.isArray(action)) ? action[1].toLowerCase() : null;

        //once edit page is entered, the page is navigated without action query string.
        //Therefore, if current page contains 'EditView' form, bind the action as 'editview'.
        if (contentWindow.EditView) {
            action = 'editview';
        }

        var attributes = {};
        if (_.contains(this.warnEnabledBwcActions, action)) {
            attributes = this.serializeObject(contentWindow.EditView);
        }
        this.resetBwcModel(attributes);
    },

    /**
     * Update current window location once bwc link is clicked.
     *
     * @param {String} url current hash path.
     * @private
     */
    _setCurrentUrl: function(url) {
    	url = app.utils.rmIframeMark(url);
        this._currentUrl = url;
        window.parent.location.hash = url;
    },

    /**
     * Revert model attributes with the current form elements.
     */
    revertBwcModel: function() {
        var bwcWindow = this.$el.get(0).contentWindow;
        var newAttributes = this.serializeObject(bwcWindow.EditView);
        this.resetBwcModel(newAttributes);
    },

    /**
     * Reset model attributes with the initial attributes.
     *
     * @param {Object} key-value pair attributes.
     */
    resetBwcModel: function(attr) {
        this.bwcModel.clear({
            silent: true
        }).set(attr);
    },

    /**
     * Gets the sidecar url based on a given bwc hyperlink.
     * @param {String} href the bwc hyperlink.
     * @return {String} the new sidecar hyperlink (empty string if unable to convert).
     */
    convertToSidecarUrl: function(href) {
        var module = this.moduleRegex.exec(href),
            id = this.idRegex.exec(href),
            action = this.actionRegex.exec(href);

        module = (_.isArray(module)) ? module[1] : null;
        if (!module) {
            return '';
        }
        //Route links for BWC modules through bwc/ route
        if (app.metadata.getModule(module).isBwcEnabled) {
            //Remove any './' nonsense in existing hrefs
            href = href.replace(/^.\//, '');
            return "bwc/" + href;
        }
        id = (_.isArray(id)) ? id[1] : null;
        action = (_.isArray(action)) ? action[1] : '';
        // fallback to sidecar detail view
        if (action.toLowerCase() === 'detailview') {
            action = '';
        }

        if (!id && action.toLowerCase() === 'editview') {
            action = 'create';
        }
        return app.router.buildRoute(module, id, action);
    },

    /**
     * Rewrites old link element to the new sidecar router.
     *
     * @param {HTMLElement} The link `<a>` to rewrite into a sidecar url.
     */
    convertToSidecarLink: function(elem) {
        elem = $(elem);
        //Relative URL works better on all browsers than trying to include origin
        var baseUrl = app.config.siteUrl || window.location.pathname;
        var href = elem.attr('href');
        var module = this.moduleRegex.exec(href);
        var dataSidecarRewrite = elem.attr('data-sidecar-rewrite');
        var action = this.actionRegex.exec(href);

        if (
            !_.isArray(module) ||
            _.isEmpty(module[1]) ||
            _.isUndefined(app.metadata.getModule(module[1])) ||
            module[1] === "Administration" || // Leave Administration module links alone for 7.0
            href.indexOf("javascript:") === 0 || //Leave javascript alone (this is mostly BWC links)
            dataSidecarRewrite === 'false' ||
            (_.isArray(action) && action[1] === 'sugarpdf') //Leave PDF downloads for bwc modules
        ) {
            return;
        }
        var sidecarUrl = this.convertToSidecarUrl(href);
        elem.attr('href', baseUrl + '#' + sidecarUrl);
        elem.data('sidecarProcessed', true);

        if (elem.attr('target') === '_blank') {
            return;
        }

        elem.click(function(e) {
            if (e.button !== 0 || e.ctrlKey || e.metaKey) {
                return;
            }
            e.stopPropagation();
            parent.SUGAR.App.router.navigate(sidecarUrl, {trigger: true});
            return false;
        });
    },

    /**
     * Rewrite old links on the frame given to the new sidecar router.
     *
     * This will match all hrefs that contain "module=" on it and if the module
     * isn't blacked listed, then rewrite into sidecar url.
     * Since iFrame needs full URL to sidecar urls (to provide copy paste urls,
     * open in new tab/window, etc.) this will check what is the base url to
     * apply to that path.
     *
     * @see include/modules.php for the list ($bwcModules) of modules not
     * sidecar ready.
     *
     * @param {Window} frame the contentWindow of the frame to rewrite links on.
     * @private
     */
    _rewriteLinksForSidecar: function(frame) {
        var self = this;

        frame.$('a[href*="module="]').each(function(i, elem) {
            self.convertToSidecarLink(elem);
        });
    },

    /**
     * Rewrite new window links (target=_blank) on the frame given to the new
     * sidecar with bwc url.
     *
     * This will match all "target=_blank" links that aren't already pointing to
     * sidecar already and make them sidecar bwc compatible. This will assume
     * that all links to sidecar modules are already rewritten.
     *
     * @param {Window} frame the contentWindow of the frame to rewrite links on.
     * @private
     */
    _rewriteNewWindowLinks: function(frame) {
        var baseUrl = app.config.siteUrl || window.location.origin + window.location.pathname,
            $links = frame.$('a[target="_blank"]').not('[href^="http"]').not('[href*="entryPoint=download"]');

        $links.each(function(i, elem) {
            var $elem = $(elem);
            if ($elem.data('sidecarProcessed')) {
                return;
            }
            $elem.attr('href', baseUrl + '#bwc/' + $elem.attr('href'));
        });
    },

    /**
     * {@inheritDoc}
     */
    _dispose: function() {
        this.bwcModel.off();
        this.bwcModel = null;
        app.view.View.prototype._dispose.call(this);
    }
})
