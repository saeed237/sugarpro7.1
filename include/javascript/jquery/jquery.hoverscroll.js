/**
     * HoverScroll jQuery Plugin
     *
     * Make an unordered list scrollable by hovering the mouse over it
     *
     * @author RasCarlito <carl.ogren@gmail.com>
     * @version 0.2.4
     * @revision 21
     *
     *
     *
     * FREE BEER LICENSE VERSION 1.02
     *
     * The free beer license is a license to give free software to you and free
     * beer (in)to the author(s).
     *
     *
     * Released: 09-12-2010 11:31pm
     *
     * Changelog
     * ----------------------------------------------------
     *
     * 0.2.4    - Added "Right to Left" option, only works with horizontal lists
     *          - Optimization of arrows opacity control (Thanks to Josef Körner)
     *
     * 0.2.3    - Added fixed arrows option
     *          - Binded startMoving and stopMoving functions to the HoverScrolls HTML object for external access
     *
     * 0.2.2    Bug fixes
     *          - Backward compatibility with jQuery 1.1.x
     *          - Added test file to the archive
     *          - Bug fix: The right arrow appeared when it wasn't necessary (thanks to <admin at unix dot am>)
     *
     * 0.2.1    Bug fixes
     *          - Backward compatibility with jQuery 1.2.x (thanks to Andy Mull for compatibility with jQuery >= 1.2.4)
     *          - Added information to the debug log
     *
     * 0.2.0    Added some new features
     *          - Direction indicator arrows
     *          - Permanent override of default parameters
     *
     * 0.1.1    Minor bug fix
     *          - Hover zones did not cover the complete container
     *
     *          note: The css file has not changed therefore it is still versioned 0.1.0
     *
     * 0.1.0    First release of the plugin. Supports:
     *          - Horizontal and vertical lists
     *          - Width and height control
     *          - Debug log (doesn't show useful information for the moment)
     */
