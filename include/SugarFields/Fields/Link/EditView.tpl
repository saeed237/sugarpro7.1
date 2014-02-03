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
{{if !$vardef.gen}}
	{if !empty({{sugarvar key='value' string=true}})}
	<input type='text' name='{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}' id='{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}' size='{{$displayParams.size|default:30}}' 
	   {{if !empty($vardef.len)}}maxlength='{{$vardef.len}}'{{/if}} value='{{sugarvar key='value'}}' title='{{$vardef.help}}' tabindex='{{$tabindex}}' {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}} >
	{else}
	<input type='text' name='{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}' id='{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}' size='{{$displayParams.size|default:30}}' 
	   {{if !empty($vardef.len)}}maxlength='{{$vardef.len}}'{{/if}}
	   {{if !empty($vardef.len) && $vardef.len >= 7}}
	   {if $displayView=='advanced_search'||$displayView=='basic_search'}value=''{else}value='http://'{/if} 
	   {{else}} value='' {{/if}} title='{{$vardef.help}}' tabindex='{{$tabindex}}' {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}} >
	{/if}
{{/if}}