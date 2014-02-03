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

(function(app) {
    app.events.on("app:init", function() {

        /**
         * Handlebar helper to get the letters used for the icons shown in various headers for each module, based on the
         * translated singular module name.  This does not always match the name of the module in the model,
         * i. e. Product == Revenue Line Item
         * If the module has an icon string defined, use it, otherwise fall back to the module's translated name.
         * If there are spaces in the name, (e. g. Revenue Line Items or Product Catalog), it takes the initials
         * from the first two words, instead of the first two letters (e. g. RL and PC, instead of Re and Pr)
         * @param {String} module to which the icon belongs
         */
        Handlebars.registerHelper('moduleIconLabel', function(module) {
            var name = app.lang.getAppListStrings('moduleIconList')[module] ||
                    app.lang.getAppListStrings('moduleListSingular')[module] ||
                    module,
                space = name.indexOf(" ");

            return (space != -1) ? name.substring(0 , 1) + name.substring(space + 1, space + 2) : name.substring(0, 2);
        });

        /**
         * Handlebar helper to get the Tooltip used for the icons shown in various headers for each module, based on the
         * translated singular module name.  This does not always match the name of the module in the model,
         * i. e. Product == Revenue Line Item
         * @param {String} module to which the icon belongs
         */
        Handlebars.registerHelper('moduleIconToolTip', function(module) {
            return app.lang.getAppListStrings('moduleListSingular')[module] || module;
        });

        /**
         * Handlebar helper to translate any dropdown values to have the appropriate labels
         * @param {String} value The value to be translated.
         * @param {String} key The dropdown list name.
         */
        Handlebars.registerHelper('getDDLabel', function(value, key) {
            return app.lang.getAppListStrings(key)[value] || value;
        });

        /**
         * Handlebar helper to retrieve a view template as a sub template
         * @param {String} key Key for the template to retrieve.
         * @param {Object} data Data to pass into the compiled template
         * @param {Object} options (optional) Optional parameters
         * @return {String} String Template
         */
        Handlebars.registerHelper('subViewTemplate', function(key, data, options) {
            var template =  app.template.getView(key, options.hash.module);
            return template ? template(data) : '';
        });

        /**
         * Handlebar helper to retrieve a field template as a sub template
         * @param {String} fieldName determines which field to use.
         * @param {String} view determines which template within the field to use.
         * @param {Object} data Data to pass into the compiled template
         * @param {Object} options (optional) Optional parameters
         * @return {String} String Template
         */
        Handlebars.registerHelper('subFieldTemplate', function(fieldName, view, data, options) {
            var template =  app.template.getField(fieldName, view, options.hash.module);
            return template ? template(data) : '';
        });

        /**
         * Handlebar helper to retrieve a  ayout template as a sub template
         * @param {String} key Key for the template to retrieve.
         * @param {Object} data Data to pass into the compiled template
         * @param {Object} options (optional) Optional parameters
         * @return {String} String Template
         */
        Handlebars.registerHelper('subLayoutTemplate', function(key, data, options) {
            var template =  app.template.getLayout(key, options.hash.module);
            return template ? template(data) : '';
        });
    });
})(SUGAR.App);
