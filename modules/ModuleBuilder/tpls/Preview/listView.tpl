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
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/ListEditor.css" />
<table class="preview-content">
<td>

{counter start=0 name="groupCounter" print=false assign="groupCounter"}
{foreach from=$groups key='label' item='list'}
	{counter name="groupCounter"}
{/foreach}
{math assign="groupWidth" equation="100/$groupCounter-5"}

{counter start=0 name="slotCounter" print=false assign="slotCounter"}
{counter start=0 name="modCounter" print=false assign="modCounter"}

{foreach from=$groups key='label' item='list'}

<div style="float: left; border: 1px gray solid; padding:4px; margin-right:4px; margin-top: 8px; width:{$groupWidth}%;">
<h3 >{$label}</h3>
<ul>

{foreach from=$list key='key' item='value'}

<li name="width={$value.width}%" class='draggable' style='cursor:default;'>
    <table width='100%'>
    	<tr>
    		<td style="font-weight: bold;">{if !empty($value.label)}{sugar_translate label=$value.label module=$language}{else}{$key}{/if}</td>
    		<td>
                {* BEGIN SUGARCRM flav=pro ONLY *}
                {if isset($field_defs.$key.calculated) && $field_defs.$key.calculated}
                    {sugar_getimage name="SugarLogic/icon_calculated" alt=$mod_strings.LBL_CALCULATED ext=".png" other_attributes=''}
                {/if}
                {if isset($field_defs.$key.dependency) && $field_defs.$key.dependency}
                    {sugar_getimage name="SugarLogic/icon_dependent" alt=$mod_strings.LBL_DEPENDANT ext=".png" other_attributes=''}
                {/if}
                {* END SUGARCRM flav=pro ONLY *}
    		</td>
    	</tr>
    	<tr class='fieldValue' style='cursor:default;'>
    		{if empty($hideKeys)}<td>[{$key}]</td>{/if}
    		<td align="right" colspan="2"><span>{$value.width}</span><span>%</span></td>
    	</tr>
    </table>
</li>
{counter name="modCounter"}
{/foreach}

<li class='noBullet'>&nbsp;</li>

</ul>
</div>

{counter name="slotCounter"}
{/foreach}
</td>
</tr></table>


