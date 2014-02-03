\{*
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
<table width="100%" border="0" cellspacing="1" cellpadding="0"  class="edit view">
{{assign var='rowCount' value=0}}
{{foreach name=rowIteration from=$panel key=row item=rowData}}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
	{{if !empty($colData.field.name)}}
		{if $fields.{{$colData.field.name}}.acl > 1 || ($showDetailData && $fields.{{$colData.field.name}}.acl > 0)}
	{{/if}}
   	<td valign="top" id='{{$colData.field.name}}_label' scope="row">
			{{if isset($colData.field.customLabel)}}
			   {{$colData.field.customLabel}}
			{{elseif isset($colData.field.label)}}
			   {capture name="label" assign="label"}
			   {sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}
			   {/capture}
			   {$label|strip_semicolon}:
			{{elseif isset($fields[$colData.field.name])}}
			   {capture name="label" assign="label"}
			   {sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}
			   {/capture}
			   {$label|strip_semicolon}:
			{{/if}}
			{{* Show the required symbol if field is required, but override not set.  Or show if override is set *}}
				{{if ($fields[$colData.field.name].required && (!isset($colData.field.displayParams.required) || $colData.field.displayParams.required)) ||
				     (isset($colData.field.displayParams.required) && $colData.field.displayParams.required)}}
			    <span class="required">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
			{{/if}}
		</td>
		{{/if}}
		{counter name="fieldsUsed"}
		<td valign="top" width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}}>
			{{if !empty($def.templateMeta.labelsOnTop)}}
				{{if isset($colData.field.label)}}
				    {{if !empty($colData.field.label)}}
			   		    {sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}:
				    {{/if}}
				{{elseif isset($fields[$colData.field.name])}}
			  		{sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}:
				{{/if}}

				{{* Show the required symbol if field is required, but override not set.  Or show if override is set *}}
				{{if ($fields[$colData.field.name].required && (!isset($colData.field.displayParams.required) || $colData.field.displayParams.required)) ||
				     (isset($colData.field.displayParams.required) && $colData.field.displayParams.required)}}
				    <span class="required" title="{{$APP.LBL_REQUIRED_TITLE}}">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
				{{/if}}
				{{if !isset($colData.field.label) || !empty($colData.field.label)}}
				<br>
				{{/if}}
			{{/if}}

		{{if !empty($colData.field.name)}}
			{if $fields.{{$colData.field.name}}.acl > 1}
		{{/if}}

			{{if $fields[$colData.field.name] && !empty($colData.field.fields) }}
			    {{foreach from=$colData.field.fields item=subField}}
			        {{if $fields[$subField.name]}}
			        	{counter name="panelFieldCount"}
			            {{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$subField.name] displayType='EditView' displayParams=$subField.displayParams formName=$form_name}}&nbsp;
			        {{/if}}
			    {{/foreach}}
			{{elseif !empty($colData.field.customCode)}}
				{counter name="panelFieldCount"}
				{{sugar_evalcolumn var=$colData.field.customCode colData=$colData tabindex=$colData.field.tabindex}}
			{{elseif $fields[$colData.field.name]}}
				{counter name="panelFieldCount"}
			    {{$colData.displayParams}}
				{{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$colData.field.name] displayType='EditView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type formName=$form_name}}
			{{/if}}
		{{if !empty($colData.field.name)}}
		{{if $showDetailData }}
		{else}
			{{if $fields[$colData.field.name] && !empty($colData.field.fields) }}
			    {{foreach from=$colData.field.fields item=subField}}
			        {{if $fields[$subField.name]}}

			            {{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$subField.name] displayType='DetailView' displayParams=$subField.displayParams formName=$form_name}}&nbsp;
			        {{/if}}
			    {{/foreach}}
			{{elseif !empty($colData.field.customCode)}}
				<td></td><td></td>
			{{elseif $fields[$colData.field.name]}}
			    {{$colData.displayParams}}
			    {counter name="panelFieldCount"}
				{{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$colData.field.name] displayType='DetailView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type formName=$form_name}}
			{{/if}}
		</td>
		{{/if}}

		{/if}

		{else}

		  <td></td><td></td>

	{/if}

	{{else}}

		</td>
	{{/if}}
    {{if !empty($colData.field.hideIf)}}
		{else}
		<td></td><td></td>
		{/if}
    {{/if}}

	{{/foreach}}
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{{/foreach}}
</table>