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
<input type="hidden" class="sugar_field" id="{{sugarvar key='name'}}" value="{{sugarvar key='value' string=true}}">
{if isset($displayParams.link)}
<a href='{{$displayParams.link}}'>
{else}
<a href="javascript:SUGAR.image.lightbox(YAHOO.util.Dom.get('img_{{sugarvar key='name'}}').src)">
{/if}
<img
	id="img_{{sugarvar key='name'}}" 
	name="img_{{sugarvar key='name'}}" 
	{{if !empty($vardef.calculated)}}
	   src='{{sugarvar key='value'}}'
	{{else}}
	{if empty({{sugarvar key='value' string=true}})}
	   src='' 	
	{else}
	   src='index.php?entryPoint=download&id={{sugarvar key='value'}}&type=SugarFieldImage&isTempFile=1'
	{/if}
	{{/if}}
	style='
		{if empty({{sugarvar key='value' string=true}})}
			display:	none;
		{/if}
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
		'		
>
</a>
