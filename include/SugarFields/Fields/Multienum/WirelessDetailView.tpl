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

{if !empty($vardef.value) && ($vardef.value != '^^')}
    <input type="hidden" class="sugar_field" id="{$vardef.name}" value="{$vardef.value}">
    {multienum_to_array string=$vardef.value assign="vals"}
    {foreach from=$vals item='item'}
    <li style="margin-left:10px;">{$vardef.options.$item}</li>
    {/foreach}
{/if}
