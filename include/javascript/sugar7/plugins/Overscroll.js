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
(function($){if(!Modernizr.touch){return;}
var touch_x,touch_y,obj_x,obj_y,speed_x=0,speed_y=0,scrollanim;document.addEventListener('touchstart',function(e){clearInterval(scrollanim);if(e.target==null||e.target==undefined){return;}
obj_x=e.target
obj_y=e.target
while((window.getComputedStyle(obj_x)['overflow-x']!="auto"&&window.getComputedStyle(obj_x)['overflow-x']!="scroll")||obj_x.parentNode==null){obj_x=obj_x.parentNode}
while((window.getComputedStyle(obj_y)['overflow-y']!="auto"&&window.getComputedStyle(obj_y)['overflow-y']!="auto")||obj_y.parentNode==null){obj_y=obj_y.parentNode}
if(obj_x.parentNode==null)obj_x=null;if(obj_y.parentNode==null)obj_y=null;var touch=e.touches[0];touch_x=touch.pageX;touch_y=touch.pageY;},false);document.addEventListener('touchmove',function(e){clearInterval(scrollanim);e.preventDefault();var touch=e.touches[0];obj_x.scrollLeft=obj_x.scrollLeft-(touch.pageX-touch_x)
obj_y.scrollTop=obj_y.scrollTop-(touch.pageY-touch_y)
speed_x=(touch.pageX-touch_x)
speed_y=(touch.pageY-touch_y)
touch_x=touch.pageX;touch_y=touch.pageY;},false);document.addEventListener('touchend',function(e){clearInterval(scrollanim);scrollanim=setInterval(function(){obj_x.scrollLeft=obj_x.scrollLeft-speed_x
obj_y.scrollTop=obj_y.scrollTop-speed_y
speed_x=speed_x*0.9;speed_y=speed_y*0.9;if(speed_x<1&&speed_x>-1&&speed_y<1&&speed_y>-1)clearInterval(scrollanim)},15)},false);})(jQuery);