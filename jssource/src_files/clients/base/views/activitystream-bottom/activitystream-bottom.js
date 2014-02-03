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
    extendsFrom: 'ListBottomView',

    showMoreRecords: function(evt) {
        var self    = this,
            options = this.context.get('collectionOptions') || {};

        // Indicates records will be added to those already loaded in to view
        options.add = true;

        options.limit = this.limit;
        options.success = function() {
            if (!self.disposed) {
                self.render();
            }
        };
        this.collection.paginate(options);
    },

    bindDataChange: function() {
        if (this.collection) {
            this.listenTo(this.collection, "add reset sync", function() {
                this.render();
            });
        }
    }
})
