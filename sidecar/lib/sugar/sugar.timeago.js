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

$(function() {

    /**
     * Timeago plugin is a jQuery/Zepto plugin for sidecar that converts a date into a relative time with a timer
     * to keep it relative to now.
     *
     * Example initialization of plugin:
     *
     * $('span.relativetime').timeago({
     *   logger: SUGAR.App.logger,
     *   date: SUGAR.App.date,
     *   lang: SUGAR.App.lang,
     *   template: SUGAR.App.template
     * });
     *
     * This plugin has a hard dependency with SideCar functions. Anyway, if you want to use your own on top of this
     * plugin, make sure that you will have defined:
     *   logger.debug()
     *   date.parse()
     *   date.format()
     *   date.UTCToLocalTime()
     *   date.getRelativeTimeLabel()
     *   lang.get()
     *   template.compile()
     */
    var relativeTimeInterval;
    $.fn.extend({
        timeago:function (options) {
            var self = this, refresh, SugarDate, SugarLog, SugarTemplate, SugarLang;
            options = options || {};

            // required
            if (!options.date || !options.logger || !options.template || !options.lang) return;

            SugarDate = options.date;
            SugarLog = options.logger;
            SugarTemplate = options.template;
            SugarLang = options.lang;
            options.dateFormat = options.dateFormat || 'Y/m/d';
            options.timeFormat = options.timeFormat || 'H:i';

            /**
             * This function pulls the date from the 'title' attribute of the element,
             * converts it in a local date, then gets the relative time and display it.
             */

            refresh = function () {
                var $this = $(this), UTCDate,ctx,
                    formattedDate, formattedTime, relativeTime, relativeTimeTpl, template;

                // REST Api returning ISO 8601 dates so this will be something like "2012-09-06T22:15:00+0000"
                // ISO8601 dates were introduced with ECMAScript v5 - http://kangax.github.com/es5-compat-table/
                var localDate = new Date($this.attr('title')),
                relativeTimeObj = SugarDate.getRelativeTimeLabel(localDate),
                label = ($this.data('label')) ? $this.data('label') : 'LBL_TIME_RELATIVE';

                if (relativeTimeObj.str) {
                    relativeTimeTpl = SugarLang.get(relativeTimeObj.str);
                    relativeTime = SugarTemplate.compile(relativeTimeObj.str, relativeTimeTpl);
                    formattedDate = SugarDate.format(localDate, options.dateFormat);
                    formattedTime = SugarDate.format(localDate, options.timeFormat);
                    ctx = {
                        date:formattedDate,
                        time:formattedTime,
                        relativetime:relativeTime(relativeTimeObj.value)
                    };
                    template = SugarTemplate.compile(label, SugarLang.get(label));

                    $this.text(template(ctx));
                }
                return this;
            };

            // Convert all dates
            self.each(refresh);

            // Add a timer to refresh the relative time each minute
            if (self.length > 0) {
                // Check if a timer is already set
                if (!relativeTimeInterval) {
                    SugarLog.debug('(relative time) Starting a timer to convert ' + self.length + ' date');
                } else {
                    clearInterval(relativeTimeInterval);
                }
                // Set a new timer
                relativeTimeInterval = setInterval(function () {
                    self.each(refresh);
                }, 60 * 1000);
            } else if (relativeTimeInterval) {
                SugarLog.debug('(relative time) Stopping the timer as there is no more date to convert');
                clearInterval(relativeTimeInterval);
                relativeTimeInterval = undefined;
            }
            return self;
        }
    });
});
