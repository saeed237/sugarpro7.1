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

({
    extendsFrom: 'RecordView',

    /**
     * Remove id, status and converted fields (including associations created during conversion) when duplicating a Lead
     * @param prefill
     */
    setupDuplicateFields: function(prefill){
        var duplicateBlackList = ["id", "status", "converted", "account_id", "opportunity_id", "contact_id"];
        _.each(duplicateBlackList, function(field){
            if(field && prefill.has(field)){
                //set blacklist field to the default value if exists
                if (!_.isUndefined(prefill.fields[field]) && !_.isUndefined(prefill.fields[field].default)) {
                    prefill.set(field, prefill.fields[field].default);
                } else {
                    prefill.unset(field);
                }
            }
        });
    }
})
