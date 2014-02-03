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
<div class='wizard' width='100%' >
	<div align='left' id='export'>{$actions}</div>

	<div>{$question}</div>
	<div id="Buttons">

	<table align="center" cellspacing="7" width="90%"><tr>
		{counter start=0 name="buttonCounter" print=false assign="buttonCounter"}
		{foreach from=$buttons item='button' key='buttonName'}
			{if $buttonCounter > 5}
				</tr><tr>
				{counter start=0 name="buttonCounter" print=false assign="buttonCounter"}
			{/if}
			{ if !isset($button.size)}
				{assign var='buttonsize' value=''}
			{else}
				{assign var='buttonsize' value=$button.size}
			{/if}
			<td {if isset($button.help)}id="{$button.help}"{/if} width="16%" name=helpable" style="padding: 5px;"  valign="top" align="center">
			     <table onclick='{if $button.action|substr:0:11 == "javascript:"}{$button.action|substr:11}{else}ModuleBuilder.getContent("{$button.action}");{/if}' 
			         class='wizardButton' onmousedown="ModuleBuilder.buttonDown(this);return false;" onmouseout="ModuleBuilder.buttonOut(this);">
			         <tr>
						<td align="center"><a class='studiolink' href="javascript:void(0)" >
						{if isset($button.imageName)}
                            {if isset($button.altImageName)}
                                {sugar_image name=$button.imageTitle width=$button.size height=$button.size image=$button.imageName altimage=$button.altImageName}
                            {else}
                                {sugar_image name=$button.imageTitle width=$button.size height=$button.size image=$button.imageName}                            
                            {/if}
						{else}
							{sugar_image name=$button.imageTitle width=$button.size height=$button.size}
						{/if}</a></td>
					 </tr>
					 <tr>
						 <td align="center"><a class='studiolink' id='{$button.linkId}' href="javascript:void(0)">
				            {if (isset($button.imageName))}{$button.imageTitle}{else}{$buttonName}{/if}</a></td>
				     </tr>
				 </table>
			</td>
			{counter name="buttonCounter"}
		{/foreach}
	</tr></table>
<!-- Hidden div for hidden content so IE doesn't ignore it -->
<div style="float:left; left:-100px; display: hidden;">&nbsp;
	{literal}
	<style type='text/css'>
		.wizard { padding: 5px; text-align:center; font-weight:bold}
		.title{ color:#990033; font-weight:bold; padding: 0px 5px 0px 0px; font-size: 20pt}
		.backButton {position:absolute; left:10px; top:35px}
	</style>
    {/literal}

	<script>
	ModuleBuilder.helpRegisterByID('export', 'input');
	ModuleBuilder.helpRegisterByID('Buttons', 'td');
	ModuleBuilder.helpSetup('studioWizard','{$defaultHelp}');
	</script>
</div>
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}
