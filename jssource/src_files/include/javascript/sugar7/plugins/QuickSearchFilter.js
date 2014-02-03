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
    app.events.on("app:init", function() {
        app.plugins.register('QuickSearchFilter', ['layout', 'view', 'field'], {
            _moduleSearchFields: {},
            _getQuickSearchFieldsByPriority: function(searchModule) {
                var meta = app.metadata.getModule(searchModule),
                    filters = meta ? meta.filters : [],
                    fields = [],
                    priority = 0;

                _.each(filters, function(value) {
                    if (value && value.meta && value.meta.quicksearch_field &&
                        priority < value.meta.quicksearch_priority) {
                        fields = value.meta.quicksearch_field;
                        priority = value.meta.quicksearch_priority;
                    }
                });

                return fields;
            },
            getModuleQuickSearchFields: function(searchModule) {
                this._moduleSearchFields[searchModule] = this._moduleSearchFields[searchModule] ||
                    this._getQuickSearchFieldsByPriority(searchModule);
                return this._moduleSearchFields[searchModule];
            },
            getFilterDef: function(searchModule, searchTerm) {
                var searchFilter = [], returnFilter = [], fieldNames, terms;

                //Special case where no specific module is selected
                if (searchModule === 'all_modules') {
                    return returnFilter;
                }
                // We allow searching based on the basic search filter.
                // For example, the Contacts module will search the records
                // whose first name or last name begins with the typed string.
                // To extend the search results, you should update the metadata for basic search filter
                fieldNames = this.getModuleQuickSearchFields(searchModule);

                if (searchTerm) {
                    //See SP-1093.
                    //For Person Type modules, need to split the terms and build a smart filter definition
                    if (fieldNames.length === 2) {
                        terms = searchTerm.split(' ');
                        var firstTerm = _.first(terms.splice(0, 1));
                        var otherTerms = terms.join(' ');
                        //First field starts with first term, second field starts with other terms
                        //If only one term, use $or and search for the term on both fields
                        terms = otherTerms ? [firstTerm, otherTerms] : null;
                    } else if (fieldNames.length > 2) {
                        app.logger.fatal('Filtering by 3 quicksearch fields is not yet supported.');
                    }
                    _.each(fieldNames, function(name, index) {
                        var o = {};
                        if (terms) {
                            o[name] = {'$starts': terms[index]};
                        } else {
                            o[name] = {'$starts': searchTerm};
                        }
                        searchFilter.push(o);
                    });
                    if (terms) {
                        returnFilter.push(searchFilter.length > 1 ? {'$and': searchFilter} : searchFilter[0]);
                    } else {
                        returnFilter.push(searchFilter.length > 1 ? {'$or': searchFilter} : searchFilter[0]);
                    }

                    // See MAR-1362 for details.
                    if (searchModule === 'Users' || searchModule === 'Employees') {
                        returnFilter[0] = ({
                            '$and': [
                                {'status': {'$not_equals': 'Inactive'}},
                                returnFilter[0]
                            ]
                        });
                    }
                }
                return returnFilter;
            }
        });
    });
})(SUGAR.App);
