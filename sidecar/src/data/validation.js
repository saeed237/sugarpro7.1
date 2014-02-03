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
 * Validation module.
 *
 * The validation module is used by {@link Data.Bean#validate} method.
 * Each bean field is validated by each of the validators specified in the {@link Data.Validation.validators} hash.
 *
 * The bean is also checked for required fields by {@link Data.Validation#requiredValidator} method.
 *
 * @class Data.Validation
 * @singleton
 * @alias SUGAR.App.validation
 */
(function(app) {

    // IMPORTANT: Validators must return nothing (undefined) if validation passes

    app.augment("validation", {

        /**
         * A hash of validators. Each validator function must return error definition or nothing otherwise.
         * Error definition could be a primitive value such as max length or an array, e.g. range's lower and upper limits.
         * Validator function accepts field metadata and the value to be validated.
         *
         * @class Data.Validation.validators
         * @singleton
         * @member Data.Validation
         */
        validators: (function() {
            // Helper that validates either min or max
            var _minMaxValue = function(field, value, type) {
                var limit = _.isUndefined(field[type]) ? (field.validation ? field.validation[type] : null) : field[type];
                if (field.type == "int" && _.isFinite(limit)) {
                    value = parseInt(value);
                    if (type == "max") {
                        if (value > limit) return limit;
                    }
                    else {
                        if (value < limit) return limit;
                    }
                }
            };
            // Helper that validates the given date is before/after the date of another field
            var _isBeforeAfter = function(field, value, type, model) {
                if(_.indexOf(['date', 'datetimecombo'], field.type) !== -1 && field.validation && field.validation.type === type) {
                    var compareTo = model.fields[field.validation.compareto];
                    if(!_.isUndefined(compareTo) && _.indexOf(['date', 'datetimecombo'], compareTo.type) != -1) {
                        var compareToValue = Date.parse(model.get(compareTo.name));
                        value = Date.parse(value.toString());
                        if(!_.isNaN(compareToValue) && !_.isNaN(value)) {
                            var compareToLabel = app.lang.get(compareTo.label || compareTo.vname || compareTo.name, model.module);
                            if(type == "isbefore") {
                                return compareToValue < value ? compareToLabel : undefined;
                            }
                            if(type == "isafter") {
                                return compareToValue > value ? compareToLabel : undefined;
                            }
                        }
                    }
                }
            };

            return {

                /**
                 * Validates the max length of a given value.
                 * @param {String} field bean field metadata
                 * @param {String|Number} value bean field value
                 * @return {Number} max length or nothing if the field is valid.
                 * @method
                 */
                maxLength: function(field, value) {
                    if(_.isNumber(value)){
                        value = value.toString();
                    }
                    if (_.isNumber(field.len)  && _.isString(value)) {
                        var maxLength = field.len;
                        value = value || "";
                        value = value.toString();
                        if (value.length > maxLength) {
                            return maxLength;
                        }
                    }
                },

                /**
                 * Validates the min length of a given value.
                 * @param {String} field bean field metadata
                 * @param {String} value bean field value
                 * @return {Number} min length or nothing if the field is valid.
                 * @method
                 */
                minLength: function(field, value) {
                    if (_.isNumber(field.minlen)) { // TODO: Not sure what the proper property is if there is one
                        var minLength = field.minlen;
                        value = value || "";
                        value = value.toString();

                        if (value.length < minLength) {
                            return minLength;
                        }
                    }
                },

                /**
                 * Validates that a given value is a valid URL.
                 * NOTE: Should be noted we can't do full validation of urls w/ javascript as that is impossible.
                 * @param {String} field bean field metadata
                 * @param {String} value bean field value
                 * @return {Boolean} `true` if the field is not valid
                 */
                url: function(field, value) {
                    // TODO: we should probably remove the requirement for http/https prefix
//                if ((field.type == "url") && (!(/^(https?|http):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/.test(value)))) {
//                    return true;
//                }
                },

                /**
                 * Validates that a given value is a valid email address.
                 *
                 * NOTE: Should be noted that we can't do full email validation w/ javascript.
                 * @param {String} field bean field metadata
                 * @param {String} emails bean field value which is an array of email objects
                 * @return {Array} Array of invalid email addresses.
                 */
                email: function(field, emails) {
                    var results;
                    if (field.type == 'email' || field.type === 'email-text') {
                        if (emails.length > 0) {
                            _.each(emails, function(email) {
                                if (!app.utils.isValidEmailAddress(email.email_address)) {
                                    if (!results) results = [];
                                    results.push(email.email_address);
                                }
                            });
                        }
                        if (results && results.length > 0) {
                            return results;
                        }
                    }
                },

                /**
                 * Validates that a given email array has at least one email set as the primary email.
                 *
                 * @param {String} field bean field metadata
                 * @param {String} emails bean field value which is an array of email objects
                 * @return {Array} Array of invalid email addresses.
                 */
                primaryEmail: function(field, emails) {
                    if (field.type == "email") {
                        if (emails.length > 0 &&
                            !_.find(emails, function(email) { return email.primary_address == "1"; })) {
                            return true;
                        }
                    }
                },

                /**
                 * Validates that a given email array has no duplicate email addresses.
                 *
                 * @param {String} field bean field metadata
                 * @param {String} emails bean field value which is an array of email objects
                 * @return {Array} Array of invalid email addresses.
                 */
                duplicateEmail: function(field, emails) {
                    if (field.type == "email") {
                        var values = _.pluck(emails, "email_address"),
                            duplicates = [],
                            n = values.length,
                            i, j;
                        // to ensure the fewest possible comparisons
                        for (i = 0; i < n; i++) {                      // outer loop uses each item i at 0 through n
                            for (j = i + 1; j < n; j++) {              // inner loop only compares items j at i+1 to n
                                if (values[i] == values[j]) duplicates.push(values[i]);
                            }
                        }
                        if (duplicates && duplicates.length > 0) {
                            return duplicates;
                        }
                    }
                },

                /**
                 * Validates that a given value is a real date or datetime
                 *
                 * @param {Object} field metadata
                 * @param {String} Date or Datetime value as String
                 * @return {String} The invalid date / datetime
                 */
                datetime: function(field, value){
                    var val, invalidNumberOfDigits, format, sep, formatParts, parts, i, len;

                    function inRange(val, min, max) {
                        var value = parseInt(val, 10);
                        return (!isNaN(value) && value >= min && value <= max);
                    }

                    if(field.type === "date" || field.type === "datetimecombo") {
                        // First check will short circuit (falsy) if the value is a valid server ISO date string.
                        // For datepicker values, however, we need the second check since Safari chokes on '.', '-'
                        if(_.isNaN(Date.parse(value)) && _.isNaN(Date.parse(value.replace(/[\.\-]/g, '/')))) {
                            return value;
                        } else {

                            // Check for valid date parts for non ISO dates as IE and FF both successfully parse 
                            // 2014/13/22 simply wrapping extra months around to following year (so previous example
                            // becomes 2015/01/22).
                            if (!app.date.isIso(value)) {
                                // The first set of Date.parse conditionals will negate three digit days or months
                                // but 3 digit years are valid for JavaScript dates so they'll slip through. The reason 
                                // we explicitly invalidate 3 digit years is datepicker auto corrects 1 and 2 digit years
                                // in yyyy but cannot do anything sensible with 3 digit years. Moreover, it was decided 
                                // that it's much more likely a 3 digit years is a user entry error; they don't really
                                // intend to enter a date year (e.g. 100-999 A.D.). Also any part > 4 digits is considered
                                // invalid as well since we only support:
                                // 2010-12-23, Y-m-d
                                // 12-23-2010, m-d-Y
                                // 23-12-2010, d-m-Y
                                // 2010/12/23, Y/m/d
                                // 12/23/2010, m/d/Y
                                // 23/12/2010, d/m/Y
                                // 2010.12.23, Y.m.d
                                // 23.12.2010, d.m.Y
                                // 12.23.2010, m.d.Y
                                parts = value.replace(/[\.\-]/g, '/').split('/');
                                invalidNumberOfDigits = _.filter(parts, function(part, index) { 
                                    return part.length === 3 || part.length > 4; 
                                });
                                if (invalidNumberOfDigits.length) {
                                    return value;
                                }

                                // Invalidate consecutive separators e.g. 12--23--2013
                                if (/([\.\/\-])\1/.test(value) === true) {
                                    return value;
                                }

                                // Lastly, validate month and day ranges
                                format = app.user.getPreference('datepref');
                                sep = format.match(/[.\/\-\s].*?/);
                                formatParts = format.split(sep);
                                for(i=0, len=formatParts.length; i<len; i++) {
                                    val = parts[i];
                                    switch(formatParts[i].toLowerCase().charAt(0)) {
                                        case 'm':
                                            if (!inRange(val, 1, 12)) {
                                                return value;
                                            }
                                            break;
                                        case 'd':
                                            if (!inRange(val, 1, 31)) {
                                                return value;
                                            }
                                            break;
                                    }
                                } 
                            } else {
                                // The datepicker plugin will leave 3 digit years and this validation is supposed to
                                // invalidate; but to iso date will turn that to something like: 0201-01-31T08:00:00.000Z
                                // We have to reject 100-999 to be consistent with the rest of our date year validation.
                                if (value.charAt(0) === '0') return value;
                            }
                        }
                    }
                },

                /**
                 * Validates min integer values
                 *
                 * @param {String} field bean field metadata
                 * @param {String} value field value which is an integer
                 * @return {Array} value of actual min
                 */
                minValue: function(field, value) {
                    return _minMaxValue(field, value, "min");
                },

                /**
                 * Validates max integer values
                 *
                 * @param {String} field bean field metadata
                 * @param {String} value field value which is an integer
                 * @return {Array} value of actual max
                 */
                maxValue: function(field, value) {
                    return _minMaxValue(field, value, "max");
                },

                /**
                 * Validates numeric values
                 *
                 * @param {String} field bean field metadata
                 * @param {String} value field value which is an integer
                 * @return {Boolean} true if value is invalid, undefined otherwise
                 */
                number: function(field, value) {
                    if (_.indexOf(['int', 'float', 'currency'], field.type) != -1) {
                        return (_.isBoolean(value) || (_.isString(value) && value.trim().length == 0)
                            || isNaN(parseFloat(value)) || !_.isFinite(value)) ?
                            true : undefined;
                    }
                },

                /**
                 * Validates that the given date is before the date of another field
                 *
                 * @param {Object} field metadata
                 * @param {String} value field value which is an integer
                 * @param {Object} model model
                 * @return {String} compare field label if is invalid, undefined otherwise
                 */
                isBefore: function(field, value, model) {
                    return _isBeforeAfter(field, value, 'isbefore', model);
                },

                /**
                 * Validates that the given date is after the date of another field
                 *
                 * @param {Object} field metadata
                 * @param {String} value field value which is an integer
                 * @param {Object} model model
                 * @return {String} compare field label if is invalid, undefined otherwise
                 */
                isAfter: function(field, value, model) {
                    return _isBeforeAfter(field, value, 'isafter', model);
                }

                // TODO: More validators will be added as we need them
            }
        })(),

        /**
         * Validates if the required field is set on a bean or about to be set.
         *
         * @member Data.Validation
         * @param field field metadata
         * @param {String} fieldName bean field name
         * @param {Data.Bean} model bean instance
         * @param {String} value value to be set
         * @return {Boolean} `true` if the validation fails, `undefined` otherwise
         * @method
         */
        requiredValidator: function(field, fieldName, model, value) {
            //Image type fields have their own requiredValidator
            if ((field.required === true) && (fieldName !== "id") && (field.type !== "image") && _.isUndefined(field.auto_increment)) {
                var currentValue = model.get(fieldName);
                var currentUndefined = _.isUndefined(currentValue);
                var valueEmpty = _.isNull(value) || value === "" || (_.isArray(value) && (value.length == 0));
                if ((currentUndefined && _.isUndefined(value)) || valueEmpty) {
                    return true;
                }
            }
        }

    }, false);

})(SUGAR.App);
