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
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000"></div>
{literal}
<script>
addForm('popup_form');
</script>
{/literal}

<form name='popup_form' id='popup_form_id' onsubmit='return false;'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='{$action}'>
<input type='hidden' name='new_dropdown' value=''>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='view_module' value='{$module->name}'>
{if isset($package->name)}
    <input type='hidden' name='view_package' value='{$package->name}'>
{/if}
<input type='hidden' name='is_update' value='true'>
	{if $hideLevel < 5}
	    &nbsp;
	    <input type='button' class='button' name='fsavebtn' value='{$mod_strings.LBL_BTN_SAVE}' 
			onclick='{literal}if(validate_type_selection() && check_form("popup_form")){ {/literal}{$preSave} {literal}ModuleBuilder.submitForm("popup_form_id"); }{/literal}'>
	    <input type='button' name='cancelbtn' value='{$mod_strings.LBL_BTN_CANCEL}' 
			onclick='ModuleBuilder.tabPanel.removeTab(ModuleBuilder.findTabById("east"));' class='button'>
	    {if !empty($vardef.name)}
	        {if $hideLevel < 3}
	        {literal}
	            &nbsp;<input type='button' class='button' name='fdeletebtn' value='{/literal}{$mod_strings.LBL_BTN_DELETE}{literal}' onclick='if(confirm("{/literal}{$mod_strings.LBL_CONFIRM_FIELD_DELETE}{literal}")){document.popup_form.action.value="DeleteField";ModuleBuilder.submitForm("popup_form_id");}'>
	        {/literal}
	        {/if}
	        {if !$no_duplicate}
	        {literal}
	        &nbsp;<input type='button' class='button' name='fclonebtn' value='{/literal}{$mod_strings.LBL_BTN_CLONE}{literal}' onclick='document.popup_form.action.value="CloneField";ModuleBuilder.submitForm("popup_form_id");'>
	        {/literal}
	    {/if}
	    {/if}
	
	{else}
	    {literal}
	     <input type='button' class='button' name='lsavebtn' value='{/literal}{$mod_strings.LBL_BTN_SAVE}{literal}' onclick='if(check_form("popup_form")){this.form.action.value = "{/literal}{$action}{literal}";ModuleBuilder.submitForm("popup_form_id")};'>
	    {/literal}
	    {literal}
	        &nbsp;<input type='button' class='button' name='fclonebtn' value='{/literal}{$mod_strings.LBL_BTN_CLONE}{literal}' onclick='document.popup_form.action.value="CloneField";ModuleBuilder.submitForm("popup_form_id");'>
	     {/literal}
		 {literal}
	        &nbsp;<input type='button' class='button' name='cancel' value='{/literal}{$mod_strings.LBL_BTN_CANCEL}{literal}' onclick='ModuleBuilder.tabPanel.get("activeTab").close()'>
	        {/literal}
	        
{/if}
<hr>

<table width="400px" >
<tr>
    <td class="mbLBL" style="width:92px;">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DATA_TYPE"}:</td>
    <td >{if empty($vardef.name) && $isClone == 0}
                {html_options name="type" id="type"  options=$field_types selected=$vardef.type onchange='ModuleBuilder.moduleLoadField("", this.options[this.selectedIndex].value);'}
                {sugar_help text=$mod_strings.LBL_POPHELP_FIELD_DATA_TYPE FIXX=250 FIXY=80}
            {else}
                {$field_types[$vardef.type]}
            {/if}
            {if empty($field_types[$vardef.type]) && !empty($vardef.type)}({$vardef.type}){/if}
            <input type='hidden' name='type' value={$vardef.type} />
    </td>
</tr>
</table>
{$fieldLayout}
</form>

<script>
{literal}
function validate_type_selection(){
    var typeSel = document.getElementById('type');
    if(typeSel && typeSel.options){
        if(typeSel.options[typeSel.selectedIndex].value == ''){
            alert('{/literal}{sugar_translate module="DynamicFields" label="ERR_SELECT_FIELD_TYPE"}{literal}');
            return false;
        }
    }
    if (document.getElementById("customTypeValidate")){
        return document.getElementById("customTypeValidate").onchange(); 
    }
    return true;
}
{/literal}
ModuleBuilder.helpSetup('fieldsEditor','{$help_group}');
</script>
{* <script>//Need this to work in FF4. Bug where last script isn't executed.</script> *}
