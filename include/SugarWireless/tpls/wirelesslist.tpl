
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
<!-- ListView Data -->
{if $SUBPANEL_LIST_VIEW}
	<div class="sectitle">
	{$BEAN->name} <small>[ <a class="back_link" href="index.php?module={$MODULE}&action=wirelessdetail&record={$BEAN->id}">{sugar_translate label='LBL_BACK' module=''}</a> ]</small>
	</div>
	<div class="subpanel_sec">
	{sugar_translate label='LBL_RELATED' module=''} {$SUBPANEL_MODULE}<br />
	</div>
	<ul class="sec">
	{foreach from=$DATA item="record" name="recordlist"}
	<li class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
        <a href="index.php?module={$record->module_dir}&action=wirelessdetail&record={$record->id}">{$record->name}</a>
    </li>
	{/foreach}
	</ul>
{else}
	<div class="sectitle">{sugar_translate label='LBL_SEARCH_RESULTS' module=''}{if $SAVED_SEARCH_NAME} - {$SAVED_SEARCH_NAME}{/if}</div>
	
	<table class="sec">
	
	<tr>
		{foreach from=$displayColumns key=colHeader item=params}
			<td scope='col' width='{$params.width}%' nowrap="nowrap">
				{sugar_translate label=$params.label module=$pageData.bean.moduleDir}
			</td>
		{/foreach}
	</tr>	
	
	{foreach from=$DATA item="rowData" name="recordlist"}
	<tr>

		{foreach from=$displayColumns key=col item=params}				
		<td class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
				{if $params.link && !$params.customCode}
                    {capture assign=linkModule}{if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$MODULE}{/if}{/capture}
                    {capture assign=linkRecord}{$rowData[$params.id]|default:$rowData.ID}{/capture}
                    <a href="index.php?module={$linkModule}&action=wirelessdetail&record={$linkRecord}">{$rowData.$col}</a>
                {elseif $params.customCode} 
					{sugar_evalcolumn_old var=$params.customCode rowData=$rowData}
				{elseif $params.currency_format}
                    {**
                     * Need to refactor this wireless list fields to use the
                     * SugarFields enabling customization levels per field.
                     * Currency fields shouldn't be defined using name fields
                     * like "_USD", but rather a parameter telling what is the
                     * related currency for that field.
                     *
                     * @see SugarFieldCurrency::getListViewSmarty
                     * @see include/SugarFields/Fields/Currency/ListView.tpl
                     *}
                    {if stripos(strtoupper($col), '_USD')}
                        {sugar_currency_format var=$rowData.$col}
                    {elseif !empty($rowData.CURRENCY_ID)}
                        {sugar_currency_format var=$rowData.$col
                        currency_id=$rowData.CURRENCY_ID
                        }
                    {elseif !empty($rowData.currency_id)}
                        {sugar_currency_format var=$rowData.$col
                        currency_id=$rowData.currency_id
                        }
                    {else}
                        {* empty currency id *}
                        {sugar_currency_format var=$rowData.$col}
                    {/if}
				{elseif $params.type == 'bool'}
						<input type='checkbox' disabled=disabled class='checkbox'
						{if !empty($rowData[$col])}
							checked=checked
						{/if}
						/>
				{elseif $params.type == 'teamset'}
					{$rowData.$col}
				{elseif $params.type == 'multienum'}
					{if !empty($rowData.$col)} 
						{counter name="oCount" assign="oCount" start=0}
						{assign var="vals" value='^,^'|explode:$rowData.$col}
						{foreach from=$vals item=item}
							{counter name="oCount"}
							{sugar_translate label=$params.options select=$item}{if $oCount !=  count($vals)},{/if} 
						{/foreach}	
					{/if}
				{else}	
					{$rowData.$col|default:"&nbsp;"}
				{/if}
		</td>
		{/foreach}
	</tr>
	{/foreach}
    </table>
	
	<div class="nav_sec" align="right">
	{if $PAGEDATA.offsets.prev != -1}<small><a href="{$PAGEDATA.urls.prevPage}" class="nav">{$navStrings.previous}</a>&nbsp;</small>{/if}
	{if $PAGEDATA.offsets.lastOffsetOnPage == 0}0{else}{$PAGEDATA.offsets.current+1}{/if} - {$PAGEDATA.offsets.lastOffsetOnPage} {$navStrings.of} {if $PAGEDATA.offsets.totalCounted}{$PAGEDATA.offsets.total}{else}{$PAGEDATA.offsets.total}{if $PAGEDATA.offsets.lastOffsetOnPage != $PAGEDATA.offsets.total}+{/if}{/if}
	{if $PAGEDATA.offsets.next != -1}<small>&nbsp;<a href="{$PAGEDATA.urls.nextPage}" class="nav">{$navStrings.next}</a></small>{/if}
	</div>
	<div class="sectitle">{sugar_translate label='LBL_SEARCH' module=''} {$MODULE_NAME} {$LITERAL_MODULE}</div>
	{$WL_SAVED_SEARCH_FORM}
	<!--  Search Def Searches -->
	{$WL_SEARCH_FORM}	
{/if}
