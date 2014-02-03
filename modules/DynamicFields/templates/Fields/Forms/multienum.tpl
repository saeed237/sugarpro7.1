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
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="LBL_DROP_DOWN_LIST"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name="ext1" id="ext1" selected=$cf.ext1 values=$dropdowns output=$dropdowns onChange="dropdownChanged(this.value);"}
	{else}
		<input type='hidden' name='ext1' value='$cf.ext1'>{$cf.ext1}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name="default_value" id="default_value" selected=$cf.default_value options=$selected_dropdown }
	{else}
		<input type='hidden' name='default_value' value='$cf.default_value'>{$cf.default_value}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DISPLAYED_ITEM_COUNT"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type='text' name='ext2' id='ext2' value='{$cf.ext2|default:5}'>
		<script>addToValidate('popup_form', 'ext2', 'int', false,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DISPLAYED_ITEM_COUNT"}' );</script>
	{else}
		<input type='hidden' name='ext2' value='{$cf.ext2}'>{$cf.ext2}
	{/if}
	</td>
</tr>
<tr>
	<td nowrap="nowrap">{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MASS_UPDATE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type="checkbox" name="mass_update" value="1" {if !empty($cf.mass_update)}checked{/if}/>
	{else}
		<input type="checkbox" name="mass_update" value="1" disabled {if !empty($cf.mass_update)}checked{/if}/>
	{/if}
	</td>
</tr>

{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}
<script>dropdownChanged(document.getElementById('ext1').options[document.getElementById('ext1').options.selectedIndex]);</script>

