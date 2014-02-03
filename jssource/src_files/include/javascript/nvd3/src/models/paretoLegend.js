
nv.models.paretoLegend = function () {
  //'use strict';

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var margin = {top: 0, right: 0, bottom: 0, left: 0}
    , width = 400
    , height = 20
    , getKey = function (d) { return d.key; }
    , dispatch = d3.dispatch('legendClick', 'legendDblclick', 'legendMouseover', 'legendMouseout')
    , color = nv.utils.defaultColor()
    , classes = function (d,i) { return ''; }
    ;

  //============================================================


  function chart(selection) {
    selection.each(function (data) {
      var container = d3.select(this);

      if (!data || !data.length || !data.filter(function (d) { return d.values.length; }).length) {
        return chart;
      } else {
        container.selectAll('g.nv-legend').remove();
      }
      //------------------------------------------------------------
      // Setup containers and skeleton of chart
      var wrap = container.selectAll('g.nv-legend').data([data]);
      var gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-legend').append('g');
      var g = wrap.select('g');

      //------------------------------------------------------------

      var series = g.selectAll('.nv-series')
          .data(function (d) { return d; });
      var seriesEnter = series.enter().append('g').attr('class', 'nv-series')
          .on('mouseover', function (d,i) {
            dispatch.legendMouseover(d,i);  //TODO: Make consistent with other event objects
          })
          .on('mouseout', function (d,i) {
            dispatch.legendMouseout(d,i);
          })
          .on('click', function (d,i) {
            dispatch.legendClick(d,i);
          })
          .on('dblclick', function (d,i) {
            dispatch.legendDblclick(d,i);
          });

      if (data[0].type === 'bar') {
        seriesEnter.append('circle')
            .attr('class', function (d,i) { return this.getAttribute('class') || classes(d,i); })
            .attr('fill', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke-width', 2)
            .attr('r', 5)
            .attr('transform', 'translate(0,-4)');
        seriesEnter.append('text')
          .text(getKey)
          .attr('dy', '1.3em')
          .attr('dx', 0)
          .attr('text-anchor','middle');
      } else {
        seriesEnter.append('circle')
            .attr('class', function (d,i) { return this.getAttribute('class') || classes(d,i); })
            .attr('fill', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke-width', 0)
            .attr('r', function (d,i) { return d.type === 'dash' ? 0 : 5; })
            .attr('transform', 'translate(-15,-4)');
        seriesEnter.append('line')
            .attr('class', function (d,i) { return this.getAttribute('class') || classes(d,i); })
            .attr('stroke', function (d,i) { return this.getAttribute('stroke') || color(d,i); })
            .attr('stroke-width', 3)
            .attr('x0', 0)
            .attr('x1', function (d,i) { return d.type === 'dash' ? 40 : 30; })
            .attr('y0', 0)
            .attr('y1', 0)
            .style('stroke-dasharray', function (d,i) { return d.type === 'dash' ? '8, 8' : '0,0'; } )
            .style('stroke-width','4px')
            .attr('transform', function (d,i) { return d.type === 'dash' ? 'translate(-20,-4)' : 'translate(-15,-4)'; } );
        seriesEnter.append('circle')
            .attr('class', function (d,i) { return this.getAttribute('class') || classes(d,i); })
            .attr('fill', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke', function (d,i) { return this.getAttribute('fill') || color(d,i); })
            .attr('stroke-width', 0)
            .attr('r', function (d,i) { return d.type === 'dash' ? 0 : 5; })
            .attr('transform', 'translate(15,-4)');
        seriesEnter.append('text')
          .text(getKey)
          .attr('dy', '1.3em')
          .attr('dx', 0)
          .attr('text-anchor','middle');
      }

      series.classed('disabled', function (d) { return d.disabled; });
      series.exit().remove();

    });

    return chart;
  }


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  chart.dispatch = dispatch;

  chart.margin = function (_) {
    if (!arguments.length) { return margin; }
    margin = _;
    return chart;
  };

  chart.width = function (_) {
    if (!arguments.length) { return width; }
    width = _;
    return chart;
  };

  chart.height = function (_) {
    if (!arguments.length) { return height; }
    height = _;
    return chart;
  };

  chart.key = function (_) {
    if (!arguments.length) { return getKey; }
    getKey = _;
    return chart;
  };

  chart.color = function (_) {
    if (!arguments.length) { return color; }
    color = nv.utils.getColor(_);
    return chart;
  };

  chart.classes = function (_) {
    if (!arguments.length) { return classes; }
    classes = _;
    return chart;
  };

  chart.align = function (_) {
    if (!arguments.length) { return align; }
    align = _;
    return chart;
  };

  //============================================================


  return chart;
};
