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
var focus_obj=false;var label=SUGAR.language.get('app_strings','LBL_DEFAULT_LINK_TEXT');function remember_place(obj){focus_obj=obj;}
function showVariable(){document.EditView.variable_text.value=document.EditView.variable_name.options[document.EditView.variable_name.selectedIndex].value;}
function addVariables(the_select,the_module){the_select.options.length=0;for(var i=0;i<field_defs[the_module].length;i++){var new_option=document.createElement("option");new_option.value="$"+field_defs[the_module][i].name;new_option.text=field_defs[the_module][i].value;the_select.options.add(new_option,i);}
showVariable();}
function toggle_text_only(firstRun){if(typeof(firstRun)=='undefined')
firstRun=false;var text_only=document.getElementById('text_only');if(firstRun){setTimeout("tinyMCE.execCommand('mceAddControl', false, 'body_text');",500);var tiny=tinyMCE.getInstanceById('body_text');}
if(document.getElementById('toggle_textonly').checked==true){document.getElementById('body_text_div').style.display='none';document.getElementById('toggle_textarea_option').style.display='none';document.getElementById('text_div').style.display='block';text_only.value=1;}else{document.getElementById('body_text_div').style.display='inline';document.getElementById('toggle_textarea_option').style.display='inline';document.getElementById('text_div').style.display='none';text_only.value=0;}
update_textarea_button();}
function update_textarea_button()
{if(document.getElementById('text_div').style.display=='none'){document.getElementById('toggle_textarea_elem').value=toggle_textarea_elem_values[0];}else{document.getElementById('toggle_textarea_elem').value=toggle_textarea_elem_values[1];}}
function toggle_textarea_edit(obj)
{if(document.getElementById('text_div').style.display=='none')
{document.getElementById('text_div').style.display='block';}else{document.getElementById('text_div').style.display='none';}
update_textarea_button();}
function setTinyHTML(text){var tiny=tinyMCE.getInstanceById('body_text');if(tiny.getContent()!=null){tiny.setContent(text)}else{setTimeout(setTinyHTML(text),1000);}}
function stripTags(str){var theText=new String(str);if(theText!='undefined'){return theText.replace(/<\/?[^>]+>/gi,'');}}
function insert_variable_text(myField,myValue){if(document.selection){myField.focus();sel=document.selection.createRange();sel.text=myValue;}
else if(myField.selectionStart||myField.selectionStart=='0'){var startPos=myField.selectionStart;var endPos=myField.selectionEnd;myField.value=myField.value.substring(0,startPos)
+myValue
+myField.value.substring(endPos,myField.value.length);}else{myField.value+=myValue;}}
function insert_variable_html(text){var inst=tinyMCE.getInstanceById("body_text");if(inst)
inst.getWin().focus();inst.execCommand('mceInsertRawHTML',false,text);}
function insert_variable_html_link(text){the_label=document.getElementById('url_text').value;if(typeof(the_label)=='undefined'){the_label=label;}
if(the_label[0]=='{'&&the_label[the_label.length-1]=='}'){the_label=the_label.substring(1,the_label.length-1);}
var thelink="<a href='"+text+"' > "+the_label+" </a>";insert_variable_html(thelink);}
function insert_variable(text){if(document.getElementById('toggle_textonly').checked==true){insert_variable_text(document.getElementById('body_text_plain'),text);}else{insert_variable_html(text);}}