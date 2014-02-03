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

<div id='SpotResults'>
{if !empty($displayResults)}
    {foreach from=$displayResults key=module item=data}
    <section>
        <div class="resultTitle">
            {if isset($appListStrings.moduleList[$module])}
                {$appListStrings.moduleList[$module]}
            {else}
                {$module}
            {/if}
            {if !empty($displayMoreForModule[$module])}
                {assign var="more" value=$displayMoreForModule[$module]}
                <br>
                <small class='more' onclick="DCMenu.spotZoom('{$more.query}', '{$module}', '{$more.offset}');">({$more.countRemaining} {$appStrings.LBL_SEARCH_MORE})</small>
            {/if}
        </div>
            <ul>
                {foreach from=$data key=id item=name}
                        <div class="gsLinkWrapper" >
                            <a href="index.php?module={$module}&action=DetailView&record={$id}" class="gs_link">{$name}</a>
                        </div>
                        </div>
                {/foreach}
            </ul>
        <div class="clear"></div>
    </section>
    {/foreach}
    <a href='index.php?module=Home&action=UnifiedSearch&search_form=false&advanced=false&query_string={$queryEncoded}' class="resultAll" data-sidecar-rewrite="false">
        {$appStrings.LNK_SEARCH_NONFTS_VIEW_ALL}
    </a>
{else}
    <section class="resultNull">
        <h1>{$appStrings.LBL_EMAIL_SEARCH_NO_RESULTS}</h1>
        <div style="float:right;">
            <a href="index.php?module=Home&action=UnifiedSearch&search_form=false&advanced=false&query_string={$queryEncoded}" data-sidecar-rewrite="false">{$appStrings.LNK_ADVANCED_SEARCH}</a>
        </div>
    </section>
{/if}
</div>
