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
     * Contains the actual chart being displayed
     */
    chart: undefined,
    chartType: '',

    /**
     * @{inheritDoc}
     */
    bindDataChange: function() {
        this.model.on('change:rawChartData', function() {
            if(this.model.get('rawChartData').values.length > 0) {
                this.$el.find('.nv-chart').toggleClass('hide', false);
                this.$el.find('.block-footer').toggleClass('hide', true);

                this.generateD3Chart();

                this.$el.find('.nv-chart').attr('class', 'nv-chart nv-' + this.chartType);
            } else {
                this.$el.find('.nv-chart').toggleClass('hide', true);
                this.$el.find('.block-footer').toggleClass('hide', false);
            }

        }, this);
    },

    /**
     * Generate the D3 Chart Object
     */
    generateD3Chart: function() {
        var chartId = this.cid,
            chartConfig = this.getChartConfig(),
            params = {
                contentEl: chartId,
                minColumnWidth: 120
            },
            chart = new loadSugarChartD3(chartId, this.model.get('rawChartData'), [], chartConfig, params, _.bind(function(chart){
                this.chart = chart;
            }, this));
    },

    /**
     * Builds the chart config based on the type of chart
     * @returns {*}
     */
    getChartConfig: function() {
        var chartConfig,
            chartData = this.model.get('rawChartData');

        switch(chartData.properties[0].type) {
            case 'pie chart':
                chartConfig = {
                    pieType: 'basic',
                    tip: 'name',
                    chartType: 'pieChart'
                };
                break;

            case 'line chart':
                chartConfig = {
                    lineType: 'basic',
                    tip: 'name',
                    chartType: 'lineChart'
                };
                break;

            case 'funnel chart 3D':
                chartConfig = {
                    funnelType: 'basic',
                    tip: 'name',
                    chartType: 'funnelChart'
                };
                break;

            case 'gauge chart':
                chartConfig = {
                    gaugeType: 'basic',
                    tip: 'name',
                    chartType: 'gaugeChart'
                };
                break;

            case 'stacked group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    tip: 'title',
                    chartType: 'barChart'
                };
                break;

            case 'group by chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'grouped',
                    tip: 'name',
                    chartType: 'barChart'
                };
                break;

            case 'bar chart':
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'basic',
                    tip: 'label',
                    chartType: 'barChart'
                };
                break;

            case 'horizontal group by chart':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'stacked',
                    tip: 'name',
                    chartType: 'barChart'
                };
                break;

            case 'horizontal bar chart':
            case 'horizontal':
                chartConfig = {
                    orientation: 'horizontal',
                    barType: 'basic',
                    tip: 'label',
                    chartType: 'barChart'
                };
                break;

            default:
                chartConfig = {
                    orientation: 'vertical',
                    barType: 'stacked',
                    tip: 'name',
                    chartType: 'barChart'
                };
                break;
        }

        this.chartType = chartConfig.chartType;

        return chartConfig;
    }
})
