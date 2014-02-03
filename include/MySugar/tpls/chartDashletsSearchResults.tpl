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
<h4>{$lblSearchResults} - <i>{$searchString}</i>:</h4>
<hr>
{if count($charts)}
<h3>{sugar_translate label='LBL_BASIC_CHARTS' module='Home'}</h3>
<table width="100%">
	{foreach from=$charts item=chart}
	<tr>
		<td width="100%" align="left"><a href="javascript:void(0)" onclick="{$chart.onclick}">{$chart.icon}</a>&nbsp;<a class="mbLBLL" href="#" onclick="{$chart.onclick}">{$chart.title}</a><br /></td>
	</tr>
	{/foreach}
</table>
{/if}
{if count($myFavoriteReports)}
<h3>{sugar_translate label='LBL_MY_FAVORITE_REPORT_CHARTS' module='Home'}</h3>
<table width="100%">
	{foreach from=$myFavoriteReports item=chart}
	<tr>
		<td width="100%" align="left">&nbsp;<a class="mbLBLL" href="javascript:void(0)" onclick="{$chart.onclick}">{$chart.title}</a><br /></td>
	</tr>
	{/foreach}
</table>
{/if}
{if count($mySavedReports)}
<h3>{sugar_translate label='LBL_MY_SAVED_REPORT_CHARTS' module='Home'}</h3>
<table width="100%">
	{foreach from=$mySavedReports item=chart}
	<tr>
		<td width="100%" align="left">&nbsp;<a class="mbLBLL" href="javascript:void(0)" onclick="{$chart.onclick}">{$chart.title}</a><br /></td>
	</tr>
	{/foreach}
</table>
{/if}
{if count($myTeamReports)}
<h3>{sugar_translate label='LBL_MY_TEAM_REPORT_CHARTS' module='Home'}</h3>
<table width="100%">
	{foreach from=$myTeamReports item=chart}
	<tr>
		<td width="100%" align="left">&nbsp;<a class="mbLBLL" href="javascript:void(0)" onclick="{$chart.onclick}">{$chart.title}</a><br /></td>
	</tr>
	{/foreach}
</table>
{/if}
{if count($globalReports)}
<h3>{sugar_translate label='LBL_GLOBAL_REPORT_CHARTS' module='Home'}</h3>
<table width="100%">
	{foreach from=$globalReports item=chart}
	<tr>
		<td width="100%" align="left">&nbsp;<a class="mbLBLL" href="javascript:void(0)" onclick="{$chart.onclick}">{$chart.title}</a><br /></td>
	</tr>
	{/foreach}
</table>
{/if}
