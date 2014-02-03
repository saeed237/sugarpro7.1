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
     * @class ComposeAddressbookLayout
     * @extends Layout
     */
    initialize: function(options) {
        app.view.Layout.prototype.initialize.call(this, options);
        this.context.set('allowed_modules', ['Accounts', 'Contacts', 'Leads', 'Prospects', 'Users']);
        this.context.on('compose:addressbook:search', this.search, this);
    },
    /**
     * Adds the set of modules and term that should be used to search for recipients.
     *
     * @param {Array} modules
     * @param {String} term
     */
    search: function(modules, term) {
        var options = {
            query:       term,
            module_list: modules
        };
        this.collection.resetPagination();
        // the context load state must be reset so that fetch will not be skipped
        this.context.resetLoadFlag(false);
        this.context.set('skipFetch', false);
        this.loadData(options, true);
    },
    /**
     * Override to inject options into the load data flow and perform the search.
     *
     * @param {Object} options
     * @param {Boolean} setFields
     */
    loadData: function(options, setFields) {
        var allowedModules  = this.context.get('allowed_modules');
        options             = options || {};
        options.module_list = options.module_list || [];
        // attempt to turn any non-array of modules into an array
        if (!_.isArray(options.module_list)) {
            // gracefully handle a comma-separated string of modules
            options.module_list = options.module_list.split(',');
        }
        // only fetch from the approved modules
        if (!_.isEmpty(options.module_list)) {
            options.module_list = _.intersection(allowedModules, options.module_list);
        }
        // search all approved modules if no modules are in option.module_list
        options.module_list = (!_.isEmpty(options.module_list)) ? options.module_list : allowedModules;
        app.view.Layout.prototype.loadData.call(this, options, setFields);
    }
})
