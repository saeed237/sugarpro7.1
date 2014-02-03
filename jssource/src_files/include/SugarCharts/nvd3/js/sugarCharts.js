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




function loadSugarChartD3 (chartId, jsonFilename, css, chartConfig, params, callback) {
    this.chartObject = "";

    // get chartId from params or use the default for sugar
    var d3ChartId = 'd3_'+chartId || 'd3_c3090c86-2b12-a65e-967f-51b642ac6165';
    var canvasChartId = 'canvas_'+chartId || 'canvas_c3090c86-2b12-a65e-967f-51b642ac6165';

    //Bug#45831
    if (document.getElementById(d3ChartId) === null) {
        return false;
    }

    var labelType = 'Native',
        useGradients = false,
        animate = false,
        that = this,
        /**
         * the main container to render chart
         */
            contentEl = 'content',
        /**
         * with of one column to render bars
         */
            minColumnWidth = 40;

    params = params ? params : {};

    contentEl = params.contentEl || contentEl;
    minColumnWidth = params.minColumnWidth || minColumnWidth;

    switch(chartConfig["chartType"]) {

        case "paretoChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {

                if(SUGAR.chartsD3.isDataEmpty(data)){
                    var json = SUGAR.chartsD3.translateParetoDataToD3(data,params,chartConfig);

                    var marginBottom = (chartConfig["orientation"] == 'vertical' && data.values.length > 8) ? 20*4 : 20;

                    var paretoChart = nv.models.paretoChart()
                        .margin({top: 0, right: 0, bottom: 20, left: 45})
                        .showTitle(false)
                        .tooltips(true)
                        .tooltipLine(function(key, x, y, e, graph) {
                            // Format the value using currency class and user settings
                            var val = App.currency.formatAmountLocale(e.point.y);
                            return '<p>' + key +': <b>' + val + '</b></p>';
                        })
                        .tooltipBar(function(key, x, y, e, graph) {
                            // Format the value using currency class and user settings
                            var val = App.currency.formatAmountLocale(e.value);
                            return '<p>' + SUGAR.App.lang.get('LBL_SALES_STAGE', 'Forecasts') + ': <b>' + key + '</b></p>' +
                                '<p>' + SUGAR.App.lang.get('LBL_AMOUNT', 'Forecasts') + ': <b>' + val + '</b></p>' +
                                '<p>' + SUGAR.App.lang.get('LBL_PERCENT', 'Forecasts') + ': <b>' + x + '%</b></p>';
                        })
                        .showControls(false)
                        .colorData( 'default' )
                        .colorFill( 'default' )
                        .stacked(!params.display_manager)
                        .id(chartId);

                    // get chartId from params or use the default for sugar
                    d3ChartId = params.chartId || 'db620e51-8350-c596-06d1-4f866bfcfd5b';

                    // After the .call(paretoChart) line, we are selecting the text elements for the Y-Axis
                    // only so we can custom format the Y-Axis values
                    d3.select('#' + d3ChartId)
                        .append('svg')
                        .datum(json)
                        .transition().duration(500)
                        .call(paretoChart)
                        .selectAll('.nv-y.nv-axis text')
                        .text(function(d) {
                            return App.user.get('preferences').currency_symbol + d3.format(",.2s")(d);
                        });

                    nv.utils.windowResize(paretoChart.update);

                    that.chartObject = paretoChart;

                    SUGAR.chartsD3.setChartObject(paretoChart);
                }
                SUGAR.chartsD3.callback(callback);
            });
            break;

        case "barChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {

                if (SUGAR.chartsD3.isDataEmpty(data)) {
                    var json = SUGAR.chartsD3.translateDataToD3(data,params,chartConfig);

                    var marginBottom = (chartConfig["orientation"] === 'vertical' && data.values.length > 8) ? 20*3 : 20;
                    var marginLeft = (chartConfig["orientation"] === 'vertical') ? 45 : 20;
                    var rotateLabels = (chartConfig["orientation"] === 'vertical' && data.values.length > 8) ? 20 : 0;

                    var barChart = (chartConfig["orientation"] === 'vertical') ? nv.models.multiBarChart() : nv.models.multiBarHorizontalChart();

                    barChart
                        .margin({top: 0, right: 20, bottom: marginBottom, left: marginLeft})
                        .showTitle(true)
                        .tooltips(true)
                        .tooltipContent( function(key, x, y, e, graph) {
                            return '<h3>' + key + '</h3>' +
                                '<p>' +  y + '</p>';
                        })
                        .showControls(false)
                        .rotateLabels(rotateLabels)
                        .reduceXTicks(false)
                        .colorData('default')
                        .stacked(chartConfig.barType === 'stacked'? true : true)
                        .id(d3ChartId);

                    barChart.yAxis
                        .tickSize(0)
                        .tickFormat(d3.format(",.0f"));

                    d3.select('#' + d3ChartId)
                        .append('svg')
                        .datum(json)
                        .transition().duration(500)
                        .call(barChart);

                    nv.utils.windowResize(barChart.update);

                    that.chartObject = barChart;

                    SUGAR.chartsD3.setChartObject(barChart);
                }

                SUGAR.chartsD3.callback(callback);
            });
            break;

        case "lineChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {
                if(SUGAR.chartsD3.isDataEmpty(data)){
                    var json = SUGAR.chartsD3.translateDataToD3(data,params,chartConfig);
                    var xLabels = data.label;

                    var lineChart = nv.models.lineChart()
                        .x(function(d) { return d[0]; })
                        .y(function(d) { return d[1]; })
                        .size(function() { return 123; })
                        .margin({top: 0, right: 20, bottom: 30, left: 45})
                        .tooltipContent( function(key, x, y, e, graph) {
                            return '<h3>' + key + '</h3>' +
                                '<p>' +  y + '</p>';
                        })
                        .showTitle(true)
                        .tooltips(true)
                        .showControls(false)
                        .colorData('default')
                        .id(d3ChartId);

                    lineChart.xAxis
                        .showMaxMin(false)
                        .highlightZero(false)
                        .tickFormat(function(d,i) { return xLabels[d]; });

                    d3.select('#' + d3ChartId)
                        .append('svg')
                        .datum(json)
                        .transition().duration(500)
                        .call(lineChart);

                    nv.utils.windowResize(lineChart.update);

                    that.chartObject = lineChart;

                    SUGAR.chartsD3.setChartObject(lineChart);
                }
                SUGAR.chartsD3.callback(callback);
            });
            break;

        case "pieChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {
                if(SUGAR.chartsD3.isDataEmpty(data)){
                    var json = SUGAR.chartsD3.translateDataToD3(data,params,chartConfig);

                    var pieChart = nv.models.pieChart()
                        .margin({top: 0, right: 0, bottom: 20, left: 45})
                        .showTitle(true)
                        .tooltips(true)
                        .colorData('default')
                        .id(d3ChartId);

                    d3.select('#' + d3ChartId)
                        .append('svg')
                        .datum(json)
                        .transition().duration(500)
                        .call(pieChart);

                    nv.utils.windowResize(pieChart.update);

                    that.chartObject = pieChart;

                    SUGAR.chartsD3.setChartObject(pieChart);
                }
                SUGAR.chartsD3.callback(callback);
            });
            break;

        case "funnelChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {
                if(SUGAR.chartsD3.isDataEmpty(data)){
                    var json = SUGAR.chartsD3.translateDataToD3(data,params,chartConfig);

                    var funnelChart = nv.models.funnelChart()
                        .margin({top: 0, right: 0, bottom: 20, left: 45})
                        .showTitle(true)
                        .tooltips(true)
                        .fmtValueLabel(function(d) { return d.y; })
                        .tooltipContent( function(key, x, y, e, graph) {
                            return '<h3>' + key + '</h3>' +
                                '<p>' +  y + '</p>';
                        })
                        .colorData('default')
                        .id(d3ChartId);

                    d3.select('#' + d3ChartId)
                        .append('svg')
                        .datum(json)
                        .transition().duration(500)
                        .call(funnelChart);

                    nv.utils.windowResize(funnelChart.update);

                    that.chartObject = funnelChart;

                    SUGAR.chartsD3.setChartObject(funnelChart);
                }
                SUGAR.chartsD3.callback(callback);
            });
            break;

        case "gaugeChart":
            SUGAR.chartsD3.get(jsonFilename, params, function(data) {
                if(SUGAR.chartsD3.isDataEmpty(data)){
                    var properties = $jit.util.splat(data.properties)[0];

                    //init Gauge Chart
                    var gaugeChart = new $jit.GaugeChart({
                        //id of the visualization container
                        injectInto: chartId,
                        //whether to add animations
                        animate: animate,
                        renderBackground: chartConfig['imageExportType'] == "jpg" ? true: false,
                        backgroundColor: 'rgb(255,255,255)',
                        colorStop1: 'rgba(255,255,255,.8)',
                        colorStop2: 'rgba(255,255,255,0)',
                        labelType: properties['labels'],
                        hoveredColor: false,
                        Title: {
                            text: properties['title'],
                            size: 16,
                            color: '#444444',
                            offset: 20
                        },
                        Subtitle: {
                            text: properties['subtitle'],
                            size: 11,
                            color: css["color"],
                            offset: 5
                        },
                        //offsets
                        offset: 20,
                        gaugeStyle: {
                            backgroundColor: '#aaaaaa',
                            borderColor: '#999999',
                            needleColor: 'rgba(255,0,0,.8)',
                            borderSize: 4,
                            positionFontSize: 24,
                            positionOffset: 2
                        },
                        //slice style
                        type: useGradients? chartConfig["gaugeType"]+':gradient' : chartConfig["gaugeType"],
                        //whether to show the labels for the slices
                        showLabels:true,
                        Events: {
                            enable: true,
                            onClick: function(node) {
                                if(!node || $jit.util.isTouchScreen()) return;
                                if(node.link == 'undefined' || node.link == '') return;
                                window.location.href=node.link;
                            }
                        },
                        //label styling
                        Label: {
                            type: labelType, //Native or HTML
                            size: 12,
                            family: css["font-family"],
                            color: css["color"]
                        },
                        //enable tips
                        Tips: {
                            enable: true,
                            onShow: function(tip, elem) {
                                if(elem.link != 'undefined' && elem.link != '') {
                                    drillDown = ($jit.util.isTouchScreen()) ? "<br><a href='"+ elem.link +"'>Click to drilldown</a>" : "<br>Click to drilldown";
                                } else {
                                    drillDown = "";
                                }
                                if(elem.valuelabel != 'undefined' && elem.valuelabel != undefined && elem.valuelabel != '') {
                                    value = "elem.valuelabel";
                                } else {
                                    value = "elem.value";
                                }
                                eval("tip.innerHTML = '<b>' + elem.label + '</b>: ' + "+ value +" + drillDown");
                            }
                        }
                    });
                    //load JSON data.
                    gaugeChart.loadJSON(data);

                    var list = SUGAR.chartsD3.generateLegend(gaugeChart, chartId);

                    //save canvas to image for pdf consumption
                    $jit.util.saveImageTest(chartId,jsonFilename,chartConfig["imageExportType"]);

                    SUGAR.chartsD3.trackWindowResize(gaugeChart, chartId, data);
                    that.chartObject = gaugeChart;
                }
                SUGAR.chartsD3.callback(callback);
            });
            break;
    }
}
/*
 function updateChart(jsonFilename, chart, params) {
 params = params ? params : {};
 SUGAR.chartsD3.get(jsonFilename, params, function(data) {
 if(SUGAR.chartsD3.isDataEmpty(data)){
 chart.busy = false;
 chart.updateJSON(data);
 }
 });
 }
 */
