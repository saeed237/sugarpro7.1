nv.models.pieChart = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var pie = nv.models.pie()
    , legend = nv.models.legend()
    ;

  var margin = {top: 30, right: 20, bottom: 20, left: 20}
    , width = null
    , height = null
    , showLegend = true
    , showTitle = false
    , hole = false
    , tooltip = null
    , tooltips = true
    , tooltipContent = function(key, y, e, graph) {
        return '<h3>' + key + '</h3>' +
               '<p>' +  y + '</p>';
      }
    , state = {}
    , noData = "No Data Available."
    , dispatch = d3.dispatch('tooltipShow', 'tooltipHide', 'tooltipMove', 'stateChange', 'changeState')
    ;

  //============================================================


  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var showTooltip = function(e, offsetElement, total) {

    var left = e.pos[0]
      , top = e.pos[1]
      , x = (pie.y()(e.point) * 100 / total).toFixed(1)
      , y = pie.valueFormat()( pie.y()(e.point) )
      , content = tooltipContent( e.point.key, x, y, e, chart )
      //content = tooltip(pie.x()(e.point), y, e, chart);
    ;

    //nv.tooltip.show([left, top], content, e.value < 0 ? 'n' : 's', null, offsetElement);
    tooltip = nv.tooltip.show([left, top], content, null, null, offsetElement);
  };

  //============================================================


  function chart(selection) {
    selection.each(function(chartData) {

      var properties = chartData.properties
        , data = chartData.data;

      var container = d3.select(this),
          that = this;

      var availableWidth = (width || parseInt(container.style('width'), 10) || 960) - margin.left - margin.right
        , availableHeight = (height || parseInt(container.style('height'), 10) || 400) - margin.top - margin.bottom
        , total = d3.sum( data.map( function(d) { return d.value; }) )
      ;

      chart.update = function() { container.transition().duration(300).call(chart); };
      chart.container = this;

      //set state.disabled
      state.disabled = data.map(function(d) { return !!d.disabled });

      //------------------------------------------------------------
      // Display No Data message if there's nothing to show.

      if (!data || !data.length) {
        var noDataText = container.selectAll('.nv-noData').data([noData]);

        noDataText.enter().append('text')
          .attr('class', 'nvd3 nv-noData')
          .attr('dy', '-.7em')
          .style('text-anchor', 'middle');

        noDataText
          .attr('x', margin.left + availableWidth / 2)
          .attr('y', margin.top + availableHeight / 2)
          .text(function(d) { return d; });

        return chart;
      } else {
        container.selectAll('.nv-noData').remove();
      }

      //------------------------------------------------------------


      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = container.selectAll('g.nv-wrap.nv-pieChart').data([data]);
      var gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-pieChart').append('g');
      var g = wrap.select('g');

      gEnter.append('g').attr('class', 'nv-pieWrap');

      //------------------------------------------------------------
      // Title & Legend

      var titleHeight = 0
        , legendHeight = 0;

      if (showLegend) {
        gEnter.append('g').attr('class', 'nv-legendWrap');

        legend
          .width(availableWidth)
          .key(pie.x());

        wrap.select('.nv-legendWrap')
            .datum(data)
            .call(legend);

        legendHeight = legend.height() + 10;

        if (margin.top !== legendHeight + titleHeight) {
          margin.top = legendHeight + titleHeight;
          availableHeight = (height || parseInt(container.style('height'), 10) || 400) - margin.top - margin.bottom;
        }

        wrap.select('.nv-legendWrap')
            .attr('transform', 'translate(0,' + (-margin.top) +')');
      }

      if (showTitle && properties.title) {
        gEnter.append('g').attr('class', 'nv-titleWrap');

        g.select('.nv-title').remove();

        g.select('.nv-titleWrap')
          .append('text')
            .attr('class', 'nv-title')
            .attr('x', 0)
            .attr('y', 0 )
            .attr('text-anchor', 'start')
            .text(properties.title)
            .attr('stroke', 'none')
            .attr('fill', 'black')
          ;

        titleHeight = parseInt(g.select('.nv-title').node().getBBox().height, 10) +
          parseInt(g.select('.nv-title').style('margin-top'), 10) +
          parseInt(g.select('.nv-title').style('margin-bottom'), 10);

        if (margin.top !== titleHeight + legendHeight) {
          margin.top = titleHeight + legendHeight;
          availableHeight = (height || parseInt(container.style('height'), 10) || 400) - margin.top - margin.bottom;
        }

        g.select('.nv-titleWrap')
            .attr('transform', 'translate(0,'+ ( -margin.top+parseInt(g.select('.nv-title').node().getBBox().height, 10) ) +')');
      }

      //------------------------------------------------------------


      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');


      //------------------------------------------------------------
      // Main Chart Component(s)

      pie
        .width(availableWidth)
        .height(availableHeight);


      var pieWrap = g.select('.nv-pieWrap')
          .datum(data);

      pieWrap.transition().call(pie);

      wrap.selectAll('.nv-pie-hole').remove();

      if (hole) {
          var pieHole = wrap.append('g').append('text')
            .text(hole)
              .attr('text-anchor', 'middle')
              .attr('class','nv-pie-hole')
              .attr('transform', 'translate('+ availableWidth/2 +','+ (12+availableHeight/2) +')')
              .attr('fill', '#333');
      }
      //------------------------------------------------------------


      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function(d,i, that) {
        d.disabled = !d.disabled;

        if (!pie.values()(data).filter(function(d) { return !d.disabled; }).length) {
          pie.values()(data).map(function(d) {
            d.disabled = false;
            wrap.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = data.map(function(d) { return !!d.disabled });
        dispatch.stateChange(state);

        container.transition().duration(300).call(chart);
      });

      dispatch.on('tooltipShow', function(e) {
        if (tooltips) {
          showTooltip(e, that.parentNode, total);
        }
      });

      // pie.dispatch.on('elementMouseout.tooltip', function(e) {
      //   dispatch.tooltipHide(e);
      // });

      // Update chart from a state object passed to event handler
      dispatch.on('changeState', function(e) {

        if (typeof e.disabled !== 'undefined') {
          data.forEach(function(series,i) {
            series.disabled = e.disabled[i];
          });

          state.disabled = e.disabled;
        }

        container.transition().duration(300).call(chart);
      });

      //============================================================


    });

    return chart;
  }

  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  pie.dispatch.on('elementMouseover.tooltip', function(e) {
    e.pos = [e.pos[0] +  margin.left, e.pos[1] + margin.top];
    dispatch.tooltipShow(e);
  });

  pie.dispatch.on('elementMouseout.tooltip', function(e) {
    dispatch.tooltipHide(e);
  });
  dispatch.on('tooltipHide', function() {
    if (tooltips) nv.tooltip.cleanup();
  });

  pie.dispatch.on('elementMousemove', function(e) {
    dispatch.tooltipMove(e);
  });
  dispatch.on('tooltipMove', function(e) {
    if (tooltip) {
      nv.tooltip.position(tooltip,e.pos);
    }
  });

  //============================================================


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.legend = legend;
  chart.dispatch = dispatch;
  chart.pie = pie;

  d3.rebind(chart, pie, 'valueFormat', 'values', 'x', 'y', 'description', 'id', 'showLabels', 'donutLabelsOutside', 'pieLabelsOutside', 'donut', 'donutRatio', 'labelThreshold', 'color', 'fill', 'classes', 'gradient');

  chart.colorData = function (_) {
    var colors = function (d,i) { return nv.utils.defaultColor()(d,i); },
        classes = function (d,i) { return 'nv-slice nv-series-' + i; },
        type = arguments[0],
        params = arguments[1] || {};

    switch (type) {
      case 'graduated':
        var c1 = params.c1
          , c2 = params.c2
          , l = params.l;
        colors = function (d,i) { return d3.interpolateHsl( d3.rgb(c1), d3.rgb(c2) )(i/l); };
        break;
      case 'class':
        colors = function () { return 'inherit'; };
        classes = function (d,i) {
          var iClass = (i*(params.step || 1))%20;
          return 'nv-slice nv-series-'+ i +' '+ ( d.classes || 'nv-fill' + (iClass>9?'':'0') + iClass );
        };
        break;
    }

    var fill = (!params.gradient) ? colors : function (d,i) {
      return pie.gradient(d,i);
    };

    pie.color(colors);
    pie.fill(fill);
    pie.classes(classes);

    legend.color(colors);
    legend.classes(classes);

    return chart;
  };

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin.top    = typeof _.top    != 'undefined' ? _.top    : margin.top;
    margin.right  = typeof _.right  != 'undefined' ? _.right  : margin.right;
    margin.bottom = typeof _.bottom != 'undefined' ? _.bottom : margin.bottom;
    margin.left   = typeof _.left   != 'undefined' ? _.left   : margin.left;
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

  chart.showTitle = function(_) {
    if (!arguments.length) return showTitle;
    showTitle = _;
    return chart;
  };

  chart.showLegend = function(_) {
    if (!arguments.length) return showLegend;
    showLegend = _;
    return chart;
  };

  chart.tooltips = function(_) {
    if (!arguments.length) return tooltips;
    tooltips = _;
    return chart;
  };

  chart.tooltipContent = function(_) {
    if (!arguments.length) return tooltipContent;
    tooltipContent = _;
    return chart;
  };

  chart.state = function(_) {
    if (!arguments.length) return state;
    state = _;
    return chart;
  };

  chart.noData = function(_) {
    if (!arguments.length) return noData;
    noData = _;
    return chart;
  };

  chart.hole = function(_) {
    if (!arguments.length) return hole;
    hole = _;
    return chart;
  };

  chart.tooltip = function(_) {
    if (!arguments.length) return tooltip;
    tooltip = _;
    return chart;
  };

  chart.colorFill = function(_) {
    return chart;
  };

  //============================================================


  return chart;
};
