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
    fieldTag: "input",

    plugins: ['EllipsisInline'],

    /**
     * Whether the value of this enum should be defaulted to the first item when model attribute is undefined
     * Set to false to prevent this defaulting
     */
    defaultOnUndefined: true,

    //For multi select, we replace the empty key by a temporary key because Select2 doesn't handle empty values well
    BLANK_VALUE_ID: '___i_am_empty___',

    /**
     * @param {Function} callback
     * @override
     */
    bindKeyDown: function(callback) {
        this.$('input').on("keydown.record", {field: this}, callback);
    },

    /**
     * @returns {Field} this
     * @override
     * @private
     */
    _render: function() {
        var self = this;
        if(_.isUndefined(this.items)){
            this.loadEnumOptions(false, function() {
                //Re-render widget since we have fresh options list
                if(!this.disposed){
                    this.render();
                }
            });
        }
        //Use blank value label for blank values on multiselects
        if (this.def.isMultiSelect && !_.isUndefined(this.items['']) && this.items[''] === '') {
            var obj = {};
            _.each(this.items, function(value, key) {
               // Only work on key => value pairs that are not both blank
               if (key !== '' && value !== '') {
                   obj[key] = value;
               }
            }, this);
            this.items = obj;
        }
        var optionsKeys = _.isObject(this.items) ? _.keys(this.items) : [];
        //After rendering the dropdown, the selected value should be the value set in the model,
        //or the default value. The default value fallbacks to the first option if no other is selected.
        if (this.defaultOnUndefined && !this.def.isMultiSelect && _.isUndefined(this.model.get(this.name))) {
            var defaultValue = _.first(optionsKeys);
            if (defaultValue) {
                this.model.set(this.name, defaultValue);
            }
        }
        app.view.Field.prototype._render.call(this);
        var select2Options = this.getSelect2Options(optionsKeys);
        var $el = this.$(this.fieldTag);
        if (!_.isEmpty(optionsKeys)) {
            if (this.tplName === 'edit' || this.tplName === 'list-edit') {
                $el.select2(select2Options);
                $el.select2("container").addClass("tleft");
                $el.on('change', function(ev){
                    var value = ev.val;
                    if(self.model && !(self.name == 'currency_id' && _.isUndefined(value))) {
                        self.model.set(self.name, self.unformat(value));
                    }
                });
                if (this.def.ordered) {
                    $el.select2("container").find("ul.select2-choices").sortable({
                        containment: 'parent',
                        start: function() {
                            $el.select2("onSortStart");
                        },
                        update: function() {
                            $el.select2("onSortEnd");
                        }
                    });
                }
            } else if(this.tplName === 'disabled') {
                $el.select2(select2Options);
                $el.select2('disable');
            }
            //Setup selected value in Select2 widget
            if(this.value){
                // To make pills load properly when autoselecting a string val
                // from a list val needs to be an array
                if (!_.isArray(this.value)) {
                    this.value = [this.value];
                }
                $el.select2('val', this.value);
            }
        } else {
            // Set loading message in place of empty DIV while options are loaded via API
            this.$el.html(app.lang.get("LBL_LOADING"));
        }
        return this;
    },

    /**
     * Called when focus on inline editing
     */
    focus: function () {
        //We must prevent focus for multi select otherwise when inline editing the dropdown is opened and it is
        //impossible to click on a pill `x` icon in order to remove an item
        if(this.action !== 'disabled' && !this.def.isMultiSelect) {
            this.$(this.fieldTag).select2('open');
        }
    },

    /**
     * Load the options for this field and pass them to callback function.  May be asynchronous.
     * @param {Boolean} fetch (optional) Force use of Enum API to load options.
     * @param {Function} callback (optional) Called when enum options are available.
     */
    loadEnumOptions: function(fetch, callback) {
        var self = this,
            meta = app.metadata.getModule(this.module, 'fields'),
            fieldMeta = meta && meta[this.name] ? meta[this.name] : this.def;
        this.items = this.def.options || fieldMeta.options;
        fetch = fetch || false;
        if (fetch || _.isUndefined(this.items)) {
            var _key = 'request:' + this.module + ':' + this.name;
            //if previous request is existed, ignore the duplicate request
            if (this.context.get(_key)) {
                var request = this.context.get(_key);
                request.xhr.done(_.bind(function(o) {
                    if (this.items !== o) {
                        this.items = o;
                        callback.call(this);
                    }
                }, this));
            } else {
                var request = app.api.enumOptions(self.module, self.name, {
                    success: function(o) {
                        if(self.disposed) { return; }
                        if (self.items !== o) {
                            self.items = o;
                            fieldMeta.options = self.items;
                            self.context.unset(_key);
                            callback.call(self);
                        }
                    }
                    // Use Sugar7's default error handler
                });
                this.context.set(_key, request);
            }
        } else if (_.isString(this.items)) {
            this.items = app.lang.getAppListStrings(this.items);
        }
    },

    /**
     * Helper function for generating Select2 options for this enum
     * @param {Array} optionsKeys Set of option keys that will be loaded into Select2 widget
     * @returns {{}} Select2 options, refer to Select2 documentation for what each option means
     */
    getSelect2Options: function(optionsKeys){
        var select2Options = {};
        var emptyIdx = _.indexOf(optionsKeys, "");
        if (emptyIdx !== -1) {
            select2Options.allowClear = true;
            // if the blank option isn't at the top of the list we have to add it manually
            if (emptyIdx > 1) {
                this.hasBlank = true;
            }
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * Initial value that is selected if no other selection is made
         */
        if(!this.def.isMultiSelect) {
            select2Options.placeholder = app.lang.get("LBL_SEARCH_SELECT");
        }
        // Options are being loaded via app.api.enum
        if(_.isEmpty(optionsKeys)){
            select2Options.placeholder = app.lang.get("LBL_LOADING");
        }

        /* From http://ivaynberg.github.com/select2/#documentation:
         * "Calculate the width of the container div to the source element"
         */
        select2Options.width = this.def.enum_width ? this.def.enum_width : '100%';

        /* Because the select2 dropdown is appended to <body>, we need to be able
         * to pass a classname to the constructor to allow for custom styling
         */
        select2Options.dropdownCssClass = this.def.dropdown_class ? this.def.dropdown_class : '';

        /* To get the Select2 multi-select pills to have our styling, we need to be able
         * to either pass a classname to the constructor to allow for custom styling
         * or set the 'select2-choices-pills-close' if the isMultiSelect option is set in def
         */
        select2Options.containerCssClass = this.def.container_class ? this.def.container_class : (this.def.isMultiSelect ? 'select2-choices-pills-close' : '');

        /* Because the select2 dropdown is calculated at render to be as wide as container
         * to make it differ the dropdownCss.width must be set (i.e.,100%,auto)
         */
        if (this.def.dropdown_width) {
            select2Options.dropdownCss = { width: this.def.dropdown_width };
        }

        /* All select2 dropdowns should only show the search bar for fields with 7 or more values,
         * this adds the ability to specify that threshold in metadata.
         */
        select2Options.minimumResultsForSearch = this.def.searchBarThreshold ? this.def.searchBarThreshold : 7;

        /* If is multi-select, set multiple option on Select2 widget.
         */
        if (this.def.isMultiSelect) {
            select2Options.multiple = true;
        }

        /* If we need to define a custom value separator
         */
        select2Options.separator = this.def.separator || ',';
        if (this.def.separator) {
            select2Options.tokenSeparators = [this.def.separator];
        }

        select2Options.initSelection = _.bind(this._initSelection, this);
        select2Options.query = _.bind(this._query, this);

        return select2Options;
    },

    /**
     * Set the option selection during select2 initialization.
     * Also used during drag/drop in multiselects.
     * @param {Selector} $ele Select2 element selector
     * @param {Function} callback Select2 data callback
     * @private
     */
    _initSelection: function($ele, callback){
        var data = [];
        var options = _.isString(this.items) ? app.lang.getAppListStrings(this.items) : this.items;
        var values = $ele.val();
        if (this.def.isMultiSelect) {
            values = values.split(this.def.separator || ',');
        }
        _.each(_.pick(options, values), function(value, key){
            data.push({id: key, text: value});
        }, this);
        if(data.length === 1){
            callback(data[0]);
        } else {
            callback(data);
        }
    },

    /**
     * Adapted from eachOptions helper in hbt-helpers.js
     * Select2 callback used for loading the Select2 widget option list
     * @param {Object} query Select2 query object
     * @private
     */
    _query: function(query){
        var options = _.isString(this.items) ? app.lang.getAppListStrings(this.items) : this.items;
        var data = {
            results: [],
            // only show one "page" of results
            more: false
        };
        if (_.isObject(options)) {
            _.each(options, function(element, index) {
                var text = "" + element;
                //additionally filter results based on query term
                if(query.matcher(query.term, text)){
                    data.results.push({id: index, text: text});
                }
            });
        } else {
            options = null;
        }
        query.callback(data);
    },

    /**
     *  Convert select2 value into model appropriate value for sync
     *
     * @param value Value from select2 widget
     * @return {String|Array} Unformatted value as String or String Array
     */
    unformat: function(value){
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, this.BLANK_VALUE_ID) > -1) {
            value = _.clone(value);

            // Delete empty values from the options array
            delete value[this.BLANK_VALUE_ID];
        }
        if(this.def.isMultiSelect && _.isNull(value)){
            return [];  // Returning value that is null equivalent to server.  Backbone.js won't sync attributes with null values.
        } else {
            return value;
        }
    },

    /**
     * Convert server value into one appropriate for display in widget
     *
     * @param value
     * @return {Array} Value for select2 widget as String Array
     */
    format: function(value){
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, '') > -1) {
            value = _.clone(value);

            // Delete empty values from the select list
            delete value[''];
        }
        if(this.def.isMultiSelect && _.isString(value)){
            return this.convertMultiSelectDefaultString(value);
        } else {
            return value;
        }
    },

    /**
     * Converts multiselect default strings into array of option keys for template
     * @param {String} defaultString string of the format "^option1^,^option2^,^option3^"
     * @return {Array} of the format ["option1","option2","option3"]
     */
    convertMultiSelectDefaultString: function(defaultString) {
        var result = defaultString.split(",");
        _.each(result, function(value, key) {
            // Remove empty values in the selection
            if (value !== '^^') {
                result[key] = value.replace(/\^/g,"");
            }
        });
        return result;
    },

    /**
     * Override to remove default DOM change listener, we use Select2 events instead
     * @override
     */
    bindDomChange: function() {
    },

    /**
     * @override
     */
    unbindDom: function() {
        this.$(this.fieldTag).select2('destroy');
        app.view.Field.prototype.unbindDom.call(this);
    },

    /**
     * @override
     */
    unbindData: function() {
        var _key = 'request:' + this.module + ':' + this.name;
        this.context.unset(_key);
        app.view.Field.prototype.unbindData.call(this);
    }
})
