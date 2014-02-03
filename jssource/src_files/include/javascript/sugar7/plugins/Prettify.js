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

(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('Prettify', ['layout', 'view'], {
            /**
             * Has content been prettified
             */
            _scriptReady: false,
            _pageReady: false,
            /**
             * Attach code for when the plugin is registered on a view or layout
             *
             * @param component
             * @param plugin
             */
            onAttach: function (component, plugin) {
                this.on('init', function () {
                    var self = this;
                    // was google pretty print script loaded elsewhere?
                    if (window.prettyPrint) {
                        this._scriptReady = true;
                        return;
                    }
                    $.getScript(
                        'styleguide/content/js/google-code-prettify/prettify.js',
                        function () {
                            self._scriptReady = true;
                            if (self._pageReady) {
                                // if content has been loaded, run prettify
                                prettyPrint();
                            }
                        }
                    );
                }, null, component);

                this.on('render', function () {
                    this._pageReady = true;
                    if (this._scriptReady) {
                        // if script has been loaded, run prettify
                        prettyPrint();
                    }
                }, null, component);
            }
        });
    });
})(SUGAR.App);
