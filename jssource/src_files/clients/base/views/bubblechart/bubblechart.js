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
    plugins: ['Dashlet', 'Tooltip'],

    events: {
        'click .toggle-control': 'switchChart'
    },

    filterAssigned: null,
    dateRange: [],
    dataset: {},
    params: {},
    chart: {},
    tooltiptemplate: {},

    initialize: function (options) {
        app.view.View.prototype.initialize.call(this, options);

        var self = this,
            fields = [
                'id',
                'name',
                'account_name',
                'likely_case',
                'base_rate',
                'currency_id',
                'assigned_user_name',
                'date_closed',
                'probability',
                'account_id',
                'sales_stage',
                'commit_stage'
            ];

        this.params = {
            'fields': fields.join(','),
            'max_num': 10,
            'order_by': 'likely_case:desc'
        };

        this.tooltiptemplate = app.template.getView(this.name + '.tooltiptemplate');
    },

    initDashlet: function(view) {
        this.filterAssigned = this.settings.get('filter_assigned');

       this.setDateRange();

       this.chart = nv.models.bubbleChart()
           .x(function (d) {
               return d3.time.format('%Y-%m-%d').parse(d.x);
           })
           .y(function (d) {
               return d.y;
           })
           .tooltipContent(function (key, x, y, e, graph) {
               e.point.close_date = d3.time.format('%x')(d3.time.format('%Y-%m-%d').parse(e.point.x));
               e.point.amount = e.point.currency_symbol + d3.format(',.2d')(e.point.base_amount);
               return self.tooltiptemplate(e.point).replace(/(\r\n|\n|\r)/gm,"");
           })
           .showTitle(false)
           .tooltips(true)
           .showLegend(true)
           .bubbleClick(function (e) {
               self.chart.dispatch.tooltipHide(e);
               app.router.navigate(app.router.buildRoute('RevenueLineItems', e.point.id), {trigger: true});
           })
           .colorData('class', {step:2})
           .groupBy(function (d) {
               return (self.filterAssigned === 'my') ? d.sales_stage_short : d.assigned_user_name;
           })
           .filterBy(function (d) {
               return d.probability;
           });

       this.on('data-changed', function () {
           this.updateChart();
       }, this);
       this.settings.on('change:filter_duration', this.changeFilter, this);

       app.events.on('app:toggle:sidebar', function(state) {
           if(state == 'open') {
               this.chart.render();
           }
       }, this);
    },

    /**
     * Load data into chart model
     * and and set reference to chart
     */
    updateChart: function () {
        if (this.meta.config) {
            return;
        }

        // clear out the current chart before a re-render
        if (!_.isEmpty(this.chart)) {
            nv.utils.windowUnResize(this.chart.render);
            d3.select('svg#' + this.cid).select('.nvd3').remove();
        }

        if (this.dataset.data.length > 0) {
            this.$('.nv-chart').toggleClass('hide', false);
            this.$('.block-footer').toggleClass('hide', true);

            d3.select('svg#' + this.cid)
                .datum(this.dataset)
                .transition().duration(500)
                .call(this.chart);

            nv.utils.windowResize(this.chart.render);
            nv.utils.resizeOnPrint(this.chart.render);
        } else {
            this.$('.nv-chart').toggleClass('hide', true);
            this.$('.block-footer').toggleClass('hide', false);
        }
    },

    /**
     * Filter out records that don'w meet date criteria
     * and convert into format convienient for d3
     */
    evaluateResult: function (data) {
        // TODO need i18n on this
        var salesStageMap = {
                'Negotiation/Review': 'Negotiat./Review',
                'Perception Analysis': 'Percept. Analysis',
                'Proposal/Price Quote': 'Proposal/Quote',
                'Id. Decision Makers': 'Id. Deciders'
            };
        this.dataset = {
            data: data.records.map(function (d) {
                return {
                    id: d.id,
                    x: d.date_closed,
                    y: Math.round(parseInt(d.likely_case, 10) / parseFloat(d.base_rate)),
                    shape: 'circle',
                    account_name: d.account_name,
                    assigned_user_name: d.assigned_user_name,
                    sales_stage: d.sales_stage,
                    sales_stage_short: salesStageMap[d.sales_stage] || d.sales_stage,
                    probability: parseInt(d.probability, 10),
                    base_amount: parseInt(d.likely_case, 10),
                    currency_symbol: app.currency.getCurrencySymbol(d.currency_id)
                };
            }),
            properties: {
                title: app.lang.getAppString('LBL_DASHLET_TOP10_SALES_OPPORTUNITIES_NAME'),
                value: data.records.length
            }
        };
    },

    /**
     * {@inheritDoc}
     */
    render: function() {
        app.view.invokeParent(this, {type: 'view', name: 'view', method: 'render'});
        if(this.chart && !_.isEmpty(this.dataset)) {
            this.updateChart();
        }
    },

    /**
     * Request data from REST endpoint, evaluate result and trigger data change event
     */
    loadData: function (options) {
        var self = this,
            _filter = [
                {
                    'date_closed': {
                        '$gte': self.dateRange.begin
                    }
                },
                {
                    'date_closed': {
                        '$lte': self.dateRange.end
                    }
                }
            ];

        if (this.filterAssigned === 'my') {
            _filter.push({'$owner': ''});
        }

        var _local = _.extend({'filter': _filter}, this.params);

        var url = app.api.buildURL('RevenueLineItems', null, null, _local, this.params);

        app.api.call('read', url, null, {
            success: function (data) {
                self.evaluateResult(data);
                self.trigger('data-changed');
            },
            complete: options ? options.complete : null
        });
    },

    /**
     * Calculate date range based on date range dropdown control
     */
    setDateRange: function () {
        var now = new Date(),
            duration = parseInt(this.settings.get('filter_duration'), 10),
            startMonth = Math.floor(now.getMonth() / 3) * 3,
            startDate = new Date(now.getFullYear(), (duration === 12 ? 0 : startMonth + duration), 1),
            endDate = new Date(now.getFullYear(), (duration === 12 ? 12 : startDate.getMonth() + 3), 0);
        this.dateRange = {
            'begin': app.date.format(startDate, 'Y-m-d'),
            'end': app.date.format(endDate, 'Y-m-d')
        };
    },

    /**
     * Trigger data load event based when date range dropdown changes
     */
    changeFilter: function () {
        this.setDateRange();
        this.loadData();
    },

    /**
     * Trigger data load event only when dataset toggle changes.
     */
    switchChart: function (e) {
        if (this.filterAssigned === e.currentTarget.value) {
            return;
        }
        this.filterAssigned = e.currentTarget.value;
        this.loadData();
    },

    _dispose: function () {
        this.on('data-changed', null, this);
        if (!_.isEmpty(this.chart)) {
            nv.utils.windowUnResize(this.chart.render);
            nv.utils.unResizeOnPrint(this.chart.render);
        }
        app.view.View.prototype._dispose.call(this);
    }

})
