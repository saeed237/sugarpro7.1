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


{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
<input type=hidden id='ext3' name='ext3' value='{$vardef.gen}'>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_GENERATE_URL"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='checkbox' id='gencheck' {if $vardef.gen}checked=true{/if} name='genCheck' value="0" onclick="
			if(this.checked) {ldelim}
				 YAHOO.util.Dom.setStyle('fieldListHelper', 'display', '');
				 YAHOO.util.Dom.get('ext3').value = 1;
				 addToValidate('popup_form', 'default', 'alphanumeric', true,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}' );
			{rdelim} else {ldelim}
		        YAHOO.util.Dom.setStyle('fieldListHelper', 'display', 'none');
		        YAHOO.util.Dom.get('ext3').value = 0;
				removeFromValidate('popup_form', 'default');
			{rdelim}">
	{else}
		<input type='checkbox' name='ext3' {if $vardef.gen}checked=true{/if} disabled>
	{/if}
	</td>
</tr>
<tr id='fieldListHelper' {if !$vardef.gen}style="display:none"{/if}>
	<td></td>
	<td>{html_options name="flo" id="fieldListOptions" options=$fieldOpts}
		<input type='button' class='button' value="Insert Field" onclick="
			YAHOO.util.Dom.get('default').value += '{ldelim}' + YAHOO.util.Dom.get('fieldListOptions').value + '{rdelim}'
		"></td> 
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='default' id='default' value='{$vardef.default}' maxlength='{$vardef.len|default:50}'>
	{else}
		<input type='hidden' id='default' name='default' value='{$vardef.default}'>{$vardef.default}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='len' value='{$vardef.len|default:25}' onchange="forceRange(this,1,255);changeMaxLength(document.getElementById('default'),this.value);">
		{literal}
		<script>
		function forceRange(field, min, max){
			field.value = parseInt(field.value);
			if(field.value == 'NaN')field.value = max;
			if(field.value > max) field.value = max;
			if(field.value < min) field.value = min;
		}
		function changeMaxLength(field, length){
			field.maxLength = parseInt(length);
			field.value = field.value.substr(0, field.maxLength);
		}
		</script>
		{/literal}
	{else}
		<input type='hidden' name='len' value='{$vardef.len}'>{$vardef.len}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_FRAME_HEIGHT"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='ext4' value='{$vardef.height|default:200}' onchange="forceRange(this,100,1024);">
	{else}
		<input type='hidden' name='ext4' value='{$vardef.height}'>{$vardef.height}
	{/if}
	</td>
</tr>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}