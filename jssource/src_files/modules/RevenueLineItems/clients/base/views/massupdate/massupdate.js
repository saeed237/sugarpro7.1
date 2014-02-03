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
    extendsFrom: 'MassupdateView',
    
    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        this.plugins = _.clone(this.plugins) || [];
        this.plugins.push('DisableMassdelete');
        app.view.invokeParent(this, {type: 'view', name: 'massupdate', method: 'initialize', args: [options]});
    },

    /**
     * {@inheritdoc}
     */
    delegateListFireEvents: function() {
        this.layout.on("list:massquote:fire", this.massQuote, this);
        this.layout.on("list:records:deleted", this.deleteCommitWarning, this);
        app.view.invokeParent(this, {type: 'view', name: 'massupdate', method: 'delegateListFireEvents'});
    },
    
    /**
     * Shows a warning message if a RLI that is included in a forecast is deleted.
     * @return string message
     */
    deleteCommitWarning: function(lastSelectedModels) {
        var message = null;
        
        if (!_.isUndefined(_.find(lastSelectedModels, function(model) {
            if (model.get("commit_stage") == "include") {
                return true;
            }
            return false;
        }))) {
            message = app.lang.get("WARNING_DELETED_RECORD_LIST_RECOMMIT", "RevenueLineItems");
            app.alert.show("included_list_delete_warning", {
                level: "warning",
                messages: message,
                onLinkClick: function() {
                    app.alert.dismissAll();
                }
            });
        }
        
        return message;
    },
    
    /**
     * Logic to convert multiple Revenue Line Items into a Quote
     */
    massQuote: function() {
        this.hideAll();
        var massQuote = this.context.get("mass_collection"),
            options = {},
            callbacks = {};

        // find any blockers
        var invalidItems = massQuote.filter(function(model) {
            // if product template is empty, but category is not, this RLI can not be converted to a quote
            if (_.isEmpty(model.get('product_template_id')) && !_.isEmpty(model.get('category_id'))) {
                return true;
            } else if (!_.isEmpty(model.get('quote_id'))) {
                return true;
            }

            // we don't want valid items in this array
            return false;
        }, this);

        if (!_.isEmpty(invalidItems)) {
            var messages = [app.lang.get("LBL_CONVERT_INVALID_RLI", this.module)],
                messageTpl = app.template.getView('massupdate.invalid_link', this.module);;

            _.each(invalidItems, function(item) {
                messages.push(messageTpl(item.attributes));
            });

            app.alert.show('invalid_items', {
                level: 'warning',
                autoClose: false,
                title: app.lang.get("LBL_ALERT_TITLE_WARNING", this.module) + ":",
                messages: messages,
                onLinkClick: function() {
                    app.alert.dismiss('invalid_items');
                }
            });

            return;
        }

        if (massQuote) {
            var alert = app.alert.show('info_quote', {
                level: 'info',
                autoClose: false,
                closeable: false,
                title: app.lang.get("LBL_CONVERT_TO_QUOTE_INFO", this.module) + ":",
                messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_INFO_MESSAGE", this.module)]
            });
            alert.$el.find('a.close').remove();

            var url = app.api.buildURL(this.context.get('module'), 'multi-quote');

            // custom success handler
            options.success = _.bind(function(model, data, options) {
                app.alert.dismiss('info_quote');
                app.router.navigate(app.bwc.buildRoute('Quotes', data.id, 'EditView', {
                    return_module: this.context.parent.get('module'),
                    return_id: this.context.parent.get('model').get('id')
                }), {trigger: true});
            }, this);
            options.error = _.bind(function() {
                app.alert.dismiss('info_quote');
                app.alert.show('error_xhr', {
                    level: 'error',
                    autoClose: true,
                    title: app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR", this.context.module) + ":",
                    messages: [app.lang.get("LBL_CONVERT_TO_QUOTE_ERROR_MESSAGE", this.context.module)]
                });
            }, this);

            var data = {
                'records': massQuote.pluck('id'),
                'opportunity_id': this.context.parent.get('model').get('id'),
                'account_id': this.context.parent.get('model').get('account_id')
            };

            callbacks = app.data.getSyncCallbacks('create', massQuote, options);
            app.api.call("create", url, data, callbacks);
        }
    }
})
