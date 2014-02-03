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
     * used to hold the label string from metadata to get rendered in the template.
     */
    label: '',

    /**
     * used to hold the metadata for the forecasts_ranges field, used to manipulate and render out as the radio buttons
     * that correspond to the fieldset for each bucket type.
     */
    forecastRangesField: {},

    /**
     * Used to hold the buckets_dom field metadata, used to retrieve and set the proper bucket dropdowns based on the
     * selection for the forecast_ranges
     */
    bucketsDomField: {},

    /**
     * Used to hold the category_ranges field metadata, used for rendering the sliders that correspond to the range
     * settings for each of the values contained in the selected buckets_dom dropdown definition.
     */
    categoryRangesField: {},

    /**
     * Used to keep track of the selection as it changes so that it can be used to determine how to hide and show the
     * sub-elements that contain the fields for setting the category ranges
     */
    selection: '',

    /**
     * a placeholder for the individual range sliders that will be used to build the range setting
     */
    fieldRanges: {},

    //TODO-sfa remove this once the ability to map buckets when they get changed is implemented (SFA-215).
    /**
     * This is used to determine whether we need to lock the module or not, based on whether forecasts has been set up already
     */
    disableRanges: false,

    /**
     * Holds the selected ranges ('Two Ranges', 'Three Ranges') section to add to the accordion toggle
     */
    titleSelectedRange: '',

    /**
     * Holds the selected range values ('70% - 100%') to add to the accordion toggle
     */
    titleSelectedValues: '',

    /**
     * Holds the view's title name
     */
    titleViewNameTitle: '',

    /**
     * Holds the collapsible toggle title template
     */
    toggleTitleTpl: {},

    /**
     * Holds the fields metadata
     */
    fieldsMeta: {},

    /**
     * Holds the values found in Forecasts Config commit_stages_included value
     */
    includedCommitStages: [],

    /**
     * Adds event listener to elements
     */
    events: {
        'click #btnAddCustomRange a': 'addCustomRange',
        'click #btnAddCustomRangeWithoutProbability a': 'addCustomRange',
        'click .addCustomRange': 'addCustomRange',
        'click .removeCustomRange': 'removeCustomRange',
        'keyup input[type=text]': 'updateCustomRangeLabel',
        'change input[type=checkbox]': 'updateCustomRangeIncludeInTotal',
        'click .resetLink': 'onResetLinkClicked'
    },

    /**
     * {@inheritdoc}
     *
     * @param {Object} options
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);

        this.titleViewNameTitle = app.lang.get('LBL_FORECASTS_CONFIG_TITLE_RANGES', 'Forecasts');

        this.label = _.first(this.meta.panels).label;

        // get the fields metadata
        this.fieldsMeta = _.first(this.meta.panels).fields;

        // init the fields from metadata
        this.forecastRangesField = this.fieldsMeta.forecast_ranges;
        this.bucketsDomField = this.fieldsMeta.buckets_dom;
        this.categoryRangesField = this.fieldsMeta.category_ranges;

        // Set this model equal to the latest config metadata
        // using jQuery's deep clone extend() because otherwise the range updates actually update
        // the values in config itself
        this.model.set($.extend(true, {}, app.metadata.getModule('Forecasts', 'config')));
        
        this.updateTitleValues(this.model);
        this.forecastByModule = app.lang.getAppListStrings('moduleList')[this.model.get('forecast_by')];

        // get the included commit stages
        this.includedCommitStages = this.model.get('commit_stages_included'),

        // set the values for forecastRangesField and bucketsDomField from the model, so it can be set to selected properly when rendered
        this.forecastRangesField.value = this.model.get('forecast_ranges');
        this.bucketsDomField.value = this.model.get('buckets_dom');
        this.toggleTitleTpl = app.template.getView('forecastsConfigHelpers.toggleTitle', 'Forecasts');
    },

    /**
     * Handles when reset to defaults link has been clicked for this view
     *
     * @param {jQuery.Event} evt click event
     */
    onResetLinkClicked: function(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();

        /**
         * todo implement resetting to defaults
         */
    },

    /**
     * {@inheritdoc}
     */
    bindDataChange: function() {
        if(this.model) {
            this.model.on('change', function(model) {
                this.updateTitleValues(model);
            }, this);
        }
    },

    /**
     * Load the values for the title in case the model hasn't changed when config loads
     *
     * @param {Backbone.Model} model
     */
    updateTitleValues: function(model) {
        // on a fresh install with no demo data,
        // this.model has the values and the param model is undefined
        if(_.isUndefined(model)) {
            model = this.model;
        }

        var forecastRanges = model.get('forecast_ranges'),
            rangeObjs = model.get(forecastRanges + '_ranges'),
            tmpObj = {},
            str = '';

        // Get the keys into an object
        _.each(rangeObjs, function(vals) {
            tmpObj[vals.min] = vals.max;
        });

        _.each(tmpObj, function(max,min) {
            str += min + "% - " + max + "%, ";
        });

        str = str.slice(0, str.length - 2);

        this.titleSelectedValues = str;

        this.titleSelectedRange = app.lang.getAppListStrings('forecasts_config_ranges_options_dom')[forecastRanges];
        if(_.isFunction(this.toggleTitleTpl)) {
            this.updateTitle();
        }
    },

    /**
     * Updates the accordion toggle title
     */
    updateTitle: function() {
        var tplVars = {
            title: this.titleViewNameTitle,
            message: this.titleSelectedRange,
            selectedValues: this.titleSelectedValues,
            viewName: 'forecastsConfigRanges'
        };

        this.$el.find('#' + this.name + 'Title').html(this.toggleTitleTpl(tplVars));
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        //TODO-sfa remove this once the ability to map buckets when they get changed is implemented (SFA-215).
        // This will be set to true if the forecasts ranges setup should be disabled
        this.disableRanges = this.model.get('has_commits');
        this.selection = this.model.get('forecast_ranges');

        app.view.View.prototype._render.call(this);

        // add accordion-group class to wrapper $el div
        this.$el.addClass('accordion-group');

        this._addForecastRangesSelectionHandler();
        this.updateTitle();
        return this;
    },

    /**
     * Adds the selection event handler on the forecast ranges radio which sets the value of the bucket selection
     * on the model, the correct dropdown list based on that selection, as well as opens up the element to
     * show the range setting sliders
     *
     * @private
     */
    _addForecastRangesSelectionHandler: function() {
        // finds all radiobuttons with this name
        var elements = this.$el.find(':radio[name="' + this.forecastRangesField.name + '"]');

        // apply the change handler to each of the ranges radio button elements.
        _.each(elements, function(el) {
            $(el).change({
                view: this
            }, this.selectionHandler);
            // of the elements find the one that is checked
            if($(el).prop('checked')) {
                // manually trigger the handler on the checked element so that it will render
                // for the default/previously set value
                $(el).triggerHandler("change");
            }
        }, this);
    },

    /**
     * Handles when the radio buttons change
     *
     * @param {jQuery.Event} event
     */
    selectionHandler: function(event) {
        var view = event.data.view,
            oldValue,
            bucket_dom,
            hideElement,
            showElement;

        // get the value of the previous selection so that we can hide that element
        oldValue = view.selection;
        // now set the new selection, so that if they change it, we can later hide the things we are about to show.
        view.selection = this.value;

        bucket_dom = view.bucketsDomField.options[this.value];

        hideElement = view.$el.find('#' + oldValue + '_ranges');
        showElement = view.$el.find('#' + this.value + '_ranges');

        if(showElement.children().length == 0) {
            this.value == 'show_custom_buckets' ? view._customSelectionHandler(this, showElement) : view._selectionHandler(this, showElement);

            // use call to set context back to the view for connecting the sliders
            view.connectSliders.call(view, this.value, view.fieldRanges);
        }

        if(hideElement) {
            hideElement.toggleClass('hide', true);
        }
        if(showElement) {
            showElement.toggleClass('hide', false);
        }

        // set the forecast ranges and associated dropdown dom on the model
        view.model.set(this.name, this.value);
        view.model.set(view.bucketsDomField.name, bucket_dom);
    },

    /**
     * Selection handler for standard ranges (two and three ranges)
     *
     * @param {Object} element HTML element for the radio button that was clicked
     * @param {jQuery Object} showElement the jQuery-wrapped html element from selectionHandler
     * @private
     */
    _selectionHandler: function(element, showElement) {
        var bucket_dom = this.bucketsDomField.options[element.value];

        // add the things here...
        this.fieldRanges[element.value] = {};
        showElement.append('<p>' + app.lang.get('LBL_FORECASTS_CONFIG_' + element.value.toUpperCase() + '_RANGES_DESCRIPTION', 'Forecasts', this) + '</p>');

        _.each(app.lang.getAppListStrings(bucket_dom), function(label, key) {
            if(key != 'exclude') {

                var rangeField,
                    model = new Backbone.Model(),
                    fieldSettings;

                // get the value in the current model and use it to display the slider
                model.set(key, this.view.model.get(this.category + '_ranges')[key]);

                // build a range field
                fieldSettings = {
                    view: this.view,
                    def: this.view.fieldsMeta.category_ranges[key],
                    viewName: 'edit',
                    context: this.view.context,
                    module: this.view.module,
                    model: model,
                    meta: app.metadata.getField('range')
                };

                rangeField = app.view.createField(fieldSettings);
                this.showElement.append('<b>' + label + ':</b>').append(rangeField.el);
                rangeField.render();

                // now give the view a way to get at this field's model, so it can be used to set the value on the
                // real model.
                this.view.fieldRanges[this.category][key] = rangeField;

                // this gives the field a way to save to the view's real model. It's wrapped in a closure to allow us to
                // ensure we have everything when switching contexts from this handler back to the view.
                rangeField.sliderDoneDelegate = function(category, key, view) {
                    return function(value) {
                        this.view.updateRangeSettings(category, key, value);
                    };
                }(this.category, key, this.view);
            }
        }, {view: this, showElement: showElement, category: element.value});
        showElement.append($('<p>' + app.lang.get("LBL_FORECASTS_CONFIG_RANGES_EXCLUDE_INFO", "Forecasts") + '</p>'));
    },

    /**
     * Selection handler for custom ranges
     *
     * @param {Object} element HTML element for the radio button that was clicked
     * @param {jQuery Object} showElement the jQuery-wrapped html element from selectionHandler
     * @private
     */
    _customSelectionHandler: function(element, showElement) {
        var bucket_dom = this.bucketsDomField.options[element.value],
            bucket_dom_options = [],
            rangeField,
            _ranges;

        // add the things here...
        this.fieldRanges[element.value] = {};
        showElement.append('<p>' + app.lang.get('LBL_FORECASTS_CONFIG_' + element.value.toUpperCase() + '_RANGES_DESCRIPTION', 'Forecasts', this) + '</p>');

        // if custom bucket isn't defined seve default values
        if(!this.model.has(element.value + '_ranges')) {
            this.model.set(element.value + '_ranges', {});
        }
        _.each(app.lang.getAppListStrings(bucket_dom), function(label, key) {
            if (_.isUndefined(this.view.model.get(this.category + '_ranges')[key])) {
                // the range doesn't exist, so we add it to the ranges
                _ranges = this.view.model.get(this.category + '_ranges');
                _ranges[key] = {min: 0, max: 100, in_included_total: false};
                this.view.model.set(this.category + '_ranges', _ranges);
            } else {
                // the range already exists, update the in_included_total value
                _ranges = this.view.model.get(this.category + '_ranges');
                _ranges[key].in_included_total = (_.contains(this.view.includedCommitStages, key));
                this.view.model.set(this.category + '_ranges', _ranges);
            }
            bucket_dom_options.push([key, label]);
        }, {view: this, category: element.value});

        // save key and label of custom range from the language file to model
        // then we can add or remove ranges and save it on backend side
        // bind handler on change to validate data
        this.model.set(element.value + '_options', bucket_dom_options);
        this.model.on('change:' + element.value + '_options', function(event) {
            this.view.validateCustomRangeLabels(this.category);
        }, {view: this, category: element.value});

        // create layout, create pleceholders for different types of custom ranges
        this._renderCustomRangesLayout(showElement, element.value);

        // render custom ranges
        _.each(app.lang.getAppListStrings(bucket_dom), function(label, key) {
            rangeField = this.view._renderCustomRange(key, label, showElement, element.value);
            // now give the view a way to get at this field's model, so it can be used to set the value on the
            // real model.
            this.view.fieldRanges[element.value][key] = rangeField;
        }, { view: this, showElement: showElement, category: element.value });

        // if there are custom ranges not based on probability hide add button on the top of block
        if(this._getLastCustomRangeIndex(element.value, 'custom')) {
            this.$el.find('#btnAddCustomRange').hide();
        }

        // if there are custom ranges not based on probability hide add button on the top of block
        if(this._getLastCustomRangeIndex(element.value, 'custom_without_probability')) {
            this.$el.find('#btnAddCustomRangeWithoutProbability').hide();
        }
    },

    /**
     * Render layout for custom ranges, add placeholders for different types of ranges
     *
     * @param {jQuery Object} showElement the jQuery-wrapped html element from selectionHandler
     * @param {String} category type for the ranges 'show_binary' etc.
     * @private
     */
    _renderCustomRangesLayout : function(showElement, category) {
        var template =
            '<p><b>{{str "LBL_FORECASTS_RANGES_BASED_TITLE" "Forecasts"}}</b></p>'+
                '<div id="plhCustomProbabilityRanges">'+
                '   <div id="plhCustomDefault"></div>'+
                '   <p><b>{{str "LBL_FORECASTS_CUSTOM_BASED_TITLE" "Forecasts"}}</b></p>'+
                '   <div id="plhCustom"></div>'+
                '   <div id="plhExclude">'+
                '       <div class="btn-group" id="btnAddCustomRange"><a class="btn" href="javascript:void(0)" data-type="custom" data-category="{{category}}"><i class="icon-plus"></i></a></div>'+
                '   </div>'+
                '</div>'+
                '<p><b>{{str "LBL_FORECASTS_CUSTOM_NO_BASED_TITLE" "Forecasts"}}</b></p>'+
                '<div id="plhCustomWithoutProbability">'+
                '   <div class="btn-group" id="btnAddCustomRangeWithoutProbability"><a class="btn" href="javascript:void(0)" data-type="custom_without_probability" data-category="{{category}}"><i class="icon-plus"></i></a></div>'+
                '</div>';
        showElement.append( Handlebars.compile(template)({category: category}) );
    },

    /**
     * Creates a new custom range field and renders it in showElement
     *
     * @param {String} key
     * @param {String} label
     * @param {jQuery Object} showElement the jQuery-wrapped html element from selectionHandler
     * @param {String} category type for the ranges 'show_binary' etc.
     * @private
     * @return View.field new created field
     */
    _renderCustomRange: function(key, label, showElement, category) {
        var customType = key,
            customIndex = 0,
            isExclude = false,
        // placeholder to insert custom range
            currentPlh = showElement,
            rangeField,
            model = new Backbone.Model(),
            fieldSettings,
            lastCustomRange;

        // define type of new custom range based on name of range and choose placeholder to insert
        // custom_default: include, upside or exclude
        // custom - based on probability
        // custom_without_probability - not based on probability
        if(key.substring(0, 26) == 'custom_without_probability') {
            customType = 'custom_without_probability';
            customIndex = key.substring(27);
            currentPlh = this.$el.find('#plhCustomWithoutProbability');
        } else if(key.substring(0, 6) == 'custom') {
            customType = 'custom';
            customIndex = key.substring(7);
            currentPlh = this.$el.find('#plhCustom');
        } else if(key.substring(0, 7) == 'exclude') {
            customType = 'custom_default';
            currentPlh = this.$el.find('#plhExclude');
            isExclude = true;
        } else {
            customType = 'custom_default';
            currentPlh = this.$el.find('#plhCustomDefault');
        }

        // get the value in the current model and use it to display the slider
        model.set(key, this.model.get(category + '_ranges')[key]);

        // get the field definition from
        var fieldDef = this.fieldsMeta.category_ranges[key] || this.fieldsMeta.category_ranges[customType];

        // build a range field
        fieldSettings = {
            view: this,
            def: _.clone(fieldDef),
            viewName: 'forecastsCustomRange',
            context: this.context,
            module: this.module,
            model: model,
            meta: app.metadata.getField('range')
        };
        // set up real range name
        fieldSettings.def.name = key;
        // set up view
        fieldSettings.def.view = 'forecastsCustomRange';
        // enable slider
        fieldSettings.def.enabled = true;

        rangeField = app.view.createField(fieldSettings);
        currentPlh.append(rangeField.el);
        rangeField.label = label;
        rangeField.customType = customType;
        rangeField.customIndex = customIndex;
        rangeField.isExclude = isExclude;
        rangeField.in_included_total = (_.contains(this.includedCommitStages, key));
        rangeField.category = category;
        rangeField.render();

        // enable slider after render
        rangeField.$el.find(rangeField.fieldTag).noUiSlider('enable');

        // hide add button for previous custom range not based on probability
        lastCustomRange = this._getLastCustomRange(category, rangeField.customType);
        if(!_.isUndefined(lastCustomRange)) {
            lastCustomRange.$el.find('.addCustomRange').parent().hide();
        }

        _.isEmpty(rangeField.label) ? rangeField.$el.find('.control-group').addClass('error') : rangeField.$el.find('.control-group').removeClass('error');

        // this gives the field a way to save to the view's real model. It's wrapped in a closure to allow us to
        // ensure we have everything when switching contexts from this handler back to the view.
        rangeField.sliderDoneDelegate = function(category, key, view) {
            return function(value) {
                this.view.updateRangeSettings(category, key, value);
            };
        }(category, key, this);

        return rangeField;
    },

    /**
     * Returns the index of the last custom range or 0
     *
     * @param {String} category type for the ranges 'show_binary' etc.
     * @param {String} customType
     * @return {Number}
     * @private
     */
    _getLastCustomRangeIndex: function(category, customType) {
        var lastCustomRangeIndex = 0;
        // loop through all ranges, if there are multiple ranges with the same customType, they'll just overwrite
        // each other's index and after the loop we'll have the final index left
        if(this.fieldRanges[category]) {
            _.each(this.fieldRanges[category], function(range) {
                if(range.customType == customType && range.customIndex > lastCustomRangeIndex) {
                    lastCustomRangeIndex = range.customIndex;
                }
            }, this);
        }
        return lastCustomRangeIndex;
    },

    /**
     * Returns the last created custom range object, if no range object, return upside/include
     * for custom type and exclude for custom_without_probability type
     *
     * @param {String} category type for the ranges 'show_binary' etc.
     * @param {String} customType
     * @return {*}
     * @private
     */
    _getLastCustomRange: function(category, customType) {
        if(this.fieldRanges[category] && !_.isEmpty(this.fieldRanges[category])) {
            var lastCustomRange = undefined;
            // loop through all ranges, if there are multiple ranges with the same customType, they'll just overwrite
            // each other on lastCustomRange and after the loop we'll have the final one left
            _.each(this.fieldRanges[category], function(range) {
                if(range.customType == customType
                    && (_.isUndefined(lastCustomRange) || range.customIndex > lastCustomRange.customIndex)) {
                    lastCustomRange = range;
                }
            }, this);

            if(_.isUndefined(lastCustomRange)) {
                // there is not custom range - use default ranges
                if(customType == 'custom') {
                    // use upside or include
                    lastCustomRange = this.fieldRanges[category].upside || this.fieldRanges[category].include;
                } else {
                    // use exclude
                    lastCustomRange = this.fieldRanges[category].exclude;
                }
            }
        }

        return lastCustomRange;
    },

    /**
     * Adds a new custom range field and renders it in specific placeholder
     *
     * @param {jQuery.Event} event click
     */
    addCustomRange: function(event) {
        var view = this,
            category = $(event.currentTarget).data('category') || null,
            customType = $(event.currentTarget).data('type') || null,
            ranges = view.model.get(category + '_ranges'),
            bucket_dom_options = view.model.get(category + '_options'),
            showElement = ( customType == 'custom' ) ? view.$el.find('#plhCustom') : view.$el.find('#plhCustomWithoutProbability'),
            label = app.lang.get('LBL_FORECASTS_CUSTOM_RANGES_DEFAULT_NAME', 'Forecasts'),
            key,
            rangeField,
            lastCustomRange,
            lastCustomRangeIndex,
            lastOptionIndex;

        if ( _.isNull(category) || _.isNull(customType) ||
            _.isUndefined(ranges) && _.isUndefined(bucket_dom_options) ) {
            return false;
        }

        lastCustomRange = view._getLastCustomRange(category, customType);
        lastCustomRangeIndex = view._getLastCustomRangeIndex(category, customType);
        lastCustomRangeIndex++;

        // setup key for the new range
        key = customType + '_' + lastCustomRangeIndex;

        // set up min/max values for new custom range
        if(customType != 'custom') {
            // if range is without probability setup min and max values to 0
            ranges[key] = {min: 0, max: 0, in_included_total:false};
        } else if ( ranges.exclude.max - ranges.exclude.min > 3 ) {
            // decrement exclude range to insert new range
            ranges[key] = {min: parseInt(ranges.exclude.max, 10) - 1, max: parseInt(ranges.exclude.max, 10), in_included_total:false};
            ranges.exclude.max = parseInt(ranges.exclude.max, 10) - 2;
            if(!_.isUndefined(view.fieldRanges[category].exclude.$el)) {
                view.fieldRanges[category].exclude.$el.find(view.fieldRanges[category].exclude.fieldTag).noUiSlider('move', {handle: 'upper', to: ranges.exclude.max});
            }
        } else if(ranges[lastCustomRange.name].max - ranges[lastCustomRange.name].min > 3) {
            // decrement previous range to insert new range
            ranges[key] = {min: parseInt(ranges[lastCustomRange.name].min, 10), max: parseInt(ranges[lastCustomRange.name].min, 10) + 1, in_included_total:false};
            ranges[lastCustomRange.name].min = parseInt(ranges[lastCustomRange.name].min, 10) + 2;
            if(!_.isUndefined(lastCustomRange.$el)) {
                lastCustomRange.$el.find(lastCustomRange.fieldTag).noUiSlider('move', {handle: 'lower', to: ranges[lastCustomRange.name].min});
            }
        } else {
            // TODO
            ranges[key] = {min: parseInt(ranges[lastCustomRange.name].min, 10) - 2, max: parseInt(ranges[lastCustomRange.name].min, 10) - 1, in_included_total:false};
        }

        view.model.unset(category + '_ranges', {silent: true});
        view.model.set(category + '_ranges', ranges);

        rangeField = view._renderCustomRange(key, label, showElement, category);
        if(!_.isUndefined(rangeField) && !_.isNull(rangeField)) {
            view.fieldRanges[category][key] = rangeField;
        }

        // add range to options
        _.each(bucket_dom_options, function(item, key) {
            if(item[0] == this.value) {
                lastOptionIndex = key;
            }
        }, {value: lastCustomRange.name});

        bucket_dom_options.splice(lastOptionIndex + 1, 0, [key, label]);
        view.model.unset(category + '_options', {silent: true});
        view.model.set(category + '_options', bucket_dom_options);

        if(customType == 'custom') {
            // use call to set context back to the view for connecting the sliders
            view.$el.find('#btnAddCustomRange').hide();
            view.connectSliders.call(view, category, view.fieldRanges);
        } else {
            // hide add button form top of block and for previous ranges not based on probability
            view.$el.find('#btnAddCustomRangeWithoutProbability').hide();
            _.each(view.fieldRanges[category], function(item) {
                if(item.customType == this.key && item.customIndex < this.index && !_.isUndefined(item.$el)) {
                    item.$el.find('.addCustomRange').parent().hide();
                }
            }, this);
        }
    },

    /**
     * Removes a custom range from the model and view
     *
     * @param {jQuery.Event} event click
     * @return void
     */
    removeCustomRange : function(event) {
        var view = this,
            category = $(event.currentTarget).data('category') || null,
            fieldKey = $(event.currentTarget).data('key') || null,
            ranges = view.model.get(category + '_ranges'),
            bucket_dom_options = view.model.get(category + '_options'),
            range,
            previousCustomRange,
            lastCustomRangeIndex,
            lastCustomRange,
            optionIndex;

        if (_.isNull(category) || _.isNull(fieldKey) || _.isUndefined(view.fieldRanges[category])
            || _.isUndefined(view.fieldRanges[category][fieldKey]) || _.isUndefined(ranges)
            || _.isUndefined(bucket_dom_options))
             {
            return false;
        }

        range = view.fieldRanges[category][fieldKey];

        if ( _.indexOf(['include', 'upside', 'exclude'], range.name) != -1 ) {
            return false;
        }

        if(range.customType == 'custom') {
            // find previous renge and reassign range values form removed to it
            _.each(this.fieldRanges[category], function(item) {
                if(item.customType == 'custom' && item.customIndex < range.customIndex) {
                    previousCustomRange = item;
                }
            }, this);

            if(_.isUndefined(previousCustomRange)) {
                previousCustomRange = !_.isUndefined(view.fieldRanges[category].upside) ? view.fieldRanges[category].upside : view.fieldRanges[category].include;
            }

            ranges[previousCustomRange.name].min = +ranges[range.name].min;

            if(!_.isUndefined(previousCustomRange.$el)) {
                previousCustomRange.$el.find(previousCustomRange.fieldTag).noUiSlider('move', {handle: 'lower', to: ranges[previousCustomRange.name].min});
            }
        }

        // remove view for the range
        view.fieldRanges[category][range.name].remove();

        delete ranges[range.name];
        delete view.fieldRanges[category][range.name];

        // remove from bucket_dom_options
        _.each(bucket_dom_options, function(item, key) {
            if(item[0] == this.value) {
                optionIndex = key;
            }
        }, {value: range.name});

        bucket_dom_options.splice(optionIndex, 1);
        view.model.unset(category + '_options', {silent: true});
        view.model.set(category + '_options', bucket_dom_options);

        view.model.unset(category + '_ranges', {silent: true});
        view.model.set(category + '_ranges', ranges);

        lastCustomRangeIndex = view._getLastCustomRangeIndex(category, range.customType);
        if(range.customType == 'custom') {
            // use call to set context back to the view for connecting the sliders
            if (lastCustomRangeIndex == 0) {
               view.$el.find('#btnAddCustomRange').show();
            }
            view.connectSliders.call(view, category, view.fieldRanges);
        } else {
            // show add button for custom range not based on probability
            if(lastCustomRangeIndex == 0) {
                view.$el.find('#btnAddCustomRangeWithoutProbability').show();
            }
        }
        lastCustomRange = view._getLastCustomRange(category, range.customType);
        if(!_.isUndefined(lastCustomRange.$el)) {
            lastCustomRange.$el.find('.addCustomRange').parent().show();
        }
    },

    /**
     * Change a label for a custom range in the model
     *
     * @param {jQuery.Event} event keyup
     */
    updateCustomRangeLabel : function(event) {
        var view = this,
            category = $(event.target).data('category') || null,
            fieldKey = $(event.target).data('key') || null,
            bucket_dom_options = view.model.get(category + '_options'),
            optionIndex;

        if ( !_.isNull(category) && !_.isNull(fieldKey) && !_.isUndefined(bucket_dom_options) ) {
            _.each(bucket_dom_options, function(item, key){
                if (item[0] == this.value) { optionIndex = key; }
            }, {value: fieldKey});
            bucket_dom_options[optionIndex][1] = $(event.target).val();
            view.model.unset(category + '_options', {silent: true});
            view.model.set(category + '_options', bucket_dom_options);
        }
    },

    /**
     * Validate labels for custom ranges, if it is invalid add error style for input
     *
     * @param {String} category type for the ranges 'show_binary' etc.
     */
    validateCustomRangeLabels: function(category) {
        _.each(this.model.get(category + '_options'), function(item, key) {
            if(_.isEmpty(item[1])) {
                this.view.fieldRanges[category][item[0]].$el.find('.control-group').addClass('error');
                this.view.layout.$el.find('[name=save_button]').addClass('disabled');
            } else {
                this.view.fieldRanges[category][item[0]].$el.find('.control-group').removeClass('error')
            }
        }, {view: this});
    },

    /**
     * Change in_included_total value for custom range in model
     *
     * @param {Backbone.Event} event change
     */
    updateCustomRangeIncludeInTotal : function(event) {
        var view = this,
            category = $(event.target).data('category') || null,
            fieldKey = $(event.target).data('key') || null,
            ranges;

        if (!_.isNull(category) && !_.isNull(fieldKey))
        {
            ranges = view.model.get(category + '_ranges');
            if (!_.isUndefined(ranges) && !_.isUndefined(ranges[fieldKey]))
            {
                if (fieldKey !== 'exclude' && fieldKey.indexOf('custom_without_probability') == -1) {
                    ranges[fieldKey].in_included_total = $(event.target).is(':checked');
                } else {
                    ranges[fieldKey].in_included_total = false;
                }
                view.model.unset(category + '_ranges', {silent: true});
                view.model.set(category + '_ranges', ranges);
            }
        }
    },

    /**
     * Updates the setting in the model for the specific range types.
     * This gets triggered when the range slider after the user changes a range
     *
     * @param {String} category type for the ranges 'show_binary' etc.
     * @param {String} range - the range being set, i. e. `include`, `exclude` or `upside` for `show_buckets` category
     * @param {Number} value - the value being set
     */
    updateRangeSettings: function(category, range, value) {
        var catRange = category + '_ranges',
            setting = this.model.get(catRange);

        if (category == 'show_custom_buckets') {
            value.in_included_total = setting[range].in_included_total || false;
        }

        setting[range] = value;
        this.model.unset(catRange, {silent: true});
        this.model.set(catRange, setting);
    },

    /**
     * Graphically connects the sliders to the one below, so that they move in unison when changed, based on category.
     *
     * @param {String} ranges - the forecasts category that was selected, i. e. 'show_binary' or 'show_buckets'
     * @param {Object} sliders - an object containing the sliders that have been set up in the page.  This is created in the
     * selection handler when the user selects a category type.
     */
    connectSliders: function(ranges, sliders) {
        var rangeSliders = sliders[ranges];

        if(ranges == 'show_binary') {
            rangeSliders.include.sliderChangeDelegate = function(value) {
                // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                rangeSliders.include.$el.find(rangeSliders.include.fieldTag).noUiSlider('move', {handle: 'upper', to: rangeSliders.include.def.maxRange});
                // set the excluded range based on the lower value of the include range
                this.view.setExcludeValueForLastSlider(value, ranges, rangeSliders.include);
            };
        } else if(ranges == 'show_buckets') {
            rangeSliders.include.sliderChangeDelegate = function(value) {
                // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                rangeSliders.include.$el.find(rangeSliders.include.fieldTag).noUiSlider('move', {handle: 'upper', to: rangeSliders.include.def.maxRange});

                rangeSliders.upside.$el.find(rangeSliders.upside.fieldTag).noUiSlider('move', {handle: 'upper', to: value.min - 1});
                if(value.min <= rangeSliders.upside.$el.find(rangeSliders.upside.fieldTag).noUiSlider('value')[0] + 1) {
                    rangeSliders.upside.$el.find(rangeSliders.upside.fieldTag).noUiSlider('move', {handle: 'lower', to: value.min - 2});
                }
            };
            rangeSliders.upside.sliderChangeDelegate = function(value) {
                rangeSliders.include.$el.find(rangeSliders.include.fieldTag).noUiSlider('move', {handle: 'lower', to: value.max + 1});
                // set the excluded range based on the lower value of the upside range
                this.view.setExcludeValueForLastSlider(value, ranges, rangeSliders.upside);
            };
        } else if(ranges == 'show_custom_buckets') {
            var i, max,
                customSliders = _.sortBy(_.filter(
                    rangeSliders,
                    function(item) {
                        return item.customType == 'custom'
                    }
                ), function(item) {
                        return parseInt(item.customIndex, 10);
                    }
                ),
                probabilitySliders = _.union(rangeSliders.include, rangeSliders.upside, customSliders, rangeSliders.exclude);

            if(probabilitySliders.length) {
                for(i = 0, max = probabilitySliders.length; i < max; i++) {
                    probabilitySliders[i].connectedSlider = ( !_.isUndefined(probabilitySliders[i + 1]) ) ? probabilitySliders[i + 1] : null;
                    probabilitySliders[i].connectedToSlider = ( !_.isUndefined(probabilitySliders[i - 1]) ) ? probabilitySliders[i - 1] : null;
                    probabilitySliders[i].sliderChangeDelegate = function(value, populateEvent) {
                        // lock the upper handle to 100, as per UI/UX requirements to show a dual slider
                        if(this.name == 'include') {
                            this.$el.find(this.fieldTag).noUiSlider('move', {handle: 'upper', to: this.def.maxRange});
                        } else if(this.name == 'exclude') {
                            this.$el.find(this.fieldTag).noUiSlider('move', {handle: 'lower', to: this.def.minRange});
                        }

                        if(!_.isUndefined(this.connectedSlider) && !_.isNull(this.connectedSlider)) {
                            this.connectedSlider.$el.find(this.connectedSlider.fieldTag).noUiSlider('move', {handle: 'upper', to: value.min - 1});
                            if(value.min <= this.connectedSlider.$el.find(this.connectedSlider.fieldTag).noUiSlider('value')[0] + 1) {
                                this.connectedSlider.$el.find(this.connectedSlider.fieldTag).noUiSlider('move', {handle: 'lower', to: value.min - 2});
                            }
                            if(_.isUndefined(populateEvent) || populateEvent == 'down') {
                                this.connectedSlider.sliderChangeDelegate.call(this.connectedSlider, {
                                    min: this.connectedSlider.$el.find(this.connectedSlider.fieldTag).noUiSlider('value')[0],
                                    max: this.connectedSlider.$el.find(this.connectedSlider.fieldTag).noUiSlider('value')[1]
                                }, 'down');
                            }
                        }
                        if(!_.isUndefined(this.connectedToSlider) && !_.isNull(this.connectedToSlider)) {
                            this.connectedToSlider.$el.find(this.connectedToSlider.fieldTag).noUiSlider('move', {handle: 'lower', to: value.max + 1});
                            if(value.max >= this.connectedToSlider.$el.find(this.connectedToSlider.fieldTag).noUiSlider('value')[1] - 1) {
                                this.connectedToSlider.$el.find(this.connectedToSlider.fieldTag).noUiSlider('move', {handle: 'upper', to: value.max + 2});
                            }
                            if(_.isUndefined(populateEvent) || populateEvent == 'up') {
                                this.connectedToSlider.sliderChangeDelegate.call(this.connectedToSlider, {
                                    min: this.connectedToSlider.$el.find(this.connectedToSlider.fieldTag).noUiSlider('value')[0],
                                    max: this.connectedToSlider.$el.find(this.connectedToSlider.fieldTag).noUiSlider('value')[1]
                                }, 'up');
                            }
                        }
                    };
                }
            }
        }
    },

    /**
     * Provides a way for the last of the slider fields in the view, to set the value for the exclude range.
     *
     * @param {Object} value the range value of the slider
     * @param {String} ranges the selected config range
     * @param {Object} slider the slider
     */
    setExcludeValueForLastSlider: function(value, ranges, slider) {
        var excludeRange = {
                min: 0,
                max: 100
            },
            settingName = ranges + '_ranges',
            setting = this.model.get(settingName);

        excludeRange.max = value.min - 1;
        excludeRange.min = slider.def.minRange;
        setting.exclude = excludeRange;
        this.model.set(settingName, setting);
    }
})
