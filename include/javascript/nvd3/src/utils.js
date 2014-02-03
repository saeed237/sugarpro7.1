nv.utils.windowSize=function(){var size={width:640,height:480};if(document.body&&document.body.offsetWidth){size.width=document.body.offsetWidth;size.height=document.body.offsetHeight;}
if(document.compatMode=='CSS1Compat'&&document.documentElement&&document.documentElement.offsetWidth){size.width=document.documentElement.offsetWidth;size.height=document.documentElement.offsetHeight;}
if(window.innerWidth&&window.innerHeight){size.width=window.innerWidth;size.height=window.innerHeight;}
return(size);};nv.utils.windowResize=function(fun)
{if(window.attachEvent){window.attachEvent('onresize',fun);}
else if(window.addEventListener){window.addEventListener('resize',fun,true);}
else{}};nv.utils.windowUnResize=function(fun)
{if(window.detachEvent){window.detachEvent('onresize',fun);}
else if(window.removeEventListener){window.removeEventListener('resize',fun,true);}
else{}}
nv.utils.resizeOnPrint=function(fn){if(window.matchMedia){var mediaQueryList=window.matchMedia('print');mediaQueryList.addListener(function(mql){if(mql.matches){fn();}});}else if(window.attachEvent){window.attachEvent("onbeforeprint",fn);}else{window.onbeforeprint=fn;}};nv.utils.unResizeOnPrint=function(fn){if(window.matchMedia){var mediaQueryList=window.matchMedia('print');mediaQueryList.removeListener(function(mql){if(mql.matches){fn();}});}else if(window.detachEvent){window.detachEvent("onbeforeprint",fn);}else{window.onbeforeprint=null;}};nv.utils.getColor=function(color){if(!arguments.length)return nv.utils.defaultColor();if(Object.prototype.toString.call(color)==='[object Array]')
return function(d,i){return d.color||color[i%color.length];};else
return color;}
nv.utils.defaultColor=function(){var colors=d3.scale.category20().range();return function(d,i){return d.color||colors[i%colors.length]};}
nv.utils.customTheme=function(dictionary,getKey,defaultColors){getKey=getKey||function(series){return series.key};defaultColors=defaultColors||d3.scale.category20().range();var defIndex=defaultColors.length;return function(series,index){var key=getKey(series);if(!defIndex)defIndex=defaultColors.length;if(typeof dictionary[key]!=="undefined")
return(typeof dictionary[key]==="function")?dictionary[key]():dictionary[key];else
return defaultColors[--defIndex];}}
nv.utils.pjax=function(links,content){d3.selectAll(links).on("click",function(){history.pushState(this.href,this.textContent,this.href);load(this.href);d3.event.preventDefault();});function load(href){d3.html(href,function(fragment){var target=d3.select(content).node();target.parentNode.replaceChild(d3.select(fragment).select(content).node(),target);nv.utils.pjax(links,content);});}
d3.select(window).on("popstate",function(){if(d3.event.state)load(d3.event.state);});}
nv.utils.colorLinearGradient=function(d,i,p,c,defs){var id='lg_gradient_'+i,grad=defs.select('#'+id);if(grad.empty()){if(p.position==='middle')
{nv.utils.createLinearGradient(id,p,defs,[{'offset':'0%','stop-color':d3.rgb(c).darker().toString(),'stop-opacity':1},{'offset':'20%','stop-color':d3.rgb(c).toString(),'stop-opacity':1},{'offset':'50%','stop-color':d3.rgb(c).brighter().toString(),'stop-opacity':1},{'offset':'80%','stop-color':d3.rgb(c).toString(),'stop-opacity':1},{'offset':'100%','stop-color':d3.rgb(c).darker().toString(),'stop-opacity':1}]);}
else
{nv.utils.createLinearGradient(id,p,defs,[{'offset':'0%','stop-color':d3.rgb(c).darker().toString(),'stop-opacity':1},{'offset':'50%','stop-color':d3.rgb(c).toString(),'stop-opacity':1},{'offset':'100%','stop-color':d3.rgb(c).brighter().toString(),'stop-opacity':1},]);}}
return'url(#'+id+')';}
nv.utils.createLinearGradient=function(id,params,defs,stops)
{var x2=params.orientation==='horizontal'?'0%':'100%',y2=params.orientation==='horizontal'?'100%':'0%',grad=defs.append('linearGradient').attr('id',id).attr('x1','0%').attr('y1','0%').attr('x2',x2).attr('y2',y2).attr('spreadMethod','pad');for(var i=0;i<stops.length;i++)
{var attrs=stops[i],stop=grad.append('stop');for(var a in attrs)
{if(attrs.hasOwnProperty(a)){stop.attr(a,attrs[a]);}}}}
nv.utils.colorRadialGradient=function(d,i,p,c,defs){var id='rg_gradient_'+i,grad=defs.select('#'+id);if(grad.empty())
{nv.utils.createRadialGradient(id,p,defs,[{'offset':p.s,'stop-color':d3.rgb(c).brighter().toString(),'stop-opacity':1},{'offset':'100%','stop-color':d3.rgb(c).darker().toString(),'stop-opacity':1}]);}
return'url(#'+id+')';}
nv.utils.createRadialGradient=function(id,params,defs,stops)
{var grad=defs.append('radialGradient').attr('id',id).attr('r',params.r).attr('cx',params.x).attr('cy',params.y).attr('gradientUnits',params.u).attr('spreadMethod','pad');for(var i=0;i<stops.length;i++)
{var attrs=stops[i],stop=grad.append('stop');for(var a in attrs)
{if(attrs.hasOwnProperty(a)){stop.attr(a,attrs[a]);}}}}
nv.utils.getAbsoluteXY=function(element)
{var viewportElement=document.documentElement,box=element.getBoundingClientRect(),scrollLeft=viewportElement.scrollLeft+document.body.scrollLeft,scrollTop=viewportElement.scrollTop+document.body.scrollTop,x=box.left+scrollLeft,y=box.top+scrollTop;return{'left':x,'top':y};};nv.utils.roundedRectangle=function(x,y,width,height,radius)
{return"M"+x+","+y
+"h"+(width-radius*2)
+"a"+radius+","+radius+" 0 0 1 "+radius+","+radius
+"v"+(height-2-radius*2)
+"a"+radius+","+radius+" 0 0 1 "+-radius+","+radius
+"h"+(radius*2-width)
+"a"+-radius+","+radius+" 0 0 1 "+-radius+","+-radius
+"v"+(-height+radius*2+2)
+"a"+radius+","+radius+" 0 0 1 "+radius+","+-radius
+"z";}
nv.utils.dropShadow=function(id,defs,options)
{var opt=options||{},h=opt.height||'130%',o=opt.offset||2,b=opt.blur||1;var filter=defs.append('filter').attr('id',id).attr('height',h);var offset=filter.append('feOffset').attr('in','SourceGraphic').attr('result','offsetBlur').attr('dx',o).attr('dy',o);var color=filter.append('feColorMatrix').attr('in','offsetBlur').attr('result','matrixOut').attr('type','matrix').attr('values','1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0');var blur=filter.append('feGaussianBlur').attr('in','matrixOut').attr('result','blurOut').attr('stdDeviation',b);var merge=filter.append('feMerge');merge.append('feMergeNode');merge.append('feMergeNode').attr('in','SourceGraphic');return'url(#'+id+')';}