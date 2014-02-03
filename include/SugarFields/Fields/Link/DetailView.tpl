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
{capture name=getLink assign=link}{{sugarvar key='value'}}{/capture}
{{if $vardef.gen}}
{sugar_replace_vars subject='{{$vardef.default|replace:'{':'['|replace:'}':']'}}' assign='link'}
{{/if}}
{if !empty($link)}
{capture name=getStart assign=linkStart}{$link|substr:0:7}{/capture}
<span class="sugar_field" id="{{sugarvar key='name'}}">
<a href='{$link|to_url}' {{if $displayParams.link_target}}target='{{$displayParams.link_target}}'{{elseif $vardef.link_target}}target='{{$vardef.link_target}}'{{/if}} >{{if !empty($displayParams.title)}}{sugar_translate label='{{$displayParams.title}}' module=$module}{{else}}{$link}{{/if}}</a>
</span>
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}}
{{/if}}
{/if}
