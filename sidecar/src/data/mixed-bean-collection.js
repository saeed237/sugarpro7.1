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

/**
 * Mixed collection class.
 *
 * **Filtering and searching**
 *
 * The collection's {@link Data.BeanCollection#fetch} method supports filter and search options.
 * For example, to search across accounts, opportunities, and contacts for favorite records
 * that have `"Acme"` string in their searchable fields:
 * <pre><code>
 * (function(app) {
 *
 *     var records = app.data.getMixedBeanCollection();
 *     records.fetch({
 *         favorites: true,
 *         query: "Acme",
 *         module_list: "Accounts,Opportunities,Contacts"
 *     });
 *
 * })(SUGAR.App);
 * </code></pre>
 *
 *
 * @class Data.MixedBeanCollection
 * @alias SUGAR.App.MixedBeanCollection
 * @extends Data.BeanCollection
 */
(function(app) {

    app.augment("MixedBeanCollection", app.BeanCollection.extend({

        _prepareModel: function(model, options) {
            var module = model instanceof app.Bean ? model.module : model._module;
            this.model = app.data.getBeanClass(module);
            return app.BeanCollection.prototype._prepareModel.call(this, model, options);
        },

        /**
         * Fetches records.
         *
         * This method performs global search across multiple modules.
         * @param options(optional) Fetch options.
         *
         * - module_list: comma-delimited list of modules to search across. The default is a list of all displayable modules.
         *
         * See {@link Data.BeanCollection#fetch} method for details about the reset of the options.
         *
         */
        fetch: function(options) {
            options = options || {};
            // We set a list of all modules by default
            options.module_list = this.module_list = options.module_list || this.module_list || app.metadata.getModuleNames();
            return app.BeanCollection.prototype.fetch.call(this, options);
        },

        /**
         * Groups models by module name.
         * @return {Object} Sets of models. Key is module name, value is array of models.
         */
        groupByModule: function() {
            return _.groupBy(this.models, function(model) {
                return model.module;
            });
        },

        /**
         * Returns string representation of this collection:
         * <code>mcoll:[length]</code>
         * @return {String} string representation of this collection.
         */
        toString: function() {
            return "mcoll:" + this.length;
        }

    }), false);

}(SUGAR.App));
