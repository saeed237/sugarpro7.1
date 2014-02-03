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
    events: {
        'keyup [data-searchfield]': 'searchFired'
    },

    /**
     * {@inheritDoc}
     *
     * Update searchable fields.
     */
    bindDataChange: function() {
        this.context.on('filteredlist:filter:set', this.setFilter, this);
    },

    /**
     * Update quick search placeholder to display searchable fields.
     * @param {Array} filter List of field name.
     */
    setFilter: function(filter) {
        var label = app.lang.get('LBL_SEARCH_BY') + ' ' + filter.join(', ') + '...';
        this.$('[data-searchfield]').attr('placeholder', label);
    },

    /**
     * Updated current typed search term.
     */
    searchFired: _.debounce(function(evt) {
        var value = $(evt.currentTarget).val();
        this.context.trigger('filteredlist:search:fired', value);
    }, 100)
})
