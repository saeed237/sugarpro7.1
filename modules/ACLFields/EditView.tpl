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
{if !empty($FIELDS)}
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/ListEditor.css" />
<h3>{sugar_translate label='LBL_FIELDS' module='ACLFields'}</h3>
<input type='hidden' name='flc_module' value='{$FLC_MODULE}'> 
<table  class='detail view' border='0' cellpadding=0 cellspacing = 1  width='100%'>
		{counter start=0 name='colCount' assign='colCount'}
		{foreach from=$FIELDS key="NAME" item="DEF"}
		
		{if ($colCount % 4 == 0 || $colCount == 0) }
			{if $colCount != 0}
				</tr>
			{/if}
			<tr>
		{/if}
			<td scope='row'>{sugar_translate label=$DEF.label module=$LBL_MODULE}{if $DEF.required}*{/if}
			{if count($DEF.fields) > 0}
			<a id="d_{$NAME}_anchor" class='link' onclick='toggleDisplay("d_{$NAME}")' href='javascript:void(0)'>[+]</a><div id='d_{$NAME}' style='display:none'>
				{foreach from=$DEF.fields key='subField' item='subLabel'}
				{sugar_translate label=$subLabel module=$FLC_MODULE}<br><span class='fieldValue'>[{$subField}]</span><br>
				{/foreach}
				</div>
			{/if}
			</td>
			
			<td>
					<div  style="display: none" id="{$DEF.key}">
						<select  name='flc_guid{$DEF.key}' id = 'flc_guid{$DEF.key}'onblur="document.getElementById('{$DEF.key}link').innerHTML=this.options[this.selectedIndex].text; aclviewer.toggleDisplay('{$DEF.key}');" >
							{if !empty($DEF.required)}
							{html_options options=$OPTIONS_REQUIRED selected=$DEF.aclaccess }
							{else}
							{html_options options=$OPTIONS selected=$DEF.aclaccess }
							{/if}
							
						</select>
					</div>
					<div  id="{$DEF.key}link" onclick="aclviewer.toggleDisplay('{$DEF.key}')">
						{if !empty($OPTIONS[$DEF.aclaccess])}
							{$OPTIONS[$DEF.aclaccess]}
						{else}
							{$MOD.LBL_NOT_DEFINED}
						{/if}
					</div>
		</td>
		{counter name='colCount'}
		{/foreach}
		</tr>	
</table>
{/if}
	