/* jQuery elementReady plugin
     * Version 0.6
     * Copyright (C) 2007-08 Bennett McElwee.
     * Licensed under a Creative Commons Attribution-Share Alike 3.0 Unported License (http://creativecommons.org/licenses/by-sa/3.0/)
     * Permissions beyond the scope of this license may be available at http://www.thunderguy.com/semicolon/.
     */
(function($){var interval=null;var checklist=[];$.elementReady=function(id,fn){checklist.push({id:id,fn:fn});if(!interval){interval=setInterval(check,$.elementReady.interval_ms);}
return this;};$.elementReady.interval_ms=23;function check(){var docReady=$.isReady;for(var i=checklist.length-1;0<=i;--i){var el=document.getElementById(checklist[i].id);if(el){var fn=checklist[i].fn;checklist[i]=checklist[checklist.length-1];checklist.pop();fn.apply(el,[$]);}}
if(docReady){clearInterval(interval);interval=null;}};})(jQuery);