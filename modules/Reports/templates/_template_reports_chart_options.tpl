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

<span id="no_chart_text">{$mod_strings.LBL_GROUP_BY_REQUIRED}</span>
<span scope="row"><h5>{$mod_strings.LBL_CHART_TYPE}:</h5></span>
<table width="100%" cellpadding=0 cellspacing=0>
<tr>
<td align=left>
<select name='chart_type'>
{foreach from=$chart_types key=thekey item=theval}
<option value="{$thekey}" {if $report_def.chart_type eq $thekey} "SELECTED" {/if}>{$theval}</option>
{/foreach}
</select>
</td>
</tr>
</table>
<P/>
<span scope="row"><h5>{$mod_strings.LBL_USE_COLUMN_FOR}:</h5></span>
<table width="100%" cellpadding=0 cellspacing=0>
<tr>
<td align=left>
<select name='numerical_chart_column'>
</select>
</td>
</tr>
</table>
<P/>
<span scope="row"><h5>{$mod_strings.LBL_CHART_DESCRIPTION}:</h5></span>
<table width="100%" cellpadding=0 cellspacing=0>
<tr>
<td align=left>
<input name='chart_description' size='50' value="{$chart_description}" maxsize="255"/>
</td>
</tr>
</table>