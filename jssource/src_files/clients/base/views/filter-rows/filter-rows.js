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
     * Form for creating a filter
     * Part of BaseFilterpanelLayout layout
     *
     * @class BaseFilterRowsView
     * @extends View
     */

    events: {
        'click a.addme': 'addRow',
        'click a.removeme': 'removeRow',
        'change .filter-field input[type=hidden]': 'handleFieldSelected',
        'change .filter-operator input[type=hidden]': 'handleOperatorSelected'
    },

    className: 'filter-definition-container',

    filterFields: [],

    lastFilterDef: [],

    /**
     * Map of fields types.
     *
     * Specifies correspondence between field types and field operator types.
     */
    fieldTypeMap: {
        'datetime' : 'date',
        'datetimecombo' : 'date'
    },

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        //Load partial
        this.formRowTemplate = app.template.get("filter-rows.filter-row-partial");

        this.filterOperatorMap = app.lang.getAppListStrings("filter_operators_dom");
        app.view.View.prototype.initialize.call(this, opts);

        this.listenTo(this.layout, "filterpanel:change:module", this.handleFilterChange);
        this.listenTo(this.layout, "filter:create:open", this.openForm);
        this.listenTo(this.layout, "filter:create:close", this.render);
        this.listenTo(this.layout, "filter:create:save", this.saveFilter);
        this.listenTo(this.layout, "filter:create:delete", this.deleteFilter);
        this.listenTo(this.layout, "filter:create:validate", this.validateRows);
    },

    /**
     * Handler for filter:change event
     * Loads filterable fields for specified module
     * @param moduleName
     */
    handleFilterChange: function(moduleName) {
        var moduleMeta = app.metadata.getModule(moduleName);
        if (!moduleMeta) {
            return;
        }
        this.fieldList = this.getFilterableFields(moduleName);

        this.filterFields = {};
        this.moduleName = moduleName;

        _.each(this.fieldList, function(value, key) {
            var text = app.lang.get(value.vname, moduleName);
            // Check if we support this field type.
            var type = this.fieldTypeMap[value.type] || value.type;
            //Predefined filters don't have operators defined
            if ((this.filterOperatorMap[type] || value.predefined_filter === true) && !_.isUndefined(text)) {
                this.filterFields[key] = text;
            }
        }, this);
    },

    /**
     * Handler for filter:create:open event
     * @param filterModel
     */
    openForm: function(filterModel) {
        if (!filterModel.get('filter_definition')) {
            this.render();
            this.addRow();
        } else {
            this.populateFilter();
        }
    },

    /**
     * Save the filter
     * @param {String} name
     */
    saveFilter: function(name) {
        var self = this,
            obj = {
                filter_definition: this.buildFilterDef(),
                name: name,
                module_name: this.moduleName
            };

        this.layout.editingFilter.save(obj, {
            success: function(model) {
                self.layout.trigger("filter:add", model);
                self.layout.trigger("filter:create:rowsValid", false);
            },
            alerts: {
                'success': {
                    title: app.lang.get("LBL_EMAIL_SUCCESS") + ":",
                    messages: app.lang.get("LBL_FILTER_SAVE") + " " + name
                }
            }
        });

        this.layout.trigger('filter:create:close');
    },

    /**
     * Delete the filter
     */
    deleteFilter: function() {
        var self = this,
            name = this.layout.editingFilter.get('name');
        this.layout.editingFilter.destroy({
            success: function(model) {
                self.layout.trigger("filter:remove", model);
            },
            alerts: {
                'success': {
                    title: app.lang.get('LBL_EMAIL_SUCCESS') + ':',
                    message: app.lang.get('LBL_DELETED') + ' ' + name
                }
            }
        });
        this.layout.trigger('filter:create:close');
    },


    /**
     * Get filterable fields from the module metadata
     * @param {String} moduleName
     * @returns {Object}
     */
    getFilterableFields: function(moduleName) {
        var moduleMeta = app.metadata.getModule(moduleName),
            fieldMeta = moduleMeta.fields,
            fields = {};
        if (moduleMeta.filters) {
            _.each(moduleMeta.filters, function(templateMeta) {
                if (templateMeta.meta && templateMeta.meta.fields) {
                    fields = _.extend(fields, templateMeta.meta.fields);
                }
            });
        }

        _.each(fields, function(fieldFilterDef, fieldName) {
            if (_.isEmpty(fieldFilterDef)) {
                fields[fieldName] = fieldMeta[fieldName] || {};
            } else {
                fields[fieldName] = _.extend({name: fieldName}, fieldFilterDef, fieldMeta[fieldName]);
            }
            delete fields[fieldName]['readonly'];
        });

        return fields;
    },

    /**
     * Utility function to instanciate an enum field
     *
     * @param {Model} model
     * @param {Object} def
     * @returns {Field}
     */
    createField: function(model, def) {
        var obj = {
            meta: {
                view: "edit"
            },
            def: def,
            model: model,
            context: app.controller.context,
            viewName: "edit",
            view: this
        };
        var field = app.view.createField(obj);
        return field;
    },

    /**
     * Add a row
     * @param {Event} e
     * @returns {Object}
     */
    addRow: function(e) {
        var $row, model, field, $fieldValue, $fieldContainer;

        if (e) {
            // Triggered by clicking the plus sign. Add the row to that point.
            $row = this.$(e.currentTarget).parents('.filter-body');
            $row.after(this.formRowTemplate());
            $row = $row.next();
        } else {
            // Add the initial row.
            $row = $(this.formRowTemplate()).appendTo(this.$el);
        }
        model = app.data.createBean(this.moduleName);
        field = this.createField(model, {
            type: 'enum',
            options: this.filterFields
        });

        $fieldValue = $row.find('.filter-field');
        $fieldContainer = $(field.getPlaceholder().string);
        $fieldContainer.appendTo($fieldValue);

        $row.data('nameField', field);

        this._renderField(field);
        this.layout.trigger("filter:create:rowsValid", false);

        return $row;
    },


    /**
     * Remove a row
     * @param {Event} e
     */
    removeRow: function(e) {
        var $row = this.$(e.currentTarget).parents('article.filter-body'),
            fieldOpts = [
                {'field': 'nameField', 'value': 'name'},
                {'field': 'operatorField', 'value': 'operator'},
                {'field': 'valueField', 'value': 'value'}
            ];

        this._disposeFields($row, fieldOpts);
        $row.remove();
        this.validateRows();
        if (this.$('article.filter-body').length === 0) {
            this.addRow();
        }
    },

    /**
     * Validate rows
     * @returns {Boolean} TRUE if valid, FALSE otherwise
     */
    validateRows: function() {
        var isValid = true,
            $rows = this.$('article.filter-body');

        _.each($rows, function(row) {
            if (!isValid) return false;
            isValid = this.validateRow($(row));
        }, this);
        this.layout.trigger("filter:create:rowsValid", isValid);
        return isValid;
    },

    /**
     * Verify the value of the row is not empty
     * @param {Element} $row the row to validate
     * @returns {Boolean} TRUE if valid, FALSE otherwise
     */
    validateRow: function($row) {
        var data = $row.data();
        //For date range and predefined filters there is no value
        if (data.isDateRange || data.isPredefinedFilter) {
            return true;
        }
        //Special case for between operators where 2 values are needed
        var needTwoValues = ['$between', '$dateBetween'];
        if (_.indexOf(needTwoValues, data.operator) > -1) {
            if (_.isArray(data.value) && data.value.length === 2) {
                if (data.operator === "$between") {
                    return _.isNumber(data.value[0]) && _.isNumber(data.value[1]);
                }
                if (data.operator === "$dateBetween") {
                    return !_.isUndefined(data.value[0]) && !_.isUndefined(data.value[1]);
                }
            } else {
                return false;
            }
        }
        return _.isNumber(data.value) || !_.isEmpty(data.value);
    },

    /**
     * Rerender the view with selected filter
     */
    populateFilter: function() {
        var filterDef = this.layout.editingFilter.get("filter_definition"),
            name = this.layout.editingFilter.get("name");

        this.render();
        this.layout.trigger("filter:set:name", name);

        _.each(filterDef, function(row) {
            this.populateRow(row);
        }, this);
        //Set lastFilterDef because the filter has already been applied and fireSearch is called in _disposeFields
        this.lastFilterDef = this.buildFilterDef();
    },

    /**
     * Populate filter edition row
     * @param {Object} rowObj
     */
    populateRow: function(rowObj) {
        var $row = this.addRow();
        _.each(rowObj, function(value, key) {
            if (key === "$or") {
                var keys = _.reduce(value, function(memo, obj) {
                    return memo.concat(_.keys(obj));
                }, []);

                key = _.find(_.keys(this.fieldList), function(key) {
                    if (_.has(this.fieldList[key], 'dbFields')) {
                        return _.isEqual(this.fieldList[key].dbFields.sort(), keys.sort());
                    }
                }, this);

                // Predicates are identical, so we just use the first.
                value = _.values(value[0])[0];
            }

            //Make sure we use name for relate fields
            if (!this.fieldList[key]) {
                var relate = _.find(this.fieldList, function(field) { return field.id_name === key; });
                key = relate.name;
            }
            $row.find('.filter-field input[type=hidden]').select2('val', key).trigger('change');
            if (_.isString(value)) {
                value = {"$equals": value};
            }
            _.each(value, function(value, operator) {
                $row.data('value', value);
                $row.find('.filter-operator input[type=hidden]')
                    .select2('val', operator === '$dateRange' ? value : operator)
                    .trigger('change');
            });
        }, this);
    },

    /**
     * Fired when a user selects a field to filter by
     * @param {Event} e
     */
    handleFieldSelected: function(e) {
        var $el = this.$(e.currentTarget),
            $row = $el.parents('.filter-body'),
            $fieldWrapper = $row.find('.filter-operator'),
            data = $row.data(),
            fieldName = $el.val(),
            fieldOpts = [
                {'field': 'operatorField', 'value': 'operator'},
                {'field': 'valueField', 'value': 'value'}
            ];
        this._disposeFields($row, fieldOpts);

        data['name'] = fieldName;
        if (!fieldName) {
            return;
        }
        // For relate fields
        data.id_name = this.fieldList[fieldName].id_name;

        //Predefined filters don't need operators and value field
        if (this.fieldList[fieldName].predefined_filter === true) {
            data.isPredefinedFilter = true;
            this.fireSearch();
            return;
        }

        // Get operators for this filter type
        var fieldType = this.fieldTypeMap[this.fieldList[fieldName].type] || this.fieldList[fieldName].type,
            payload = {},
            types = _.keys(this.filterOperatorMap[fieldType]);

        $fieldWrapper.removeClass('hide').empty();
        $row.find('.filter-value').addClass('hide').empty();

        // If the user is editing a filter, clear the operator.
        //$row.find('.field-operator select').select2('val', '');

        _.each(types, function(operand) {
            payload[operand] = this.filterOperatorMap[fieldType][operand];
        }, this);

        // Render the operator field
        var model = app.data.createBean(this.moduleName);
        var field = this.createField(model, {
                type: 'enum',
                // minimumResultsForSearch set to 9999 to hide the search field,
                // See: https://github.com/ivaynberg/select2/issues/414
                searchBarThreshold: 9999,
                options: payload
            }),
            $field = $(field.getPlaceholder().string);

        $field.appendTo($fieldWrapper);
        data['operatorField'] = field;

        this._renderField(field);
    },

    /**
     * Fired when a user selects an operator to filter by
     * @param {Event} e
     */
    handleOperatorSelected: function(e) {
        var $el = this.$(e.currentTarget),
            $row = $el.parents('.filter-body'),
            data = $row.data(),
            operation = $el.val(),
            fieldOpts = [
                {'field': 'valueField', 'value': 'value'}
            ];

        this._disposeFields($row, fieldOpts);

        data['operator'] = operation;
        if (!operation) {
            return;
        }

        // Patching fields metadata
        var moduleName = this.moduleName,
            module = app.metadata.getModule(moduleName),
            fields = app.metadata._patchFields(moduleName, module, app.utils.deepCopy(this.fieldList));

        // More patch for some field types
        var fieldName = $row.find('.filter-field input[type=hidden]').select2('val'),
            fieldType = this.fieldTypeMap[this.fieldList[fieldName].type] || this.fieldList[fieldName].type,
            fieldDef = fields[fieldName];

        switch (fieldType) {
            case 'enum':
                fieldDef.isMultiSelect = true;
                // minimumResultsForSearch set to 9999 to hide the search field,
                // See: https://github.com/ivaynberg/select2/issues/414
                fieldDef.searchBarThreshold = 9999;
                break;
            case 'bool':
                fieldDef.type = 'enum';
                // minimumResultsForSearch set to 9999 to hide the search field,
                // See: https://github.com/ivaynberg/select2/issues/414
                fieldDef.searchBarThreshold = 9999;
                break;
            case 'int':
                fieldDef.auto_increment = false;
                break;
            case 'teamset':
                fieldDef.type = 'relate';
                break;
            case 'datetimecombo':
            case 'date':
                fieldDef.type = 'date';
                //Flag to indicate the value needs to be formatted correctly
                data.isDate = true;
                if (operation.charAt(0) !== '$') {
                    //Flag to indicate we need to build the date filter definition based on the date operator
                    data.isDateRange = true;
                    this.fireSearch();
                    return;
                }
                break;
            case 'relate':
                fieldDef.auto_populate = true;
                break;
        }
        data.isRequired = fieldDef.required;

        // Create new model with the value set
        var model = app.data.createBean(moduleName);

        var $fieldValue = $row.find('.filter-value');
        $fieldValue.removeClass('hide').empty();

        //fire the change event as soon as the user start typing
        var _keyUpCallback = function(e) {
            if ($(e.currentTarget).is(".select2-input")) {
                return; //Skip select2. Select2 triggers other events.
            }
            this.value = $(e.currentTarget).val();
            // We use "silent" update because we don't need re-render the field.
            model.set(this.name, this.unformat($(e.currentTarget).val()), {silent: true});
            model.trigger('change');
        };

        //If the operation is $between we need to set two inputs.
        if (operation === '$between' || operation === '$dateBetween') {
            var minmax = [],
                value = $row.data('value') || [];

            model.set(fieldName + '_min', value[0] || '');
            model.set(fieldName + '_max', value[1] || '');
            minmax.push(this.createField(model, _.extend({}, fieldDef, {name: fieldName + '_min'})));
            minmax.push(this.createField(model, _.extend({}, fieldDef, {name: fieldName + '_max'})));

            if(operation === '$dateBetween') {
                minmax[0].label = app.lang.get('LBL_FILTER_DATEBETWEEN_FROM');
                minmax[1].label = app.lang.get('LBL_FILTER_DATEBETWEEN_TO');
            } else {
                minmax[0].label = app.lang.get('LBL_FILTER_BETWEEN_FROM');
                minmax[1].label = app.lang.get('LBL_FILTER_BETWEEN_TO');
            }

            data['valueField'] = minmax;
            _.each(minmax, function(field) {
                var fieldContainer = $(field.getPlaceholder().string);
                $fieldValue.append(fieldContainer);
                this.listenTo(field, 'render', function() {
                    field.$('input, select, textarea').addClass('inherit-width');
                    field.$('.input-append').prepend('<span class="add-on">' + field.label + '</span>');
                    field.$('.input-append').addClass('input-prepend');
                    // .date makes .inherit-width on input have no effect so we need to remove it.
                    field.$('.input-append').removeClass('date');
                    field.$('input, textarea').on('keyup', _.debounce(_.bind(_keyUpCallback, field), 400));
                });
                this._renderField(field);
            }, this);
        } else {
            model.set(fieldDef.id_name || fieldName, $row.data('value'));
            // Render the value field
            var field = this.createField(model, _.extend({}, fieldDef, {name: fieldName})),
                fieldContainer = $(field.getPlaceholder().string);
            $fieldValue.append(fieldContainer);
            data['valueField'] = field;

            this.listenTo(field, 'render', function() {
                field.$('input, select, textarea').addClass('inherit-width');
                // .date makes .inherit-width on input have no effect so we need to remove it.
                field.$('.input-append').removeClass('date');
                field.$('input, textarea').on('keyup',_.debounce(_.bind(_keyUpCallback, field), 400));
            });

            if (fieldType === 'relate' && $row.data('value')) {
                var self = this,
                    findRelatedName = app.data.createBeanCollection(fieldDef.module);
                findRelatedName.fetch({fields: [fieldDef.rname], params: {filter: [{'id': $row.data('value')}]},
                complete: function() {
                    if (!self.disposed) {
                        if (findRelatedName.first()) {
                            model.set(fieldName, findRelatedName.first().get(fieldDef.rname), { silent: true });
                        }
                        self._renderField(field);
                    }
                }});
            } else {
                this._renderField(field);
            }
        }

        // When the value change a quicksearch should be fired to update the results
        this.listenTo(model, "change", function() {
            this._updateFilterData($row);
            this.fireSearch();
        });

        // Manually trigger the filter request if a value has been selected lately
        // This is the case for checkbox fields or enum fields that don't have empty values.
        var modelValue = model.get(fieldDef.id_name || fieldName);
        if (!_.isEmpty(modelValue) && modelValue !== $row.data('value')) {
            model.trigger('change');
        }
    },

    /**
     * Update filter data for this row
     * @param $row Row to update
     * @private
     */
    _updateFilterData: function($row){
        var data = $row.data(),
            field = data['valueField'],
            name = data['name'],
            valueForFilter;

        //Make sure we use ID for relate fields
        if (this.fieldList[name] && this.fieldList[name].id_name) {
            name = this.fieldList[name].id_name;
        }

        //If we have multiple fields we have to build an array of values
        if (_.isArray(field)) {
            valueForFilter = [];
            _.each(field, function(field) {
                var value = !field.disposed && field.model.has(field.name) ? field.model.get(field.name) : '';
                value = $row.data('isDate') ? app.date.stripIsoTimeDelimterAndTZ(value) : value;
                valueForFilter.push(value);
            });
        } else {
            var value = !field.disposed && field.model.has(name) ? field.model.get(name) : '';
            valueForFilter = $row.data('isDate') ? app.date.stripIsoTimeDelimterAndTZ(value) : value;
        }
        $row.data("value", valueForFilter); // Update filter value once we've calculated final value
    },

    /**
     * Check each row, builds the filter definition and trigger the filtering
     */
    fireSearch: _.debounce(function() {
        var filterDef = this.buildFilterDef();
        //Do not apply same filter twice
        if (_.isEqual(this.lastFilterDef, filterDef)) {
            return;
        }
        this.validateRows();
        this.lastFilterDef = filterDef;
        this.layout.trigger('filter:apply', null, filterDef);
    }, 400),

    /**
     * Build filter definition for all valid rows
     * @returns {Array} Filter definition
     */
    buildFilterDef: function() {
        var $rows = this.$('article.filter-body'),
            filter = [];

        _.each($rows, function(row) {
            var rowFilter = this.buildRowFilterDef($(row));

            if (rowFilter) {
                filter.push(rowFilter);
            }
        }, this);

        return filter;
    },

    /**
     * Runs validation on this row and build filter definition when validation passes.
     * @param {Element} $row the related row
     * @returns {Object} Filter definition for this row
     */
    buildRowFilterDef: function($row) {
        var data = $row.data();
        if (!this.validateRow($row)) {
            return;
        }
        var operator = data['operator'],
            value = data['value'],
            name = data['id_name'] || data['name'],
            filter = {};

        if (data.isPredefinedFilter) {
            filter[name] = "";
            return filter;
        } else {
            if (this.fieldList[name] && _.has(this.fieldList[name], 'dbFields')) {
                var subfilters = [];
                _.each(this.fieldList[name].dbFields, function(dbField) {
                    var filter = {};
                    filter[dbField] = {};
                    filter[dbField][operator] = value;
                    subfilters.push(filter);
                });
                filter["$or"] = subfilters;
            } else {
                if (operator === "$equals") {
                    filter[name] = value;
                } else if (data.isDateRange) {
                    //Once here the value is actually a key of date_range_selector_dom and we need to build a real
                    //filter definition on it.
                    filter[name] = {};
                    filter[name].$dateRange = operator;
                } else if (operator === "$in" || operator === "$not_in") {
                    // IN/NOT IN require an array
                    filter[name] = {};
                    filter[name][operator] = _.isArray(value) ? value : [value];
                } else {
                    filter[name] = {};
                    filter[name][operator] = value;
                }
            }

            return filter;
        }
    },

    /**
     * Internal function that disposes fields stored in the data attribute of the row el.
     * @param  {jQuery el} $row The row which fields are to be disposed.
     * @param  {array} opts An array of objects, corresponding with the data obj of the row.
     * Example: opts = [{'field': 'nameField', 'value': 'name'},
     {'field': 'operatorField', 'value': 'operator'},
     {'field': 'valueField', 'value': 'value'}]
     */
    _disposeFields: function($row, opts) {
        var data = $row.data(), model;

        if (_.isObject(data) && _.isArray(opts)) {
            _.each(opts, function(val) {
                if (data[val.field]) {
                    //For in between filter we have an array of fields so we need to cover all cases
                    var fields = _.isArray(data[val.field]) ? data[val.field] : [data[val.field]];
                    data[val.value] = "";
                    _.each(fields, function(field) {
                        model = field.model;
                        if (val.field === "valueField" && model) {
                            model.clear({silent: true});
                            this.stopListening(model);
                        }
                        field.dispose();
                        field = null;
                    }, this);
                }
            }, this);
        }
        //Reset flags
        data.isDate = false;
        data.isDateRange = false;
        data.isPredefinedFilter = false;
        $row.data(data);
        this.fireSearch();
    }
})
