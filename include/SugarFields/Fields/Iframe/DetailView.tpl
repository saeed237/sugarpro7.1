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
{if !empty($link) && $link != "http://" && $link != "https://"}
{capture name=getStart assign=linkStart}{$link|substr:0:7}{/capture}
<input type="hidden" class="sugar_field" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}" value="{if ( $linkStart != 'http://' || $linkStart != 'https:/' ) && $link}http://{/if}{$link}">
<iframe src="{if $linkStart != 'http://' && $linkStart != 'https:/' && $link}http://{/if}{$link}" title="{if $linkStart != 'http://' && $linkStart != 'https:/' && $link}http://{/if}{$link}" height="{{sugarvar key='height'}}" width="100%"/></iframe>
{/if}
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}} 
{{/if}}