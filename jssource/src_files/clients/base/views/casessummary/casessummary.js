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
    plugins: ['Dashlet'],
    className: 'cases-summary-wrapper',
    chart: {},
    total: 0,

    initialize: function(o) {
        app.view.View.prototype.initialize.call(this, o);
    },

    _render: function () {
        app.view.View.prototype._render.call(this);

        if (this.viewName === "config" || this.total === 0) {
            return;
        }

        this.chart = nv.models.pieChart()
            .x(function(d) { return d.key; })
            .y(function(d) { return d.value; })
            .margin({top:10, right:10, bottom:15, left:10})
            .donut(true)
            .donutLabelsOutside(true)
            .donutRatio(0.4)
            .hole(self.totalCases)
            .showTitle(false)
            .showLegend(false)
            .colorData('class')
            .tooltipContent( function(key, x, y, e, graph) {
                return '<p><b>' + key +' '+  parseInt(y, 10) +'</b></p>';
            });

        d3.select('svg#' + this.cid)
            .datum(this.chartData)
            .transition().duration(500)
            .call(this.chart);

        app.events.on('app:toggle:sidebar', function(state) {
            if(state == 'open') {
                this.chart.update();
            }
        }, this);

        nv.utils.windowResize(this.chart.update);
        nv.utils.resizeOnPrint(this.chart.update);
    },

    /* Process data loaded from REST endpoint so that d3 chart can consume
     * and set general chart properties
     */
    evaluateResult: function (data) {
        this.chartCollection = data;
        this.closedCases = this.chartCollection.where({status:'Closed'});
        this.closedCases = this.closedCases.concat(this.chartCollection.where({status:'Rejected'}));
        this.closedCases = this.closedCases.concat(this.chartCollection.where({status:'Duplicate'}));
        this.openCases = this.chartCollection.models.length - this.closedCases.length;
        this.chartData = {
            'data': [
            ]
        };
        this.chartData.data.push({
            key: 'Closed Cases',
            class: 'nv-fill-green',
            value: this.closedCases.length
        });
        this.chartData.data.push({
            key: 'Open Cases',
            class: 'nv-fill-red',
            value: this.openCases
        });

        this.total = this.openCases + this.closedCases.length;
    },

    loadData: function (options) {
        var self = this,
            oppID = this.model.get('account_id'),
            accountBean;
        if (oppID) {
            accountBean = app.data.createBean('Accounts', {id: oppID});
        }
        var relatedCollection = app.data.createRelatedCollection(accountBean || this.model, 'cases');
        relatedCollection.fetch({
            relate: true,
            success: function(resultCollection) {
                self.evaluateResult(resultCollection);
                self.processCases();
                self.render();
                self.addFavs();
            },
            complete: options ? options.complete : null
        });
    },

    addFavs: function() {
        var self = this;
        this.favFields = [];
        //loop over chartCollection
        _.each(this.tabData, function(tabGroup) {
            if (tabGroup.models && tabGroup.models.length >0) {
                _.each(tabGroup.models, function(model){
                    var field = app.view.createField({
                            def: {
                                type: "favorite"
                            },
                            model: model,
                            meta: {
                                view: "detail"
                            },
                            viewName: "detail",
                            view: self
                        }
                    );
                    field.setElement(self.$('.favTarget.[data-model-id="'+model.id+'"]'));
                    field.render();
                    self.favFields.push(field);
                });
            }
        });
    },

    processCases: function () {
        var status2css = {
            'Rejected':'label-success',
            'Closed':'label-success',
            'Duplicate':'label-success'
        };
        if (!this.chartCollection || this.chartCollection.models.length === 0) return;
        this.tabData = [];

        var stati = _.uniq(this.chartCollection.pluck('status'));

        _.each(stati, function(status, index){
            if (!status2css[status]) {
                this.tabData.push({
                    index: index,
                    status: status,
                    models: this.chartCollection.where({'status':status}),
                    cssClass: status2css[status] ? status2css[status] : 'label-important'
                });
            }
        }, this);

        this.tabClass = ['one','two','three','four','five'][this.tabData.length] || 'four';
    },

    _dispose: function() {
        this.favFields = null;
        this.model.off("change", this.loadData, this);
        if (!_.isEmpty(this.chart)) {
            nv.utils.windowUnResize(this.chart.update);
            nv.utils.unResizeOnPrint(this.chart.update);
        }
        app.view.View.prototype._dispose.call(this);
    }
})
