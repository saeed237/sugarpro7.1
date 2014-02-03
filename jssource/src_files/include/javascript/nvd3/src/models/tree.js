
nv.models.tree = function() {

  // issues: 1. zoom slider doesn't zoom on chart center
  // orientation
  // bottom circles

  // all hail, stepheneb
  // https://gist.github.com/1182434
  // http://mbostock.github.com/d3/talk/20111018/tree.html
  // https://groups.google.com/forum/#!topic/d3-js/-qUd_jcyGTw/discussion
  // http://ajaxian.com/archives/foreignobject-hey-youve-got-html-in-my-svg

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  // specific to org chart
  var r = 5.5
    , padding = { 'top': 10, 'right': 10, 'bottom': 10, 'left': 10 } // this is the distance from the edges of the svg to the chart
    , duration = 300
    , zoomExtents = { 'min': 0.25, 'max': 2 }
    , nodeSize = { 'width': 100, 'height': 50 }
    , nodeImgPath = '../img/'
    , nodeRenderer = function(d) { return '<div class="nv-tree-node"></div>'; }
    , horizontal = false
  ;

  var id = Math.floor( Math.random() * 10000 ) //Create semi-unique ID in case user doesn't select one
    , color = nv.utils.defaultColor()
    , fill = function(d,i) { return color(d,i); }
    , gradient = function(d,i) { return color(d,i); }

    , setX = function(d,v) { d.x = v; }
    , setY = function(d,v) { d.y = v; }
    , setX0 = function(d,v) { if (horizontal) { d.y0 = v; } else { d.x0 = v; } }
    , setY0 = function(d,v) { if (horizontal) { d.x0 = v; } else { d.y0 = v; } }

    , getX = function(d) { return (horizontal?d.y:d.x); }
    , getY = function(d) { return (horizontal?d.x:d.y); }
    , getX0 = function(d) { return (horizontal?d.y0:d.x0); }
    , getY0 = function(d) { return (horizontal?d.x0:d.y0); }

    , getId = function(d) { return d.id; }

    , fillGradient = function(d,i) {
        return nv.utils.colorRadialGradient( d, i, 0, 0, '35%', '35%', color(d,i), wrap.select('defs') );
      }
    , useClass = false
    , valueFormat = d3.format(',.2f')
    , showLabels = true
    , dispatch = d3.dispatch( 'chartClick', 'elementClick', 'elementDblClick', 'elementMouseover', 'elementMouseout' )
  ;

  //============================================================

  function chart(selection)
  {
    selection.each(function(data) {

      var diagonal = d3.svg.diagonal()
            .projection(function(d) {
              return [getX(d), getY(d)];
            });
      var zoom = d3.behavior.zoom().scaleExtent([zoomExtents.min, zoomExtents.max])
            .on('zoom', function() {
              gEnter.attr('transform', 'translate('+ d3.event.translate +')scale('+ d3.event.scale +')' );
            });
      //------------------------------------------------------------
      // Setup svgs and skeleton of chart

      var svg = d3.select(this);
      var wrap = svg.selectAll('.nv-wrap').data([1]);
      var wrapEnter = wrap.enter().append('g')
            .attr('class', 'nvd3 nv-wrap')
            .attr('id', 'nv-chart-' + id)
            .call( zoom );

      var defsEnter = wrapEnter.append('defs');

      var backg = wrapEnter.append('svg:rect')
            .attr('id', 'backg')
            .attr('transform', 'translate('+ padding.left +','+ padding.top +')')
            .style('fill', 'transparent');

      var gEnter = wrapEnter.append('g');

      var treeChart = gEnter.append('g')
            .attr('class', 'nv-tree')
            .attr('id', 'vis');

      // Compute the new tree layout.
      var tree = d3.layout.tree()
            .size(null)
            .elementsize([(horizontal ? nodeSize.height : nodeSize.width),1])
            .separation( function separation(a,b) { return a.parent == b.parent ? 1 : 1; });

      var svgSize = { // the size of the svg container
          'width': parseInt(svg.style('width'), 10)
        , 'height': parseInt(svg.style('height'), 10)
      };

      data.x0 = data.x0 || 0;
      data.y0 = data.y0 || 0;

      var _data = data;

      chart.showall = function() {
        function expandAll(d) {
          if ( (d.children && d.children.length) || (d._children && d._children.length) ) {
            if (d._children && d._children.length) {
              d.children = d._children;
              d._children = null;
            }
            d.children.forEach(expandAll);
          }
        }
        expandAll(_data);
        zoom.translate([0, 0]).scale(1);
        gEnter.attr('transform', 'translate('+ [0,0] +')scale('+ 1 +')');
        chart.update(_data);
      };

      chart.resize = function() {
        svgSize = {
            'width': parseInt(svg.style('width'), 10 )
          , 'height': parseInt(svg.style('height'), 10 )
        };
        chart.reset();
        chart.update(_data);
      };

      chart.orientation = function(orientation) {
        horizontal = (orientation === 'horizontal' || !horizontal ? true : false);
        chart.reset();
        chart.update(_data);
      };

      chart.reset = function() {
        zoom.translate([0, 0]).scale(1);
        gEnter.attr('transform', 'translate('+ [0,0] +')scale('+ 1 +')');
      };

      chart.zoom = function(step) {
        var limit = (step>0 ? zoomExtents.max : zoomExtents.min)
          , scale = Math.min( Math.max( zoom.scale() + step, zoomExtents.min), zoomExtents.max);
        if (scale !== limit) {
          zoom.translate([0, 0]).scale(scale);
          gEnter.attr('transform', 'translate('+ [0,0] +')scale('+ scale +')');
        }
        return scale;
      };

      chart.zoomLevel = function(level) {
        var scale = Math.min( Math.max( level, zoomExtents.min), zoomExtents.max);
        zoom.translate([0, 0]).scale(scale);
        gEnter.attr('transform', 'translate('+ [0,0] +')scale('+ scale +')');
        return scale;
      };

      chart.filter = function(node) {
        var __data = {}
          , found = false;

        function findNode(d) {
          if (getId(d) === node) {
            __data = d;
            found = true;
          } else if (!found && d.children) {
            d.children.forEach(findNode);
          }
        }

        // Initialize the display to show a few nodes.
        findNode(data);

        __data.x0 = 0;
        __data.y0 = 0;

        _data = __data;

        chart.update(_data);
      };

      chart.update = function(source) {

        // Click tree node.
        function leafClick(d) {
          toggle(d);
          chart.update(d);
        }

        // Toggle children.
        function toggle(d) {
          if (d.children) {
            d._children = d.children;
            d.children = null;
          } else {
            d.children = d._children;
            d._children = null;
          }
        }

        var nodes = tree.nodes(_data);
        var root = nodes[0];

        var availableSize = { // the size of the svg container minus padding
            'width': svgSize.width - padding.left - padding.right
          , 'height': svgSize.height - padding.top  - padding.bottom
        };

        var chartSize = { // the size of the chart itself
            'width': d3.min(nodes, getX) + d3.max(nodes, getX )
          , 'height': d3.min(nodes, getY) + d3.max(nodes, getY)
        };

        if (horizontal) {
          chartSize.width = (chartSize.width * nodeSize.width*2) + nodeSize.width;
        } else {
          chartSize.height = (chartSize.height * nodeSize.height*2) + nodeSize.height;
        }

        // initial chart scale to fit chart in container
        var scale = d3.min([ availableSize.width/chartSize.width, availableSize.height/chartSize.height ]);

        // initial chart translation to position chart in the center of container
        var center = (availableSize.width/chartSize.width < availableSize.height/chartSize.height) ?
                [ 0, ((availableSize.height/scale)-chartSize.height)/2 ]
              :
                [ ((availableSize.width/scale)-chartSize.width)/2, 0 ]
              ;

        // this is needed because the origin of a node is at the bottom
        var offset = {
            'top': (horizontal ? padding.top/2 : nodeSize.height)
          , 'left': (horizontal ? nodeSize.width : padding.left/2)
        };

        backg
          .attr('width', availableSize.width)
          .attr('height', availableSize.height);

        treeChart.attr('transform', 'translate('+ [
            (offset.left + center[0]) * scale,
            (offset.top + center[1]) * scale
          ] +')scale('+ scale +')');

        nodes.forEach(function(d) {
          setY(d, d.depth * (horizontal ? 2 * nodeSize.width : 2 * nodeSize.height) );
        });

        // Update the nodes…
        var node = treeChart.selectAll('g.nv-card')
              .data(nodes, getId);

        // Enter any new nodes at the parent's previous position.
        var nodeEnter = node.enter().append('svg:g')
              .attr('class', 'nv-card')
              .attr('id', function(d) { return 'nv-card-'+ getId(d); })
              .attr("transform", function(d) {
                if (getY(source) === 0) {
                  return "translate(" + getX(root) + "," + getY(root) + ")";
                } else {
                  return "translate(" + getX0(source) + "," + getY0(source) + ")";
                }
              })
              .on('click', leafClick);

        // node content
        nodeEnter.append("foreignObject").attr('class', 'nv-foreign-object')
            .attr("width", 1)
            .attr("height", 1)
            .attr("x", -1)
            .attr("y", -1)
          .append("xhtml:body")
            .style("font", "14px 'Helvetica Neue'")
            .html(nodeRenderer);

        // node circle
        var xcCircle = nodeEnter.append('svg:g').attr('class', 'nv-expcoll')
              .style('opacity', 1e-6);
            xcCircle.append('svg:circle').attr('class', 'nv-circ-back')
              .attr('r', r);
            xcCircle.append('svg:line').attr('class', 'nv-line-vert')
              .attr('x1', 0).attr('y1', 0.5-r).attr('x2', 0).attr('y2', r-0.5)
              .style('stroke', '#bbb');
            xcCircle.append('svg:line').attr('class', 'nv-line-hrzn')
              .attr('x1', 0.5-r).attr('y1', 0).attr('x2', r-0.5).attr('y2', 0)
              .style('stroke', '#fff');

        //Transition nodes to their new position.
        var nodeUpdate = node.transition()
              .duration(duration)
              .attr('transform', function(d) { return 'translate('+ getX(d) +','+ getY(d) +')'; });

            nodeUpdate.select('.nv-expcoll')
              .style('opacity', function(d) { return ( (d.children && d.children.length) || (d._children && d._children.length) ) ? 1 : 0; });
            nodeUpdate.select('.nv-circ-back')
              .style('fill', function(d) { return (d._children && d._children.length) ? '#777' : (d.children?'#bbb':'none'); });
            nodeUpdate.select('.nv-line-vert')
              .style('stroke', function(d) { return (d._children && d._children.length) ? '#fff' : '#bbb'; });

            nodeUpdate.selectAll('.nv-foreign-object')
              .attr("width", nodeSize.width)
              .attr("height", nodeSize.height)
              .attr("x", (horizontal ? -nodeSize.width+r : -nodeSize.width/2) )
              .attr("y", (horizontal ? -nodeSize.height/2+r : -nodeSize.height+r*2) );

        // Transition exiting nodes to the parent's new position.
        var nodeExit = node.exit().transition()
              .duration(duration)
              .attr('transform', function(d) { return "translate(" + getX(source) + "," + getY(source) + ")"; })
              .remove();
            nodeExit.selectAll('.nv-expcoll')
              .style('stroke-opacity', 1e-6);

            nodeExit.selectAll('.nv-foreign-object')
              .attr("width", 1)
              .attr("height", 1)
              .attr("x", -1)
              .attr("y", -1);

        // Update the links
        var link = treeChart.selectAll('path.link')
              .data(tree.links(nodes), function(d) { return getId(d.source) + '-' + getId(d.target); });

            // Enter any new links at the parent's previous position.
            link.enter().insert('svg:path', 'g')
              .attr('class', 'link')
              .attr('d', function(d) {
                var o = ( getY(source) === 0 ) ? { x: source.x, y: source.y } : { x: source.x0, y: source.y0 };
                return diagonal({ source: o, target: o });
              });

            // Transition links to their new position.
            link.transition()
              .duration(duration)
              .attr('d', diagonal);

            // Transition exiting nodes to the parent's new position.
            link.exit().transition()
              .duration(duration)
              .attr('d', function(d) {
                var o = { x: source.x, y: source.y };
                return diagonal({ source: o, target: o });
              })
              .remove();

        // Stash the old positions for transition.
        nodes
          .forEach(function(d) {
            setX0(d, getX(d));
            setY0(d, getY(d));
          });

      };

      chart.gradient( fillGradient );
      chart.update(_data);

    });

    return chart;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  chart.dispatch = dispatch;

  chart.color = function(_) {
    if (!arguments.length) return color;
    color = _;
    return chart;
  };
  chart.fill = function(_) {
    if (!arguments.length) return fill;
    fill = _;
    return chart;
  };
  chart.gradient = function(_) {
    if (!arguments.length) return gradient;
    gradient = _;
    return chart;
  };
  chart.useClass = function(_) {
    if (!arguments.length) return useClass;
    useClass = _;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.values = function(_) {
    if (!arguments.length) return getValues;
    getValues = _;
    return chart;
  };

  chart.x = function(_) {
    if (!arguments.length) return getX;
    getX = _;
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) return getY;
    getY = d3.functor(_);
    return chart;
  };

  chart.showLabels = function(_) {
    if (!arguments.length) return showLabels;
    showLabels = _;
    return chart;
  };

  chart.id = function(_) {
    if (!arguments.length) return id;
    id = _;
    return chart;
  };

  chart.valueFormat = function(_) {
    if (!arguments.length) return valueFormat;
    valueFormat = _;
    return chart;
  };

  chart.labelThreshold = function(_) {
    if (!arguments.length) return labelThreshold;
    labelThreshold = _;
    return chart;
  };

  // ORG

  chart.radius = function(_) {
    if (!arguments.length) return r;
    r = _;
    return chart;
  };

  chart.duration = function(_) {
    if (!arguments.length) return duration;
    duration = _;
    return chart;
  };

  chart.zoomExtents = function(_) {
    if (!arguments.length) return zoomExtents;
    zoomExtents = _;
    return chart;
  };

  chart.padding = function(_) {
    if (!arguments.length) return padding;
    padding = _;
    return chart;
  };

  chart.nodeSize = function(_) {
    if (!arguments.length) return nodeSize;
    nodeSize = _;
    return chart;
  };

  chart.nodeImgPath = function(_) {
    if (!arguments.length) return nodeImgPath;
    nodeImgPath = _;
    return chart;
  };

  chart.nodeRenderer = function(_) {
    if (!arguments.length) return nodeRenderer;
    nodeRenderer = _;
    return chart;
  };

  chart.horizontal = function(_) {
    if (!arguments.length) return horizontal;
    horizontal = _;
    return chart;
  };

  chart.getId = function(_) {
    if (!arguments.length) return getId;
    getId = _;
    return chart;
  };
  //============================================================

  return chart;
};
