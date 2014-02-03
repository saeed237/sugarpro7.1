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
<form name="TrackerSettings" method="POST">
<input type="hidden" name="action" value="TrackerSettings">
<input type="hidden" name="module" value="Trackers">
<input type="hidden" name="process" value="">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
<tr>
<td scope="row" width="100%" colspan="2">
<input type="button" onclick="document.TrackerSettings.process.value='true'; if(check_form('TrackerSettings')) {ldelim} document.TrackerSettings.submit(); {rdelim}" class="button primary" title="{$app.LBL_SAVE_BUTTON_TITLE}" accessKey="{$app.LBL_SAVE_BUTTON_KEY}" value="{$app.LBL_SAVE_BUTTON_LABEL}">
<input type="button" onclick="document.TrackerSettings.process.value='false'; document.TrackerSettings.submit();" class="button" title="{$app.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$app.LBL_CANCEL_BUTTON_KEY}" value="{$app.LBL_CANCEL_BUTTON_LABEL}">
</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
<tr>
<td scope="row" width="50%">&nbsp;</td>
<td scope="row" width="50%">{$mod.LBL_ENABLE}</td>
</tr>
{foreach name=trackerEntries from=$trackerEntries key=key item=entry}
<tr>
<td scope="row" width="50%">{$entry.label}:&nbsp;{sugar_help text=$entry.helpLabel}</td>
<td  width="50%"><input type="checkbox" id="{$key}" name="{$key}" value="1" {if !$entry.disabled}CHECKED{/if}>
</tr>
{/foreach}
<tr>
<td scope="row">{$mod.LOG_SLOW_QUERIES}:</td>
{if !empty($config.dump_slow_queries)}
	{assign var='dump_slow_queries_checked' value='CHECKED'}
{else}
	{assign var='dump_slow_queries_checked' value=''}
{/if}
<td ><input type='hidden' name='dump_slow_queries' value='false'><input name='dump_slow_queries'  type="checkbox" value='true' {$dump_slow_queries_checked}></td>
</tr>

<tr>
<td scope="row" width="20%">{$mod.LBL_TRACKER_PRUNE_INTERVAL}</td>
<td><input type='text' id='tracker_prune_interval' name='tracker_prune_interval' size='5' value='{$tracker_prune_interval}'></td>
</tr>
<tr>
<td scope="row">{$mod.SLOW_QUERY_TIME_MSEC}: </td>
<td >
<input type='text' size='5' name='slow_query_time_msec' value='{$config.slow_query_time_msec}'>
</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td scope="row" width="100%" colspan="2">
<input type="button" onclick="document.TrackerSettings.process.value='true'; if(check_form('TrackerSettings')) {ldelim} document.TrackerSettings.submit(); {rdelim}" class="button primary" title="{$app.LBL_SAVE_BUTTON_TITLE}" value="{$app.LBL_SAVE_BUTTON_LABEL}">
<input type="button" onclick="document.TrackerSettings.process.value='false'; document.TrackerSettings.submit();" class="button" title="{$app.LBL_CANCEL_BUTTON_TITLE}"  value="{$app.LBL_CANCEL_BUTTON_LABEL}">
</td>
</tr>
</table>
</form>


<script type="text/javascript">
addToValidate('TrackerSettings', 'tracker_prune_interval', 'int', true, "{$mod.LBL_TRACKER_PRUNE_RANGE}");
addToValidateRange('TrackerSettings', 'tracker_prune_interval', 'range', true, '{$mod.LBL_TRACKER_PRUNE_RANGE}', 1, 180);
addToValidate('TrackerSettings', 'slow_query_time_msec', 'int', true, "{$mod.SLOW_QUERY_TIME_MSEC}");
</script>