(function($){$.fn.hoverscroll=function(params){if(!params){params={};}
params=$.extend({},$.fn.hoverscroll.params,params);this.each(function(){var $this=$(this);if(params.debug){$.log('[HoverScroll] Trying to create hoverscroll on element '+this.tagName+'#'+this.id);}
if(params.fixedArrows){$this.wrap('<div class="fixed-listcontainer"></div>')}
else{$this.wrap('<div class="listcontainer"></div>');}
$this.addClass('listitem');var listctnr=$this.parent();listctnr.wrap('<div class="ui-widget-content hoverscroll'+
(params.rtl&&!params.vertical?" rtl":"")+'"></div>');var ctnr=listctnr.parent();var leftArrow,rightArrow,topArrow,bottomArrow;if(params.arrows){if(!params.vertical){if(params.fixedArrows){leftArrow='<div class="fixed-arrow left"></div>';rightArrow='<div class="fixed-arrow right"></div>';listctnr.before(leftArrow).after(rightArrow);}
else{leftArrow='<div class="arrow left"></div>';rightArrow='<div class="arrow right"></div>';listctnr.append(leftArrow).append(rightArrow);}}
else{if(params.fixedArrows){topArrow='<div class="fixed-arrow top"></div>';bottomArrow='<div class="fixed-arrow bottom"></div>';listctnr.before(topArrow).after(bottomArrow);}
else{topArrow='<div class="arrow top"></div>';bottomArrow='<div class="arrow bottom"></div>';listctnr.append(topArrow).append(bottomArrow);}}}
ctnr.width(params.width).height(params.height);if(params.arrows&&params.fixedArrows){if(params.vertical){topArrow=listctnr.prev();bottomArrow=listctnr.next();listctnr.width(params.width).height(params.height-(topArrow.height()+bottomArrow.height()));}
else{leftArrow=listctnr.prev();rightArrow=listctnr.next();listctnr.height(params.height).width(params.width-(leftArrow.width()+rightArrow.width()));}}
else{listctnr.width(params.width).height(params.height);}
var size=0;if(!params.vertical){ctnr.addClass('horizontal');$this.children().each(function(){$(this).addClass('item');if($(this).outerWidth){size+=$(this).outerWidth(true);}
else{size+=$(this).width()+parseInt($(this).css('padding-left'))+parseInt($(this).css('padding-right'))
+parseInt($(this).css('margin-left'))+parseInt($(this).css('margin-right'));}});$this.width(size);if(params.debug){$.log('[HoverScroll] Computed content width : '+size+'px');}
if(ctnr.outerWidth){size=ctnr.outerWidth();}
else{size=ctnr.width()+parseInt(ctnr.css('padding-left'))+parseInt(ctnr.css('padding-right'))
+parseInt(ctnr.css('margin-left'))+parseInt(ctnr.css('margin-right'));}
if(params.debug){$.log('[HoverScroll] Computed container width : '+size+'px');}}
else{ctnr.addClass('vertical');$this.children().each(function(){$(this).addClass('item')
if($(this).css('display')!="none"){if($(this).outerHeight){size+=$(this).outerHeight(true);}
else{size+=$(this).height()+parseInt($(this).css('padding-top'))+parseInt($(this).css('padding-bottom'))
+parseInt($(this).css('margin-bottom'))+parseInt($(this).css('margin-bottom'));}}});$this.height(size);if(params.debug){$.log('[HoverScroll] Computed content height : '+size+'px');}
if(ctnr.outerHeight){size=ctnr.outerHeight();}
else{size=ctnr.height()+parseInt(ctnr.css('padding-top'))+parseInt(ctnr.css('padding-bottom'))
+parseInt(ctnr.css('margin-top'))+parseInt(ctnr.css('margin-bottom'));}
if(params.debug){$.log('[HoverScroll] Computed container height : '+size+'px');}}
var arrowHeight=$(this).parent().find('.arrow.top').height();if(params.hoverZone=="gradual"){var zone={1:{action:'move',from:0,to:0.06*size,direction:-1,speed:16},2:{action:'move',from:0.06*size,to:0.15*size,direction:-1,speed:8},3:{action:'move',from:0.15*size,to:0.25*size,direction:-1,speed:4},4:{action:'move',from:0.25*size,to:0.4*size,direction:-1,speed:2},5:{action:'stop',from:0.4*size,to:0.6*size},6:{action:'move',from:0.6*size,to:0.75*size,direction:1,speed:2},7:{action:'move',from:0.75*size,to:0.85*size,direction:1,speed:4},8:{action:'move',from:0.85*size,to:0.94*size,direction:1,speed:8},9:{action:'move',from:0.94*size,to:size,direction:1,speed:16}}}else{var zone={1:{action:'move',from:0,to:arrowHeight,direction:-1,speed:16},2:{action:'move',from:size-arrowHeight,to:size,direction:1,speed:16}}}
ctnr[0].isChanging=false;ctnr[0].direction=0;ctnr[0].speed=1;function checkMouse(x,y){x=x-ctnr.offset().left;y=y-ctnr.offset().top;var pos;if(!params.vertical){pos=x;}
else{pos=y;}
for(i in zone){if(pos>=zone[i].from&&pos<zone[i].to){if(zone[i].action=='move'){startMoving(zone[i].direction,zone[i].speed);}
else{stopMoving();}}}}
function setArrowOpacity(){if(!params.arrows||params.fixedArrows){return;}
var maxScroll;var scroll;if(!params.vertical){maxScroll=listctnr[0].scrollWidth-listctnr.width();scroll=listctnr[0].scrollLeft;}
else{maxScroll=listctnr[0].scrollHeight-listctnr.height();scroll=listctnr[0].scrollTop;}
var limit=params.arrowsOpacity;var opacity=(scroll / maxScroll)*limit;if(opacity>limit){opacity=limit;}
if(isNaN(opacity)){opacity=0;}
var done=false;if(opacity<=0){$('div.arrow.left, div.arrow.top',ctnr).hide();if(maxScroll>0){$('div.arrow.right, div.arrow.bottom',ctnr).show().css('opacity',limit);}
done=true;}
if(opacity>=limit||maxScroll<=0){$('div.arrow.right, div.arrow.bottom',ctnr).hide();done=true;}
if(!done){$('div.arrow.left, div.arrow.top',ctnr).show().css('opacity',opacity);$('div.arrow.right, div.arrow.bottom',ctnr).show().css('opacity',(limit-opacity));}}
function startMoving(direction,speed){if(ctnr[0].direction!=direction){if(params.debug){$.log('[HoverScroll] Starting to move. direction: '+direction+', speed: '+speed);}
stopMoving();ctnr[0].direction=direction;ctnr[0].isChanging=true;move();}
if(ctnr[0].speed!=speed){if(params.debug){$.log('[HoverScroll] Changed speed: '+speed);}
ctnr[0].speed=speed;}}
function stopMoving(){if(ctnr[0].isChanging){if(params.debug){$.log('[HoverScroll] Stoped moving');}
ctnr[0].isChanging=false;ctnr[0].direction=0;ctnr[0].speed=1;clearTimeout(ctnr[0].timer);}}
function move(){if(ctnr[0].isChanging==false){return;}
setArrowOpacity();var scrollSide;if(!params.vertical){scrollSide='scrollLeft';}
else{scrollSide='scrollTop';}
listctnr[0][scrollSide]+=ctnr[0].direction*ctnr[0].speed;ctnr[0].timer=setTimeout(function(){move();},50);}
if(params.rtl&&!params.vertical){listctnr[0].scrollLeft=listctnr[0].scrollWidth-listctnr.width();}
ctnr.mousemove(function(e){checkMouse(e.pageX,e.pageY);}).bind('mouseleave, mouseout',function(){stopMoving();});this.startMoving=startMoving;this.stopMoving=stopMoving;if(params.arrows&&!params.fixedArrows){setArrowOpacity();}
else{$('.arrowleft, .arrowright, .arrowtop, .arrowbottom',ctnr).hide();}});return this;};if(!$.fn.offset){$.fn.offset=function(){this.left=this.top=0;if(this[0]&&this[0].offsetParent){var obj=this[0];do{this.left+=obj.offsetLeft;this.top+=obj.offsetTop;}while(obj=obj.offsetParent);}
return this;}}
$.fn.hoverscroll.params={vertical:false,width:400,height:50,arrows:true,arrowsOpacity:0.7,fixedArrows:false,rtl:false,debug:false,hoverZone:'gradual'};$.fn.hoverscroll.destroy=function(el){var container=el.parent().parent(),originalContainer=container.parent();$(el).prependTo(originalContainer).removeClass('listitem').removeAttr("style");container.remove();};$.log=function(){try{console.log.apply(console,arguments);}
catch(e){try{opera.postError.apply(opera,arguments);}
catch(e){}}};})(jQuery);