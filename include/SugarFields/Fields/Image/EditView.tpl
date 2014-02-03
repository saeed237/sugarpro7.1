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
{if empty({{sugarvar key='value' string=true}})}
{assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
{assign var="value" value={{sugarvar key='value' string=true}} }
{/if}  

{{capture name=idname assign=idname}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
    {{assign var=idname value=$displayParams.idName}}
{{/if}}

{if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}
<input type="hidden" id="{{$idname}}_duplicate" name="{{$idname}}_duplicate" value="{$value}"/>
{/if}

<input 
	type="file" id="{{$idname}}" name="{{$idname}}" 
	title="" size="30" maxlength="255" value="" tabindex="{{$tabindex}}"
	onchange="SUGAR.image.confirm_imagefile('{{$idname}}');" 
	class="imageUploader"
	{if !empty({{sugarvar key='value' string=true}}) {{if !empty($vardef.calculated)}}|| true{{/if}} }
	style="display:none"
	{/if}  {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}
/>

{if empty({{sugarvar key='value' string=true}}) {{if !empty($vardef.calculated)}}&& false{{/if}}}
{else}
<a href="javascript:SUGAR.image.lightbox(Dom.get('img_{{$idname}}').src)">
<img
	id="img_{{$idname}}" 
	name="img_{{$idname}}" 	
	{{if empty($vardef.calculated)}}
	   src='index.php?entryPoint=download&id={{sugarvar key='value'}}&type=SugarFieldImage&isTempFile=1'
	{{else}}
	   src='{{sugarvar key='value'}}'
	{{/if}}
	style='
		{if "{{$vardef.border}}" eq ""}
			border: 0; 
		{else}
			border: 1px solid black; 
		{/if}
		{if "{{$vardef.width}}" eq ""}
			width: auto;
		{else}
			width: {{$vardef.width}}px;
		{/if}
		{if "{{$vardef.height}}" eq ""}
			height: auto;
		{else}
			height: {{$vardef.height}}px;
		{/if}
		{if empty({{sugarvar key='value' string=true}})} 
		  visibility:hidden;
		{/if}
		'	

></a>
{{if empty($vardef.calculated)}}
<img
	id="bt_remove_{{$idname}}" 
	name="bt_remvoe_{{$idname}}" 
	alt="{sugar_translate label='LBL_REMOVE'}"
	title="{sugar_translate label='LBL_REMOVE'}"
	src="{sugar_getimagepath file='delete_inline.gif'}"
	onclick="SUGAR.image.remove_upload_imagefile('{{$idname}}');" 	
	/>

<input 
	id="remove_imagefile_{{$idname}}" name="remove_imagefile_{{$idname}}" 
	type="hidden"  value="" />
{{/if}}
{/if}