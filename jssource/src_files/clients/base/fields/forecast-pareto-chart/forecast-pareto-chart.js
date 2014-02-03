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
    /**
     * The data from the server
     */
    _serverData: undefined,

    /**
     * The open state of the sidepanel
     */
    state: "open",

    /**
     * Visible state of the preview window
     */
    preview_open: false,

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        this.once('render', function() {
            this.renderChart();
        }, this);
        app.view.Field.prototype.initialize.call(this, options);
    },

    /**
     * {@inheritDoc}
     */
    bindDataChange: function() {
        app.events.on('preview:open', function() {
            this.preview_open = true;
        }, this);
        app.events.on('preview:close', function() {
            this.preview_open = false;
        }, this);
        app.events.on('app:toggle:sidebar', function(state) {
            this.state = state;
            if (this.state == 'open' && !this.preview_open
                && !_.isUndefined(this._serverData)) {
                this.convertDataToChartData();
                this.generateD3Chart();
            }
        }, this);

        this.model.on('change', function(model) {
            var changed = _.keys(model.changed);
            if (!_.isEmpty(_.intersection(['user_id', 'display_manager', 'timeperiod_id'], changed))) {
                this.renderChart();
            }
        }, this);

        this.model.on('change:group_by change:dataset change:ranges', function() {
            if (this.state == 'open' && !this.preview_open
                && !_.isUndefined(this._serverData)) {
                this.convertDataToChartData();
                this.generateD3Chart();
            }
        }, this);
    },

    /**
     * {@inheritdoc}
     * Clean up!
     */
    unbindData: function() {
        app.events.off(null, null, this);
        app.view.View.prototype.unbindData.call(this);
    },

    /**
     * Render the chart for the first time
     *
     * @param {Object} [options]        Options from the dashlet loaddata call
     */
    renderChart: function(options) {
        if (this.disposed || !this.triggerBefore('chart:pareto:render')
            || _.isUndefined(this.model.get('timeperiod_id'))
            || _.isUndefined(this.model.get('user_id'))) {
            return;
        }

        this._serverData = undefined;

        this.chartId = this.cid + '_chart';
        this.paretoChart = nv.models.paretoChart()
            .margin({top: 0, right: 10, bottom: 20, left: 50})
            .showTitle(false)
            .tooltips(true)
            .tooltipLine(function(key, x, y, e, graph) {
                // Format the value using currency class and user settings
                var val = App.currency.formatAmountLocale(e.point.y);
                return '<p>' + key + ': <b>' + val + '</b></p>';
            })
            .tooltipBar(function(key, x, y, e, graph) {
                // Format the value using currency class and user settings
                var val = App.currency.formatAmountLocale(e.value);
                return '<p>' + SUGAR.App.lang.get('LBL_SALES_STAGE', 'Forecasts') + ': <b>' + key + '</b></p>' +
                    '<p>' + SUGAR.App.lang.get('LBL_AMOUNT', 'Forecasts') + ': <b>' + val + '</b></p>' +
                    '<p>' + SUGAR.App.lang.get('LBL_PERCENT', 'Forecasts') + ': <b>' + x + '%</b></p>';
            })
            .showControls(false)
            .colorData('default')
            .colorFill('default')
            .id(this.chartId);

        // just on the off chance that no options param is passed in
        options = options || {};
        options.success = _.bind(function(data) {
            if(this.model) {
                this._serverData = data;
                this.convertDataToChartData();
                this.generateD3Chart();
            }
        }, this);

        var read_options = {};
        if (this.model.has('no_data') && this.model.get('no_data') === true) {
            read_options['no_data'] = 1;
        }

        var url = app.api.buildURL(this.buildChartUrl(), null, null, read_options);

        app.api.call('read', url, {}, options);
    },

    /**
     * Generate the D3 Chart Object
     */
    generateD3Chart: function() {
        var params = this.model.toJSON();

        // clear out the current chart before a re-render
        if (!_.isEmpty(this.paretoChart)) {
            nv.utils.windowUnResize(this.paretoChart.update);
            d3.select('#' + this.chartId + ' svg').remove();
        }

        this.paretoChart.stacked(!params.display_manager);

        if (this.d3Data.data.length > 0) {
            // if the chart element is hidden by a previous render, but has data now, show it
            this.$('.nv-chart').toggleClass('hide', false);
            this.$('.block-footer').toggleClass('hide', true);

            // After the .call(paretoChart) line, we are selecting the text elements for the Y-Axis
            // only so we can custom format the Y-Axis values
            d3.select('#' + this.chartId)
                .append('svg')
                .datum(this.d3Data)
                .transition().duration(500)
                .call(this.paretoChart)
                .selectAll('.nv-y.nv-axis .tick')
                .select('text')
                .text(function(d) {
                    return App.user.get('preferences').currency_symbol + d3.format(',.2s')(d);
                });

            nv.utils.windowResize(this.paretoChart.update);
            nv.utils.resizeOnPrint(this.paretoChart.update);
        } else {
            this.$('.nv-chart').toggleClass('hide', true);
            this.$('.block-footer').toggleClass('hide', false);
        }

        this.trigger('chart:pareto:rendered');
    },

    /**
     * Utility method to determine which data we need to parse,
     */
    convertDataToChartData: function() {
        if(this.state == 'closed' || this.preview_open || _.isUndefined(this._serverData)) {
            return -1;
        }

        if (this.model.get('display_manager')) {
            this.convertManagerDataToChartData();
        } else {
            this.convertRepDataToChartData(this.model.get('group_by'));
        }
    },

    /**
     * Parse the Manager Data and set the d3Data object
     */
    convertManagerDataToChartData: function() {
        var dataset = this.model.get('dataset'),
            records = this._serverData.data,
            chartData = {
                'properties': {
                    'name': this._serverData.title,
                    'quota': parseFloat(this._serverData.quota),
                    'quotaLabel': app.lang.get('LBL_QUOTA_ADJUSTED', 'Forecasts'),
                    'groupData': records.map(function(record, i) {
                        return {
                            group: i,
                            l: record.name,
                            t: parseFloat(record[dataset]) + parseFloat(record[dataset + '_adjusted'])
                        };
                    })
                },
                'data': []
            },
            barData = [dataset, dataset + '_adjusted'].map(function(ds, seriesIdx) {
                var vals = records.map(function(rec, recIdx) {
                    return {
                        series: seriesIdx,
                        x: recIdx + 1,
                        y: parseFloat(rec[ds]),
                        y0: 0
                    };
                });

                return {
                    key: this._serverData.labels['dataset'][ds],
                    series: seriesIdx,
                    type: 'bar',
                    values: vals,
                    valuesOrig: vals
                };
            }, this),
            lineData = [dataset, dataset + '_adjusted'].map(function(ds, seriesIdx) {
                var vals = records.map(function(rec, recIdx) {
                    return {
                        series: seriesIdx,
                        x: recIdx + 1,
                        y: parseFloat(rec[ds])
                    }
                });

                // fix the vals
                var addToLine = 0;
                _.each(vals, function(val, i, list) {
                    list[i].y += addToLine;
                    addToLine = list[i].y;
                });

                return {
                    key: this._serverData.labels['dataset'][ds],
                    series: seriesIdx,
                    type: 'line',
                    values: vals,
                    valuesOrig: vals
                };
            }, this);

        chartData.data = barData.concat(lineData);
        this.d3Data = chartData;
    },

    /**
     * Convert the Rep Data and set the d3Data Object
     *
     * @param {string} type     What we are dispaying
     */
    convertRepDataToChartData: function(type) {
        var dataset = this.model.get('dataset'),
            ranges = this.model.get('ranges'),
            seriesIdx = 0,
            barData = [],
            lineVals = this._serverData['x-axis'].map(function(axis, i) {
                return { series: seriesIdx, x: i + 1, y: 0 }
            }),
            line = {
                'key': this._serverData.labels.dataset[dataset],
                'type': 'line',
                'series': seriesIdx,
                'values': [],
                'valuesOrig': []
            },
            chartData = {
                'properties': {
                    'name': this._serverData.title,
                    'quota': parseFloat(this._serverData.quota),
                    'quotaLabel': app.lang.get('LBL_QUOTA', 'Forecasts'),
                    'groupData': this._serverData['x-axis'].map(function(item, i) {
                        return {
                            'group': i,
                            'l': item.label,
                            't': 0
                        };
                    })
                },
                'data': []
            },
            records = this._serverData.data,
            data = (!_.isEmpty(ranges)) ? records.filter(function(rec) {
                return _.contains(ranges, rec.forecast);
            }) : records;

        _.each(this._serverData.labels[type], function(label, value) {
            var td = data.filter(function(d) {
                return (d[type] == value);
            });

            if (!_.isEmpty(td)) {
                var barVal = this._serverData['x-axis'].map(function(axis, i) {
                        return { series: seriesIdx, x: i + 1, y: 0, y0: 0 }
                    }),
                    axis = this._serverData['x-axis'];

                // loop though all the data and map it to the correct x series
                _.each(td, function(record) {
                    for(var y = 0; y < axis.length; y++) {
                        if (record.date_closed_timestamp >= axis[y].start_timestamp &&
                            record.date_closed_timestamp <= axis[y].end_timestamp) {
                            // add the value
                            var val = parseFloat(record[dataset]);
                            barVal[y].y += val;
                            chartData.properties.groupData[y].t += val;
                            lineVals[y].y += val;
                            break;
                        }
                    }
                }, this);

                barData.push({
                    key: label,
                    series: seriesIdx,
                    type: 'bar',
                    values: barVal,
                    valuesOrig: barVal
                });

                // increase the series
                seriesIdx++;
            }
        }, this);

        if (!_.isEmpty(barData)) {
            // fix the line
            var addToLine = 0;
            _.each(lineVals, function(val, i, list) {
                list[i].y += addToLine;
                addToLine = list[i].y;
            });

            line.values = lineVals;
            line.valuesOrig = lineVals;

            barData.push(line);
            chartData.data = barData;
        }

        this.d3Data = chartData;
    },

    /**
     * Accepts params object and builds the proper endpoint url for charts
     *
     * @return {String} has the proper structure for the chart url.
     */
    buildChartUrl: function() {
        var baseUrl = this.model.get('display_manager') ? 'ForecastManagerWorksheets' : 'ForecastWorksheets';
        return baseUrl + '/chart/' + this.model.get('timeperiod_id') + '/' + this.model.get('user_id');
    },

    /**
     * Do we have serverData yet?
     * @returns {boolean}
     */
    hasServerData: function() {
        return !_.isUndefined(this._serverData);
    },

    /**
     * Return the data that was passed back from the server
     * @returns {Object}
     */
    getServerData: function() {
        return this._serverData;
    },

    /**
     *
     * @param {Object} data
     * @param {Boolean} [adjustLabels]
     */
    setServerData: function(data, adjustLabels) {
        this._serverData = data;

        if (adjustLabels === true) {
            this.adjustProbabilityLabels();
        }

        this.convertDataToChartData();
        this.generateD3Chart();
    },

    /**
     * When the Probability Changes on the Rep Worksheet, The labels in the chart data need to be updated
     * to Account for the potentially new label.
     */
    adjustProbabilityLabels: function() {
        var probabilities = _.unique(_.map(this._serverData.data, function(item) {
            return item.probability;
        })).sort();

        this._serverData.labels.probability = _.object(probabilities, probabilities);
    }
})
