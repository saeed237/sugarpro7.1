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
    app.events.on("app:init", function() {

        /**
         * This plugin disallows mass-deleting for closed won/lost items (for use in Opps and Products)
         */
        app.plugins.register('DisableMassdelete', ["view"], {

            /**
             * override of parent deleteModels. Removes closed lost/won items from the list to be deleted, and
             * throws a warning if it removes anything
             *
             * @return string message
             */
            warnDelete: function() {
                
                var closedModels = [],
                    sales_stage_won = null,
                    sales_stage_lost = null,
                    closed_RLI_count = 0,
                    message = null,
                    status = null,
                    module = this.getMassUpdateModel(this.module);

                if (app.metadata.getModule("Forecasts", "config").is_setup == 1) {
                    sales_stage_won = app.metadata.getModule("Forecasts", "config").sales_stage_won;
                    sales_stage_lost = app.metadata.getModule("Forecasts", "config").sales_stage_lost;

                    closedModels = _.filter(module.models, function(model) {
                        status = null;
                        if (_.isEmpty(status)) {
                            status = model.get("sales_stage");
                        }
                        
                        if (_.contains(sales_stage_won, status) || _.contains(sales_stage_lost, status)) {
                            message = app.lang.getAppString("WARNING_NO_DELETE_SELECTED");
                            return true;
                        }

                        if (closed_RLI_count > 0) {
                            message = app.lang.get("WARNING_NO_DELETE_CLOSED_SELECTED", "Opportunities");
                            return true;
                        }

                        return false;
                    });

                    if (closedModels.length > 0) {
                       module.remove(closedModels);
                       this.context.set('mass_collection', module);
                        //uncheck items
                        _.each(closedModels, function(item){
                            var id = item.module + "_" + item.id;
                            $("[name='" + id + "'] input").attr("checked", false);
                        });
                        app.alert.show('delete_warning', {
                            level: 'warning',
                            messages: message
                        });
                    }
                }

                if (module.models.length > 0) {
                    app.view.invokeParent(this, {type: 'view', name: 'massupdate', method: 'warnDelete'});
                }
                return message;
            }
        });
    });
})(SUGAR.App);
