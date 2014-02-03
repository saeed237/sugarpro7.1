
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
<hr />
<!-- Activities for the day -->
{if $todays_activities}
<div class="sectitle">{sugar_translate label='LBL_TODAYS_ACTIVITIES' module=''}</div>
{foreach from=$activities_today item=data key=module}
	<div class="subpanel_sec">{$module}:</div>
	<ul class="sec">
	{foreach from=$data item=activity name="activitylist"}
	{assign var="activity_image" value=$module}
	{assign var="dotgif" value=".gif"}	
	<li class="{if $smarty.foreach.activitylist.index % 2 == 0}odd{else}even{/if}">
        <a href=index.php?module={$module}&action=wirelessdetail&record={$activity.ID}>{sugar_getimage name=$activity_image$dotgif alt=$activity_image other_attributes='border="0" '}&nbsp;
        {$activity.NAME}</a>
    </li>
	{/foreach}
	</ul>
{/foreach}
{/if}
<!-- Last Viewed -->
{if $last_viewed}
<div class="sectitle">{$LBL_LAST_VIEWED}</div>
<ul class="sec">
	{foreach from=$LAST_VIEWED_LIST item=LAST_VIEWED key=ID name="recordlist"}
	{assign var="module_image" value=$LAST_VIEWED.module}
	{assign var="dotgif" value=".gif"}
	<li class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
        <a href=index.php?module={$LAST_VIEWED.module}&action=wirelessdetail&record={$ID}>{sugar_getimage name=$module_image$dotgif alt=$module_image other_attributes='border="0" '}&nbsp;
        {$LAST_VIEWED.summary}</a>
    </li>
	{/foreach}
</ul>
{/if}