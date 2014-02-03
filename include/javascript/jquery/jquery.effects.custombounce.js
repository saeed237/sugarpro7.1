/*!
     * jQuery UI Effects Bounce 1.8.21
     *
     * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
     * Dual licensed under the MIT or GPL Version 2 licenses.
     * http://jquery.org/license
     *
     * http://docs.jquery.com/UI/Effects/Bounce
     *
     * Depends:
     *	jquery.effects.core.js
     */
/*!
 * jQuery UI Effects Bounce 1.8.21
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Bounce
 *
 * Depends:
 *	jquery.effects.core.js
 */

(function($,undefined){$.effects.custombounce=function(o){return this.queue(function(){var el=$(this),props=['position','top','bottom','left','right'];var mode=$.effects.setMode(el,o.options.mode||'effect');var direction=o.options.direction||'up';var gravity=(o.options.gravity=="undefined")?true:o.options.gravity;var distance=o.options.distance||20;var times=o.options.times||5;var speed=o.duration||250;if(/show|hide/.test(mode))props.push('opacity');$.effects.save(el,props);el.show();$.effects.createWrapper(el);var ref,ref2,motion;if(direction=='up'||direction=='down'){ref='top';}else if(direction=='up right'||direction=='down right'||direction=='up left'||direction=='down left'){ref='top';ref2='left';}else{ref='left';}
var motion=(direction=='up'||direction=='left')?'pos':'neg';if(direction=="up"||direction=="left"){motion="pos";}else{motion="neg";}
var distance=o.options.distance||(ref=='top'?el.outerHeight({margin:true})/ 3:el.outerWidth({margin:true})/ 3);if(mode=='show')el.css('opacity',0).css(ref,motion=='pos'?-distance:distance);if(mode=='hide')distance=distance /(times*2);if(mode!='hide')times--;if(mode=='show'){var animation={opacity:1};animation[ref]=(motion=='pos'?'+=':'-=')+distance;el.animate(animation,speed / 2,o.options.easing);distance=distance / 2;times--;};for(var i=0;i<times;i++){var animation1={},animation2={};animation1[ref]=(motion=='pos'?'-=':'+=')+distance;animation2[ref]=(motion=='pos'?'+=':'-=')+distance;var rtl=rtl=="undefined"?false:rtl;if(ref2!="undefined"){if(!rtl){if(direction=="up right"||direction=="down left"){animation1[ref2]=(motion=='pos'?'-=':'+=')+distance;animation2[ref2]=(motion=='pos'?'+=':'-=')+distance;}else{animation1[ref2]=(motion=='pos'?'+=':'-=')+distance;animation2[ref2]=(motion=='pos'?'-=':'+=')+distance;}}else{if(direction=="down right"||direction=="up left"){animation1[ref2]=(motion=='pos'?'-=':'+=')+distance;animation2[ref2]=(motion=='pos'?'+=':'-=')+distance;}else{animation1[ref2]=(motion=='pos'?'+=':'-=')+distance;animation2[ref2]=(motion=='pos'?'-=':'+=')+distance;}}}
el.animate(animation1,speed / 2,o.options.easing).animate(animation2,speed / 2,o.options.easing);if(gravity){distance=(mode=='hide')?distance*2:distance / 2;}};if(mode=='hide'){var animation={opacity:0};animation[ref]=(motion=='pos'?'-=':'+=')+distance;el.animate(animation,speed / 2,o.options.easing,function(){el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);});}else{var animation1={},animation2={};animation1[ref]=(motion=='pos'?'-=':'+=')+distance;animation2[ref]=(motion=='pos'?'+=':'-=')+distance;if(ref2!="undefined"){animation1[ref2]=(motion=='pos'?'+=':'-=')+distance;animation2[ref2]=(motion=='pos'?'-=':'+=')+distance;}
el.animate(animation1,speed / 2,o.options.easing).animate(animation2,speed / 2,o.options.easing,function(){$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);});};el.queue('fx',function(){el.dequeue();});el.dequeue();});};})(jQuery);