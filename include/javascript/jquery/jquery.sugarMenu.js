/* This is a simple plugin to render action dropdown menus from html.
     * John Barlow - SugarCRM
     * add secondary popup implementation by Justin Park - SugarCRM
     *
     * The html structure it expects is as follows:
     *
     * <ul>                                     - Menu root
     *      <li>                                - First element in menu (visible)
     *      <ul class="subnav">		            - Popout menu (should start hidden)
     *          <li></li>                       - \
     *          ...                             -  Elements in popout menu
     *          <li></li>                       - /
     *          <li>
     *              <input></input>  - element contains submenu
     *              <ul class="subnav-sub">     - sub-popout menu (shown when mouseover on the above element)
     *                  <li></li>               - \
     *                  ...                     -  Elements in sub-popout menu
     *                  <li></li>               - /
     *              </ul>
     *          </li>
     *      </ul>
     *      </li>
     * </ul>
     *
     * By adding a class of "fancymenu" to the menu root, the plugin adds an additional "ab" class to the
     * dropdown handle, allowing you to make the menu "fancy" with additional css if you would like :)
     *
     * Functions:
     *
     * 		init: initializes things (called by default)... currently no options are passed
     *
     * 		Adds item to the menu at position index
     * 		addItem: (item, index)
     * 			item - created dom element or string that represents one
     * 			index(optional) - the position you want your new menuitem. If you leave this off,
     * 				the item is appended to the end of the list.
     *      	returns: nothing
     *
     *      Finds an item in the menu (including the root node "outside" the ul structure).
     * 		findItem: (item)
     * 			item - string of the menu item you are looking for.
     * 			returns: index of element, or -1 if not found.
     */
