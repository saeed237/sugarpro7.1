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
<div id="{$source_id}_add_tables" class="sources_table_div">
{foreach from=$display_data key=module item=data}

<table border="0">
<tr>
<td colspan="2"><span><font size="3">{sugar_translate label=$module}</font></span></td></tr>
<tr>
<td width="150px"><b>{$mod.LBL_CONNECTOR_FIELDS}</b></td>
<td><b>{$mod.LBL_MODULE_FIELDS}</b></td>
</tr>
</table>

<table border="0" name="{$module}" id="{$module}" class="mapping_table">
<tr>
<td colspan="2">
{foreach from=$data.field_keys key=field_id item=field}
{if $field_id != 'id'}
<div id="{$source_id}:{$module}:{$field}_div" style="width:500px; display:block; cursor:pointer">
<table border="0" cellpadding="1" cellspacing="1">
<tr>
<td width="150px">
{$field}
</td>
<td>
<select id="{$source_id}:{$module}:{$field_id}">
<option value="">---</option>
{foreach from=$data.available_fields key=available_field_id item=available_field}
<option value="{$available_field_id}" {if $data.field_mapping.$field_id == $available_field_id}SELECTED{/if}>{$available_field}</option>
{/foreach}
</select>
</td>
</tr>
</table>
</div>
{/if}
{/foreach}
</td>
</tr>
</table>

<hr/>
{/foreach}
</div>

{if $empty_mapping}
<h3>{$mod.ERROR_NO_SEARCHDEFS_DEFINED}</h3>
{/if}

