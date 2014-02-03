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


<table width="100%"><tr><td class='mbLBL' width='30%' >{sugar_translate module="DynamicFields" label="COLUMN_TITLE_NAME"}:</td><td >
{if $hideLevel == 0}
	<input id="field_name_id" type="hidden" name="name" value="parent_name"/>parent_name
{else}
	<input id= "field_name_id" type="hidden" name="name" value="{$vardef.name}"/>{$vardef.name}{/if}
<script>

	addToValidate('popup_form', 'name', 'DBName', true,'{sugar_translate module="DynamicFields" label="COLUMN_TITLE_NAME"} [a-zA-Z_]' );
	addToValidateIsInArray('popup_form', 'name', 'in_array', true,'{sugar_translate module="DynamicFields" label="ERR_RESERVED_FIELD_NAME"}', '{$field_name_exceptions}', '==');

</script>
</td></tr>
<tr>
	<td class='mbLBL' >{sugar_translate module="DynamicFields" label="COLUMN_TITLE_LABEL"}:</td>
	<td>
	{if $hideLevel < 5}
		<input id ="label_key_id" type="text" name="label" value="{$vardef.vname}">
	{else}
		<input id ="label_key_id" type="hidden" name="label" value="{$vardef.vname}">{$vardef.vname}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL' >{sugar_translate module="DynamicFields" label="COLUMN_TITLE_LABEL_VALUE"}:</td>
	<td>
		<input id="label_value_id" type="text" name="labelValue" value="{$lbl_value}">
	</td>
</tr>
<tr>
	<td class='mbLBL' >{sugar_translate module="DynamicFields" label="COLUMN_TITLE_HELP_TEXT"}:</td>
	<td>
	{if $hideLevel < 5 }
		<input type="text" name="help" value="{$vardef.help}">
	{else}
		<input type="hidden" name="help" value="{$vardef.help}">{$vardef.help}
	{/if}
	</td>
</tr>
<script>
	if(document.getElementById('label_key_id').value == '')
		document.getElementById('label_key_id').value = 'LBL_FLEX_RELATE';
	if(document.getElementById('label_value_id').value == '')
		document.getElementById('label_value_id').value = 'Flex Relate';
</script>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}
