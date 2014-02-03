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

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
{*  --export and pagination-- *}
	{include file='modules/KBDocuments/tpls/ListViewPagination.tpl'}
{*  --Header Row -- *}
	<tr height='20'>
		{if $prerow}
			<td scope='col'  nowrap width='1%'>
				<input type='checkbox' class='checkbox' id='massall' name='massall' value='' onclick='sListView.check_all(document.MassUpdate, "mass[]", this.checked);' />
			</td>
		{/if}
		{counter start=0 name="colCounter" print=false assign="colCounter"}
        {capture assign="other_attributes"}align="absmiddle" border="0"{/capture}
		{foreach from=$displayColumns key=colHeader item=params}
			<td scope='col' width='{$params.width}%' >
				<span sugar="sugar{$colCounter}"><div style='white-space: normal;'width='100%' align='{$params.align|default:'left'}'>
                {if !$params.ajaxSort|default:false}
	                {* normal sort is specified, so set the proper urls*}
	                {if $params.sortable|default:true}
		                <a href='{$pageData.urls.orderBy}{$params.orderBy|default:$colHeader|lower}' class='listViewThLinkS1' onclick="this.href='{$pageData.urls.orderBy}{$params.orderBy|default:$colHeader|lower}&mode='+document.getElementById('mode').value;">
		                	{sugar_translate label=$params.label module=$pageData.bean.moduleDir}&nbsp;&nbsp;
						{if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
							{if $pageData.ordering.sortOrder == 'ASC'}
                                {capture assign="imageName"}arrow_down.{$arrowExt}{/capture}
                                {sugar_getimage name=$imageName width="$arrowWidth" height="$arrowHeight" alt=$arrowAlt other_attributes="$other_attributes"}
                            {else}
                                {capture assign="imageName"}arrow_up.{$arrowExt}{/capture}
                                {sugar_getimage name=$imageName width="$arrowWidth" height="$arrowHeight" alt=$arrowAlt other_attributes="$other_attributes"}
                            {/if}
                        {else}
                            {capture assign="imageName"}arrow.{$arrowExt}{/capture}
                            {sugar_getimage name=$imageName width="$arrowWidth" height="$arrowHeight" alt=$arrowAlt other_attributes="$other_attributes"}
                        {/if}
						</a>
					{else}
						{sugar_translate label=$params.label module=$pageData.bean.moduleDir}
					{/if}
				{else}
					{* this is where the ajax sorting goes, set the sort urls appropriately*}
                        <a href='javascript:SUGAR.kb.sortBrowseList({$pageData.queries.orderBy|@json},"{$params.orderBy|default:$colHeader|lower}", true)' class='listViewThLinkS1'>{sugar_translate label=$params.label module=$pageData.bean.moduleDir}&nbsp;&nbsp;
						{if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
							{if $pageData.ordering.sortOrder == 'ASC'}
                                {capture assign="imageName"}arrow_down.{$arrowExt}{/capture}
                                {sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight alt=$arrowAlt other_attributes=$other_attributes}
                            {else}
                                {capture assign="imageName"}arrow_up.{$arrowExt}{/capture}
                                {sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight alt=$arrowAlt other_attributes=$other_attributes}
                            {/if}
                        {else}
                            {capture assign="imageName"}arrow.{$arrowExt}{/capture}
                            {sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight alt=$arrowAlt other_attributes=$other_attributes}
                        {/if}
						</a>
				{/if}
				</div></span sugar='sugar{$colCounter}'>
			</td>
			{counter name="colCounter"}
		{/foreach}
		{if !empty($quickViewLinks)}
		<td scope='col'  nowrap width='1%'>&nbsp;</td>
		{/if}
	</tr>

	{foreach name=rowIteration from=$data key=id item=rowData}
		{if $smarty.foreach.rowIteration.iteration is odd}
			{assign var='_bgColor' value=$bgColor[0]}
			{assign var='_rowColor' value=$rowColor[0]}
		{else}
			{assign var='_bgColor' value=$bgColor[1]}
			{assign var='_rowColor' value=$rowColor[1]}
		{/if}
		<tr height='20' class='{$_rowColor}S1'>
			{if $prerow}
			<td width='1%' nowrap='nowrap'>
					<input onclick='sListView.check_item(this, document.MassUpdate)' type='checkbox' class='checkbox' name='mass[]' value='{$rowData[$params.id]|default:$rowData.ID}'>
					{$pageData.additionalDetails.$id}
			</td>
			{/if}
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$displayColumns key=col item=params}
				{assign var='ucol' value=$col|upper}
				<td scope='row' align='{$params.align|default:'left'}' valign='top'><span sugar="sugar{$colCounter}b">
					{if $params.link && !$params.customCode}
						{if $params.contextMenu}
							<span id='obj_{$rowData[$params.id]|default:$rowData.ID}'>
						{/if}

							<span id='adspan_{$rowData[$params.id]|default:$rowData.ID}' onmouseout="return document_clearAdditionalDetailsCall('{$rowData[$params.id]|default:$rowData.ID}', 'adspan_{$rowData[$params.id]|default:$rowData.ID}', '{$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}')"
							onmouseover="return getDocumentDetails('KBDocuments', '{$rowData[$params.id]|default:$rowData.ID}', 'adspan_{$rowData[$params.id]|default:$rowData.ID}', '{$rowData[$params.id]|default:$rowData.KBDOCUMENT_NAME_js}', 'panel_{$rowData[$params.id]|default:$rowData.ID}','{$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}')" onclick="updateKBViewsCount('{$rowData[$params.id]|default:$rowData.ID}')">
								<{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN} href='#'>
								{$rowData.$ucol}
								</{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN}>
							</span>


						{if $params.contextMenu}
							</span>
							<script>
							SUGAR.contextMenu.registerObject('{$params.contextMenu.objectType}', 'adspan_{$rowData[$params.id]|default:$rowData.ID}'{if $params.contextMenu.metaData},	{sugar_evalcolumn var=$params.contextMenu.metaData rowData=$rowData toJSON=true}{/if}, false);
							</script>
						{/if}
   				  	{elseif $params.customCode}
						{sugar_evalcolumn var=$params.customCode rowData=$rowData}1
					{elseif $params.currency_format}
						{sugar_currency_format
							var=$rowData.$ucol
							round=$params.currency_format.round
							decimals=$params.currency_format.decimals
							symbol=$params.currency_format.symbol
						}
					{elseif $params.type == 'bool'}
							<input type='checkbox' disabled=disabled class='checkbox'
							{if !empty($rowData.$ucol)}
								checked=checked
							{/if}
							/>
					{else}
						{$rowData.$ucol}
					{/if}
                    {if empty($rowData.$ucol)}&nbsp;{/if}
				</span sugar='sugar{$colCounter}b'></td>
				{counter name="colCounter"}
			{/foreach}
			{if !empty($quickViewLinks)}
			<td width='1%' nowrap='nowrap'>
				{if $pageData.access.edit}
					<a title='{$editLinkString}' id="edit-{$rowData.ID}" href='index.php?action=EditView&module={$params.module|default:$pageData.bean.moduleDir}&record={$rowData[$params.id]|default:$rowData.ID}&offset={$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}&stamp={$pageData.stamp}&return_module={$params.module|default:$pageData.bean.moduleDir}'>{sugar_getimage alt=$mod_strings.LBL_EDIT_INLINE name="edit_inline" ext=".gif" other_attributes='border="0" '}</a>
				{/if}
			</td>
	    	</tr>
			{/if}

	{/foreach}
	{include file='modules/KBDocuments/tpls/ListViewPagination.tpl'}
</table>
