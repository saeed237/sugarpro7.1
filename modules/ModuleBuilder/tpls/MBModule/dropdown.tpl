 {*
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

*}
<div>&nbsp;
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/ListEditor.css"></link>
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/MBModule/dropdown.css"></link> 
<form name='dropdown_form' onsubmit = "return false">
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='{$action}'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='view_module' value='{$module_name}'>
<input type='hidden' name='view_package' value='{$package_name}'>
<input type='hidden' id='list_value' name='list_value' value=''>
{if ($refreshTree)}
<input type='hidden' name='refreshTree' value='1'>
{/if}
<table>
	<tr>
		<td colspan='3'>
			<input id = "saveBtn" type='button' class='button' onclick='SimpleList.handleSave()' value='{$APP.LBL_SAVE_BUTTON_LABEL}'>
			<input type='button' class='button' onclick='SimpleList.undo()' value='{$MOD.LBL_BTN_UNDO}'>
			<input type='button' class='button' onclick='SimpleList.redo()' value='{$MOD.LBL_BTN_REDO}'>
			<input type='button' class='button' name='cancel' value='{$MOD.LBL_BTN_CANCEL}' onclick='ModuleBuilder.tabPanel.get("activeTab").close()'>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<hr/>
		</td>
	</tr>
	<tr>
		<td>
			<span class='mbLBLL'>{$MOD.LBL_DROPDOWN_TITLE_NAME}:&nbsp;</span>
			{if $name }
			<input type='hidden' id='dropdown_name' name='dropdown_name' value='{$dropdown_name}'>{$dropdown_name}
			{else}
			<input type='text' id='dropdown_name' name='dropdown_name' value={$prepopulated_name}>
			{/if}
		</td>
	</tr>
	<tr>
		<td class='mbLBLL'>
			{$MOD.LBL_DROPDOWN_LANGUAGE}:&nbsp;
			{html_options name='dropdown_lang' options=$available_languages selected=$selected_lang onchange='this.form.action.value="dropdown";ModuleBuilder.handleSave("dropdown_form")'}
		</td>
	</tr>
	<tr>
		<td style='padding-top:10px;' class='mbLBLL'>{$MOD.LBL_DROPDOWN_ITEMS}:</td>
	</tr>
	<tr>
		<td><b>{$MOD.LBL_DROPDOWN_ITEM_NAME}</b><span class='fieldValue'>[{$MOD.LBL_DROPDOWN_ITEM_LABEL}]<span></td>
	</tr>
	<tr>
		<td colspan='3'>
		    <ul id="ul1" class="listContainer">
		    {foreach from=$options key='name' item='val'}
                {if (!isset($val) || $val =='')}{assign var='name' value=$MOD.LBL_BLANK}{/if}
		    	<li class="draggable" id="{$name}" >
			      <table width='100%'>
			        <tr>
			           <td>
			               <b>{$name}</b>
			               <input id='value_{$name}' value='{$val}' type = 'hidden'>
			               <span class='fieldValue' id='span_{$name}'>
			                   {if (!isset($val) || $val =='')}[{$MOD.LBL_BLANK}]{else}[{$val}]{/if}
			               </span>
			               <span class='fieldValue' id='span_edit_{$name}' style='display:none'>
			                   <input type='text' id='input_{$name}' value="{$val}" onBlur='SimpleList.setDropDownValue("{$name}", this.value, true)' >
			               </span>
			           </td>
			           <td align='right'>
			               <a href='javascript:void(0)' onclick='SimpleList.editDropDownValue("{$name}", true)'>
			               {$editImage}</a>
			               &nbsp;
			               <a href='javascript:void(0)' onclick='SimpleList.deleteDropDownValue("{$name}", true)'>
			               {$deleteImage}</a>
			           </td>
			        </tr>
			      </table>
			    </li>
			{/foreach}
		   </ul>
		</td>
	</tr>
	<tr>
		<td colspan='3'>
		   <table width='100%'>
		    	<tr>
		    		<td class='mbLBLL'>{$MOD.LBL_DROPDOWN_ITEM_NAME}:</td><td class='mbLBLL'>{$MOD.LBL_DROPDOWN_ITEM_LABEL}:</td>
		    	</tr>
		    	<tr>
		    		<td><input type='text' id='drop_name' name='drop_name' maxlength='100'></td>
		    		<td><input type='text' id='drop_value' name='drop_value'></td>
		    	</tr>
		    	<tr><td><input type='button' id='dropdownaddbtn' value='{$APP.LBL_ADD_BUTTON}' class='button'></td></tr>
		    </table>
   		</td>
   	</tr>
   	<tr>
   		<td colspan='3'>
   			<input type='button' class='button' value='{$MOD.LBL_BTN_SORT_ASCENDING}' onclick='SimpleList.sortAscending()'>
   			<input type='button' class='button' value='{$MOD.LBL_BTN_SORT_DESCENDING}' onclick='SimpleList.sortDescending()'>
   		</td>
   	</tr>
  </table>
  </form>
  {literal}
<script>
addForm('dropdown_form');
addToValidate('dropdown_form', 'dropdown_name', 'DBName', false, SUGAR.language.get("ModuleBuilder", "LBL_JS_VALIDATE_NAME"));
addToValidate('dropdown_form', 'drop_value', 'varchar', false, SUGAR.language.get("ModuleBuilder", "LBL_JS_VALIDATE_LABEL"));
eval({/literal}{$ul_list}{literal});
SimpleList.name = {/literal}'{$dropdown_name}'{literal};
SimpleList.requiredOptions = {/literal}{$required_items}{literal};
SimpleList.ul_list = list;
SimpleList.init({/literal}'{$editImage}'{literal}, {/literal}'{$deleteImage}'{literal});
ModuleBuilder.helpSetup('dropdowns','editdropdown');

var addListenerFields = ['drop_name','drop_value' ]
YAHOO.util.Event.addListener(addListenerFields,"keydown", function(e){
	if (e.keyCode == 13) {
		YAHOO.util.Event.stopEvent(e);
	}
});

</script>
<script>// Bug in FF4 where it doesn't run the last script. Remove when the bug is fixed.</script>
{/literal}
</div>

