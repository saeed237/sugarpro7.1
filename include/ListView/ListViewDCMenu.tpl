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
<script type="text/javascript">
{literal}
function submitListViewDCMenu(submitElem) {
var callback = {
success: function(o) {
var contentElem = document.getElementById('dcSearch');
while ( typeof(contentElem) != 'undefined' && contentElem.className != 'dccontent' ) {
contentElem = contentElem.parentNode;
}
contentElem.innerHTML = o.responseText;
},
failure: function(o) {
// AJAX failed, we have probably timed out of our session, force a reload
window.history.go(0);
}
};

YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, "module=Meetings&action=listbytype&button=Search&name_basic="+document.getElementById('dcSearch').value);

}
{/literal}
</script>
<form id="dcSearchForm">
<table class='dcSearch' cellpadding='0' cellspacing='0'>
			<tr>
			<td>
			<input type='text' id='dcSearch' name='dcSearch' value="{$DCSEARCH}">
			</td>
			<td>
			<input type='submit' name='submit' class='dcSubmit' value='Search Meetings' onclick="submitListViewDCMenu(this); return false;">
			</td>
			</tr>
		</table>
</form>		
		<table width='500' class='dcListView' cellpadding='0' cellspacing='0'>
<tr height='20'>
		{if $prerow}
			<th scope='col' nowrap="nowrap" width='1%' class="selectCol">
				<div>
			        <input type='checkbox'  title="{sugar_translate label='LBL_SELECT_ALL_TITLE'}"  class='checkbox' name='massall' id='massall' value='' onclick='sListView.check_all(document.MassUpdate, "mass[]", this.checked);' />
				{$selectLink}
				</div>
			</th>
		{/if}
		{if $favorites}
		<th scope='col'>
				&nbsp;
		</th>
		{/if}
		{if !empty($quickViewLinks)}
		<th scope='col' width='1%' style="padding: 0px;">&nbsp;</th>
		{/if}
		{counter start=0 name="colCounter" print=false assign="colCounter"}
		{foreach from=$displayColumns key=colHeader item=params}
			<th scope='col' width='{$params.width}%'>
				<div style='white-space: normal;'width='100%' align='{$params.align|default:'left'}'>
                {if false}
                    {if $params.url_sort}
                        <a href='{$pageData.urls.orderBy}{$params.orderBy|default:$colHeader|lower}' class='listViewThLinkS1' title="{$arrowAlt}">
                    {else}
                        {if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
                            <a href='javascript:sListView.order_checks("{$pageData.ordering.sortOrder|default:ASCerror}", "{$params.orderBy|default:$colHeader|lower}" , "{$pageData.bean.moduleDir}2_{$pageData.bean.objectName|upper}_ORDER_BY");' class='listViewThLinkS1' title="{$arrowAlt}">
                        {else}
                            <a href='javascript:sListView.order_checks("ASC", "{$params.orderBy|default:$colHeader|lower}" , "{$pageData.bean.moduleDir}2_{$pageData.bean.objectName|upper}_ORDER_BY");' class='listViewThLinkS1' title="{$arrowAlt}">
                        {/if}
                    {/if}
                    {sugar_translate label=$params.label module=$pageData.bean.moduleDir}
					&nbsp;&nbsp;
					{if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
						{if $pageData.ordering.sortOrder == 'ASC'}
							{capture assign="imageName"}arrow_down.{$arrowExt}{/capture}
                            {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT_DESC'}{/capture}
							{sugar_getimage name="$imageName" width="$arrowWidth" height="$arrowHeight" attr='align="absmiddle" border="0" ' alt="$alt_sort"}
						{else}
							{capture assign="imageName"}arrow_up.{$arrowExt}{/capture}
                            {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT_ASC'}{/capture}
							{sugar_getimage name="$imageName" width="$arrowWidth" height="$arrowHeight" attr='align="absmiddle" border="0" ' alt="$alt_sort"}
						{/if}
					{else}
						{capture assign="imageName"}arrow.{$arrowExt}{/capture}
                        {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT'}{/capture}
						{sugar_getimage name="$imageName" width="$arrowWidth" height="$arrowHeight" attr='align="absmiddle" border="0" ' alt="$alt_sort"}
					{/if}
                    </a>
				{else}
                    {if !isset($params.noHeader) || $params.noHeader == false} 
					  {sugar_translate label=$params.label module=$pageData.bean.moduleDir}
                    {/if}
				{/if}
				</div>
			</th>
			{counter name="colCounter"}
		{/foreach}
	</tr>
	
	
	{counter start=$pageData.offsets.current print=false assign="offset" name="offset"}	
	{foreach name=rowIteration from=$data key=id item=rowData}
	    {counter name="offset" print=false}

		{if $smarty.foreach.rowIteration.iteration is odd}
			{assign var='_rowColor' value=$rowColor[0]}
		{else}
			{assign var='_rowColor' value=$rowColor[1]}
		{/if}
		<tr height='20' class='{$_rowColor}S1'>
			{if $prerow}
			<td width='1%' class='nowrap'>
			 {if !$is_admin && is_admin_for_user && $rowData.IS_ADMIN==1}
					<input type='checkbox' disabled="disabled" class='checkbox' value='{$rowData.ID}'>
			 {else}
                    <input onclick='sListView.check_item(this, document.MassUpdate)' type='checkbox' class='checkbox' name='mass[]' value='{$rowData.ID}'>		 
			 {/if}
			</td>
			{/if}
			{if $favorites}
				<td>{$rowData.star}</td>
			{/if}
			{if !empty($quickViewLinks)}

			<td width='2%' nowrap>{if $pageData.access.edit}<a title='{$editLinkString}' id="dashedit-{$rowData.ID}" href="index.php?action=EditView&module={if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$pageData.bean.moduleDir}{/if}&record={$rowData[$params.parent_id]|default:$rowData.ID}&offset={$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}&stamp={$pageData.stamp}&return_module=Home&return_action=index" title="{sugar_translate label="LBL_EDIT_INLINE"}">{sugar_getimage name="edit_inline.gif" attr='border="0" '}</a>{/if}</td>

			{/if}
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$displayColumns key=col item=params}
			    {strip}
				<td scope='row' align='{$params.align|default:'left'}' valign="top" {if ($params.type == 'teamset')}class="nowrap"{/if}>
					{if $col == 'NAME' || $params.bold}<b>{/if}
				    {if $params.link && !$params.customCode}
						<{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN} href='index.php?action={$params.action|default:'DetailView'}&module={if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$params.module|default:$pageData.bean.moduleDir}{/if}&record={$rowData[$params.id]|default:$rowData.ID}&offset={$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}&stamp={$pageData.stamp}'>
					{/if}
					{if $params.customCode}
						{sugar_evalcolumn_old var=$params.customCode rowData=$rowData}
					{else}
                       {sugar_field parentFieldArray=$rowData vardef=$params displayType=ListView field=$col}
					{/if}
					{if empty($rowData.$col) && empty($params.customCode)}&nbsp;{/if}
					{if $params.link && !$params.customCode}
						</{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN}>
                    {/if}
                    {if $col == 'NAME' || $params.bold}</b>{/if}
				</td>
				{/strip}
				{counter name="colCounter"}
			{/foreach}
	    	</tr>
	{foreachelse}
	<tr height='20' class='{$rowColor[0]}S1'>
	    <td colspan="{$colCount}">
	        <em>{$APP.LBL_NO_DATA}</em>
	    </td>
	</tr> 
	{/foreach}
		</table>
