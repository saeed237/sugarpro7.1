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

<div class="ftsModuleFilterSpan">
    {if empty($moduleFilter)}
        <input type="checkbox" checked="checked" id="all" name="module_filter" class="ftsModuleFilter">
        <span id="all_label" class="checked">&nbsp;{$APP.LBL_EMAIL_SHOW_READ}</span>
    {else}
        <input type="checkbox" id="all" name="module_filter" class="ftsModuleFilter">
        <span id="all_label" class="unchecked">&nbsp;{$APP.LBL_EMAIL_SHOW_READ}</span>
    {/if}
</div>
{foreach from=$filterModules item=entry key=module}
    <div class="ftsModuleFilterSpan">
        {if is_array($moduleFilter) && in_array($entry.module, $moduleFilter)}
            <input type="checkbox" checked="checked" id="{$entry.module}" name="module_filter" class="ftsModuleFilter">
            <span id="{$entry.module}_label" class="checked">&nbsp;{$entry.label}</span>
            <span id="{$entry.module}_count" class="checked">{if is_int($entry.count)}({$entry.count}){/if}</span>
        {else}
            <input type="checkbox" id="{$entry.module}" name="module_filter" class="ftsModuleFilter">
            <span id="{$entry.module}_label" class="unchecked">&nbsp;{$entry.label}</span>
            <span id="{$entry.module}_count" class="unchecked">{if is_int($entry.count) }({$entry.count}){/if}</span>
        {/if}
    </div>
{/foreach}
