
nv.utils.windowSize = function() {
    // Sane defaults
    var size = {width: 640, height: 480};

    // Earlier IE uses Doc.body
    if (document.body && document.body.offsetWidth) {
        size.width = document.body.offsetWidth;
        size.height = document.body.offsetHeight;
    }

    // IE can use depending on mode it is in
    if (document.compatMode=='CSS1Compat' &&
        document.documentElement &&
        document.documentElement.offsetWidth ) {
        size.width = document.documentElement.offsetWidth;
        size.height = document.documentElement.offsetHeight;
    }

    // Most recent browsers use
    if (window.innerWidth && window.innerHeight) {
        size.width = window.innerWidth;
        size.height = window.innerHeight;
    }
    return (size);
};

// Easy way to bind multiple functions to window.onresize
// TODO: give a way to remove a function after its bound, other than removing alkl of them
// nv.utils.windowResize = function(fun)
// {
//   var oldresize = window.onresize;

//   window.onresize = function(e) {
//     if (typeof oldresize == 'function') oldresize(e);
//     fun(e);
//   }
// }

nv.utils.windowResize = function(fun)
{
  if(window.attachEvent) {
      window.attachEvent('onresize', fun);
  }
  else if(window.addEventListener) {
      window.addEventListener('resize', fun, true);
  }
  else {
      //The browser does not support Javascript event binding
  }
};

nv.utils.windowUnResize = function(fun)
{
  if (window.detachEvent) {
      window.detachEvent('onresize', fun);
  }
  else if (window.removeEventListener) {
      window.removeEventListener('resize', fun, true);
  }
  else {
      //The browser does not support Javascript event binding
  }
}

nv.utils.resizeOnPrint = function(fn) {
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                fn();
            }
        });
    } else if (window.attachEvent) {
      window.attachEvent("onbeforeprint", fn);
    } else {
      window.onbeforeprint = fn;
    }
    //TODO: allow for a second call back to undo using
    //window.attachEvent("onafterprint", fn);
};

nv.utils.unResizeOnPrint = function(fn) {
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.removeListener(function(mql) {
            if (mql.matches) {
                fn();
            }
        });
    } else if (window.detachEvent) {
      window.detachEvent("onbeforeprint", fn);
    } else {
      window.onbeforeprint = null;
    }
};

// Backwards compatible way to implement more d3-like coloring of graphs.
// If passed an array, wrap it in a function which implements the old default
// behavior
nv.utils.getColor = function(color) {
    if (!arguments.length) return nv.utils.defaultColor(); //if you pass in nothing, get default colors back

    if( Object.prototype.toString.call( color ) === '[object Array]' )
        return function(d, i) { return d.color || color[i % color.length]; };
    else
        return color;
        //can't really help it if someone passes rubbish as color
}

// Default color chooser uses the index of an object as before.
nv.utils.defaultColor = function() {
    var colors = d3.scale.category20().range();
    return function(d, i) { return d.color || colors[i % colors.length] };
}


// Returns a color function that takes the result of 'getKey' for each series and
// looks for a corresponding color from the dictionary,
nv.utils.customTheme = function(dictionary, getKey, defaultColors) {
  getKey = getKey || function(series) { return series.key }; // use default series.key if getKey is undefined
  defaultColors = defaultColors || d3.scale.category20().range(); //default color function

  var defIndex = defaultColors.length; //current default color (going in reverse)

  return function(series, index) {
    var key = getKey(series);

    if (!defIndex) defIndex = defaultColors.length; //used all the default colors, start over

    if (typeof dictionary[key] !== "undefined")
      return (typeof dictionary[key] === "function") ? dictionary[key]() : dictionary[key];
    else
      return defaultColors[--defIndex]; // no match in dictionary, use default color
  }
}



// From the PJAX example on d3js.org, while this is not really directly needed
// it's a very cool method for doing pjax, I may expand upon it a little bit,
// open to suggestions on anything that may be useful
nv.utils.pjax = function(links, content) {
  d3.selectAll(links).on("click", function() {
    history.pushState(this.href, this.textContent, this.href);
    load(this.href);
    d3.event.preventDefault();
  });

  function load(href) {
    d3.html(href, function(fragment) {
      var target = d3.select(content).node();
      target.parentNode.replaceChild(d3.select(fragment).select(content).node(), target);
      nv.utils.pjax(links, content);
    });
  }

  d3.select(window).on("popstate", function() {
    if (d3.event.state) load(d3.event.state);
  });
}

//SUGAR ADDITIONS

//gradient color
nv.utils.colorLinearGradient = function ( d, i, p, c, defs ) {
  var id = 'lg_gradient_'+ i
    , grad = defs.select('#'+ id);
  if ( grad.empty() ) {
    if (p.position === 'middle')
    {
      nv.utils.createLinearGradient( id, p, defs, [
        { 'offset': '0%',  'stop-color': d3.rgb(c).darker().toString(),  'stop-opacity': 1 },
        { 'offset': '20%', 'stop-color': d3.rgb(c).toString(), 'stop-opacity': 1 },
        { 'offset': '50%', 'stop-color': d3.rgb(c).brighter().toString(), 'stop-opacity': 1 },
        { 'offset': '80%', 'stop-color': d3.rgb(c).toString(), 'stop-opacity': 1 },
        { 'offset': '100%','stop-color': d3.rgb(c).darker().toString(),  'stop-opacity': 1 }
      ]);
    }
    else
    {
      nv.utils.createLinearGradient( id, p, defs, [
        { 'offset': '0%',  'stop-color': d3.rgb(c).darker().toString(),  'stop-opacity': 1 },
        { 'offset': '50%', 'stop-color': d3.rgb(c).toString(), 'stop-opacity': 1 },
        { 'offset': '100%','stop-color': d3.rgb(c).brighter().toString(), 'stop-opacity': 1 },
      ]);
    }
  }
  return 'url(#'+ id +')';
}

