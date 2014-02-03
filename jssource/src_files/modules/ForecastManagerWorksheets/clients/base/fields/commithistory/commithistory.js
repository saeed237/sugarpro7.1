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

({
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);

        this.on('render', function() {
            this.loadData();
        }, this);
    },

    /**
     * Load Data Method
     */
    loadData: function() {

        var ctx = this.context.parent || this.context,
            su = ctx.get('selectedUser') || app.user.toJSON(),
            isManager = this.model.get('isManager'),
            showOpps = (su.id == this.model.get('user_id')) ? 1 : 0,
            forecastType = app.utils.getForecastType(isManager, showOpps),
            args_filter = [],
            options = {};


        args_filter.push({"user_id": this.model.get('user_id')});
        args_filter.push({"forecast_type": forecastType});

        var url = {"url": app.api.buildURL('Forecasts', 'filter'), "filters": {"filter": args_filter}};

        options.success = _.bind(function(data) {
            this.buildLog(data);
        }, this);
        app.api.call('create', url.url, url.filters, options, { context: this });
    },

    /**
     * Build out the History Log
     * @param data
     */
    buildLog: function(data) {
        data = data.records;
        var ctx = this.context.parent || this.context,
            forecastCommitDate = ctx.get('currentForecastCommitDate'),
            commitDate = new Date(forecastCommitDate),
            newestModel = new Backbone.Model(_.first(data)),
        // get everything that is left but the first item.
            otherModels = _.last(data, data.length - 1),
            oldestModel = {},
            displayCommitDate = newestModel.get('date_modified');

        // using for because you can't break out of _.each
        for(var i = 0; i < otherModels.length; i++) {
            // check for the first model equal to or past the forecast commit date
            // we want the last commit just before the whole forecast was committed
            if (new Date(otherModels[i].date_modified) <= commitDate) {
                oldestModel = new Backbone.Model(otherModels[i]);
                displayCommitDate = oldestModel.get('date_modified');
                break;
            }
        }

        // create the history log
        var tpl = app.template.getField(this.type, 'log', this.module);
        this.$el.html(tpl({
            commit: app.utils.createHistoryLog(oldestModel, newestModel).text,
            commit_date: displayCommitDate
        }));

        // kick off the relativetime
        this.$el.find("span.relativetime").timeago({
            logger: SUGAR.App.logger,
            date: SUGAR.App.date,
            lang: SUGAR.App.lang,
            template: SUGAR.App.template
        });
    },

    /**
     * Override the _render so we can tell it where to render at in the list view
     * @private
     */
    _render: function() {
        // set the $el equal to the place holder so it renders in the correct spot
        this.$el = this.view.$el.find('span[sfuuid="' + this.sfId + '"]');
        app.view.Field.prototype._render.call(this);
    }
})
