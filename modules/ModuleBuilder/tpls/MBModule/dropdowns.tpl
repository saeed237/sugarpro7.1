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

<div id='dropdowns'>
<input type='button' name='adddropdownbtn'
	value='{$LBL_BTN_ADDDROPDOWN}' class='button'
	onclick='ModuleBuilder.getContent("module=ModuleBuilder&action=dropdown&refreshTree=1");'>&nbsp;

<hr>
<table width='100%'>
	<colgroup span='3' width='33%'>
	
	
	<tr>
		{counter name='items' assign='items' start=0} {foreach from=$dropdowns
		key='name' item='def'} {if $items % 3 == 0 && $items != 0}
	</tr>
	<tr>
		{/if}
		<td><a class='mbLBLL' href='javascript:void(0)'
			onclick='ModuleBuilder.getContent("module=ModuleBuilder&action=dropdown&dropdown_name={$name}")'>{$name}</a></td>
		{counter name='items'} {/foreach} {if $items == 0}
		<td class='mbLBLL'>{$mod_strings.LBL_NONE}</td>
		{elseif $items % 3 == 1}
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		{elseif $items % 3 == 2}
		<td>&nbsp;</td>
		{/if}
	</tr>
</table>

<script>
ModuleBuilder.helpRegisterByID('dropdowns', 'input');
ModuleBuilder.helpSetup('dropdowns','default');
</script> {include
file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}