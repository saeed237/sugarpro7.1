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
    extendsFrom: 'RecordView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'initialize', args: [options]});
        this._parsePanelFields(this.meta.panels);
    },

    /**
     * @inheritdoc
     */
    cancelClicked: function () {
        /**
         * todo: this is a sad way to work around some problems with sugarlogic and revertAttributes
         * but it makes things work now. Probability listens for Sales Stage to change and then by
         * SugarLogic, it updates probability when sales_stage changes. When the user clicks cancel,
         * it goes to revertAttributes() which sets the model back how it was, but when you try to
         * navigate away, it picks up those new changes as unsaved changes to your model, and tries to
         * falsely warn the user. This sets the model back to those changed attributes (causing them to
         * show up in this.model.changed) then calls the parent cancelClicked function which does the
         * exact same thing, but that time, since the model was already set, it doesn't see anything in
         * this.model.changed, so it doesn't warn the user.
         */
        var changedAttributes = this.model.changedAttributes(this.model.getSyncedAttributes());
        this.model.set(changedAttributes);
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'cancelClicked'});
    },

    /**
     * extend save options
     * @param {Object} options save options.
     * @return {Object} modified success param.
     */
    getCustomSaveOptions: function(options) {
        // make copy of original function we are extending
        var origSuccess = options.success;
        // return extended success function with added alert
        return {
            success: _.bind(function() {
                if (_.isFunction(origSuccess)) {
                    origSuccess();
                }
                if (!_.isEmpty(this.model.get('quote_id'))) {
                    app.alert.show('save_rli_quote_notice', {
                        level: 'info',
                        messages: app.lang.get(
                            'SAVE_RLI_QUOTE_NOTICE',
                            'RevenueLineItems'
                        ),
                        autoClose: true
                    });
                }
            }, this)
        };
    },

    initButtons: function() {
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'initButtons'});

        // if the model has a quote_id and it's not empty, disable the convert_to_quote_button
        if (this.model.has('quote_id') && !_.isEmpty(this.model.get('quote_id'))
            && !_.isUndefined(this.buttons['convert_to_quote_button'])) {
            this.buttons['convert_to_quote_button'].setDisabled(true);
        }
    },

    /**
     * Bind to model to make it so that it will re-render once it has loaded.
     */
    bindDataChange: function() {
        this.model.on('duplicate:before', this._handleDuplicateBefore, this);

        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'bindDataChange'});
    },

    /**
     * Handle what should happen before a duplicate is created
     *
     * @param {Backbone.Model} new_model
     * @private
     */
    _handleDuplicateBefore: function(new_model) {
        new_model.unset('quote_id');
        new_model.unset('quote_name');
    },

    delegateButtonEvents: function() {
        this.context.on('button:convert_to_quote:click', this.convertToQuote, this);
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'delegateButtonEvents'});
    },

    /**
     * convert RLI to quote
     * @param {Object} e
     */
    convertToQuote: function(e) {
        // if product template is empty, but category is not, this RLI can not be converted to a quote
        if (_.isEmpty(this.model.get('product_template_id')) && !_.isEmpty(this.model.get('category_id'))) {
            app.alert.show('invalid_items', {
                level: 'error',
                autoClose: false,
                title: app.lang.get('LBL_ALERT_TITLE_ERROR', this.module) + ':',
                messages: [app.lang.get('LBL_CONVERT_INVALID_RLI_PRODUCT', this.module)]
            });
            return;
        }

        var alert = app.alert.show('info_quote', {
            level: 'info',
            autoClose: false,
            closeable: false,
            title: app.lang.get("LBL_CONVERT_TO_QUOTE_INFO", this.module) + ":",
            messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_INFO_MESSAGE", this.module)]
        });
        // remove the close since we don't want this to be closable
        alert.$el.find('a.close').remove();

        var url = app.api.buildURL(this.model.module, 'quote', { id: this.model.id });
        var callbacks = {
            'success': _.bind(function(resp) {
                app.alert.dismiss('info_quote');
                app.router.navigate(app.bwc.buildRoute('Quotes', resp.id, 'EditView', {
                    return_module: this.model.module,
                    return_id: this.model.id
                }), {trigger: true});
            }, this),
            'error': _.bind(function() {
                app.alert.dismiss('info_quote');
                app.alert.show('error_xhr', {
                    level: 'error',
                    autoClose: true,
                    title: app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR", this.module) + ":",
                    messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE", this.module)]
                });
            }, this)
        };
        app.api.call("create", url, null, callbacks);
    },

    /**
     * Parse the fields in the panel for the different requirement that we have
     *
     * @param {Array} panels
     * @protected
     */
    _parsePanelFields: function(panels) {
        _.each(panels, function(panel) {
            if (!app.metadata.getModule("Forecasts", "config").is_setup) {
                // use _.every so we can break out after we found the commit_stage field
                _.every(panel.fields, function(field, index) {
                    if (field.name == 'commit_stage') {
                        panel.fields[index] = {
                            'name': 'spacer',
                            'span': 6,
                            'readonly': true
                        };
                        return false;
                    }
                    return true;
                }, this);
            } else {
                _.each(panel.fields, function(field) {
                    if (field.name == "commit_stage") {
                        field.options = app.metadata.getModule("Forecasts", "config").buckets_dom;
                    }
                }, this);
            }
        }, this);
    }
})
