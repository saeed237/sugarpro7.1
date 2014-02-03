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
	<div class='title'>{$title}</div>&nbsp;
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
			<td id="{$button.help}"  width="16%" name=helpable" style="padding: 5px;" align="center">
			     <table onclick="{$button.action}" class='wizardButton'>
			         <tr>
						<td align="center"><a class='studiolink' href='{$button.action}'>
						    {sugar_image name=$button.imageTitle width=$button.size height=$button.size}</a></td>
					 </tr><tr>
						 <td align="center"><a class='studiolink' href='{$button.action}'>
				            {$buttonName}</a></td>
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
{/literal}
</style>
	</div>