function swapChart(chartId,jsonFilename,css,chartConfig){
    $("#"+chartId).empty();
    $("#legend"+chartId).empty();
    $("#tiptip_holder").empty();
    var chart = new loadSugarChartD3(chartId,jsonFilename,css,chartConfig);
    return chart;
}

/**
 * As you touch the code above, migrate the code to use the pattern below.
 */
(function($) {

    if (typeof SUGAR == "undefined" || !SUGAR) {
        SUGAR = {};
    }
    SUGAR.chartsD3 = {

        chart : null,
        /**
         * Execute callback function if specified
         *
         * @param callback
         */
        callback: function(callback) {
            if (callback) {
                // if the call back is fired, include the chart as the only param
                callback(this.chart);
            }
        },

        setChartObject : function(chart) {
            this.chart = chart;
        },

        /**
         * Handle the Legend Generation
         *
         * @param chart
         * @param chartId
         * @return {*}
         */
        generateLegend: function(chart, chartId) {
            var list = $jit.id('legend'+chartId);
            var legend = chart.getLegend();
            var table, i;
            if (typeof legend['wmlegend'] != "undefined" && legend['wmlegend']['name'].length > 0) {
                table = "<div class='col'>";
            } else {
                table = "<div class='row'>";
            }
            for (i=0;i<legend['name'].length;i++) {
                if(legend["name"][i] !== undefined) {
                    table += "<div class='legendGroup'>";
                    table += '<div class=\'query-color\' style=\'background-color:' +
                        legend["color"][i] +'\'></div>';
                    table += '<div class=\'label\'>';
                    table += legend["name"][i];
                    table += '</div>';
                    table += "</div>";
                }
            }

            table += "</div>";


            if(typeof legend['wmlegend'] != "undefined" && legend['wmlegend']['name'].length > 0) {

                table += "<div class='col2'>";
                for(i=0;i<legend['wmlegend']['name'].length;i++) {
                    table += "<div class='legendGroup'>";
                    table += "<div class='waterMark  "+ legend["wmlegend"]['type'][i] +"' style='background-color: "+ legend["wmlegend"]['color'][i] +";'></div>";
                    table += "<div class='label'>"+ legend["wmlegend"]['name'][i] +"</div>";
                    table += "</div>";
                }
                table += "</div>";

            }

            list.innerHTML = table;

            //adjust legend width to chart width
            jQuery('#legend'+chartId).ready(function() {
                var chartWidth = jQuery('#'+chartId).width();
                var sel;
                chartWidth = chartWidth - 20;
                $('#legend'+chartId).width(chartWidth);
                var legendGroupWidth = [];
                if(typeof legend['wmlegend'] != "undefined" && legend['wmlegend']['name'].length > 0) {
                    sel = ".col .legendGroup";
                } else {
                    sel = ".row .legendGroup";
                }
                $(sel).each(function(index) {
                    legendGroupWidth[index] = $(this).width();
                });
                var largest = Math.max.apply(Math, legendGroupWidth);
                $(sel).width(largest+2);
            });

            return list;
        },

        /**
         * @override
         *
         * For D3 charts we already have the data, don't need to make an ajax call to get anything
         *
         * @param data - JSON data for the chart
         * @param param - object of parameters to pass to the server
         * @param success - callback function to be executed
         */
        get: function(data, params, success) {
            success(data);
        },

        translateDataToD3 : function( json, params, chartConfig ) {
            var data = [];

            if (json.values.filter(function(d) { return d.values.length; }).length) {

                switch(chartConfig["chartType"]) {

                    case "barChart":
                        data = (chartConfig.barType === 'stacked') ?
                            json.label.map( function(d,i){
                                return {
                                    "key": (d !== '')?d:'',
                                    "type": "bar",
                                    "values": json.values.map( function(e,j) {
                                        return { "series": i, "x": j+1, "y": (parseInt(e.values[i],10) || 0), y0: 0 };
                                    })
                                };
                            }) :
                            json.values.map( function(d,i){
                                return {
                                    "key": (d.label[0] !== '')?d.label[0]:'',
                                    "type": "bar",
                                    "values": json.values.map( function(e,j) {
                                        return { "series": i, "x": j+1, "y": (i===j?parseInt(e.values[0],10):0), y0: 0 };
                                    })
                                };
                            });
                        break;

                    case "pieChart":
                        data = json.values.map( function(d,i){
                            return {
                                "key": (d.label[0] !== '')?d.label[0]:'',
                                "value": parseInt(d.values[0],10)
                            };
                        });
                        break;

                    case "funnelChart":
                        data = json.values.map( function(d,i){
                            return {
                                "key": (d.label[0] !== '')?d.label[0]:'',
                                "values": [{ "series": i, "x": 0, "y": (parseInt(d.values[0],10) || 0), y0: 0 }]
                            };
                        });
                        break;


                    case "lineChart":
                        data = json.values.map( function(d,i){
                            return {
                                "key": (d.label !== '')?d.label:'',
                                "values": d.values.map( function(e,j) {
                                    return [j, parseInt(e,10)];
                                })
                            };
                        });
                        break;
                }
            }

            return {
                "properties":{
                    "title": json.properties[0].title,
                    // bar group data (x-axis)
                    "labels": (!json.values.filter(function(d) { return d.values.length; }).length) ? []
                        : json.values.map( function(d,i) {
                        return {
                            "group": i+1,
                            "l": (d.label !== '')?d.label:''
                        };
                    }),
                    "values": (!json.values.filter(function(d) { return d.values.length; }).length) ? []
                        : json.values.map( function(d,i) {
                        return {
                            "group": i+1,
                            "t": d.values.reduce( function(p, c, i, a) {
                                return parseInt(p,10) + parseInt(c,10);
                            })
                        };
                    })
                },
                // series data
                "data": data
            };
        },

        translateParetoDataToD3 : function( json, params ) {
            return {
                'properties':{
                    'title': json.properties[0].title,
                    'quota': parseInt(json.values[0].goalmarkervalue[0],10),
                    // bar group data (x-axis)
                    'groupData': (!json.values.filter(function(d) { return d.values.length; }).length) ? []
                        : json.values.map( function(d,i){
                        return {
                            'group': i,
                            'l': json.values[i].label,
                            't': json.values[i].values.reduce( function(p, c, i, a){
                                return parseInt(p,10) + parseInt(c,10);
                            })
                        };
                    })
                },
                // series data
                'data': (!json.values.filter(function(d) { return d.values.length; }).length) ? [] :
                    json.label.map( function(d,i){
                        return {
                            'key': d,
                            'type': 'bar',
                            'series': i,
                            'values': json.values.map( function(e,j){
                                return { 'series': i, 'x': j+1, 'y': parseInt(e.values[i],10), y0: 0 };
                            }),
                            'valuesOrig': json.values.map( function(e,j){
                                return { 'series': i, 'x': j+1, 'y': parseInt(e.values[i],10), y0: 0 };
                            })
                        };
                    }).concat(
                            json.properties[0].goal_marker_label.filter( function(d,i){
                                return d !== 'Quota';
                            }).map( function(d,i){
                                    return {
                                        'key': d,
                                        'type': 'line',
                                        'series': i,
                                        'values': json.values.map( function(e,j){
                                            return { 'series': i, 'x': j+1, 'y': parseInt(e.goalmarkervalue[i+1],10) };
                                        }),
                                        'valuesOrig': json.values.map( function(e,j){
                                            return { 'series': i, 'x': j+1, 'y': parseInt(e.goalmarkervalue[i+1],10) };
                                        })
                                    };
                                })
                        )
            };
        },
        /**
         * Is data returned from the server empty?
         *
         * @param data
         * @return {Boolean}
         */
        isDataEmpty: function(data) {
            if (data !== undefined && data !== "No Data" && data !== "") {
                return true;
            } else {
                return false;
            }
        },

        /**
         * Resize graph on window resize
         *
         * @param chart
         * @param chartId
         * @param json
         */
        trackWindowResize: function(chart, chartId, json) {
            var timeout,
                delay = 500,
                origWindowWidth = document.documentElement.scrollWidth,
                container = document.getElementById(chartId),
                widget = document.getElementById(chartId + "-canvaswidget");

            // refresh graph on window resize
            $(window).resize(function() {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(function() {
                    var newWindowWidth = document.documentElement.scrollWidth;

                    // if window width has changed during resize
                    if (newWindowWidth != origWindowWidth) {
                        // hide widget in order to let it's container have
                        // width corresponding to current window size,
                        // not it's contents
                        widget.style.display = "none";

                        // add one more timeout in order to let all widgets
                        // on the page hide
                        setTimeout(function() {
                            // measure container width
                            var width = container.offsetWidth;
                            var chartWidth = width - 20;
                            $('#legend'+chartId).width(chartWidth);

                            // display widget before resize, otherwise
                            // it will be rendered incorrectly in IE
                            widget.style.display = "";

                            chart.resizeGraph(json, width);
                            origWindowWidth = newWindowWidth;
                        }, 0);
                    }
                }, delay);
            });
        },

        /**
         * Update chart with new data from server
         *
         * @param chart
         * @param url
         * @param params
         * @param callback
         */
        update: function(chart, url, params, callback) {
            var self = this;
            params = params ? params : {};
            self.chart = chart;
            this.get(url, params, function(data) {
                if(self.isDataEmpty(data)){
                    self.chart.busy = false;
                    self.chart.updateJSON(data);
                    self.callback(callback);
                }
            });
        },


        saveImageFile: function (id,jsonfilename,imageExt,saveTo) {
            var parts = jsonfilename.split("/"),
                filename = parts[parts.length - 1].replace(".js","."+imageExt),
                oCanvas = document.getElementById(id),
                strDataURI,
                url;

            if (oCanvas) {
                if (imageExt === "jpg") {
                    strDataURI = oCanvas.toDataURL("image/jpeg");
                } else {
                    strDataURI = oCanvas.toDataURL("image/png");
                }

                if (!saveTo) {
                    url =  "index.php?action=DynamicAction&DynamicAction=saveImage&module=Charts&to_pdf=1";
                } else {
                    url = saveTo;
                }

                jQuery.post(url, {imageStr: strDataURI, filename: filename  })
                    .success(function() {  })
                    .error(function() {  });
            }
        },

        saveImageTest: function (id,jsonfilename,imageExt,saveTo) {
            if (typeof FlashCanvas != "undefined") {
                setTimeout(function(){SUGAR.charts.saveImageFile(id,jsonfilename,imageExt,saveTo);},10000);
            } else {
                SUGAR.charts.saveImageFile(id,jsonfilename,imageExt,saveTo);
            }
        }
    };
})(jQuery);
