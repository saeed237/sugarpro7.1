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
$(document).ready(function(){SUGAR.themes.actionMenu();});SUGAR.themes=SUGAR.namespace("themes");SUGAR.append(SUGAR.themes,{actionMenu:function(){$("ul.clickMenu").each(function(index,node){$(node).sugarActionMenu();});$("[class^='moduleMenuOverFlow']").each(function(index,node){var jNode=$(node);jNode.unbind("click");jNode.click(function(event){event.stopPropagation();});});},sugar_theme_gm_switch:function(groupName,groupId){SUGAR.themes.current_theme=(SUGAR.themes.current_theme)?SUGAR.themes.current_theme:sugar_theme_gm_current;$('ul.sf-menu:visible li').hideSuperfishUl();$('#moduleTabMore'+SUGAR.themes.current_theme+' li').hideSuperfishUl();var dcheight=$("#dcmenu").outerHeight();var current_menu=$('ul.sf-menu:visible');var target_menu=$('#themeTabGroupMenu_'+(groupId?groupId:groupName));SUGAR.themes.current_theme=sugar_theme_gm_current=groupName;$.ajax({type:"POST",url:"index.php?module=Users&action=ChangeGroupTab&to_pdf=true",data:'newGroup='+groupName});}});YAHOO.util.Event.onContentReady("tabListContainerTable",function()
{YUI({combine:true,timeout:10000,base:"include/javascript/yui3/build/",comboBase:"index.php?entryPoint=getYUIComboFile&"}).use("anim",function(Y)
{var content=Y.one('#content');var addPage=Y.one('#add_page');var tabListContainer=Y.one('#tabListContainer');var tabList=Y.one('#tabList');var dashletCtrlsElem=Y.one('#dashletCtrls');var contentWidth=content.get('offsetWidth');var dashletCtrlsWidth=dashletCtrlsElem.get('offsetWidth')+10;var addPageWidth=addPage.get('offsetWidth')+2;var tabListContainerWidth=tabListContainer.get('offsetWidth');var tabListWidthElem=tabList.get('offsetWidth');var maxWidth=(contentWidth-3)-(dashletCtrlsWidth+addPageWidth+2);var tabListChildren=tabList.get('children');var tabListWidth=0;for(i=0;i<tabListChildren.size();i++){if(Y.UA.ie==7){tabListWidth+=tabListChildren.item(i).get('offsetWidth')+2;}else{tabListWidth+=tabListChildren.item(i).get('offsetWidth');}}
if(tabListWidth>maxWidth){tabListContainer.setStyle('width',maxWidth+"px");tabList.setStyle('width',tabListWidth+"px");tabListContainer.addClass('active');}
var node=Y.one('#tabListContainer .yui-bd');var anim=new Y.Anim({node:node,to:{scroll:function(node){return[node.get('scrollLeft')+node.get('offsetWidth'),0]}},easing:Y.Easing.easeOut});var onClick=function(e){var y=node.get('offsetWidth');if(e.currentTarget.hasClass('yui-scrollup')){y=0-y;}
anim.set('to',{scroll:[y+node.get('scrollLeft'),0]});anim.run();};Y.all('#tabListContainer .yui-hd a').on('click',onClick);});});