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
    extendsFrom: 'FilterRowsView',

    /**
     * {@inheritDoc}
     */
    getFilterableFields: function(moduleName) {
        var fields = app.view.invokeParent(this, {type: 'view', name: 'filter-rows', method: 'getFilterableFields', args: [moduleName]})

        if (app.metadata.getModule("Forecasts", "config").is_setup != 1) {
            delete fields['commit_stage'];
        } else {
            _.each(fields, function(field, key, list) {
                if (key.indexOf('_case') != -1) {
                    var fld = 'show_worksheet_' + key.replace('_case', '');
                    if (app.metadata.getModule("Forecasts", "config")[fld] != 1) {
                        delete list[key];
                    }
                }
            });

        }

        return fields;
    }
})
