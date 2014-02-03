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
        app.plugins.register('ErrorDecoration', ['view'], {

            /**
             * Clears validation errors on start and success.
             *
             * @param {Object} component
             * @param {Object} plugin
             * @return {void}
             */
            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.model.on('validation:start validation:success', this.clearValidationErrors, this);
                }, this);
            },

            /**
             * We need to add those events to the view to show/hide the tooltip that contains the error message
             */
            events:{
                'focus input':'showTooltip',
                'blur input':'hideTooltip',
                'focus textarea':'showTooltip',
                'blur textarea':'hideTooltip'
            },
            showTooltip:function (e) {
                _.defer(function () {
                    var $addon = this.$(e.currentTarget).next('.add-on');
                    if ($addon && _.isFunction($addon.tooltip)) {
                        $addon.tooltip('show');
                    }
                }, this);
            },
            hideTooltip:function (e) {
                var $addon = this.$(e.currentTarget).next('.add-on');
                if ($addon && _.isFunction($addon.tooltip)) $addon.tooltip('hide');
            },

            /**
             * Remove validation error decoration from fields
             *
             * @param fields Fields to remove error from
             */
            clearValidationErrors:function (fields) {
                fields = fields || _.toArray(this.fields);
                if (fields.length > 0) {
                    _.defer(function () {
                        _.each(fields, function (field) {
                            if (_.isFunction(field.clearErrorDecoration) && field.disposed !== true) {
                                field.isErrorState = false;
                                field.clearErrorDecoration();
                            }
                        });
                    }, fields);
                }
                _.defer(function() {
                    if (this.disposed) {
                        return;
                    }
                    this.$('.error').removeClass('error');
                    this.$('.error-tooltip').remove();
                }, this);
            }
        });
    });
})(SUGAR.App);