(function($){var methods={init:function(options){var menuNode=this;if(!this.hasClass("SugarActionMenu")){this.addClass("SugarActionMenu");this.find("input[type='submit'], input[type='button']").each(function(idx,node){var jNode=$(node);var parent=jNode.parent();var _subnav=menuNode.find("ul.subnav");var _timer_for_subnav=null;var disabled=$(this).prop('disabled');var newItem=$(document.createElement("li"));var newItemA=$(document.createElement("a"));var accesskey=jNode.attr("accesskey");var accesskey_el=$("<a></a>");newItemA.html(jNode.val());if(!disabled)
{newItemA.click(function(event){if($(this).hasClass("void")===false){jNode.click();}});}
else
{newItemA.addClass("disabled");}
newItemA.attr("id",jNode.attr("id"));accesskey_el.attr("id",jNode.attr("id")+"_accesskey");jNode.attr("id",jNode.attr("id")+"_old");if(accesskey!==undefined){if($('#'+accesskey_el.attr('id')).length===0){accesskey_el.attr("accesskey",accesskey).click(function(){jNode.click();}).appendTo("#content");}
jNode.attr("accesskey",'');}
if(menuNode.sugarActionMenu("findItem",newItemA.html())==-1){parent.prepend(newItemA);}
jNode.siblings(".subnav-sub").each(function(idx,node){var _menu=$(node);var _hide_menu=function(){if(_menu.hasClass("hover")===false)
_menu.hide();};var _hide_timer=null;var _delay=300;_menu.mouseover(function(evt){if($(this).hasClass("hover")===false)
$(this).addClass("hover");}).mouseout(function(evt){if($(this).hasClass("hover"))
$(this).removeClass("hover");if(_hide_timer)
clearTimeout(_hide_timer);_hide_timer=setTimeout(_hide_menu,_delay);});newItemA.mouseover(function(evt){$("ul.SugarActionMenu ul.subnav-sub").each(function(index,node){$(node).removeClass("hover");$(node).hide();});var _left=parent.offset().left+parent.width()-newItemA.css("paddingRight").replace("px","");var _top=parent.offset().top-_menu.css("paddingTop").replace("px","");_menu.css({left:_left,top:_top});if(_menu.hasClass("hover")===false)
_menu.addClass("hover");if(_subnav.hasClass("subnav-sub-handler")===false)
_subnav.addClass("subnav-sub-handler");_menu.show();}).mouseout(function(evt){_menu.removeClass("hover");_subnav.removeClass("subnav-sub-handler")
if(_hide_timer)
clearTimeout(_hide_timer);_hide_timer=setTimeout(_hide_menu,_delay);}).click(function(evt){if(_timer_for_subnav)
clearTimeout(_timer_for_subnav);}).addClass("void");menuNode.append(_menu);});jNode.css("display","none");});this.find("ul.subnav").each(function(index,node){var jNode=$(node);var parent=jNode.parent();var fancymenu="";var slideUpSpeed=1;var slideDownSpeed=1;var dropDownHandle;if(parent.find("span").length==0){dropDownHandle=$(document.createElement("span"));parent.append(dropDownHandle);}else{dropDownHandle=$(parent.find("span"));}
if(menuNode.hasClass("fancymenu")&&!window.parent.Modernizr.touch){dropDownHandle.addClass("ab");dropDownHandle.tipTip({maxWidth:"auto",edgeOffset:10,content:"More Actions",defaultPosition:"top"});}
dropDownHandle.click(function(event){$("ul.SugarActionMenu > li").each(function(){$(this).sugarActionMenu('IEfix');});$("ul.SugarActionMenu ul.subnav").each(function(subIndex,node){var subjNode=$(node);if(!(subjNode[0]===jNode[0])){subjNode.slideUp(slideUpSpeed);subjNode.removeClass("ddopen");}});if(jNode.hasClass("ddopen")){parent.sugarActionMenu('IEfix');var _animation={'height':0};if(jNode.hasClass("upper")){_animation['top']=(dropDownHandle.height()*-1);}
jNode.animate(_animation,slideUpSpeed,function(){$(this).css({'height':'','top':''}).hide().removeClass("upper ddopen");});}
else{parent.sugarActionMenu('IEfix',jNode);var _dropdown_height=jNode.height(),_animation={'height':_dropdown_height},_dropdown_bottom=dropDownHandle.offset().top+dropDownHandle.height()-$(document).scrollTop()+jNode.outerHeight(),_win_height=$(window).height();if(dropDownHandle.offset().top>jNode.height()&&_dropdown_bottom>$(window).height()){jNode.css('top',(dropDownHandle.height()*-1)).addClass("upper");_animation['top']=(jNode.height()+dropDownHandle.height())*-1;}
jNode.height(0).show().animate(_animation,slideDownSpeed,function(){$(this).css('height','');});jNode.addClass("ddopen");}
event.stopPropagation();});var jBody=$("body");var _hide_subnav_delay=30;var _hide_subnav=function(subnav){if(subnav.hasClass("subnav-sub-handler")===false){subnav.slideUp(slideUpSpeed);subnav.removeClass("ddopen");}}
if(jBody.data("sugarActionMenu")!=true){jBody.data("sugarActionMenu",true);jBody.bind("click",function(){$("ul.SugarActionMenu > li").each(function(){$(this).sugarActionMenu('IEfix');});$("ul.SugarActionMenu ul.subnav").each(function(subIndex,node){var _hide=function(){_hide_subnav($(node));}
setTimeout(_hide,_hide_subnav_delay);});$("ul.SugarActionMenu ul.subnav-sub").each(function(subIndex,node){var _hide=function(){$(this).removeClass("hover");$(this).hide();}
_timer_for_subnav=setTimeout(_hide,_hide_subnav_delay);});});}
dropDownHandle.hover(function(){dropDownHandle.addClass("subhover");},function(){dropDownHandle.removeClass("subhover");});jNode.find("li").each(function(index,subnode){$(subnode).bind("click",function(evt){var _hide=function(){_hide_subnav(jNode);}
setTimeout(_hide,_hide_subnav_delay);});});jNode.find("a").each(function(index,subnode){$(subnode).html(function(index,oldhtml){return oldhtml.replace(" ","&nbsp;");});});});this.find(".subnav > li").each(function(index,subnode){if($(subnode).html().replace(/ /g,'')==''){$(subnode).remove();}});this.find("li.sugar_action_button:first").each(function(index,node){var _this=$(node);var _first_item=$(node).find("a:first").not($(node).find(".subnav > li a"));if(_first_item.length==0){var sub_items=$(node).find(".subnav > li:first").children();if(sub_items.length==0)
menuNode.hide();else
_this.prepend(sub_items);}});}
return this;},addItem:function(args){if(args.index==null){this.find("ul.subnav").each(function(index,node){$(node).append(args.item);})}
else{this.find("ul.subnav").find("li").each(function(index,node){if(args.index==index+1){$(node).before(args.item);}});}
return this;},findItem:function(item){var index=-1;this.find("a").each(function(idx,node){var jNode=$(node);if($.trim(jNode.html())==$.trim(item)){index=idx;}});return index;},IEfix:function($ul){if($.browser.msie&&$.browser.version>6){if($ul){if($ul.hasClass('iefixed')===false)
return;this.each(function(){SUGAR.themes.counter=SUGAR.themes.counter?SUGAR.themes.counter++:1;var $$=$(this),_id=$$.attr("ul-child-id")?$$.attr("ul-child-id"):($$.parent('.SugarActionMenu').attr("id"))?$$.parent('.SugarActionMenu').attr("id")+'Subnav':'sugaractionmenu'+SUGAR.themes.counter,_top=$$.position().top+$$.outerHeight(),_width=($$.parent('.SugarActionMenu').attr("id")==='globalLinks')?$$.parent('.SugarActionMenu').width():'auto',_css={top:_top,width:_width,position:'fixed'},_right=$('body').width()-$$.offset().left-$$.width(),_left=$$.offset().left;if($ul.css('right')!='auto'){_css['right']=_right;}else{_css['left']=_left;}
$('body').append($ul.attr("id",_id).addClass("SugarActionMenuIESub").css(_css));$$.attr("ul-child-id",_id);});}else{this.each(function(){var _id=$(this).attr("ul-child-id");$(this).append($("body>#"+_id).removeClass("SugarActionMenuIESub"));});}}}}
$.fn.sugarActionMenu=function(method){if(methods[method]){return methods[method].apply(this,Array.prototype.slice.call(arguments,1));}else if(typeof method==='object'||!method){return methods.init.apply(this,arguments);}else{$.error('Method '+method+' does not exist on jQuery.tooltip');}}})(jQuery);