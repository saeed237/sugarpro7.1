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
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);

        this.funnelCollection = app.data.createBeanCollection(this.module);
        this.funnelCollection.fetch({
            //Don't show alerts for this request
            showAlerts: false
        });
        this.guid = _.uniqueId("funnel");
    },

    _render: function() {
        var self = this;

        app.view.View.prototype._render.call(this);

        // Once the data is fetched, process it, then render it.
        this.funnelCollection.on("reset", function() {
            var day_ms = 1000*60*60*24;
            var today = new Date();
            today.setUTCHours(0,0,0,0);
            var d1 = new Date(today.getTime() + 31*day_ms);
            var data, sum;
            if(self.funnelCollection) {
                data = self.funnelCollection.filter(function(model) {
                    // Filter for 30 days from now.
                    var d2 = new Date(model.get("date_closed") || "1970-01-01");
                    return (d2-d1)/day_ms <= 30;
                });
                sum = _.reduce(data, function(memo, model) {
                    return memo + parseInt(model.get('amount_usdollar'), 10);
                }, 0);
                data = _.groupBy(data, function(m) {
                    return m.get("sales_stage");
                });
            }

            var stages = ["Prospecting", "Qualification", "Closed Lost", "Closed Won"];
            var scale = 1000;

            // Massage the values to what we want.
            // TODO: Make this more efficient.
            var root = {
                properties: {
                    scale: scale,
                    title: "Pipeline",
                    units: "$",
                    total: parseInt(sum/scale, 10)
                },
                data: []
            };

            var cumulative = 0;

            _.each(stages, function(stage, i) {
                var subtotal = 0;
                if(data && data[stage]) {
                    subtotal = _.reduce(data[stage], function(memo, model) {
                        return memo + parseInt(model.get('amount_usdollar'), 10);
                    }, 0)/scale;
                }
                root.data.push({
                    bar: true,
                    key: stage,
                    values: [{
                        series: i,
                        x: 0,
                        y: subtotal,
                        y0: cumulative
                    }]
                });
                cumulative += subtotal;
            });

            nv.addGraph(function() {
                var chart = nv.models.funnelChart();

                // chart.xAxis
                //     .tickFormat(d3.format(',f'));

                chart.yAxis
                    .tickFormat(d3.format(',.1f'));

                chart.showTitle(false);

                d3.select('#'+self.guid+' svg')
                    .datum(root)
                  .transition().duration(500).call(chart);

                nv.utils.windowResize(chart.update);

                return chart;
            });

        });
    },

    unbindData: function() {
        this.funnelCollection.off();
        this.funnelCollection = null;
        app.view.View.prototype.unbindData.call(this);
    }
})
