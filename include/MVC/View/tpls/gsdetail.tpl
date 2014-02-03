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
<style>
{literal}
.searchHighlight{
    background-color: #FFFF00;
}

.detail_label{
	color:#666666;
	font-weight:bold;
}
.odd {
    background-color: #f6f6f6;
}
.even {
    background-color: #eeeeee;
}
div.sec .odd a, div.sec .even a {
    font-size: 12px;
}
#gsdetail_div {
    overflow-x:auto;
}
{/literal}
</style>
<!-- Global Search Detail View -->
<div id="gsdetail_div">
<div><h3>{$BEAN_NAME}</h3></div>
<br>
<div style="height:325px;width:300px" >
<table>
	{foreach from=$DETAILS item=DETAIL name="recordlist"}
	{if !$fields[$DETAIL.field].hidden}
    <tr>
		<td class="detail_label {if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">{$DETAIL.label|strip_semicolon}:</td>
		<td class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
		{if !empty($DETAIL.customCode)}
            {eval var=$DETAIL.customCode}
        {else}
            {sugar_field parentFieldArray='fields' vardef=$fields[$DETAIL.field] displayType='wirelessDetailView' displayParams='' typeOverride=$DETAIL.type}
        {/if}
		</td>
	</tr>
    {/if}
	{/foreach}
	<tr><td>&nbsp;<td></tr>
	<tr>
	<td colspan="2">
	<h3>{$LBL_GS_HELP}</h3>
	</td>
	</tr>
</table>
</div>
<div style="padding-right:200px">
</div>
</div>
