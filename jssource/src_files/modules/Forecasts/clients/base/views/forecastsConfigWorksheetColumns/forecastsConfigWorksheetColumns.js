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
     * Holds the changing date value for the title
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
     * Holds the select2 reference to the #wkstColumnSelect element
     */
    wkstColumnsSelect2: {},

    /**
     * Holds the default/selected items
     */
    selectedOptions: [],

    /**
     * Holds all items
     */
    allOptions: [],

    /**
     * The field object id/label for likely_case
     */
    likelyFieldObj: {},


    /**
     * The field object id/label for best_case
     */
    bestFieldObj: {},


    /**
     * The field object id/label for worst_case
     */
    worstFieldObj: {},

    events: {
        'click .resetLink': 'onResetLinkClicked'
    },

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);

        this.titleViewNameTitle = app.lang.get('LBL_FORECASTS_CONFIG_TITLE_WORKSHEET_COLUMNS', 'Forecasts');
        this.toggleTitleTpl = app.template.getView('forecastsConfigHelpers.toggleTitle', 'Forecasts');
        this.allOptions = [];
        this.selectedOptions = [];

        var config = app.metadata.getModule('Forecasts', 'config'),
            cfgFields = config.worksheet_columns,
            index = 0;

        // set up scenarioOptions
        _.each(options.meta.panels[0].fields, function(field) {
            var labelModule = (!_.isUndefined(field.label_module)) ? field.label_module : 'Forecasts',
                obj = {
                    id: field.name,
                    text: app.lang.get(field.label, labelModule),
                    index: index,
                    locked: field.locked || false
                },
                cField = _.find(cfgFields, function(cfgField) {
                    return cfgField == field.name;
                }, this),
                addFieldToFullList = true;

            // save the field objects
            if (field.name == 'best_case') {
                this.bestFieldObj = obj;
                addFieldToFullList = (config.show_worksheet_best === 1)
            } else if (field.name == 'likely_case') {
                this.likelyFieldObj = obj;
                addFieldToFullList = (config.show_worksheet_likely === 1)
            } else if (field.name == 'worst_case') {
                this.worstFieldObj = obj;
                addFieldToFullList = (config.show_worksheet_worst === 1)
            }

            if (addFieldToFullList) {
                this.allOptions.push(obj);
            }

            // If the current field being processed was found in the config fields,
            if (!_.isUndefined(cField)) {
                // push field to defaults
                this.selectedOptions.push(obj);
            }

            index++;
        }, this);
    },

    /**
     * Handles when reset to defaults link has been clicked
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
        if (this.model) {
            this.model.on('change:columns', function(model) {
                var arr = [],
                    cfgFields = this.model.get('worksheet_columns'),
                    metaFields = this.meta.panels[0].fields;

                _.each(metaFields, function(metaField) {
                    _.each(cfgFields, function(field) {
                        if (metaField.name == field) {
                            var labelModule = metaField.label_module || 'Forecasts';
                            arr.push(app.lang.get(metaField.label, labelModule));
                        }
                    }, this);
                }, this);
                this.titleSelectedValues = arr.join(', ');

                // Handle truncating the title string and adding "..."
                this.titleSelectedValues = this.titleSelectedValues.slice(0, 50) + "...";

                this.updateTitle();
            }, this);

            // trigger the change event to set the title when this gets added
            this.model.trigger('change:columns', this.model);

            this.model.on('change:scenarios', function(model) {
                // check model settings and update select2 options
                if (this.model.get('show_worksheet_best')) {
                    this.addOption(this.bestFieldObj);
                } else {
                    this.removeOption(this.bestFieldObj);
                }

                if (this.model.get('show_worksheet_likely')) {
                    this.addOption(this.likelyFieldObj);
                } else {
                    this.removeOption(this.likelyFieldObj);
                }

                if (this.model.get('show_worksheet_worst')) {
                    this.addOption(this.worstFieldObj);
                } else {
                    this.removeOption(this.worstFieldObj);
                }

                // force render
                this._render();

                // update the model, since a field was added or removed
                var arr = [];
                _.each(this.selectedOptions, function(field) {
                    arr.push(field.id);
                }, this);
                this.setModelValue(arr);

            }, this);
        }
    },

    /**
     * Adds a field object to allOptions & selectedOptions if it is not found in those arrays
     *
     * @param {Object} fieldObj
     */
    addOption: function(fieldObj) {
        if (!_.contains(this.allOptions, fieldObj)) {
            this.allOptions.splice(fieldObj.index, 0, fieldObj);
            this.selectedOptions.splice(fieldObj.index, 0, fieldObj);
        }
    },

    /**
     * Removes a field object to allOptions & selectedOptions if it is not found in those arrays
     *
     * @param {Object} fieldObj
     */
    removeOption: function(fieldObj) {
        this.allOptions = _.without(this.allOptions, fieldObj);
        this.selectedOptions = _.without(this.selectedOptions, fieldObj);
    },

    /**
     * Updates the accordion toggle title
     */
    updateTitle: function() {
        var tplVars = {
            title: this.titleViewNameTitle,
            selectedValues: this.titleSelectedValues,
            viewName: 'forecastsConfigWorksheetColumns'
        };

        this.$el.find('#' + this.name + 'Title').html(this.toggleTitleTpl(tplVars));
    },

    /**
     * {@inheritdoc}
     */
    _render: function() {
        app.view.View.prototype._render.call(this);
        // add accordion-group class to wrapper $el div
        this.$el.addClass('accordion-group');
        this.updateTitle();

        // handle setting up select2 options
        this.wkstColumnsSelect2 = this.$el.find('#wkstColumnsSelect').select2({
            data: this.allOptions,
            multiple: true,
            containerCssClass: "select2-choices-pills-close",
            initSelection: _.bind(function(element, callback) {
                callback(this.selectedOptions);
            }, this)
        });
        this.wkstColumnsSelect2.select2('val', this.selectedOptions);

        this.wkstColumnsSelect2.on('change', _.bind(this.handleColumnModelChange, this));
    },

    /**
     * Handles the select2 adding/removing columns
     *
     * @param evt change event from the select2 selected values
     */
    handleColumnModelChange: function(evt) {
        // did we add something?  if so, lets add it to the selectedOptions
        if (!_.isUndefined(evt.added)) {
            this.selectedOptions.push(evt.added);
        }

        // did we remove something? if so, lets remove it from the selectedOptions
        if (!_.isUndefined(evt.removed)) {
            this.selectedOptions = _.without(this.selectedOptions, evt.removed);
        }

        // pass the val from the evt since it's already a nicly formatted array of the selected values
        this.setModelValue(evt.val);
    },

    /**
     * Set the value for the worksheet_columns on the model and trigger the event
     * @param value
     */
    setModelValue: function(value) {
        this.model.set('worksheet_columns', value);
        this.model.trigger('change:columns', this.model);
    },


    /**
     * {@inheritdoc}
     *
     * override dispose function to remove custom listener off select2 instance
     */
    _dispose: function() {
        // remove event listener from select2
        this.wkstColumnsSelect2.off();
        this.wkstColumnsSelect2.select2('destroy');
        this.wkstColumnsSelect2 = null;
        app.view.Component.prototype._dispose.call(this);
    }
})
