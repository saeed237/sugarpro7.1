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
{capture name=getLink assign=link}{sugar_fetch object=$parentFieldArray key=$col}{/capture}
{if $vardef.gen && $vardef.default && $link}
    {capture name=getDefault assign=default}{if is_string($vardef.default)}{$vardef.default}{else}{$link}{/if}{/capture}
    {sugar_replace_vars subject=$default use_curly=true assign='link' fields=$parentFieldArray}
{/if}

<a href="{$link|to_url}" {if $displayParams.link_target}target='{$displayParams.link_target}'{elseif $vardef.link_target}target='{$vardef.link_target}'{/if}>{$link}</a>
