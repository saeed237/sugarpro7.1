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
/**
 * Forecast Manger Worksheet Record List
 *
 * Events
 *
 * forecasts:worksheet:is_dirty
 *  on: this.context.parent || this.context
 *  by: this.dirtyModels 'add' Event
 *  when: a model is added to the dirtModels collection
 *
 * forecasts:worksheet:needs_commit
 *  on: this.context.parent || this.context
 *  by: checkForDraftRows
 *  when: this.collection has a row newer than the last commit date
 *
 * forecasts:worksheet:totals
 *  on: this.context.parent || this.context
 *  by: calculateTotals
 *  when: after it's done calculating totals from a collection change or reset event
 *
 * forecasts:worksheet:saved
 *  on: this.context.parent || this.context
 *  by: saveWorksheet and _worksheetSaveHelper
 *  when: after it's done saving the worksheets to the db for a save draft
 *
 * forecasts:worksheet:commit
 *  on: this.context.parent || this.context
 *  by: forecasts:worksheet:saved event
 *  when: only when the commit button is pressed
 *
 * forecasts:assign_quota
 *  on: this.context.parent || this.context
 *  by: forecasts:worksheet:saved event
 *  when: only when the Assign Quota button is pressed
 *
 */
({
    /**
     * Who are parent is
     */
    extendsFrom: 'RecordlistView',

    /**
     * what type of worksheet are we?
     */
    worksheetType: 'manager',

    /**
     * Selected User Storage
     */
    selectedUser: {},

    /**
     * Can we edit this worksheet?
     */
    canEdit: true,

    /**
     * Selected Timeperiod Storage
     */
    selectedTimeperiod: {},

    /**
     * Totals Storage
     */
    totals: {},

    /**
     * Default values for the blank rows
     */
    defaultValues: {
        quota: 0,
        best_case: 0,
        best_case_adjusted: 0,
        likely_case: 0,
        likely_case_adjusted: 0,
        worst_case: 0,
        worst_case_adjusted: 0,
        show_history_log: 0
    },

    /**
     * Navigation Message To Display
     */
    navigationMessage: '',

    /**
     * Special Navigation for the Window Refresh
     */
    routeNavigationMessage: '',

    /**
     * Do we actually need to display a navigation message
     */
    displayNavigationMessage: false,

    /**
     * Only check for draft records once
     */
    hasCheckedForDraftRecords: false,

    /**
     * Draft Save Type
     */
    draftSaveType : undefined,

    /**
     * is the collection syncing
     * @param boolean
     */
    isCollectionSyncing: false,

    initialize: function(options) {
        // we need to make a clone of the plugins and then push to the new object. this prevents double plugin
        // registration across ExtendedComponents
        this.plugins = _.clone(this.plugins);
        this.plugins.push('CteTabbing');
        this.plugins.push('DirtyCollection');
        app.view.invokeParent(this, {type: 'view', name: 'recordlist', method: 'initialize', args: [options]});
        this.selectedUser = this.context.get('selectedUser') || this.context.parent.get('selectedUser') || app.user.toJSON();
        this.selectedTimeperiod = this.context.get('selectedTimePeriod') || this.context.parent.get('selectedTimePeriod') || '';
        this.context.set('skipFetch', (this.selectedUser.isManager && this.selectedUser.showOpps));    // skip the initial fetch, this will be handled by the changing of the selectedUser
        this.collection.sync = _.bind(this.sync, this);
    },

    _dispose: function() {
        if (!_.isUndefined(this.context.parent) && !_.isNull(this.context.parent)) {
            this.context.parent.off(null, null, this);
        }
        app.routing.offBefore('route', this.beforeRouteHandler, this);
        $(window).off("beforeunload." + this.worksheetType);
        app.view.invokeParent(this, {type: 'view', name: 'recordlist', method: '_dispose'});
    },

    bindDataChange: function() {
        // these are handlers that we only want to run when the parent module is forecasts
        if (!_.isUndefined(this.context.parent) && !_.isUndefined(this.context.parent.get('model'))) {
            if (this.context.parent.get('model').module == 'Forecasts') {
                this.context.parent.on('button:export_button:click', function() {
                    if (this.layout.isVisible()) {
                        this.exportCallback();
                    }
                }, this);
                // before render has happened, potentially stopping the render from happening
                this.before('render', function() {
                    return this.beforeRenderCallback();
                }, true);

                // after render has completed
                this.on('render', function() {
                    this.renderCallback();
                }, this);

                this.on('list:toggle:column', function(column, isVisible, columnMeta) {
                    // if we hide or show a column, recalculate totals
                    this.calculateTotals();
                }, this);

                // trigger the worksheet save draft code
                this.context.parent.on('button:save_draft_button:click', function() {
                    if (this.layout.isVisible()) {
                        // after we save, trigger the needs_commit event

                        this.context.parent.once('forecasts:worksheet:saved', function() {
                            // clear out the current navigation message
                            this.setNavigationMessage(false, '', '');
                            this.context.parent.trigger('forecasts:worksheet:needs_commit', this.worksheetType);
                        }, this);
                        this.draftSaveType = 'draft';
                        this.saveWorksheet(true);
                    }
                }, this);

                // trigger the worksheet save draft code and then commit the worksheet
                this.context.parent.on('button:commit_button:click', function() {
                    if (this.layout.isVisible()) {
                        // we just need to listen to it once, then we don't want to listen to it any more
                        this.context.parent.once('forecasts:worksheet:saved', function() {
                            this.context.parent.trigger('forecasts:worksheet:commit', this.selectedUser, this.worksheetType, this.getCommitTotals())
                        }, this);
                        this.draftSaveType = 'commit';
                        this.saveWorksheet(false);
                    }
                }, this);

                /**
                 * Watch for a change to the selectedTimePeriod
                 */
                this.context.parent.on('change:selectedTimePeriod', function(model, changed) {
                    this.updateSelectedTimeperiod(changed);
                }, this);

                /**
                 * Watch for a change int he worksheet totals
                 */
                this.context.parent.on('forecasts:worksheet:totals', function(totals, type) {
                    if (type == this.worksheetType) {
                        var tpl = app.template.getView('recordlist.totals', this.module);
                        this.$el.find('tfoot').remove();
                        this.$el.find('tbody').after(tpl(this));
                    }
                }, this);

                /**
                 * Watch for a change in the selectedUser
                 */
                this.context.parent.on('change:selectedUser', function(model, changed) {
                    this.updateSelectedUser(changed);
                }, this);

                /**
                 * Watch for the currentForecastCommitDate to be updated
                 */
                this.context.parent.on('change:currentForecastCommitDate', function(context, changed) {
                    if (this.layout.isVisible()) {
                        this.checkForDraftRows(changed);
                    }
                }, this);

                this.collection.on('data:sync:start', function() {
                    this.isCollectionSyncing = true;
                }, this);

                this.collection.on('data:sync:complete', function() {
                    this.isCollectionSyncing = false;
                }, this);

                /**
                 * When the collection is reset, we need checkForDraftRows
                 */
                this.collection.on('reset', function() {
                    var ctx = this.context.parent || this.context;
                    ctx.trigger('forecasts:worksheet:is_dirty', this.worksheetType, false);
                    this.checkForDraftRows(ctx.get('currentForecastCommitDate'));
                }, this);

                this.collection.on('change:quota', function(model, changed) {
                    // a quota has changed, trigger an event to toggle the assign quota button
                    var ctx = this.context.parent || this.context;
                    ctx.trigger('forecasts:worksheet:quota_changed', this.worksheetType);
                }, this);

                this.context.parent.on('forecasts:worksheet:committed', function() {
                    if (this.layout.isVisible()) {
                        var ctx = this.context.parent || this.context;
                        ctx.trigger('forecasts:worksheet:is_dirty', this.worksheetType, false);
                        this.refreshData();
                        // after a commit, we don't need to check for draft records again
                        this.hasCheckedForDraftRecords = true;
                    }
                }, this);

                this.context.parent.on('forecasts:worksheet:is_dirty', function(worksheetType, is_dirty) {
                    if (this.worksheetType == worksheetType) {
                        if (is_dirty) {
                            this.setNavigationMessage(true, 'LBL_WORKSHEET_SAVE_CONFIRM', 'LBL_WORKSHEET_SAVE_CONFIRM_UNLOAD');
                        } else {
                            // worksheet is not dirty,
                            this.cleanUpDirtyModels();
                            this.setNavigationMessage(false, '', '');
                        }
                    }
                }, this);

                this.context.parent.on('button:assign_quota:click', function() {
                    this.context.parent.once('forecasts:worksheet:saved', function() {
                        // clear out the current navigation message
                        this.setNavigationMessage(false, '', '');
                        this.context.parent.trigger('forecasts:assign_quota', this.worksheetType, this.selectedUser, this.selectedTimeperiod);
                    }, this);
                    app.alert.show('saving_quota', {
                        level: 'process',
                        title: app.lang.get('LBL_ASSIGNING_QUOTA', 'Forecasts')
                    });
                    this.draftSaveType = 'assign_quota';
                    this.saveWorksheet(true, true);
                }, this);

                this.context.parent.on('forecasts:quota_assigned', function() {
                    // after the quote has been re-assigned, lets refresh the data just in case.
                    this.refreshData();
                }, this);

                app.routing.before('route', this.beforeRouteHandler, {}, this);

                $(window).bind("beforeunload." + this.worksheetType, _.bind(function() {
                    if (!this.disposed) {
                        var ret = this.showNavigationMessage('window');
                        if (_.isString(ret)) {
                            return ret;
                        }
                    }
                }, this));
            }
        }

        // make sure that the dirtyModels plugin is there
        if (!_.isUndefined(this.dirtyModels)) {
            // when something gets added, the save_draft and commit buttons need to be enabled
            this.dirtyModels.on('add', function() {
                var ctx = this.context.parent || this.context;
                ctx.trigger('forecasts:worksheet:is_dirty', this.worksheetType, true);
            }, this);
        }

        /**
         * Listener for the list:history_log:fire event, this triggers the inline history log to display or hide
         */
        this.context.on('list:history_log:fire', function(model, e) {
            // parent row

            var row_name = model.module + '_' + model.id;

            // check if the row is open, if it is, just destroy it
            var log_row = this.$el.find('tr[name="' + row_name + '_commit_history"]');

            var field;

            // if we have a row, just close it and destroy the field
            if (log_row.length == 1) {
                // remove it and dispose the field
                log_row.remove();
                // find the field
                field = _.find(this.fields, function(field, idx) {
                    return (field.name == row_name + '_commit_history');
                }, this);
                field.dispose();
            } else {
                var rowTpl = app.template.getView('recordlist.commithistory', this.module);
                field = app.view.createField({
                    def: {
                        'type': 'commithistory',
                        'name': row_name + '_commit_history'
                    },
                    view: this,
                    model: model
                });
                this.$el.find('tr[name="' + row_name + '"]').after(rowTpl({
                    module: this.module,
                    id: model.id,
                    placeholder: field.getPlaceholder(),
                    colspan: this._fields.visible.length + this.leftColumns.length + this.rightColumns.length  // do the +1 to account for right side Row Actions
                }));
                field.render();
            }
        }, this);

        /**
         * On Collection Reset or Change, calculate the totals
         */
        this.collection.on('reset change', function() {
            this.calculateTotals();
        }, this);

        this.layout.on('hide', function() {
            this.totals = {};
        }, this);

        // call the parent
        app.view.invokeParent(this, {type: 'view', name: 'recordlist', method: 'bindDataChange'});
    },

    beforeRouteHandler: function() {
        var ret = this.showNavigationMessage('router');
        this.processNavigationMessageReturn(ret);
    },

    /**
     * Handle Showing of the Navigation messages if any are applicable
     *
     * @param type
     * @returns {*}
     */
    showNavigationMessage: function(type) {
        if (this.layout.isVisible()) {
            var canEdit = this.dirtyCanEdit || this.canEdit;
            if (canEdit && this.displayNavigationMessage) {
                if (type == 'window') {
                    if (!_.isEmpty(this.routeNavigationMessage)) {
                        return app.lang.get(this.routeNavigationMessage, 'Forecasts');
                    }
                    return false;
                }

                var ret = confirm(app.lang.get(this.navigationMessage, 'Forecasts').split("<br>"));
                return {'message': this.navigationMessage, 'run_action': ret};
            }
            return true;
        }

        return true;
    },

    /**
     * Utility to set the Navigation Message and Flag
     *
     * @param display
     * @param reload_label
     * @param route_label
     */
    setNavigationMessage: function(display, reload_label, route_label) {
        this.displayNavigationMessage = display;
        this.navigationMessage = reload_label;
        this.routeNavigationMessage = route_label;
    },

    /**
     * Custom Method to handle the refreshing of the worksheet Data
     */
    refreshData: function() {
        var ret = this.showNavigationMessage('forecast');

        if (this.processNavigationMessageReturn(ret)) {
            this.hasCheckedForDraftRecords = false;
            this.displayLoadingMessage();
            this.collection.fetch();
        }
    },

    /**
     * Set the loading message and have a way to hide it
     */
    displayLoadingMessage: function() {
        app.alert.show('workshet_loading',
            {level: 'process', title: app.lang.getAppString('LBL_LOADING')}
        );
        this.collection.once('reset', function() {
            app.alert.dismiss('workshet_loading');
        }, this);
    },
    /**
     * Utility to process the return from the Navigation Message
     *
     * @param message_result
     * @returns {boolean}
     */
    processNavigationMessageReturn: function(message_result) {
        if (_.isObject(message_result) && message_result.run_action === true) {
            if (message_result.message == 'LBL_WORKSHEET_SAVE_CONFIRM') {
                this.context.parent.once('forecasts:worksheet:saved', function() {
                    if (this.layout.isVisible()) {
                        this.displayLoadingMessage();
                        this.collection.fetch();
                    }
                }, this);
                this.saveWorksheet(true);
            }

            return false
        }

        return true;
    },

    /**
     * Handle the export callback
     */
    exportCallback: function() {
        var url = 'index.php?module=Forecasts&action=ExportManagerWorksheet';
        url += '&user_id=' + this.selectedUser.id;
        url += '&timeperiod_id=' + this.selectedTimeperiod;

        if (this.canEdit && this.isDirty()) {
            if (confirm(app.lang.get("LBL_WORKSHEET_EXPORT_CONFIRM", "Forecasts"))) {
                this.runExport(url);
            }
        } else {
            this.runExport(url);
        }
    },

    /**
     * runExport
     * triggers the browser to download the exported file
     * @param url URL to the file to download
     */
    runExport: function(url) {
        var dlFrame = $("#forecastsDlFrame");
        //check to see if we got something back
        if (dlFrame.length == 0) {
            //if not, create an element
            dlFrame = $("<iframe>");
            dlFrame.attr("id", "forecastsDlFrame");
            dlFrame.css("display", "none");
            $("body").append(dlFrame);
        }
        dlFrame.attr("src", url);
    },

    /**
     * Method for the before('render') event
     */
    beforeRenderCallback: function() {
        // if manager is not set or manager == false
        var ret = true;
        if (_.isUndefined(this.selectedUser.isManager) || this.selectedUser.isManager == false) {
            ret = false;
        }

        // only render if this.selectedUser.showOpps == false which means
        // we want to display the manager worksheet view
        if (ret) {
            ret = !(this.selectedUser.showOpps);
        }

        // if we are going to stop render but the layout is visible
        if (ret === false && this.layout.isVisible()) {
            // hide the layout
            this.layout.hide();
        }

        // empty out the left columns
        this.leftColumns = [];

        return ret;
    },

    /**
     * Method for the on('render') event
     */
    renderCallback: function() {
        var user = this.selectedUser || this.context.parent.get('selectedUser') || app.user.toJSON();
        if (user.isManager && user.showOpps == false) {
            if (!this.layout.isVisible()) {
                this.layout.once('show', this.calculateTotals, this);
                this.layout.show();
            }

            if (!_.isEmpty(this.totals) && this.layout.isVisible()) {
                var tpl = app.template.getView('recordlist.totals', this.module);
                this.$el.find('tfoot').remove();
                this.$el.find('tbody').after(tpl(this));
            }

            // set the commit button states to match the models
            this.setCommitLogButtonStates();

            var outerwidth = this.$el.find('span.isEditable').outerWidth();
            this.$el.find('span.isEditable').parent("td").css("min-width", "105px");

        } else {
            if (this.layout.isVisible()) {
                this.layout.hide();
            }
        }
    },

    /**
     * Update the selected timeperiod, and run a fetch if the worksheet is visible
     * @param changed
     */
    updateSelectedTimeperiod: function(changed) {
        if (this.displayNavigationMessage) {
            // save the time period just in case
            this.dirtyTimeperiod = this.selectedTimeperiod;
        }

        this.selectedTimeperiod = changed;
        if (this.layout.isVisible()) {
            this.refreshData();
        }
    },

    /**
     * Update the selected user and do a fetch if the criteria is met
     * @param changed
     */
    updateSelectedUser: function(changed) {
        // selected user changed
        var doFetch = false;
        if (this.selectedUser.id != changed.id) {
            doFetch = true;
        }
        if (!doFetch && this.selectedUser.isManager != changed.isManager) {
            doFetch = true;
        }
        if (!doFetch && this.selectedUser.showOpps != changed.showOpps) {
            doFetch = !(changed.showOpps);
        }

        if (this.displayNavigationMessage) {
            // save the user just in case
            this.dirtyUser = this.selectedUser;
            this.dirtyCanEdit = this.canEdit;
        }

        this.selectedUser = changed;

        // Set the flag for use in other places around this controller to suppress stuff if we can't edit
        this.canEdit = (this.selectedUser.id == app.user.get('id'));

        if (doFetch) {
            this.refreshData();
        } else {
            if (this.selectedUser.isManager && this.selectedUser.showOpps == true && this.layout.isVisible()) {
                if (this.displayNavigationMessage && this.dirtyUser.id == this.selectedUser.id) {
                    this.processNavigationMessageReturn(this.showNavigationMessage('manager_to_rep'));
                } else if (this.displayNavigationMessage) {
                    this.processNavigationMessageReturn(this.showNavigationMessage('user_switch'));
                }
                // viewing managers opp worksheet so hide the manager worksheet
                this.layout.hide();
            }
        }
    },

    /**
     * Check the collection for any rows that may have been saved as a draft or rolled up from a reportee commit and
     * trigger the commit button to be enabled
     *
     * @trigger forecasts:worksheet:needs_commit
     * @param lastCommitDate
     */
    checkForDraftRows: function(lastCommitDate) {
        if (this.layout.isVisible() && this.canEdit && !_.isUndefined(lastCommitDate)
            && this.collection.length !== 0 && this.hasCheckedForDraftRecords === false &&
            this.isCollectionSyncing === false) {
            this.hasCheckedForDraftRecords = true;
            this.collection.find(function(item) {
                if (item.get('date_modified') > lastCommitDate) {
                    this.context.parent.trigger('forecasts:worksheet:needs_commit', this.worksheetType);
                    return true;
                }
                return false;
            }, this);
        } else if(this.layout.isVisible() === false && this.canEdit && this.hasCheckedForDraftRecords === false) {
            // since the layout is not visible, lets wait for it to become visible
            this.layout.once('show', function() {
                this.checkForDraftRows(lastCommitDate);
            }, this);
        } else if(this.isCollectionSyncing === true) {
            this.collection.once('data:sync:complete', function() {
                this.checkForDraftRows(lastCommitDate);
            }, this);
        }
    },

    /**
     * Handles setting the proper state for the CommitLog Buttons in the row-actions
     */
    setCommitLogButtonStates: function() {
        _.each(this.fields, function(field) {
            if (field.def.event === 'list:history_log:fire') {
                // we have a field that needs to be disabled, so disable it!
                field.setDisabled((field.model.get('show_history_log') == "0"));
                if((field.model.get('show_history_log') == "0")) {
                    field.$el.find("a.rowaction").attr(
                        "data-original-title",
                        app.lang.get("LBL_NO_COMMIT","ForecastManagerWorksheets")
                    );
                }
            }
        });
    },

    /**
     * Override the sync method so we can put out custom logic in it
     *
     * @param method
     * @param model
     * @param options
     */
    sync: function(method, model, options) {

        if (!_.isUndefined(this.context.parent) && !_.isUndefined(this.context.parent.get('selectedUser'))) {
            var sl = this.context.parent.get('selectedUser');

            if (sl.isManager == false) {
                // they are not a manager, we should always hide this if it's not already hidden
                if (this.layout.isVisible()) {
                    this.layout.hide();
                }
                return;
            }
        }

        var callbacks,
            url;

        options = options || {};

        options.params = options.params || {};

        if (!_.isUndefined(this.selectedUser.id)) {
            options.params.user_id = this.selectedUser.id;
        }

        if (!_.isEmpty(this.selectedTimeperiod)) {
            options.params.timeperiod_id = this.selectedTimeperiod;
        }

        options.limit = 1000;
        options = app.data.parseOptionsForSync(method, model, options);

        // custom success handler
        options.success = _.bind(function(model, data, options) {
            this.collectionSuccess(data);
        }, this);

        callbacks = app.data.getSyncCallbacks(method, model, options);
        this.collection.trigger("data:sync:start", method, model, options);

        url = app.api.buildURL("ForecastManagerWorksheets", null, null, options.params);
        app.api.call("read", url, null, callbacks);
    },

    /**
     * Method to handle the success of a collection call to make sure that all reportee's show up in the table
     * even if they don't have data for the user that is asking for it.
     *
     * @param data
     */
    collectionSuccess: function(data) {
        var records = [],
            users = $.map(this.selectedUser.reportees, function(obj) {
                return $.extend(true, {}, obj);
            });

        // put the selected user on top
        users.unshift({id: this.selectedUser.id, name: this.selectedUser.full_name});

        // get the base currency
        var currency_id = app.currency.getBaseCurrencyId();
        var currency_base_rate = app.metadata.getCurrency(app.currency.getBaseCurrencyId()).conversion_rate;

        _.each(users, function(user) {
            var row = _.find(data, function(rec) {
                return (rec.user_id == this.id)
            }, user);
            if (!_.isUndefined(row)) {
                // update the name on the row as this will have the correct formatting for the locale
                row.name = user.name;
            } else {
                row = _.clone(this.defaultValues);
                row.currency_id = currency_id;
                row.base_rate = currency_base_rate;
                row.user_id = user.id;
                row.assigned_user_id = this.selectedUser.id;
                row.draft = (this.selectedUser.id == app.user.id) ? 1 : 0;
                row.name = user.name;
            }
            records.push(row);
        }, this);

        if (!_.isUndefined(this.orderBy)) {
            // lets sort the collection
            if (this.orderBy.field !== 'name') {
                records = _.sortBy(records, function(item) {

                    if (this.orderBy.direction == "_desc") {
                        return -item[this.orderBy.field];
                    } else {
                        return item[this.orderBy.field];
                    }
                }, this);
            } else {
                // we have the name
                records.sort(_.bind(function(a, b) {
                    if (this.orderBy.direction == '_asc') {
                        if (a.name.toString() < b.name.toString()) return 1;
                        if (a.name.toString() > b.name.toString()) return -1;
                    } else {
                        if (a.name.toString() < b.name.toString()) return -1;
                        if (a.name.toString() > b.name.toString()) return 1;
                    }
                    return 0;
                }, this));
            }
        }
        this.collection.reset(records);
    },

    /**
     * Calculates the display totals for the worksheet
     *
     * @triggers forecasts:worksheet:totals
     */
    calculateTotals: function() {
        if (this.layout.isVisible()) {
            this.totals = this.getCommitTotals();
            this.totals['display_total_label_in'] = _.first(this._fields.visible).name;
            _.each(this._fields.visible, function(field) {
                this.totals[field.name + '_display'] = true;
            }, this);

            var ctx = this.context.parent || this.context;
            // fire an event on the parent context
            ctx.trigger('forecasts:worksheet:totals', this.totals, this.worksheetType);
        }
    },

    /**
     * Gets the numbers needed for a commit
     *
     * @returns {{quota: number, best_case: number, best_adjusted: number, likely_case: number, likely_adjusted: number, worst_case: number, worst_adjusted: number, included_opp_count: number, pipeline_opp_count: number, pipeline_amount: number, closed_amount: number, closed_count: number}}
     */
    getCommitTotals: function() {
        var quota = 0,
            best_case = 0,
            best_case_adjusted = 0,
            likely_case = 0,
            likely_case_adjusted = 0,
            worst_case_adjusted = 0,
            worst_case = 0,
            included_opp_count = 0,
            pipeline_opp_count = 0,
            pipeline_amount = 0,
            closed_amount = 0;


        this.collection.forEach(function(model) {
            var base_rate = parseFloat(model.get('base_rate')),
                mPipeline_opp_count = model.get("pipeline_opp_count"),
                mPipeline_amount = model.get("pipeline_amount"),
                mClosed_amount = model.get("closed_amount"),
                mOpp_count = model.get("opp_count");

            quota += app.currency.convertWithRate(model.get('quota'), base_rate);
            best_case += app.currency.convertWithRate(model.get('best_case'), base_rate);
            best_case_adjusted += app.currency.convertWithRate(model.get('best_case_adjusted'), base_rate);
            likely_case += app.currency.convertWithRate(model.get('likely_case'), base_rate);
            likely_case_adjusted += app.currency.convertWithRate(model.get('likely_case_adjusted'), base_rate);
            worst_case += app.currency.convertWithRate(model.get('worst_case'), base_rate);
            worst_case_adjusted += app.currency.convertWithRate(model.get('worst_case_adjusted'), base_rate);
            included_opp_count += (_.isUndefined(mOpp_count)) ? 0 : parseInt(mOpp_count);
            pipeline_opp_count += (_.isUndefined(mPipeline_opp_count)) ? 0 : parseInt(mPipeline_opp_count);
            if (!_.isUndefined(mPipeline_amount)) {
                pipeline_amount = app.math.add(pipeline_amount, mPipeline_amount);
            }
            if (!_.isUndefined(mClosed_amount)) {
                closed_amount = app.math.add(closed_amount, mClosed_amount);
            }

        });

        return {
            'quota': quota,
            'best_case': best_case,
            'best_adjusted': best_case_adjusted,
            'likely_case': likely_case,
            'likely_adjusted': likely_case_adjusted,
            'worst_case': worst_case,
            'worst_adjusted': worst_case_adjusted,
            'included_opp_count': included_opp_count,
            'pipeline_opp_count': pipeline_opp_count,
            'pipeline_amount': pipeline_amount,
            'closed_amount': closed_amount,
            'closed_count': (included_opp_count - pipeline_opp_count)
        };
    },

    /**
     * We have to overwrite this method completely, since there is currently no way to completely disable
     * a field from being displayed
     *
     * @returns {{default: Array, available: Array, visible: Array, options: Array}}
     */
    parseFields: function() {
        var catalog = app.view.invokeParent(this, {
            type: 'view',
            name: 'recordlist',
            method: 'parseFields'
        });
        _.each(catalog, function(group, i) {
            catalog[i] = _.filter(group, function(fieldMeta) {
                return app.utils.getColumnVisFromKeyMap(fieldMeta.name, 'forecastsWorksheetManager');
            });
        });
        return catalog;
    },

    /**
     * Call the worksheet save event
     *
     * @triggers forecasts:worksheet:saved
     * @param {bool} isDraft
     * @param {bool} [suppressMessage]
     * @returns {number}
     */
    saveWorksheet: function(isDraft, suppressMessage) {
        // only run the save when the worksheet is visible and it has dirty records
        var saveObj = {
                totalToSave: 0,
                saveCount: 0,
                model: undefined,
                isDraft: isDraft,
                suppressMessage: suppressMessage || false,
                timeperiod: this.dirtyTimeperiod,
                userId: this.dirtyUser
            },
            ctx = this.context.parent || this.context;

        if (this.layout.isVisible()) {

            if (_.isUndefined(saveObj.userId)) {
                saveObj.userId = this.selectedUser;
            }
            saveObj.userId = saveObj.userId.id;
            /**
             * If the sheet is dirty, save the dirty rows. Else, if the save is for a commit, and we have
             * draft models (things saved as draft), we need to resave those as committed (version 1). If neither
             * of these conditions are true, then we need to fall through and signal that the save is complete so other
             * actions listening for this can continue.
             */
            if (this.isDirty()) {
                saveObj.totalToSave = this.dirtyModels.length;

                this.dirtyModels.each(function(model) {
                    saveObj.model = model;
                    this._worksheetSaveHelper(saveObj, ctx);
                }, this);

                this.cleanUpDirtyModels();
            } else {
                if (isDraft && saveObj.suppressMessage === false) {
                    app.alert.show('success', {
                        level: 'success',
                        autoClose: true,
                        title: app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE", "Forecasts") + ":",
                        messages: [app.lang.get("LBL_FORECASTS_WORKSHEET_SAVE_DRAFT_SUCCESS", "Forecasts")]
                    });
                }
                ctx.trigger('forecasts:worksheet:saved', saveObj.totalToSave, this.worksheetType, isDraft);
            }
        }

        this.draftSaveType = undefined;

        return saveObj.totalToSave
    },

    /**
     * Helper function for worksheet save
     *
     * @triggers forecasts:worksheet:saved
     */
    _worksheetSaveHelper: function(saveObj, ctx) {
        saveObj.model.set({
            current_user: saveObj.userId || this.selectedUser.id,
            timeperiod_id: saveObj.timeperiod || this.selectedTimeperiod,
            draft_save_type: this.draftSaveType
        }, {silent: true});

        saveObj.model.save({}, {success: _.bind(function() {
            saveObj.saveCount++;
            //if this is the last save, go ahead and trigger the callback;
            if (saveObj.totalToSave === saveObj.saveCount) {
                if (saveObj.isDraft && saveObj.suppressMessage === false) {
                    app.alert.show('success', {
                        level: 'success',
                        autoClose: true,
                        title: app.lang.get("LBL_FORECASTS_WIZARD_SUCCESS_TITLE", "Forecasts") + ":",
                        messages: [app.lang.get("LBL_FORECASTS_WORKSHEET_SAVE_DRAFT_SUCCESS", "Forecasts")]
                    });
                }
                ctx.trigger('forecasts:worksheet:saved', saveObj.totalToSave, this.worksheetType, saveObj.isDraft);
            }
        }, this), silent: true, alerts: { 'success': false }});
    }
})
