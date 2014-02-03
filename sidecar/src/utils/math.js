
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

(function(app) {
    /**
     * Math module provides utility methods for working with basic calculations
     * that JS normally fails to do well.
     *
     * @class Utils.Math
     * @singleton
     * @alias SUGAR.App.math
     */
    app.augment('math', {

        /**
         * Do math calculations in javascript,
         * sans floating point errors.
         *
         * ex. $10.52 is really 1052 cents. Think of currency as
         * cents and apply math that way (as integers)  and this should
         * help keep floating point issues out of the picture.
         *
         * @param {String} operator
         * @param {Number} n1
         * @param {Number|undefined} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        _math: function(operator, n1, n2, decimals, fixed) {
            decimals = (_.isFinite(decimals) && decimals >= 0) ? parseInt(decimals) : app.user.getPreference('decimal_precision');
            fixed = fixed || false;
            var result;
            var divisor = Math.pow(10, decimals);
            var r1 = parseFloat(n1) * divisor;
            var r2 = !_.isUndefined(n2) ? (parseFloat(n2) * divisor) : undefined;
            switch (operator) {
                case 'round':
                    result = Math.round(r1) / divisor;
                    break;
                case 'add':
                    result = (r1 + r2) / divisor;
                    break;
                case 'sub':
                    result = (r1 - r2) / divisor;
                    break;
                case 'mul':
                    result = this.round(r1 * r2 / divisor / divisor, decimals, fixed);
                    break;
                case 'div':
                    result = this.round(r1 / r2, decimals, fixed);
                    break;
                default:
                    // no valid operator, just return number
                    return n1;
                    break;
            }
            return fixed ? result.toFixed(decimals) : result;
        },

        /**
         * round a number to specified decimals as integer value.
         *
         * @param {Number} number
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        round: function(number, decimals, fixed) {
            return this._math('round', number, null, decimals, fixed);
        },

        /**
         * add two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        add: function(n1, n2, decimals, fixed) {
            return this._math('add', n1, n2, decimals, fixed);
        },

        /**
         * subtract two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        sub: function(n1, n2, decimals, fixed) {
            return this._math('sub', n1, n2, decimals, fixed);
        },

        /**
         * multiply two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        mul: function(n1, n2, decimals, fixed) {
            return this._math('mul', n1, n2, decimals, fixed);
        },

        /**
         * divide two numbers as integer values
         *
         * @param {Number} n1
         * @param {Number} n2
         * @param {Number|undefined} decimals
         * @param {boolean|undefined} fixed return value as fixed string
         * @return {Number|String} rounded amount
         */
        div: function(n1, n2, decimals, fixed) {
            return this._math('div', n1, n2, decimals, fixed);
        }

    }, false);
})(SUGAR.App);
