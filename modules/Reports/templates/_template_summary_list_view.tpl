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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="reportlistView">
{if ($show_pagination neq "")}
{$pagination_data}
{/if}
<tr height="20">
{if ($isSummaryCombo)}
<th scope="col" align='center' class="reportlistViewThS1" valign=middle nowrap>&nbsp;</th>
{/if}
{if ($isSummaryComboHeader)}
<td><span id="img_{$divId}"><a href="javascript:expandCollapseComboSummaryDiv('{$divId}')"><img width="8" height="8" border="0" absmiddle="" alt=$mod_strings.LBL_SHOW src="{$image_path}advanced_search.gif"/></a></span></td>
{/if}
{php}
	$count = 0;
	$this->assign('count', $count);
{/php}
{foreach from=$header_row key=module item=cell}
	{if (($args.group_column_is_invisible != "") && ($args.group_pos eq $count))}
{php}	
	$count = $count + 1;
	$this->assign('count', $count);
{/php}
	{ else }
	{if $cell eq ""}
{php}	
	$cell = "&nbsp;";
	$this->assign('cell', $cell);
{/php}
	{/if}
	<th scope="col" align='center' class="reportlistViewThS1" valign=middle nowrap>	
	
	{$cell}
	{/if}
{/foreach}
</tr>

{php}
require_once('modules/Reports/templates/templates_reports.php');
$reporter = $this->get_template_vars('reporter');
$args = $this->get_template_vars('args');
$got_row = 0;
while (( $row = $reporter->get_summary_next_row() ) != 0 ) {
	$got_row = 1;
	template_list_row($row,true);
{/php}
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
	{if $cell eq ""}
{php}	
	$cell = "&nbsp;";
	$this->assign('cell', $cell);
{/php}
	{/if}
	
	<td width="{$width}%" valign=TOP class="{$row_class[$module]}" bgcolor="{$bg_color}" {if $scope_row} scope='row' {/if}>
	{$cell}</td>
	{/if}
	 {assign var='scope_row' value=false}
{/foreach}
</tr>
{php}
}
if (!$got_row) {
	echo template_summary_view_no_results($args);
} // if
echo template_end_table($args);	
if ($reporter->has_summary_columns()) {
	$reporter->run_total_query();
	// start template_total_table code
	global $mod_strings;
	$total_header_row = $reporter->get_total_header_row(); 
	$total_row = $reporter->get_summary_total_row();
	if ( isset($total_row['group_pos'])) {
		$args['group_pos'] = $total_row['group_pos'];
	} // if
	if ( isset($total_row['group_column_is_invisible'])) {
		$args['group_column_is_invisible'] = $total_row['group_column_is_invisible'];
	} // if
 	$reporter->layout_manager->setAttribute('no_sort',1);
  	echo get_form_header( $mod_strings['LBL_GRAND_TOTAL'],"", false); 
  	template_header_row($total_header_row,$args);
{/php}
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list view">
	{if ($show_pagination neq "")}
	{$pagination_data}
	{/if}
	<tr height="20">
	{if ($isSummaryCombo)}
	<th scope="col"  valign=middle nowrap>&nbsp;</th>
	{/if}
	{if ($isSummaryComboHeader)}
	<th><span id="img_{$divId}"><a href="javascript:expandCollapseComboSummaryDiv('{$divId}')"><img width="8" height="8" border="0" absmiddle="" alt=$mod_strings.LBL_SHOW src="{$image_path}advanced_search.gif"/></a></span></th>
	{/if}
	{php}
		$count = 0;
		$this->assign('count', $count);
	{/php}
	{foreach from=$header_row key=module item=cell}
		{if (($args.group_column_is_invisible != "") && ($args.group_pos eq $count))}
	{php}	
		$count = $count + 1;
		$this->assign('count', $count);
	{/php}
		{ else }
	{if $cell eq ""}
{php}	
	$cell = "&nbsp;";
	$this->assign('cell', $cell);
{/php}
	{/if}		
		<th scope="col"  valign=middle nowrap>	
		
		{$cell}
		{/if}
	{/foreach}
	</tr>
{php}
  	if (! empty($total_row)) {
    	template_list_row($total_row);
{/php}
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
	{if $cell eq ""}
{php}	
	$cell = "&nbsp;";
	$this->assign('cell', $cell);
{/php}
	{/if}
			<td width="{$width}%" valign=TOP class="{$row_class}" bgcolor="{$bg_color}" {if $scope_row} scope='row' {/if}>
			
			{$cell}
			{/if}
			{assign var='scope_row' value=false}
		{/foreach}
		</tr>
{php}
  	} else {
		echo template_summary_view_no_results();
  	}
	echo template_end_table($args);
  	// end template_total_table code	
	//template_total_table($reporter);
} // if	
template_query_table($reporter); 
{/php}