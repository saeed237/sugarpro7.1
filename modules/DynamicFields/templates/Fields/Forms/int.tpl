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
<script>
formsWithFieldLogic=null;
</script>

{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td><td>
	{if $hideLevel < 5}
		<input type='text' name='default' id='int_default' value='{$vardef.default}'>
		<script>addToValidate('popup_form', 'default', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}' );</script>
	{else}
		<input type='hidden' name='default' id='int_default' value='{$vardef.default}'>{$vardef.default}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MIN_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='min' id='int_min' value='{$vardef.validation.min}'>
		<script>addToValidate('popup_form', 'min', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MIN_VALUE"}' );</script>
	{else}
		<input type='hidden' name='min' id='int_min' value='{$vardef.validation.min}'>{$vardef.range.min}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='max' id='int_max' value='{$vardef.validation.max}'>
		<script>addToValidate('popup_form', 'max', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_VALUE"}' );</script>
	{else}
		<input type='hidden' name='max' id='int_max' value='{$vardef.validation.max}'>{$vardef.range.max}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='len' id='int_len' value='{$vardef.len|default:11}'></td>
		<script>addToValidate('popup_form', 'len', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}' );</script>
	{else}
		<input type='hidden' name='len' id='int_len' value='{$vardef.len}'>{$vardef.len}
	{/if}
	</td>
</tr>
{if $range_search_option_enabled}
<tr>	
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_ENABLE_RANGE_SEARCH"}:</td>
    <td>
        <input type='checkbox' name='enable_range_search' value=1 {if !empty($vardef.enable_range_search) }checked{/if} {if $hideLevel > 5}disabled{/if} />
        {if $hideLevel > 5}<input type='hidden' name='enable_range_search' value='{$vardef.enable_range_search}'>{/if}
    </td>	
</tr>
{/if}
{*  
<!-- REMOVING THIS FOR 6.0, but need to allow for people create auto_increment fields and have to add appropriate indexes if in strict mode.
<tr>
    <td class='mbLBL'>Auto Increment:</td>
    <td>
        <input type='checkbox' name='autoinc' id='autoinc' value=1 {if !empty($vardef.auto_increment) }checked{/if} 
        {if $hideLevel > 2 || !$allowAutoInc} disabled{/if} 
        onclick="document.getElementById('auto_increment').value = this.checked;document.getElementById('autoinc_start_wrap').style.display = this.checked ? '' : 'none';">
        <input type='hidden' name='auto_increment' id='auto_increment' value='{if !empty($vardef.auto_increment) }true{else}false{/if}'>
    </td>
</tr>
-->
*}
{if !empty($vardef.auto_increment) }
<tr id="autoinc_start_wrap" {if empty($vardef.auto_increment) }style="display:none" {/if}>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_AUTOINC_NEXT"}:</td>
    <td>
        <input type='hidden' name='auto_increment' id='auto_increment' value='true'>
		<input type='text' name='autoinc_next' id='autoinc_next' value='{$vardef.autoinc_next|default:1}' {if $MB}disabled=1{/if}>
        <script>addToValidateMoreThan('popup_form', 'autoinc_next', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_AUTOINC_NEXT"}', {$vardef.autoinc_next|default:1});</script>
        <input type='hidden' name='autoinc_val_changed' id='autoinc_val_changed' value='false'>
    </td>
</tr>
{/if}
<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_DISABLE_NUMBER_FORMAT"}:</td>
    <td>
        <input type='checkbox' name='ext3' value=1 {if !empty($vardef.disable_num_format) }checked{/if} {if $hideLevel > 5}disabled{/if} />
        {if $hideLevel > 5}<input type='hidden' name='ext3' value='{$vardef.disable_num_format}'>{/if}
    </td>
</tr>
<script>
	formsWithFieldLogic=new addToValidateFieldLogic('popup_form_id', 'int_min', 'int_max', 'int_default', 'int_len', 'int', 'Invalid Logic.');
</script>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}