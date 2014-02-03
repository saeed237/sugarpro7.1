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
 * View that displays a list of models pulled from the context's collection.
 * @class View.Views.TreeView
 * @alias SUGAR.App.layout.TreeView
 * @extends View.View
 */
({
    events: {
        'click .zoom-control': 'zoomChart',
        'click .toggle-control': 'toggleChart'
    },

    results: {},
    plugins: ['Dashlet', 'Tooltip'],

    // user configurable
    nodetemplate: {},
    reporteesEndpoint: '',
    currentRootId: '',
    zoomExtents: {},
    nodeSize: {},

    // private
    treeData: {},
    jsTree: {},
    slider: {},
    sliderZoomIn: {},
    sliderZoomOut: {},
    chart: {},
    viewName: '',

    /**
     * Initialize the View
     *
     * @constructor
     * @param {Object} options
     */
    initialize: function (options) {
        app.view.View.prototype.initialize.call(this, options);

        // custom renderer for node
        this.nodetemplate = app.template.getView(this.name + '.orgchartnode');

        //TODO: change api to accept id as param or attrib as object to produce
        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'reportees/' + app.user.get('id'), null, {'level': 2});

        this.currentRootId = app.user.get('id');
        this.zoomExtents = { 'min': 0.25, 'max': 2 };
        this.nodeSize = { 'width': 124, 'height': 56 };
    },

    /**
     * store current view state of dashlet
     */
    initDashlet: function (viewName) {
        this.viewName = viewName;
    },

    /**
     * overriding _dispose to make sure custom added event listeners are removed
     * @private
     */
    _dispose: function () {

        if (!_.isEmpty(this.jsTree)) {
            this.jsTree.off();
        }
        if (!_.isEmpty(this.slider)) {
            this.slider.off('move');
        }
        if (!_.isEmpty(this.chart)) {
            nv.utils.windowUnResize(this.chart.resize);
            nv.utils.unResizeOnPrint(this.chart.resize);
        }

        app.view.View.prototype._dispose.call(this);
    },

    /**
     * Returns a url to a user record
     * @param {String} id the User record id.
     * @protected
     */
    _buildUserUrl: function(id) {
        return '#' + app.router.buildRoute('Users', id);
    },

    /**
     * Renders JSTree
     * @param ctx
     * @param options
     * @protected
     */
    _renderHtml: function () {
        if (this.viewName !== "config" && nv && nv.models) {
            var self = this,
                chart = nv.models.tree()
                    .duration(300)
                    .nodeSize(this.nodeSize)
                    .nodeRenderer(function (d) {
                        return self.nodetemplate(d.metadata);
                    })
                    .zoomExtents(this.zoomExtents)
                    .horizontal(false)
                    .getId(function (d) {
                        return d.metadata.id;
                    });


            app.view.View.prototype._renderHtml.call(this);

            // chart controls
            this.slider = this.$('.btn-slider .noUiSlider');
            this.sliderZoomIn = this.$('.btn-slider i[data-control="zoom-in"]');
            this.sliderZoomOut = this.$('.btn-slider i[data-control="zoom-out"]');


            if (!_.isEmpty(this.treeData)) {

                //jsTree control for selecting root node
                this.jsTree = this.$('div[data-control="org-jstree"]').jstree({
                    // generating tree from json data
                    'json_data': {
                        'data': this.treeData
                    },
                    // plugins used for this tree
                    'plugins': [ 'json_data', 'ui', 'types' ],
                    'core': {
                        'animation': 0
                    },
                    'ui': {
                        // when the tree re-renders, initially select the root node
                        'initially_select': [ 'jstree_node_' + app.user.get("user_name") ]
                    }
                })
                    .on('loaded.jstree', function (e) {
                        // do stuff when tree is loaded
                        self.$('div[data-control="org-jstree"]').addClass('jstree-sugar');
                        self.$('div[data-control="org-jstree"] > ul').addClass('list');
                        self.$('div[data-control="org-jstree"] > ul > li > a').addClass('jstree-clicked');
                    })
                    .on('click.jstree', function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                    })
                    .on('select_node.jstree', function (event, data) {
                        var jsData = data.inst.get_json();

                        chart.filter(jQuery.data(data.rslt.obj[0], 'id'));
                        self.$('div[data-control="org-jstree-dropdown"] .jstree-label').text(data.inst.get_text());
                        data.inst.toggle_node(data.rslt.obj);
                    });


                d3.select('svg#' + this.cid)
                    .datum(this.treeData[0])
                    .transition().duration(700)
                    .call(chart);


                //slider
                this.slider.noUiSlider('init', {
                    start: 100,
                    knobs: 1,
                    scale: [25, 200],
                    connect: false,
                    step: 25,
                    change: function () {
                        var values = self.slider.noUiSlider('value'),
                            scale = chart.zoomLevel(values[0] / 100);
                        self.sliderZoomIn.toggleClass('disabled', (scale === self.zoomExtents.max));
                        self.sliderZoomOut.toggleClass('disabled', (scale === self.zoomExtents.min));
                    }
                });

                self.chart = chart;
                nv.utils.windowResize(self.chart.resize);
                nv.utils.resizeOnPrint(self.chart.resize);

                _.debounce(function () {
                    if (self.disposed) {
                        return;
                    }
                    self.chart.reset();
                }, 3000);
            }
        }
    },


    /**
     * Recursively step through the tree and for each node representing a tree node, run the data attribute through
     * the _postProcessTree function.  This function supports n-levels of the tree hierarchy.
     *
     * @param data The data structure returned from the REST API Forecasts/reportees endpoint
     * @param ctx A reference to the view's context so that we may recursively call _postProcessTree
     * @return The modified data structure after all the parent and children nodes have been stepped through
     * @private
     */
    _postProcessTree: function (data, ctx) {
        var adopt = [],
            newChild = {};

        _.each(data, function (entry, index) {

            //Scan for the nodes with the data attribute.  These are the nodes we are interested in
            if (!entry.data) {
                return;
            }

            data[index].data = (function (value) {
                return value.replace(/&amp;/gi, '&').replace(/&#039;/gi, '\'').replace(/&quot;/gi, '"');
            })(entry.data);

            data[index].metadata.url = ctx._buildUserUrl(entry.metadata.id);

            data[index].metadata.img = app.api.buildFileURL({
                module: "Users",
                id: entry.metadata.id,
                field: "picture"
            });

            if (!entry.children) {
                return;
            }

            adopt = [];

            //For each children found (if any) then call _postProcessTree again.  Notice setting
            //childEntry to an Array.  This is crucial so that the beginning _.each loop runs correctly.
            _.each(entry.children, function (childEntry, index2) {
                if (entry.metadata.id !== childEntry.metadata.id) {

                    newChild = ctx._postProcessTree([childEntry], ctx);

                    if (!_.isEmpty(newChild)) {
                        adopt.push(newChild[0]);
                    }
                }
            }, this);

            data[index].children = adopt;

        }, this);

        return data;
    },

    zoomChart: function (e) {
        var button = $(e.target),
            scale = this.chart.zoom(button.data('control') === 'zoom-in' ? 0.25 : -0.25);

        this.sliderZoomIn.toggleClass('disabled', (scale === this.zoomExtents.max));
        this.sliderZoomOut.toggleClass('disabled', (scale === this.zoomExtents.min));

        this.slider.noUiSlider('move', {to: scale * 100});
    },

    toggleChart: function (e) {
        //if icon clicked get parent button
        var button = $(e.currentTarget).hasClass('btn') ? $(e.currentTarget) : $(e.currentTarget).parent('.btn');

        switch (button.data('control')) {
            case 'orientation':
                this.chart.orientation();
                button.find('i').toggleClass('icon-arrow-right icon-arrow-down');
                break;

            case 'show-all-nodes':
                this.chart.showall();
                break;

            case 'zoom-to-fit':
                this.chart.reset();
                this.slider.noUiSlider('move', {to: 100});
                break;

            default:
        }
    },

    loadData: function (options) {
        var self = this;

        app.api.call('get', this.reporteesEndpoint, null, {
            success: function (data) {
                self.treeData = self._postProcessTree([data], self);
                self.treeData.ctx = self.context;
                if (!self.disposed) {
                    self.render();
                }
            },
            complete: options ? options.complete : null
        });
    }

})
