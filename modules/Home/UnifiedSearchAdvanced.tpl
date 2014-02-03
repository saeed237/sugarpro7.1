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

<form name='UnifiedSearchAdvanced' method='get'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='query_string' value=''>
<input type='hidden' name='advanced' value='true'>
<input type='hidden' name='action' value='UnifiedSearch'>
<input type='hidden' name='search_form' value='false'>

<table border="0" class="actionsContainer">
<tr><td>
<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" type="submit" class="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.UnifiedSearchAdvanced.action.value='index'; document.UnifiedSearchAdvanced.module.value='Administration';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
</td></tr>
</table>

<table width='600' class='edit view' border='0' cellpadding='0' cellspacing='1'>
{foreach from=$MODULES_TO_SEARCH name=m key=module item=info}
{if $smarty.foreach.m.first}
	<tr style='padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px'>
{/if}
	<td width='1' style='border: none; padding: 0px 10px 0px 0px; margin: 0px 0px 0px 0px'>
		<input class='checkbox' id='cb_{$module}' type='checkbox' name='search_mod_{$module}' value='true' {if $info.checked}checked{/if}>
	</td>
	<td style='border: none; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px; cursor: hand; cursor: pointer' onclick="document.getElementById('cb_{$module}').checked = !document.getElementById('cb_{$module}').checked;">
		{$info.translated}
	</td>
{if $smarty.foreach.m.index % 2 == 1}
	</tr><tr style='padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px'>
{/if}
{/foreach}
</tr>
</table>

<table border="0" class="actionsContainer">
<tr><td>
<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" type="submit" class="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.UnifiedSearchAdvanced.action.value='index'; document.UnifiedSearchAdvanced.module.value='Administration';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
</td></tr>
</table>
</form>