// defs:definition container
// id:dynamic id for arc
// radius:outer edge of gradient
// stops: an array of attribute objects
nv.utils.createLinearGradient = function ( id, params, defs, stops )
{
  var x2 = params.orientation === 'horizontal' ? '0%' : '100%'
    , y2 = params.orientation === 'horizontal' ? '100%' : '0%'
    , grad = defs.append('linearGradient')
        .attr('id', id)
        .attr('x1', '0%')
        .attr('y1', '0%')
        .attr('x2', x2 )
        .attr('y2', y2 )
        //.attr('gradientUnits', 'userSpaceOnUse')objectBoundingBox
        .attr('spreadMethod', 'pad');
  for (var i=0; i<stops.length; i++)
  {
    var attrs = stops[i]
      , stop = grad.append('stop');
    for (var a in attrs)
    {
      if ( attrs.hasOwnProperty(a) ) {
        stop.attr(a, attrs[a]);
      }
    }
  }
}

nv.utils.colorRadialGradient = function ( d, i, p, c, defs ) {
  var id = 'rg_gradient_'+ i
    , grad = defs.select('#'+ id);
  if ( grad.empty() )
  {
    nv.utils.createRadialGradient( id, p, defs, [
      { 'offset': p.s, 'stop-color': d3.rgb(c).brighter().toString(), 'stop-opacity': 1 },
      { 'offset': '100%','stop-color': d3.rgb(c).darker().toString(), 'stop-opacity': 1 }
    ]);
  }
  return 'url(#'+ id +')';
}

nv.utils.createRadialGradient = function ( id, params, defs, stops )
{
  var grad = defs.append('radialGradient')
        .attr('id', id)
        .attr('r', params.r)
        .attr('cx', params.x)
        .attr('cy', params.y)
        .attr('gradientUnits', params.u)
        .attr('spreadMethod', 'pad');
  for (var i=0; i<stops.length; i++)
  {
    var attrs = stops[i]
      , stop = grad.append('stop');
    for (var a in attrs)
    {
      if ( attrs.hasOwnProperty(a) ) {
        stop.attr(a, attrs[a]);
      }
    }
  }
}

nv.utils.getAbsoluteXY = function (element)
{
  var viewportElement = document.documentElement
    , box = element.getBoundingClientRect()
    , scrollLeft = viewportElement.scrollLeft + document.body.scrollLeft
    , scrollTop = viewportElement.scrollTop + document.body.scrollTop
    , x = box.left + scrollLeft
    , y = box.top + scrollTop;

  return {'left': x, 'top': y};
};

// Creates a rectangle with rounded corners
nv.utils.roundedRectangle = function (x, y, width, height, radius)
{
  return "M" + x + "," + y
       + "h" + (width - radius*2)
       + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius
       + "v" + (height - 2 - radius*2)
       + "a" + radius + "," + radius + " 0 0 1 " + -radius + "," + radius
       + "h" + (radius*2 - width)
       + "a" + -radius + "," + radius + " 0 0 1 " + -radius + "," + -radius
       + "v" + ( -height+radius*2 + 2 )
       + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + -radius
       + "z";
}

nv.utils.dropShadow = function (id, defs, options)
{
  var opt = options || {}
    , h = opt.height || '130%'
    , o = opt.offset || 2
    , b = opt.blur || 1;

  var filter = defs.append('filter')
        .attr('id',id)
        .attr('height',h);
  var offset = filter.append('feOffset')
        .attr('in','SourceGraphic')
        .attr('result','offsetBlur')
        .attr('dx',o)
        .attr('dy',o); //how much to offset
  var color = filter.append('feColorMatrix')
        .attr('in','offsetBlur')
        .attr('result','matrixOut')
        .attr('type','matrix')
        .attr('values','1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0');
  var blur = filter.append('feGaussianBlur')
        .attr('in','matrixOut')
        .attr('result','blurOut')
        .attr('stdDeviation',b); //stdDeviation is how much to blur
  var merge = filter.append('feMerge');
      merge.append('feMergeNode'); //this contains the offset blurred image
      merge.append('feMergeNode')
        .attr('in','SourceGraphic'); //this contains the element that the filter is applied to

  return 'url(#'+ id +')';
}
// <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
//   <defs>
//     <filter id="f1" x="0" y="0" width="200%" height="200%">
//       <feOffset result="offOut" in="SourceGraphic" dx="20" dy="20" />
//       <feColorMatrix result="matrixOut" in="offOut" type="matrix"
//       values="0.2 0 0 0 0 0 0.2 0 0 0 0 0 0.2 0 0 0 0 0 1 0" />
//       <feGaussianBlur result="blurOut" in="matrixOut" stdDeviation="10" />
//       <feBlend in="SourceGraphic" in2="blurOut" mode="normal" />
//     </filter>
//   </defs>
//   <rect width="90" height="90" stroke="green" stroke-width="3"
//   fill="yellow" filter="url(#f1)" />
// </svg>
