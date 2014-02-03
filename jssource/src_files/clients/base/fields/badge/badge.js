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
    /**
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    /**
     * {@inheritDoc}
     *
     * The badge is always a readonly field.
     */
    initialize: function(options) {
        options.def.readonly = true;
        app.view.Field.prototype.initialize.call(this, options);
    }
})
