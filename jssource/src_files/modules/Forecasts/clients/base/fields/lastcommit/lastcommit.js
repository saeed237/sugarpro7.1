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

    commit_date: undefined,

    data_points: [],

    points: [],

    events: {
        'click': 'triggerHistoryLog'
    },

    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);

        this.points = [];
        this.data_points = [];

        // map what points we should display
        _.each(options.def.datapoints, function(point) {
            if (app.utils.getColumnVisFromKeyMap(point, 'forecastsWorksheet')) {
                this.points.push(point);
            }
        }, this);

        this.on('render', function() {
            if (!_.isUndefined(this.commit_date)) {
                this.$el.find("span.relativetime").timeago({
                    logger: SUGAR.App.logger,
                    date: SUGAR.App.date,
                    lang: SUGAR.App.lang,
                    template: SUGAR.App.template
                });
            }
        }, this);
    },
    triggerHistoryLog: function() {
        this.$el.find('i').toggleClass('icon-caret-down icon-caret-up');
        this.context.trigger('forecast:commit_log:trigger');
    },

    bindDataChange: function() {
        this.collection.on('reset', function() {
            // get the first line
            this.data_points = [];
            var model = _.first(this.collection.models)

            if (!_.isUndefined(model)) {
                this.commit_date = model.get('date_modified');

                this.data_points = this.processDataPoints(model);
            } else {
                this.commit_date = undefined;
            }

            if (!this.disposed) this.render();
        }, this);
    },

    processDataPoints: function(model) {
        var points = [],
            noAccessTemplate = app.template.getField('base', 'noaccess')(this);

        _.each(this.points, function(point) {
            // make sure we can view data for this point
            var point_data = {};
            if (app.acl.hasAccess('read', 'ForecastWorksheets', app.user.get('id'), point)) {
                point_data.value = model.get(point)
            } else {
                point_data.error = noAccessTemplate;
            }
            points.push(point_data);
        }, this);

        return points;
    }
})
