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
<table class="h3Row" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td nowrap>
<h3>{$mod.LBL_MODIFY_SEARCH}</h3></td><td width='100%'>
<IMG height='1' width='1' src='include/images/blank.gif' alt=''>
</td>
</tr>
</table>
<form name='SearchForm' method='POST' id='SearchForm'>
 	<input type='hidden' name='source_id' id='source_id' value='{$source_id}' />
 	<input type='hidden' name='merge_module' value='{$module}' />
 	<input type='hidden' name='record' value='{$RECORD}' />
 	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tabForm">
{if !empty($search_fields) }
 	<tr>
 	 {counter assign=field_count start=0 print=0} 
	 {foreach from=$search_fields key=field_name item=field_value} 
	 	{counter assign=field_count}
		{if ($field_count % 3 == 1 && $field_count != 1)}
		</tr><tr>
		{/if}
		<td nowrap="nowrap" width='10%' class="dataLabel">
		{$field_value.label}: 
		</td>
		<td nowrap="nowrap" width='30%' class="dataField">
		<input type='text' onkeydown='checkKeyDown(event);' name='{$field_name}' value='{$field_value.value}'/>
		</td>
	 {/foreach}
{else}
     {$mod.ERROR_NO_SEARCHDEFS_MAPPING}
{/if}
</table>
<input type='button' name='btn_search' id='btn_search' title="{$APP.LBL_SEARCH_BUTTON_LABEL}" accessKey="{$APP.LBL_SEARCH_BUTTON_KEY}" class="button" onClick="javascript:SourceTabs.search();" value="      {$APP.LBL_SEARCH_BUTTON_LABEL}      "/>&nbsp;
<input type='button' name='btn_clear' title="{$APP.LBL_CLEAR_BUTTON_LABEL}" class="button" onClick="javascript:SourceTabs.clearForm();" value="{$APP.LBL_CLEAR_BUTTON_LABEL}"/>
</form>