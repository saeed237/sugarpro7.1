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
 * Handlebars helpers.
 *
 * These functions are to be used in handlebars templates.
 * @class Handlebars.helpers
 * @singleton
 */
(function(app) {

    /**
     * Creates a field widget.
     *
     * Example:
     * <pre><code>
     * {{field view model=mymodel template=edit parent=fieldset}}
     * </code></pre>
     *
     * @method field
     * @param {View.View} view Parent view
     * @param {Object} [options] Optional params to pass to the field.
     * @param {Backbone.Model} [options.model] The model associated with the field.
     * @param {check type } [options.template] The name of the template to be used.
     * @param {Field} [options.parent] The parent field of this field.
     * @return {Object} HTML placeholder for the widget as handlebars safe string.
     */
    Handlebars.registerHelper('field', function(view, options) {
        var field = app.view.createField({
            def: this,
            view: view,
            model: options.hash.model,
            viewName: options.hash.template
        });

        if (options.hash.parent && _.isArray(options.hash.parent.fields)) {
            options.hash.parent.fields.push(field);
        }

        return field.getPlaceholder();
    });

    /**
     * Creates a field widget.
     *
     * This helper is used for fields that don't have view definition.
     *
     * @method fieldOfType
     * @param {String} type Field type
     * @param {String} label Label key
     * @return {Object} HTML placeholder for the widget as handlebars safe string.
     */
    Handlebars.registerHelper('fieldOfType', function(type, label) {
        var def = {
            type: type,
            name: type,
            label: label
        };

        var field = app.view.createField({
            def: def,
            view: this
        });

        return field.getPlaceholder();
    });

    /**
     * Iterates through options specified by a key.
     *
     * The options collection is retrieved from the language helper.
     * @method eachOptions
     * @param {String} key Options key.
     * @param {Function} hbsOptions HBS options.
     * @return {String} HTML string.
     */
    Handlebars.registerHelper('eachOptions', function(key, hbsOptions) {
        var options,
            ret = "",
            iterator;

        // Retrieve app list strings
        options = _.isString(key) ? app.lang.getAppListStrings(key) : key;

        if (_.isArray(options)) {
            iterator = function(element, index) {
                ret = ret + hbsOptions.fn({key: index, value: element});
            };
        } else if (_.isObject(options)) { // Is object evaluates arrays to true, so put it second
            iterator = function(value, key) {
                ret = ret + hbsOptions.fn({key: key, value: value});
            };
        }
        else {
            options = null;
        }

        // Don't iterate if options is not iteratable
        if (options) _.each(options, iterator, this);

        return ret;
    });

    /**
     * @method buildRoute
     * Builds a route based on hashes sent on handlebars helper.
     *
     * Example:
     * <pre><code>
     * {{buildRoute context=this.context}}
     * {{buildRoute model=myModel action="create"}}
     * {{buildRoute module="Employees" action="edit"}}
     * </code></pre>
     *
     * If both `module` and `model` are sent, `module` will take precedence
     * over `model.module`.
     * Same applies for `id` (`id` will take precedence over `model.id`).
     *
     * @param {Object} options
     *   The hashes being sent by handlebars helper. It needs at least one of
     *   `options.hash.module`, `options.hash.model` or `options.hash.context`.
     * @param {String} [options.hash.module=options.hash.model.module]
     *   The name of the module.
     * @param {Data.Bean} [options.hash.model=options.hash.context.get('model')]
     *   The model to extract the module and/or id.
     * @param {Core.Context} [options.hash.context]
     *   A context to extract the module from.
     * @param {String} [options.hash.id=options.hash.model.id]
     *   The id of the bean record.
     * @param {String} [options.hash.action]
     *   The action name.
     * @return {String}
     *   The built route.
     */
    Handlebars.registerHelper('buildRoute', function(options) {
        var ctx = options.hash.context,
            model = options.hash.model || ((ctx && ctx.get('model')) ? ctx.get('model') : {}),
            module = options.hash.module || model.module || ((ctx && ctx.get('module')) ? ctx.get('module') : null),
            id = options.hash.id || model.id,
            action = options.hash.action;

        return new Handlebars.SafeString(app.router.buildRoute(module, id, action));
    });

    /**
     * Extracts bean field value.
     * @method getFieldValue
     * @param {Data.Bean} bean Bean instance.
     * @param {String} field Field name.
     * @param {String} defaultValue(optional) Default value to return if field is not set on a bean.
     * @return {String} Field value of the given bean. If field is not set the default value or empty string.
     */
    Handlebars.registerHelper('getFieldValue', function(bean, field, defaultValue) {
        return bean.get(field) || defaultValue || "";
    });


    /**
     * Executes a given block if a given array has a value.
     * @method has
     * @param {String/Object} val value
     * @param {Object/Array} array or hash object
     * @return {String} Result of the `block` execution if the `array` contains `val` or the result of the inverse block.
     */
    Handlebars.registerHelper('has', function(val, array, options) {
        // Since we need to check both just val = val 2 and also if val is in an array, we cast
        // non arrays into arrays
        if (!_.isArray(array) && !_.isObject(array)) {
            array = [array];
        }

        return _.include(array, val) ? options.fn(this) : options.inverse(this);
    });

    /**
     * Executes a given block if a given array doesn't have a value.
     * @method notHas
     * @param {String/Object} val value
     * @param {Object/Array} array or hash object
     * @return {String} Result of the `block` execution if the `array` doesn't contain `val` or the result of the inverse block.
     */
    Handlebars.registerHelper('notHas', function(val, array, options) {
        var fn = options.fn, inverse = options.inverse;
        options.fn = inverse;
        options.inverse = fn;

        return Handlebars.helpers['has'].call(this, val, array, options);
    });

    /**
     * We require sortable to be the default if not defined in either field viewdef or vardefs. Otherwise,
     * we use whatever is provided in either field vardefs or field's viewdefs where the view def has more
     * specificity.
     * @method has
     * @param {String} module name
     * @param {Object} the field view defintion (e.g. looping through meta.panels.field it will be 'this')
     * @return {String} Result of the `block` execution if sortable, otherwise empty string.
     */
    Handlebars.registerHelper('isSortable', function(module, fieldViewdef, options) {
        var fieldVardef = app.metadata.getModule(module).fields[fieldViewdef.name];
        var isSortable = true;
        if (fieldVardef && !_.isUndefined(fieldVardef.sortable)) {
            isSortable = fieldVardef.sortable;
        }
        if(fieldViewdef && !_.isUndefined(fieldViewdef.sortable)) {
            isSortable = fieldViewdef.sortable;
        }
        if(isSortable) {
            return options.fn(this);
        } else {
            return '';
        }
    });

    /**
     * Executes a given block if a given values are equal.
     * @method eq
     * @param {String} val1 first value to compare
     * @param {String} val2 second value to compare.
     * @return {String} Result of the `block` execution if the given values are equal or the result of the inverse block.
     */
    Handlebars.registerHelper('eq', function(val1, val2, options) {
        return val1 == val2 ? options.fn(this) : options.inverse(this);
    });

    /**
     * Opposite of `eq` helper.
     * @method notEq
     * @param {String} val1 first value to compare
     * @param {String} val2 second value to compare.
     * @return {String} Result of the `block` execution if the given values are not equal or the result of the inverse block.
     */
    Handlebars.registerHelper('notEq', function(val1, val2, options) {
        return val1 != val2 ? options.fn(this) : options.inverse(this);
    });

    /**
     * Same as eq helper but second value is a {String} regex expression. Unfortunately, we have to do this because the
     * Handlebar's parser gets confused by regex literals like /foo/
     * @method match
     * @param {String} val1 first value to compare
     * @param {String} val2 A String representing a RegExp constructor argument. So if RegExp('foo.*') is the desired regex,
     * val2 would contain "foo.*". No support for modifiers.
     * @return {String} Result of the `block` execution if the given values are equal or the result of the inverse block.
     */
    Handlebars.registerHelper('match', function(val1, val2, options) {
        var re = new RegExp(val2);
        if (re.test(val1)) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    /**
     * Same as notEq helper but second value is a {String} regex expression.
     * @method notMatch
     * @param {String} val1 first value to compare
     * @param {String} val2 A String representing a RegExp constructor argument. So if RegExp('foo.*') is the desired regex,
     * val2 would contain "foo.*". No support for modifiers.
     * @return {String} Result of the `block` execution if the given values are not equal or the result of the inverse block.
     */
    Handlebars.registerHelper('notMatch', function(val1, val2, options) {
        var re = new RegExp(val2);
        if (!re.test(val1)) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }
    });

    /**
     * Logs a value.
     * @method log
     * @param value
     */
    Handlebars.registerHelper("log", function(value) {
        app.logger.debug("*****HBS: Current Context*****");
        app.logger.debug(this);
        app.logger.debug("*****HBS: Current Value*****");
        app.logger.debug(value);
        console.log(value);
        app.logger.debug("***********************");
    });

    /**
     * Retrives a string by key.
     *
     * The helper queries {@link Core.LanguageHelper} module to retrieve an i18n-ed string.
     * @method str
     * @param {String} key Key of the label.
     * @param {String} module(optional) Module name.
     * @param {String} content(optional) Template content.
     * @return {String} The string for the given label key.
     */
    Handlebars.registerHelper("str", function(key, module, content) {
        module = _.isString(module) ? module : null;
        return app.lang.get(key, module, content);
    });

    /**
     * Wrap the date into a time element
     * This helper allows to implement a plugin that will parse each time element and
     * convert the date into a relative time with a timer.
     * Uses user dateTime format for future dates.
     *
     * @method timeago
     * @param {String} dateString like `YYYY-MM-DD hh:mm:ss`.
     * @param {String} label (optional) defaults to LBL_TIME_RELATIVE.
     * @return {String} the relative time like `10 minutes ago`.
     */
    Handlebars.registerHelper("timeago", function(dateString, label) {
        var label = (_.isString(label))? " data-label='" + label + "' " : "";

        var formattedDateString = app.date.format(
            new Date(dateString),
            app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref')
        );

        // TODO: Replace `span` with a `time` element. It was removed because impossible to do innerHTML on a `time` element in IE8
        var wrapper = "<span class=\"relativetime\" "+ label + " title=\"" + dateString + "\">" +
            formattedDateString +
            "</span>";

        return new Handlebars.SafeString(wrapper);
    });

    /**
     * Joins an arrays elements by a glue string
     * @method field
     * @param {Array} array Array of strings
     * @param {String} glue string glue
     * @return {String} String
     */
    Handlebars.registerHelper('arrayJoin', function(array, glue) {
        return array.join(glue);
    });

    /**
     * Converts `\r\n`, `\n\r`, `\r`, `\n` to `<br>`.
     * @method nl2br
     * @param {String} s Raw string to filter
     * @return {String} String
     */
    Handlebars.registerHelper('nl2br', function(s) {
        s = Handlebars.Utils.escapeExpression(s);
        var nl2br = s.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>');
        return new Handlebars.SafeString(nl2br);
    });

    /**
     * Formats given currency to users preferences
     * @method formatCurrency
     * @param {Number} number      The number to format.
     * @param {String} currencyId  The currency id.
     * @return {String} The formatted number.
     */
    Handlebars.registerHelper('formatCurrency', function(number, currencyId) {
        return app.currency.formatAmountLocale(number, currencyId);
    });

    /**
     * Formats a given string by returning the first n characters.
      */
    Handlebars.registerHelper('firstChars', function(text, n) {
        return text.substring(0, n);
    });

})(SUGAR.App);
