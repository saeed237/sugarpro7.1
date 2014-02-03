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
(function(app) {
    app.events.on('app:init', function() {
        /**
         * Widget for toggling more-less panel.
         *
         * In order to activate the toggleShowOrLess,
         * the view metadata must contain last_state.
         *
         * Once "Show More" is clicked,
         * any DOM element with css class 'panel_hidden' will be shown.
         *
         * Example:
         *
         * <pre><code>
         *     'last_state' => array(
         *         'id' => '<key for each view>',
         *             'defaults' => array(
         *                 //'show_more' is registered key for 'more-less' widget.
         *                 'show_more' => 'more'
         *             ),
         *         ),
         *     ),
         * </code></pre>
         */
        app.plugins.register('ToggleMoreLess', ['view'], {
            events: {
                'click [data-moreless]': 'moreLessClicked'
            },

            /**
             * last state key for "Show More".
             *
             * @property
             */
            MORE_LESS_KEY: 'show_more',

            /**
             * Status values.
             *
             * @property
             */
            MORE_LESS_STATUS: {
                MORE: 'more',
                LESS: 'less'
            },

            onAttach: function() {
                this.on('init', function() {
                    this.meta = this.meta || {};
                    this.meta.last_state = this.meta.last_state || {
                        id: this.name + '_view',
                        defaults: {}
                    };

                    this.meta.last_state['defaults'][this.MORE_LESS_KEY] = 'less';

                    // properly namespace SHOW_MORE_KEY key
                    this.SHOW_MORE_KEY = app.user.lastState.key(this.MORE_LESS_KEY, this);
                    // register default value defined in metadata
                    app.user.lastState.register(this);
                });

                this.before('render', function() {
                    // Restore state of 'Show More' panel by toggling it
                    // if 'Show Less' needs to be shown
                    var lastStatus = app.user.lastState.get(this.SHOW_MORE_KEY);
                    if (_.contains(this.MORE_LESS_STATUS, lastStatus)) {
                        this._setVisibility(lastStatus);
                    }
                }, this);
            },

            /**
             * Handles toggle buttons (more/less button).
             *
             * @param {Event} evt Mouse Event.
             */
            moreLessClicked: function(evt) {
                var moreLess = this.$(evt.currentTarget).data('moreless');
                this.toggleMoreLess(moreLess);
            },

            /**
             * Toggle visibility on buttons and hidden panel.
             *
             * @param {String} moreLess Enum value for status [more, less].
             */
            toggleMoreLess: function(moreLess) {
                this._setVisibility(moreLess);
                this.$('[data-moreless=more]').toggleClass('hide', this.hideMoreButton);
                this.$('[data-moreless=less]').toggleClass('hide', this.hideLessButton);
                var target = this.$('[data-moreless=' + moreLess + ']').data('target') ||
                    '.panel-hidden';
                this.$(target).toggleClass('hide', this.hidePanel);
                app.user.lastState.set(this.SHOW_MORE_KEY, moreLess);
                this.trigger('more-less:toggled', moreLess);
            },

            /**
             * Set visibility property for buttons and hidden panel.
             *
             * @param {String} moreLess Enum value for status [more, less].
             * @private
             */
            _setVisibility: function(moreLess) {
                this.hideMoreButton = (moreLess === this.MORE_LESS_STATUS.MORE);
                this.hideLessButton = (moreLess === this.MORE_LESS_STATUS.LESS);
                this.hidePanel = (moreLess === this.MORE_LESS_STATUS.LESS);
            }
        });
    });
})(SUGAR.App);
