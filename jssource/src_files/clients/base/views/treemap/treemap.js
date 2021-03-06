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
        this.treeCollection = app.data.createBeanCollection(this.model.module);
        this.treeCollection.fetch({
            //Don't show alerts for this request
            showAlerts: false
        });
    },

    margin: {top: 20, right: 0, bottom: 0, left: 0},
    width: 0,
    height: 0,
    root: null,

    _render: function() {
        app.view.View.prototype._render.call(this);

        this.width = parseInt(this.$(".opportunities-treemap").width(), 10);
        this.height = parseInt(this.$(".opportunities-treemap" + " svg").css('max-height'), 10);
    },

    renderTree: function() {
        var self = this;

        // Set up variables for d3 treemap.
        // TODO: Fix the following
        var transitioning,
            x = d3.scale.linear()
                .domain([0, this.width])
                .range([0, this.width]),

            y = d3.scale.linear()
                .domain([0, this.height])
                .range([0, this.height]),

            treemap = d3.layout.treemap()
                .children(function(d, depth) {
                    return depth ? null : d.children;
                }).sort(function(a, b) {
                    return a.value - b.value;
                }).round(false),

        // Actually create the DOM elements.
            svg = d3.select(".opportunities-treemap svg")
                .attr("width", this.width + this.margin.left + this.margin.right)
                .attr("height", this.height + this.margin.bottom + this.margin.top)
                .style("margin-left", -this.margin.left + "px")
                .style("margin-right", -this.margin.right + "px")
                .append("g")
                .attr("transform", "translate(" + this.margin.left + "," + this.margin.top + ")")
                .style("shape-rendering", "crispEdges"),

            grandparent = svg.append("g").attr("class", "grandparent"),
            nodes = [];

        if (!this.root) {
            return;
        }

        grandparent.append("rect")
            .attr("y", -this.margin.top)
            .attr("width", this.width)
            .attr("height", this.margin.top);

        grandparent.append("text")
            .attr("x", 6)
            .attr("y", 6 - this.margin.top)
            .attr("dy", '.75em');

        // Initialize the root node.
        function initialize(root) {
            root.x = root.y = 0;
            root.dx = self.width;
            root.dy = self.height;
            root.depth = 0;
        }

        function accumulate(d) {
            nodes.push(d);
            if (d.children) {
                return d.value = d.children.reduce(function(p, v) {
                    return p + accumulate(v);
                }, 0);
            }
            return d.value;
        }

        function layout(d) {
            if (d.children) {
                treemap.nodes({children: d.children});
                d.children.forEach(function(c) {
                    c.x = d.x + c.x * d.dx;
                    c.y = d.y + c.y * d.dy;
                    c.dx *= d.dx;
                    c.dy *= d.dy;
                    c.parent = d;
                    layout(c);
                });
            }
        }

        function display(d) {
            grandparent.datum(d.parent).on("click", transition).select("text").text(name(d));
            var g1 = svg.insert("g", ".grandparent").datum(d).attr("class", "depth");
            var g = g1.selectAll("g").data(d.children).enter().append("g");

            // Transition for nodes with children.
            g.filter(function(d) {
                return d.children;
            }).classed("children", true).on("click", transition);

            // Navigate for nodes without children (leaves).
            g.filter(function(d) {
                return !(d.children);
            }).on("click", navigate);

            var child_rects = g.selectAll(".child").data(function(d) {
                return d.children || [d];
            }).enter().append("rect").attr("class", "child").call(rect);

            var parent_rect = g.append("rect").attr("class", "parent").call(rect)
                .append("text").text(function(d) {
                    return d.name;
                });

            var label = g.append("text").attr("dy", ".75em").text(function(d) {
                return d.name;
            }).call(text);

            function navigate(d) {
                var model = app.data.createBean(self.module);
                model.set("id", d.id);
                model.fetch();
                app.navigate(self.context, model);
            }

            function transition(d) {
                if (transitioning || !d) return;
                transitioning = true;

                var g2 = display(d),
                    t1 = g1.transition().duration(750),
                    t2 = g2.transition().duration(750);

                // Update the domain only after entering new elements.
                x.domain([d.x, d.x + d.dx]);
                y.domain([d.y, d.y + d.dy]);

                // Enable anti-aliasing during the transition.
                svg.style("shape-rendering", null);

                // Draw child nodes on top of parent nodes.
                svg.selectAll(".depth").sort(function(a, b) {
                    return a.depth - b.depth;
                });

                // Fade-in entering text.
                g2.selectAll("text").style("fill-opacity", 0);

                // Transition to the new view.
                t1.selectAll("text").call(text).style("fill-opacity", 0);
                t2.selectAll("text").call(text).style("fill-opacity", 1);
                t1.selectAll("rect").call(rect);
                t2.selectAll("rect").call(rect);

                // Remove the old node when the transition is finished.
                t1.remove().each("end", function() {
                    svg.style("shape-rendering", "crispEdges");
                    transitioning = false;
                });
            }

            return g;
        }

        function text(t) {
            t.attr("x", function(d) {
                return x(d.x) + 6;
            })
                .attr("y", function(d) {
                    return y(d.y) + 6;
                });
        }

        function rect(r) {
            r.attr("x", function(d) {
                return x(d.x);
            })
                .attr("y", function(d) {
                    return y(d.y);
                })
                .attr("width", function(d) {
                    return x(d.x + d.dx) - x(d.x);
                })
                .attr("height", function(d) {
                    return y(d.y + d.dy) - y(d.y);
                })
                .attr("class", function(d) {
                    if (d3.select(this).classed(d.className)) {
                        return d3.select(this).attr('class');
                    }
                    return d3.select(this).attr('class') + " " + d.className;
                });
        }

        function name(d) {
            if (d.parent) {
                return name(d.parent) + " / " + d.name;
            }
            return d.name;
        }

        initialize(this.root);
        accumulate(this.root);
        layout(this.root);
        display(this.root);
    },

    processData: function() {
        var day_ms = 1000 * 60 * 60 * 24,
            today = new Date(),
            d1 = new Date(today.getTime() + 31 * day_ms),
            data;

        today.setUTCHours(0, 0, 0, 0);

        if (this.treeCollection) {
            data = this.treeCollection.filter(function(model) {
                // Filter for 30 days from now.
                var d2 = new Date(model.get("date_closed") || "1970-01-01");
                return (d2 - d1) / day_ms <= 30;
            });

            data = _.groupBy(data, function(m) {
                return m.get("assigned_user_name");
            });

            _.each(data, function(value, key, list) {
                list[key] = _.groupBy(value, function(m) {
                    return m.get("sales_stage");
                });
            });
        }

        // Massage the values to what we want.
        // TODO: Make this more efficient.
        this.root = {
            name: "Opportunities",
            children: []
        };

        _.each(data, function(value1, key1) {
            var child = [];
            _.each(value1, function(value2, key2) {
                _.each(value2, function(record) {
                    record.className = 'stage_' + record.get("sales_stage").toLowerCase().replace(' ', '');
                    record.value = parseInt(record.get("amount_usdollar"), 10);
                    record.name = record.get("name");
                });
                child.push({
                    name: key2,
                    className: 'stage_' + key2.toLowerCase().replace(' ', ''),
                    children: value2
                });
            });

            this.root.children.push({
                name: key1,
                children: child
            }, this);
        }, this);

        this.renderTree();
    },

    bindDataChange: function() {
        this.treeCollection.on("reset", this.processData, this);
    },

    unbindData: function() {
        this.treeCollection.off();
        this.treeCollection = null;
        app.view.View.prototype.unbindData.call(this);
    }
})
