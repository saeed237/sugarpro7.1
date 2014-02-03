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

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('Tooltip', ['layout', 'view', 'field'], {
            _$pluginTooltips: null, //array of all initialized tooltips
            _pluginTooltipCssSelector: '[rel=tooltip]', //CSS selector used to find tooltips

            /**
             * Initialize tooltips on render and destroy tooltip before render for views and fields.
             * Initialize tooltips on initialize for layouts.
             */
            onAttach: function() {
                if ((this instanceof app.view.View) || (this instanceof app.view.Field)) {
                    this.before('render', function() {
                        this.destroyAllPluginTooltips();
                    }, this);
                    this.on('render', function() {
                        this.initializeAllPluginTooltips();
                    }, this);
                } else if (this instanceof app.view.Layout) {
                    this.on('init', function() {
                        this.initializeAllPluginTooltips();
                    }, this);
                }
            },

            /**
             * Destroy tooltips on dispose.
             */
            onDetach: function() {
                this.destroyAllPluginTooltips();
            },

            /**
             * Create all tooltips in this component.
             */
            initializeAllPluginTooltips: function() {
                this.removePluginTooltips();
                this.addPluginTooltips();
            },

            /**
             * Destroy all tooltips that have been created in this component.
             */
            destroyAllPluginTooltips: function() {
                this.removePluginTooltips();
                this._$pluginTooltips = null;
            },

            /**
             * Create tooltips within a given element.
             * @param {jQuery} $element (optional)
             */
            addPluginTooltips: function($element) {
                var $tooltips = this._getPluginTooltips($element);
                this._$pluginTooltips  = this._$pluginTooltips || [];
                this._$pluginTooltips.push(app.utils.tooltip.initialize($tooltips));

                //hide tooltip when clicked
                $tooltips.on('click.tooltip', function() {
                    $(this).tooltip('hide');
                });
            },

            /**
             * Destroy tooltips within a given element.
             * @param {jQuery} $element (optional)
             */
            removePluginTooltips: function($element) {
                var $tooltips = this._getPluginTooltips($element);
                app.utils.tooltip.destroy($tooltips);
            },

            /**
             * Within a given element, get all elements that have 'rel' attribute with 'tooltip' as its value.
             * @param {jQuery} $element
             * @returns {jQuery}
             * @private
             */
            _getPluginTooltips: function($element) {
                return $element ? $element.find(this._pluginTooltipCssSelector) : this.$(this._pluginTooltipCssSelector);
            }
        });
    });
})(SUGAR.App);

(function($) {
    $(function() {
        if (!Modernizr.touch) {
            return;
        }
        /**
         * {@inheritDoc}
         * Deactivate tooltip plugin on touch devices.
         */
        $.fn.tooltip = function() {
            return this;
        };
    });
})(jQuery);
