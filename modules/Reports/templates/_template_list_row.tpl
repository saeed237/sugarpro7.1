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

<tr height=20 class="{$row_class}" onmouseover="setPointer(this, '{$rownum}', 'over', '{$bg_color}', '{$hilite_bg}', '{$click_bg}');" onmouseout="setPointer(this, '{$rownum}', 'out', '{$bg_color}', '{$hilite_bg}', '{$click_bg}');" onmousedown="setPointer(this, '{$rownum}', 'click', '{$bg_color}', '{$hilite_bg}', '{$click_bg}');">
{if ($isSummaryComboHeader)}
<td><span id="img_{$divId}"><a href="javascript:expandCollapseComboSummaryDiv('{$divId}')"><img width="8" height="8" border="0" absmiddle="" alt=$mod_strings.LBL_SHOW src="{$image_path}advanced_search.gif"/></a></span></td>
{/if}
{php}
	$count = 0;
	$this->assign('count', $count);
{/php}
{assign var='scope_row' value=true}
{foreach from=$column_row.cells key=module item=cell}
	{if (($column_row.group_column_is_invisible != "") && ($count|in_array:$column_row.group_pos)) }
{php}	
	$count = $count + 1;
	$this->assign('count', $count);
{/php}
	{ else }
	<td width="{$width}%" valign=TOP class="{$row_class}" bgcolor="{$bg_color}" {if $scope_row} scope='row' {/if}>
	
	{$cell}
	{/if}
    {assign var='scope_row' value=false}
{/foreach}
</tr>
