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

({
    /**
     * Date widget
     *
     * Base implementation for widgets that will use the datepicker. Provides core functionality
     * which can be extended as follows:
     * <pre><code>
     * extendsFrom:'DateField',
     *
     * // Derived must also implement method: _setDateIfDefaultValue
     * _setDateIfDefaultValue: function() {}
     * </code></pre>
     *
     * Derived widgets should set stripIsoTZ to indicate whether ISO 8601 Timezone information should
     * be stripped from dates or left in tact.
     *
     * Any methods defined in date.js may called from derived classes and should work as expected. If
     * core methods like _render, initialize, etc., are overriden, you should consider calling this
     * parent at some point in overriden method. For example, in a DateChild widget you may do:
     * <pre><code>
     * _render:function(value) {
     *     this.doSpecialPreParentInitialization();
     *     app.view.invokeParent(this, {type: 'field', name: 'date', method: '_render', platform: 'base'});
     *     // as it's easy to forget and do app.view.views (notice views not fields at end!)
     *     this.doSomethingElseAfterParentInitialization();
     * },
     * </code></pre>
     */
    datepickerVisible: false,

    // used by hbs template
    dateValue: '',

    // date format (for just the date part) that the server expects
    serverDateFormat: 'Y-m-d',

    // If true, attempts to strip off ISO 8601 TZ related info
    stripIsoTZ: true,

    // If invalid date flag to leave so sidecar validation will catch downstream
    leaveDirty: false,

    plugins: ['EllipsisInline'],

    /**
     * Base initialization
     * @param  {Object} options the options
     */
    initialize: function(options) {
        this.userTimePrefs  = app.user.getPreference('timepref');
        this.usersDatePrefs = app.user.getPreference('datepref');

        // Only for derived widgets that actually have a showAmPm property
        if (!_.isUndefined(this.showAmPm)) {

            // Sugar time format will always have an 'h'. If it ends with either [aA] it requires am/pm.
            this.showAmPm = this.userTimePrefs.match(/[aA]$/)==null ? true : false; // TODO: date.js doesn't yet support g/G options
        }
        app.view.Field.prototype.initialize.call(this, options);
    },
    /**
     * NOP - jquery.timepicker (the plugin we use for time part of datetimecombo widget),
     * triggers both a 'change', and, a 'changeTime' event. If we let base Field's bindDomChange
     * handle, it will result in our format method getting called and we do NOT want that. Essentially,
     * we want our datepicker and timepicker plugins to handle any change related events.
     */
    bindDomChange: function() {
        // NOP -- pass through to prevent base Field's bindDomChange from handling
    },
    /**
     * Set our internal time and date values so hbs picks up
     */
    _presetDateValues: function() {
        this.dateValue = this.$('.datepicker').val();
        this.dateValue = (this.dateValue) ? this.dateValue : '';

        // Only if object has a _setTimeValue
        if (!_.isUndefined(this._setTimeValue) && _.isFunction(this._setTimeValue)) {
            this._setTimeValue();
        }
    },
    /**
     * Set up the Datepicker
     */
    _setupDatepicker: function() {
        this.datepickerMap = this._patchDatepickerMeta(); // converts com_cal_* to languageDictionary
        this.$(".datepicker").attr('placeholder', app.date.toDatepickerFormat(this.usersDatePrefs));
        if(_.isFunction(this.setRequiredPlaceholder) && this.def.required){
            this.setRequiredPlaceholder(this.$(".datepicker"));
        }
        var appendTarget = this.$el.parents('div#drawers').length ? 'div#drawers .main-pane:first' : 'div#content .main-pane:first';
        /* TODO: Remove all this once satisfied language injection works properly ;)
        var spanishLangExample = {
            days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
            daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
            daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
        };*/
        this.$(".datepicker").datepicker({
            //languageDictionary: spanishLangExample, // TODO: remove this too!
            languageDictionary: this.datepickerMap,
            format: (this.usersDatePrefs) ? app.date.toDatepickerFormat(this.usersDatePrefs) : 'mm-dd-yyyy',
            appendTo: appendTarget
        });

        // Bind Datepicker to our proxy functions
        this.$(".datepicker").datepicker().on({
            show: _.bind(this.showDatepicker, this),
            hide: _.bind(this.hideDatepicker, this)
        });

        $('.main-pane.span8').on('scroll', _.bind(function() {
            this.$('.datepicker').datepicker('place');
        }, this));
        $('.flex-list-view-content').on('scroll', _.bind(function() {
            this.$('.datepicker').datepicker('place');
        }, this));
    },

    /**
     * {@inheritdoc}
     */
    _dispose: function() {
        $('.main-pane.span8').off();
        $('.flex-list-view-content').off();
        app.view.Field.prototype._dispose.call(this);
    },
    /**
     * Hook for when datepicker plugin shown.
     */
    showDatepicker: function(ev) {
        this.datepickerVisible = true;
    },
    /**
     * Main hook to update model when datepicker selected.
     */
    hideDatepicker: function(ev) {
        var model     = this.model,
            fieldName = this.name,
            timeValue = '',
            hrsMins   = {},
            dateValue = '',
            $timepicker;

        this.datepickerVisible = false;
        model      = this.model;
        fieldName  = this.name;

        // Only if object has a _setTimepickerValue
        if (!_.isUndefined(this._setTimepickerValue) && _.isFunction(this._setTimepickerValue)) {
            $timepicker= this.$('.ui-timepicker-input');
            // Get time values. If none, set to default of midnight; also get date, set model, etc.
            hrsMins    = this._getHoursMinutes($timepicker);
            this._setTimepickerValue($timepicker, hrsMins.hours, hrsMins.minutes);
        } else {
            // For non datetime type widgets (e.g. date) we simply blank out hours and minutes
            hrsMins    = {
                hours: '00',
                minutes: '00'
            };
        }
        dateValue = this._getDatepickerValue();
        // If date isn't good we set it raw and let sidecar catch upstream in validation.
        if (this._verifyDateString(dateValue)) {
            this.leaveDirty = false;
            model.set(fieldName, this._buildUnformatted(dateValue, hrsMins.hours, hrsMins.minutes));
        } else {
            this.leaveDirty = true;//leave invalid date value alone so sidecar can catch on validation
            model.set(fieldName, dateValue, hrsMins.hours, hrsMins.minutes);
        }
    },
    /**
     * Verifies the parts of a date string are valid according to:
     * 1. formats supported by SugarCRM
     * 2. the user's current date format
     * Note that due to several browser limitations, we can only confirm the validity of
     * the "date parts" in relation to SugarCRM's supported formats and user's current
     * date format (and cannot guarantee JavaScript Date.parse, etc., can handle this date!)
     * @param  {String} value The date string
     * @return {Boolean}       True if valid, false if not.
     */
    _verifyDateString: function(value) {
        var sep, parsed, parts, valueWithForwardSlash,
            dateFormat = (this.usersDatePrefs) ? app.date.toDatepickerFormat(this.usersDatePrefs) : 'mm-dd-yyyy';
        //First try generic date parse (since we might have an ISO). This should generally work with the
        //ISO date strings we get from server.
        parsed = Date.parse(value);
        //Firefox for invalid date returns negative value instead NaN.
        if(_.isNaN(parsed) || parsed < 0) {
            // If generic Date.parse doesn't work, defer to the more robust bootstrap-datepicker verifier
            return $.prototype.DateVerifier(value, dateFormat);
        }
        return true;
    },
    _buildUnformatted: function(d, h, m) {
        var parsedDate = app.date.parse(d, this.usersDatePrefs);
        d = app.date.format(parsedDate, this.serverDateFormat);
        return this.unformat(d + ' ' + h + ':' + m + ':00');
    },
    /**
     * Gets the current datepicker value.
     *
     * Note: If we have no date (e.g. display default was set to none), when the
     * user selects time part, date part will be pre-filled with today's date.
     */
    _getDatepickerValue: function() {
        var date  = this.$('input.datepicker'), dateValue;

        dateValue = this._getTodayDateStringIfNoDate(date.prop('value'));
        this.dateValue = dateValue; // so hbs template will pick up on next render
        return dateValue;
    },
    /**
     * Sets the current datepicker value.
     * @param String dateValue date value
     */
    _setDatepickerValue: function(dateValue) {
        var date = this.$('input.datepicker');
        dateValue = this._getTodayDateStringIfNoDate(dateValue);
        date.prop('value', dateValue);
    },
    /**
     * Set the date string for REST Api. If stripT
     * @param {Date} The date we want formatted
     * @param {Boolean} Forces the format to just have yyyy-mm-dd
     * @return {String} API ready date string
     */
    _setServerDateString: function(jsDate, forceToDate) {
        var h, m, d;

        /**
         * If we don't want the timezone info we get something like: 2012-12-31T01:30:00
         * which the server will honor. With timezone will be like: "2012-12-31T01:30:00.814Z"
         */

        d = app.date.format(jsDate, this.serverDateFormat);

        // Server wants this to be in yyyy-mm-dd format (TimeDate.php fromIsoDate wants it this way)
        if (forceToDate) {
            return d;
        }
        if (this.stripIsoTZ) {
            d = app.date.format(jsDate, this.serverDateFormat);
            h = this._forceTwoDigits(jsDate.getHours().toString());
            m = this._forceTwoDigits(jsDate.getMinutes().toString());
            return d + 'T' + h + ':' + m + ':00';
        }
        if (_.isFunction(jsDate.toISOString)) {
            // With timezone info
            return jsDate.toISOString();
        }
        return jsDate;
    },
    /**
     * Checks if dateStringToCheck is falsy..if so, returns today's date as string formatted by
     * user's prefs. Otherwise, just returns dateStringToCheck.
     * @param {String} dateStringToCheck Date string
     * @return {String} Date string
     */
    _getTodayDateStringIfNoDate: function(dateStringToCheck) {
        if (!dateStringToCheck) {
            var d = new Date();
            return app.date.format(d, this.usersDatePrefs);
        }
        return dateStringToCheck;
    },
    /**
     * Gets the name of this view.
     * @return {String} view name
     */
    _getViewName: function() {
        return this.view.meta && this.view.meta.type ? this.view.meta.type : this.view.name;
    },
    /**
     * Determines if this view is edit view.
     * @param {String} The view name
     * @return Boolean true if edit view
     */
    _isEditView: function(viewName) {
        if(this.options.def.view === 'edit' || this.options.viewName === 'edit' || viewName === 'edit') {
            return true;
        }
        return false;
    },

    // Patches our dom_cal_* metadata for use with our datepicker plugin since they're very similar.
    _patchDatepickerMeta: function() {
        var pickerMap = [], pickerMapKey, calMapIndex, mapLen, domCalKey,
            calProp, appListStrings, calendarPropsMap, i, filterIterator;

        appListStrings = app.metadata.getStrings('app_list_strings');

        filterIterator = function(v, k, l) {
            return v !== "";
        };

        // Note that ordering here is used in following for loop
        calendarPropsMap = ['dom_cal_day_long', 'dom_cal_day_short', 'dom_cal_month_long', 'dom_cal_month_short'];

        for (calMapIndex = 0, mapLen = calendarPropsMap.length; calMapIndex < mapLen; calMapIndex++) {

            domCalKey = calendarPropsMap[calMapIndex];
            calProp  = appListStrings[domCalKey];

            // Patches the metadata to work w/datepicker; initially, "calProp" will look like:
            // {0: "", 1: "Sunday", 2: "Monday", 3: "Tuesday", 4: "Wednesday", 5: "Thursday", 6: "Friday", 7: "Saturday"}
            // But we need:
            // ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]
            if (!_.isUndefined(calProp) && !_.isNull(calProp)) {
                // Reject the first 0: "" element
                calProp = _.filter(calProp, filterIterator);
                //e.g. pushed the Sun in front to end (as required by datepicker)
                calProp.push(calProp[0]);
            }
            switch (calMapIndex) {
                case 0:
                    pickerMapKey = 'day';
                    break;
                case 1:
                    pickerMapKey = 'daysShort';
                    break;
                case 2:
                    pickerMapKey = 'months';
                    break;
                case 3:
                    pickerMapKey = 'monthsShort';
                    break;
            }
            pickerMap[pickerMapKey] = calProp;
        }

        // Now add a daysMin property with just two chars per day Su Mo, etc.
        pickerMap['daysMin'] = _.map(pickerMap.daysShort, function(day) {
            return (day.length > 1) ? day.substr(0,2) : day;
        });

        return pickerMap;
    },
    /**
     * Helper to determine if this is an edit view
     * @param  {String}  value value
     * @return {Boolean} true if edit view
     */
    _isNewEditViewWithNoValue: function(value) {
        return (this.model.isNew() && !value && this._isEditView(this._getViewName()));
    },
    /**
     * Pads an int string to two digits.
     * @param {String} numstr The int as string
     */
    _forceTwoDigits: function(numstr) {
        return numstr.length === 1 ? '0' + numstr: numstr;
    },

    /**
     * Main render method. Sets up datepicker if view type "edit".
     * @param  {String} value the value
     */
    _render: function(value) {
        var self = this, viewName;

        self._presetDateValues();

        app.view.Field.prototype._render.call(this);//call proto render

        viewName = self._getViewName();

        $(function() {
            if (self._isEditView(viewName)) {
                self._setupDatepicker();
            }
        });
        if (Modernizr.touch) {
           this.$("[rel=datepicker]").attr('readonly',true);
        }
    },
    /**
     * Formats value per user's preferences
     * @param {String} value The value to format
     * @return {String} Formatted value
     */
    format:function(value) {
        var jsDate, parts;
        if (this._isNewEditViewWithNoValue(value)) {
            // If there is a default 'string' value like "yesterday", format it as a date
            jsDate = this._setDateIfDefaultValue();
            if (!jsDate) {
                return value;
            }
            value  = app.date.format(jsDate, this.usersDatePrefs);
        } else if (!value) {
            return value;
        } else if (!this.leaveDirty) {
            // Bug 56249 .. Date constructor doesn't reliably handle yyyy-mm-dd
            // e.g. new Date("2011-10-10" ) // in my version of chrome browser returns
            // Sun Oct 09 2011 17:00:00 GMT-0700 (PDT)
            parts = value.match(/(\d+)/g);
            // Bug 59827: In IE and FF, when changing from 100/23/2013 to 1//2013, got NaN/NaN/NaN.
            if (parts && parts.length > 2) {
                jsDate = new Date(parts[0], parts[1]-1, parts[2]); //months are 0-based
                value  = app.date.format(jsDate, this.usersDatePrefs);
            } else {
                return value;
            }
        } // else leave dirty is true so "no op"

        this.dateValue = value;
        this.$(".datepicker").datepicker('update', this.dateValue);
        jsDate = app.date.parse(value);
        return app.date.format(jsDate, this.usersDatePrefs);
    },

    /**
     * Overrides basedate's unformat.
     */
    unformat:function(value) {
        // In case ISO 8601 get it back to js native date which date.format understands
        var jsDate = new Date(value);

        // Safari chokes on '.', '-', (supported by datepicker), so retry replacing with '/'
        if (!jsDate || jsDate.toString() === 'Invalid Date') {
            jsDate = new Date(value.replace(/[\.\-]/g, '/'));
        }
        return app.date.format(jsDate, this.serverDateFormat);

    },

    /**
     * If the field def has a display_default property, or, is required, this
     * will set the model with corresponding date time.
     * @return {Date} The date created
     */
    _setDateIfDefaultValue: function() {
        var value, jsDate;

        if (this.def.display_default) {
            jsDate = app.date.parseDisplayDefault(this.def.display_default);
            this.model.set(this.name, app.date.format(jsDate, this.serverDateFormat));
        } else {
            return null;
        }
        return jsDate;
    },

    unbindDom: function() {
        app.view.Field.prototype.unbindDom.call(this);
    },
    /**
     * Custom error styling for date field
     * @param {Object} errors
     * @override BaseField
     */
    decorateError: function (errors) {
        var ftag = this.fieldTag || '',
            $ftag = this.$(ftag),
            errorMessages = [],
            $tooltip;

        // Add error styling
        this.$el.closest('.record-cell').addClass('error');
        this.$el.addClass('error');

        this.$el.find(".add-on").remove();
        // For each error add to error help block
        _.each(errors, function (errorContext, errorName) {
            errorMessages.push(app.error.getErrorString(errorName, errorContext));
        });
        $ftag.wrap('<div class="input-append error ' + ftag + '">');
        $ftag.after(this.exclamationMarkTemplate(errorMessages)+'<span class="add-on"><i class="icon-calendar"></i></span>');
        $tooltip = this.$('.error-tooltip');
        if (_.isFunction($tooltip.tooltip)) {
            var tooltipOpts = { container: 'body', placement: 'top', trigger: 'click' };
            $tooltip.tooltip(tooltipOpts);
        }
    },
    /**
     * Remove error decoration from field if it exists.
     */
    clearErrorDecoration: function () {
        var ftag = this.fieldTag || '',
            $ftag = this.$(ftag);
        var isWrapped = $ftag.parent().hasClass('input-append');
        if (isWrapped) {
            $ftag.parent().removeClass('error');
        }
        this.$el.removeClass(ftag);
        this.$el.removeClass("error");
        this.$el.closest("span.edit").removeClass('error');
        this.$el.closest('.record-cell').removeClass("error");
    }
})
