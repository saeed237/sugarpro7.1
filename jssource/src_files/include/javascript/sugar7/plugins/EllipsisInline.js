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
    app.events.on("app:init", function () {
        /**
         * When ellipsis_inline class is added to an element, the CSS will ellipsify the text
         * and this plugin will show a tooltip when an ellipsis exists.
         */
        app.plugins.register('EllipsisInline', ['view', 'field'], {

            events:{
                'mouseenter .ellipsis_inline': '_showEllipsisTooltip',
                'mouseleave .ellipsis_inline': '_hideEllipsisTooltip'
            },

            _$ellipsisTooltips: null, //array of all initialized tooltips

            /**
             * Initialize tooltips on render and destroy tooltip before render.
             */
            onAttach: function() {
                this.before('render', function() {
                    this.destroyEllipsisTooltips();
                }, this);

                this.on('render', function() {
                    this.initializeEllipsisTooltips();
                }, this);
            },

            /**
             * Destory all tooltips on dispose.
             */
            onDetach: function() {
                this.destroyEllipsisTooltips();
            },

            /**
             * Create tooltips for all elements that have `ellipsis_inline` class.
             */
            initializeEllipsisTooltips: function() {
                app.utils.tooltip.destroy(this._$ellipsisTooltips);
                this._$ellipsisTooltips = app.utils.tooltip.initialize(this.$('.ellipsis_inline'), {
                    trigger: 'manual'
                });
            },

            /**
             * Destroy all tooltips that have been created.
             */
            destroyEllipsisTooltips: function() {
                app.utils.tooltip.destroy(this._$ellipsisTooltips);
                this._$ellipsisTooltips = null;
            },

            /**
             * Show tooltip.
             * @param {Event} event
             * @private
             */
            _showEllipsisTooltip: function(event) {
                var target = event.currentTarget;
                if (this._shouldShowEllipsisTooltip(target)) {
                    $(target).tooltip('show');
                }
            },

            /**
             * Hide tooltip.
             * @param {Event} event
             * @private
             */
            _hideEllipsisTooltip: function(event) {
                var target = event.currentTarget;
                if (this._shouldHideEllipsisTooltip(target)) {
                    $(target).tooltip('hide');
                }
            },

            /**
             * Show tooltip if it exists on the target and if the ellipsis is shown.
             * @param {DOM} target
             * @returns {boolean}
             * @private
             */
            _shouldShowEllipsisTooltip: function(target) {
                return app.utils.tooltip.has(target) && (target.offsetWidth < target.scrollWidth);
            },

            /**
             * Hide tooltip if it exists on the target and if it is currently displayed.
             * @param {DOM} target
             * @returns {boolean}
             * @private
             */
            _shouldHideEllipsisTooltip: function(target) {
                return app.utils.tooltip.has(target) && $(target).data('tooltip').tip().hasClass('in');
            }

        });
    });
})(SUGAR.App);
