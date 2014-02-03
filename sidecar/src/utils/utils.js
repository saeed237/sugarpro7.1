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
    var _doWhenStack = [],
        _doWhenLocked = false,
        _doWhenInterval = false,
        _doWhenretryCount = 0,

        _startDoWhenInterval = function () {
            if (!_doWhenInterval) {
                _doWhenInterval = window.setInterval(app.utils._doWhenCheck, 50);
            }
        };

    /**
     * Utils module provides several utility methods used throughout the app such as number formatting.
     *
     * @class Utils.Utils
     * @singleton
     * @alias SUGAR.App.utils
     */
    app.augment('utils', {

        /**
         * Capitalizes a string.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        capitalize: function(s) {
            return s ? (s.charAt(0).toUpperCase() + (s.length > 1 ? s.substr(1) : "")) : "";
        },


        /**
         * Capitalizes a hyphenated string.
         *
         * `"my-string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        capitalizeHyphenated: function(s) {
            return this._classify(s, '-');
        },

        /**
         * Capitalizes an underscored string.
         *
         * `"my_string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        classify: function(s) {
            return this._classify(s, '_');
        },

        /**
         * Capitalizes a delimited string.
         *
         * `"my_string"` becomes `"MyString"`.
         * @param {String} s The string to capitalize.
         * @param {String} delimiter(optional) Delimiter string. Defaults to `'_'`.
         * @return {String} Capitalized string or an empty string if `s` is undefined or null.
         */
        _classify: function(s, delimiter) {
            var self = this, result = '';
            delimiter = delimiter || '_';

            if (!s || s.lastIndexOf(delimiter) === -1) {
                result = self.capitalize(s);
            } else {
                var words = s.split(delimiter);
                _.each(words, function(word) {
                    result += self.capitalize(word);
                });
            }
            return result;
        },

        /**
         * Formats Numbers
         *
         * @param {Number} value number to be formatted eg 2.134
         * @param {Number} round number of digits to right of decimal to round at
         * @param {Number} precision number of digits to right of decimal to take precision at
         * @param {String} numberGroupSeparator character separator for number groups of 3 digits to the left of the decimal to add
         * @param {String} decimalSeparator character to replace decimal in arg number with
         * @return {String} formatted number string OR original value if it is not a number
         */
        formatNumber: function(value, round, precision, numberGroupSeparator, decimalSeparator) {
            round = round || precision;
            var original = value;
            if (_.isNaN(value) || !_.isFinite(value)) {
                return original;
            }
            if (_.isString(value)) {
                value = parseFloat(value, 10);
                if(_.isNaN(value)){
                    return original;
                }
            }
            // Return original value if it is not a number
            if(!_.isNumber(value)) {
                if(!_.isNull(value) && !_.isUndefined(value)) {
                    // invalid variable type
                    app.logger.warn('formatNumber: invalid variable type ('+typeof(original)+')');
                }
                return original;
            }

            value = parseFloat(value.toFixed(round), 10).toFixed(precision).toString();
            return (_.isString(numberGroupSeparator) && _.isString(decimalSeparator))
                ? this.addNumberSeperators(value, numberGroupSeparator, decimalSeparator)
                : value;
        },

        /**
         * Format number to current user locale
         * @param {Number}  value
         * @return {String} formatted number
         */
        formatNumberLocale:function (value) {
            // use user locale, or decent defaults otherwise
            return this.formatNumber(
                value,
                app.user.getPreference('decimal_precision') || 2,
                app.user.getPreference('decimal_precision') || 2,
                app.user.getPreference('number_grouping_separator') || ',',
                app.user.getPreference('decimal_separator') || '.');
        },

        /**
         * Format full name with the provided locale format.
         * @param {Object} params Name property values.
         *        - first_name: first name.
         *        - last_name: last name.
         *        - salutation: salutation.
         * @param {String} format Locale format (i.e. [f l s], [s l, f]).
         * @return {String} formatted string.
         */
        formatName: function(params, format) {
            return format.replace(/(f)|(l)|(s)/g, function(str, firstName, lastName, salutation) {
                if (firstName) {
                    return params['first_name'] || '';
                }
                if (lastName) {
                    return params['last_name'] || '';
                }
                if (salutation && (params['last_name'] || params['first_name'])) {
                    return params['salutation'] || '';
                }
                return '';
            })
                //Remove comma when last name is empty
                .replace(/^( )?,/g, '')
                //Remove comma when last name is provided but first name is empty
                .replace(/, $/g, '')
                //Remove extra spaces when middle part is missing
                .replace(/  /g, ' ')
                //trim spaces
                .trim();
        },

        /**
         * Format full name following user locale format.
         * @param {Object} params Name property values.
         *        - first_name: first name.
         *        - last_name: last name.
         *        - salutation: salutation.
         * @return {String} {String} formatted string.
         */
        formatNameLocale: function(params) {
            return this.formatName(params, app.user.getPreference('default_locale_name_format'));
        },

        /**
         * Adds number seperators to a number string
         * @param {String} numberString string of number to be modified of the format nn.nnn
         * @param {String} numberGroupSeperator character seperator for number groups of 3 digits to the left of the decimal to add
         * @param {String} decimalSeperator character to replace decimal in arg number with
         * @return {String}
         */
        addNumberSeperators: function(numberString, numberGroupSeperator, decimalSeperator) {
            var numberArray = numberString.split("."),
                regex = /(\d+)(\d{3})/;

            while (numberGroupSeperator !== '' && regex.test(numberArray[0])) {
                numberArray[0] = numberArray[0].toString().replace(regex, '$1' + numberGroupSeperator + '$2');
            }

            return numberArray[0] + (numberArray.length > 1 && numberArray[1] !== '' ? decimalSeperator + numberArray[1] : '');
        },

        /**
         * Unformats number strings
         * @param {String} numberString
         * @param {String} numberGroupSeperator
         * @param {String} decimalSeperator
         * @param {Boolean} toFloat
         * @return {String} formatted number string
         */
        unformatNumberString: function(numberString, numberGroupSeperator, decimalSeperator, toFloat) {
            toFloat = toFloat || false;
            if (typeof numberGroupSeperator === 'undefined' || typeof decimalSeperator === 'undefined') {
                return numberString;
            }

            // if number is not as string, make it a string
            if (!_.isString(numberString)) {
                if (_.isFinite(numberString)) {
                    // valid number, convert to string
                    numberString.toString();
                } else {
                    // invalid value: null, undefined, NaN, etc.
                    // set to empty string
                    numberString = '';
                }
            }

            // parse out number group seperators
            if (numberGroupSeperator !== '') {
                var num_grp_sep_re = new RegExp('\\' + numberGroupSeperator, 'g');
                numberString = numberString.replace(num_grp_sep_re, '');
            }

            // parse out decimal seperators
            numberString = numberString.replace(decimalSeperator, '.');

            // remove any invalid chars
            //numberString = numberString.replace(/[^0-9\.\+\-\%]/g, '');

            // convert to float
            if (numberString.length > 0 && toFloat) {
                var float = parseFloat(numberString);
                if (float == numberString) {
                    return float;
                }
            }

            return numberString;
        },

        /**
         * Unformat number string with user locale
         * @param {Number}  value
         * @param {Boolean} toFloat convert string to float value
         * @return {String} formatted value
         */
        unformatNumberStringLocale:function (value, toFloat) {
            return this.unformatNumberString(
                value,
                app.user.getPreference('number_grouping_separator') || ',',
                app.user.getPreference('decimal_separator') || '.',
                toFloat);
        },

        /**
         * This function will take a string that has tokens like {0}, {1} and will replace
         * those tokens with the args provided.
         * Based on format_string function from utils.php
         * @param {String} format String to format
         * @param {String} args Arguments to replace
         * @return {String} formatted string
         */
        formatString: function(format, args){
            for(var idx in args){
                format = format.replace('{'+idx+'}',args[idx]);
            }
            return format;
        },

        /**
         * This function will take a string and escape it for use in javascript regex.
         * @param {String} string the string to escape
         * @return {String} string escaped
         */
        regexEscape: function regexEscape(string) {
            if( typeof regexEscape.specialRegExp == 'undefined' ) {
                var specials = [
                    '/', '.', '*', '+', '?', '|',
                    '(', ')', '[', ']', '{', '}', '\\',
                    '-', ',', '^', '$', '#'
                ];
                regexEscape.specialRegExp = new RegExp(
                    '(\\' + specials.join('|\\') + ')', 'g'
                );
            }
            return string.replace(regexEscape.specialRegExp, '\\$1');
        },

        cookie: {
            /**
             * Sets a cookie
             * @param {String} cName cookie name
             * @param {String} value
             * @param {Number} exdays days until expiration
             */
            setCookie: function setCookie(cName, value, exdays) {
                var exdate = new Date(), c_value;
                exdate.setDate(exdate.getDate() + exdays);
                c_value = escape(value) + ((exdays === null) ? "" : "; expires=" + exdate.toUTCString());
                document.cookie = cName + "=" + c_value;
            },

            /**
             * Gets a cookie
             * @param {String} cName
             * @return {String}
             */
            getCookie: function(cName) {
                var i, x, y, ARRcookies = document.cookie.split(";");
                for (i = 0; i < ARRcookies.length; i++) {
                    x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                    y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                    x = x.replace(/^\s+|\s+$/g, "");
                    if (x === cName) {
                        return unescape(y);
                    }
                }
            }
        },

        /**
         * Checks if an email address is valid
         * @param {String} address
         * @return {Boolean}
         */
        isValidEmailAddress: function(address) {
            // Copied regex from IsValidEmailExpression.php so that we're in
            // line with server side validation (bug55876)
            return /^\s*[\w.%+\-]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}\s*$/i.test(address) ||
                /^.*<[A-Z0-9._%+\-]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[A-Z]{2,}>\s*$/i.test(address);
        },

        /**
         *  Based on YUI onAvailible, but will use any boolean function instead of an ID.
         *  Once the given condition is met, the callback function will be executed.
         *
         * <pre><code>
         * // Execute a callback once an Object is defined
         * app.utils.doWhen("SUGAR.ObjectToWaitFor", function(){
         *     //Use the object here
         *     console.log(SUGAR.ObjectToWaitFor);
         * });
         *
         * // Use a function for condition and set paramters for the callback
         * var el = $("#myId");
         * var cond = function(){return el.hasClass("foo")};
         * var callback = function(params){this.log(params.msg); el.html(params.html);};
         * app.utils.doWhen(cond, callback, {msg:"Hello World", html:"&lt;h1&gt;Exists!&lt;/h1&gt;"}, console);
         * </code></pre>


         * @param {Function/String} condition function/evaluatable string which must return a boolean value.
         * @param {Function} callback function to execute when condition is met
         * @param {Object} [params] object to pass to the callback function
         * @param {Object} [scope] object to use as this when executing the callback
         */
        doWhen : function(condition, callback, params, scope){
            _doWhenStack.push({
                check:condition,
                fn:         callback,
                obj:        params,
                overrideContext:   scope
            });

            _doWhenretryCount = 50;
            _startDoWhenInterval();
        },
        /**
         *  The guts of doWhen. Runs through the stack checking all the conditions and fires the callbacks when the conditions are met.
         * @private
         */
        _doWhenCheck : function () {
            if (_doWhenStack.length === 0) {
                _doWhenretryCount = 0;
                if (_doWhenInterval) {
                     clearInterval(_doWhenInterval);
                    _doWhenInterval = null;
                }
                return;
            }

            if (_doWhenLocked) {
                return;
            }

            _doWhenLocked = true;

            // keep trying until after the page is loaded.  We need to
            // check the page load state prior to trying to bind the
            // elements so that we can be certain all elements have been
            // tested appropriately
            var tryAgain = $.isReady;
            if (!tryAgain) {
                tryAgain = (_doWhenretryCount > 0 && _doWhenStack.length > 0);
            }

            // onAvailable
            var notAvail = [];

            var executeItem = function (context, item) {
                if (item.overrideContext) {
                    if (item.overrideContext === true) {
                        context = item.obj;
                    } else {
                        context = item.overrideContext;
                    }
                }
                if (item.fn) {
                    item.fn.call(context, item.obj);
                }
            };

            var i, len, item, test;

            // onAvailable onContentReady
            for (i = 0, len = _doWhenStack.length; i < len; i = i + 1) {
                item = _doWhenStack[i];
                if (item) {
                    test = item.check;
                    if ((typeof(test) == "string" && eval(test)) || (typeof(test) == "function" && test())) {
                        executeItem(this, item);
                        _doWhenStack[i] = null;
                    }
                    else {
                        notAvail.push(item);
                    }
                }
            }

            _doWhenretryCount--;

            if (tryAgain) {
                for (i = _doWhenStack.length - 1; i > -1; i--) {
                    item = _doWhenStack[i];
                    if (!item || !item.check) {
                        _doWhenStack.splice(i, 1);
                    }
                }
                _startDoWhenInterval();
            } else {
                if (_doWhenInterval) {
                    clearInterval(_doWhenInterval);
                    _doWhenInterval = null;
                }
            }
            _doWhenLocked = false;
        },

        /**
         * Compares two version strings.
         *
         * <pre><code>
         * app.utils.versionCompare('8.2.5rc', '8.2.5a') === 1
         * app.utils.versionCompare('8.2.50', '8.2.52', '<') === true
         * app.utils.versionCompare('5.3.0-dev', '5.3.0') === -1
         * app.utils.versionCompare('4.1.0.52','4.01.0.51') === 1
         * </code></pre>
         *
         * @param {String} v1 First version string.
         * @param {String} v2 Second version string.
         * @param {String} operator(optional) Comparison operator.
         * @return {Number/Boolean} Result of comparison. See examples for details.
         */
        versionCompare: function(v1, v2, operator) {
            // Use php.js implementation
            // http://phpjs.org/functions/version_compare/
            return version_compare(v1, v2, operator);
        },

        extendFrom : function(subc, superc, overrides) {
            subc.prototype = new superc;	// set the superclass
            // overrides
            _.extend(subc.prototype, overrides);
        },

        /**
         * Creates a deep clone of an object.
         * @param {*} obj
         * @return {*} Returns a value of the same type as the input.
         */
        deepCopy: function(obj) {
            return _.isObject(obj) ? JSON.parse(JSON.stringify(obj)) : obj;
        },

        /**
         * Builds a good url based on `siteUrl` from configuration.
         *
         * It is ready for the several use cases that `siteUrl` can have:
         *
         * - relative path (aka context);
         * - full path;
         * - empty path.
         *
         * @param {String} url the full url or a relative url without the prepended `/`.
         * @returns {String}
         */
        buildUrl: function(url) {
            // Adjust relative URL: prepend it with site URL
            if (url.indexOf("http") !== 0 && !_.isEmpty(app.config.siteUrl)) {
                // Strip trailing forward slashes from site URL just in case
                url = app.config.siteUrl.replace(/\/+$/, "") + "/" + url;
            }
            return url;
        }

    });
})(SUGAR.App);
