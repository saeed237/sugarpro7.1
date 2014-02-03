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

{if !empty($displayParams.maxlength)}
<textarea id="{$prefix}{$name}" name="{$prefix}{$name}" maxlength="{$displayParams.maxlength}" cols="{$displayParams.cols|default:60}" rows="{$displayParams.rows|default:4}" tabindex="{$tabindex}">{$value}</textarea>
{else}
<textarea id="{$prefix}{$name}" name="{$prefix}{$name}" cols="{$displayParams.cols|default:60}" rows="{$displayParams.rows|default:4}" tabindex="{$tabindex}">{$value}</textarea>
{/if}


