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
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' id='default' name='default' value='{$vardef.default}'>
		<script>
		addToValidate('popup_form', 'default', 'float', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}' );
		formWithPrecision = new addToValidatePrecision('popup_form_id', 'default', 'precision');
		</script>
	{else}
		<input type='hidden' name='default' id='default' value='{$vardef.default}'>{$vardef.default}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='len' value='{$vardef.len|default:18}'></td>
		<script>addToValidate('popup_form', 'len', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MAX_SIZE"}' );</script>
	{else}
		<input type='hidden' name='len' value='{$vardef.len}'>{$vardef.len}
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
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_PRECISION"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' id='precision' name='precision' value='{$vardef.precision|default:0}'>
		<script>addToValidate('popup_form', 'ext1', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_PRECISION"}' );</script>
	{else}
		<input type='hidden' name='precision' value='{$vardef.precision}'>{$vardef.precision}
	{/if}
	</td>
</tr>

{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}