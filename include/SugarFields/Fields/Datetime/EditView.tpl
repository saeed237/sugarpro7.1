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
{{capture name=idname assign=idname}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
    {{assign var=idname value=$displayParams.idName}}
{{/if}}
<span class="dateTime">
{assign var=date_value value={{sugarvar key='value' string=true}} }
<input class="date_input" autocomplete="off" type="text" name="{{$idname}}" id="{{$idname}}" value="{$date_value}" title='{{$vardef.help}}' {{$displayParams.field}} tabindex='{{$tabindex}}' {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}   size="11" maxlength="10" >
{{if !$displayParams.hiddeCalendar}}
{capture assign="other_attributes"}alt="{$APP.LBL_ENTER_DATE}" style="position:relative; top:6px" border="0" id="{{$idname}}_trigger"{/capture}
{sugar_getimage name="jscalendar" ext=".gif" other_attributes="$other_attributes"}
{{/if}}
{{if $displayParams.showFormats}}
&nbsp;(<span class="dateFormat">{$USER_DATEFORMAT}</span>)
{{/if}}
</span>
{{if !$displayParams.hiddeCalendar}}
<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "{{$idname}}",
ifFormat : "{$CALENDAR_FORMAT}",
daFormat : "{$CALENDAR_FORMAT}",
button : "{{$idname}}_trigger",
singleClick : true,
dateStr : "{$date_value}",
startWeekday: {$CALENDAR_FDOW|default:'0'},
step : 1,
weekNumbers:false
{rdelim}
);
</script>
{{/if}}
