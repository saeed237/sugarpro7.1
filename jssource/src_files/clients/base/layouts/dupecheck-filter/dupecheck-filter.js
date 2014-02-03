/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
({
    extendsFrom: 'FilterLayout',

    /**
     * {@inheritDoc}
     *
     * Override getting relevant context logic in order to filter on current
     * context.
     */
    getRelevantContextList: function() {
        return [this.context];
    },

    /**
     * {@inheritDoc}
     *
     * Deactivate stickiness on find duplicates filter.
     */
    setLastFilter: function() {
        return '';
    },

    /**
     * {@inheritDoc}
     *
     * Override getting last filter in order to retrieve found duplicates for
     * initial set.
     */
    getLastFilter: function() {
        return 'all_records';
    }
})
