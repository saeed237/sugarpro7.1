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
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_LABEL_ROWS"}:</td>
	<td>
	{if $hideLevel < 4}
		<input id ="rows" type="text" name="rows" value="{$vardef.rows|default:4}">
	{else}
		<input id ="rows" type="hidden" name="rows" value="{$vardef.rows}">{$vardef.rows}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_LABEL_COLS"}:</td>
	<td>
	{if $hideLevel < 4}
		<input id ="cols" type="text" name="cols" value="{$vardef.cols|default:20}">
	{else}
		<input id ="cols" type="hidden" name="cols" value="{$vardef.displayParams.cols}">{$vardef.cols}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		<textarea name='default' id='default' >{$vardef.default}</textarea>
	{else}
		<textarea name='default' id='default' disabled >{$vardef.default}</textarea>
		<input type='hidden' name='default' value='{$vardef.default}'/>
	{/if}
	</td>
</tr>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}