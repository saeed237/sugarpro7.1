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


{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}

<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_WIDTH"}:</td>
	<td>
		<input id ="width" type="text" name="width" 
		{if !$vardef.width && !$vardef.height}
			value="120"
		{else}
			value="{$vardef.width}"
		{/if}
		>
		{sugar_help text=$mod_strings.LBL_POPHELP_IMAGE_WIDTH FIXX=300 FIXY=200}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_HEIGHT"}:</td>
	<td>
		<input id ="height" type="text" name="height" 
		{if !$vardef.width && !$vardef.height}
			value=""
		{else}
			value="{$vardef.height}"
		{/if}
		>
		{sugar_help text=$mod_strings.LBL_POPHELP_IMAGE_HEIGHT FIXX=300 FIXY=220}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="LBL_IMAGE_BORDER"}:</td>
	<td>	
		<input type="checkbox" id ="border" name="border" value="1" {if !empty($vardef.border)}checked{/if}/>
	</td>
</tr>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}