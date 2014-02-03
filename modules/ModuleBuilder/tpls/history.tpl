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
<table class="tabform" ><tr><th>{sugar_translate label='LBL_HISTORY_TIMESTAMP' module='ModuleBuilder'}</th><th>&nbsp;</th><th>&nbsp;</th></tr>
{if empty($snapshots)}
	<tr><td class='mbLBLL'>{sugar_translate label='ERROR_NO_HISTORY' module='ModuleBuilder'}</td></tr>
{/if}
{foreach from=$snapshots item='timestamp' key='id'}
<tr>
	<td class="oddListRowS1"><a onclick="ModuleBuilder.history.preview('{$view_module}', '{$view}', '{$id}', '{$subpanel}');" href="javascript:void(0);">
	{$timestamp}</a></td>
	<td width="1%"><input type='button' value="{sugar_translate label='LBL_MB_PREVIEW' module='ModuleBuilder'}" onclick="ModuleBuilder.history.preview('{$view_module}', '{$view}', '{$id}', '{$subpanel}');"/></td>
	<td width="1%"><input type='button' value="{sugar_translate label='LBL_MB_RESTORE' module='ModuleBuilder'}" onclick="ModuleBuilder.history.revert('{$view_module}', '{$view}', '{$id}', '{$subpanel}');"/></td>
</tr>
{/foreach}
</table>