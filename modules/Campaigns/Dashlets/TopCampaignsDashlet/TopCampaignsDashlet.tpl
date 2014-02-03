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


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="list view">
	<tr>
		<th>&nbsp;</td>
		<th align="center">{$lbl_campaign_name}</td>
		<th align="center">{$lbl_revenue}</td>
	</tr>
	{counter name="num" assign="num"}
	{foreach from=$top_campaigns item="campaign"}
	<tr>
		<td class="oddListRowS1" align="center" valign="top" width="6%">{$num}.</td>
		<td class="oddListRowS1" align="left" valign="top" width="74%"><a href="index.php?module=Campaigns&action=DetailView&record={$campaign.campaign_id}">{$campaign.campaign_name}</a></td>
		<td class="oddListRowS1" align="left" valign="top" width="20%">{$campaign.revenue}</td>
	</tr>
	{counter name="num"}
	{/foreach}
</table>
