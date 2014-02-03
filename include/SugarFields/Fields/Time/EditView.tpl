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

{{assign var=flag_field value=$vardef.name|cat:_flag}}

<table border="0" cellpadding="0" cellspacing="0">
<tr valign="middle">
<td nowrap>
<div id="{{$idname}}_time"></div>
{{if $displayParams.showFormats}}
<span class="timeFormat">{$TIME_FORMAT}</span>
{{/if}}
</td>
</tr>
</table>
<input type="hidden" id="{{$idname}}" name="{{$idname}}" value="{$fields[{{sugarvar key='name' stringFormat=true}}].value}">
<script type="text/javascript" src="include/SugarFields/Fields/Time/Time.js"></script>
<script type="text/javascript">

//cleanup because this happens in a screwy order in a quickcreate, and the standard $(document).ready and YUI functions don't work quite right
var timeclosure_{{$idname}} = function(){ldelim}
	var idname = "{{$idname}}";
	var timeField = "{$fields[{{sugarvar key='name' stringFormat=true}}].value}";
	var timeFormat = "{$fields[{{sugarvar key='name' stringFormat=true}}].value}";
	var tabIndex = "{{$tabindex}}";
	var callback = "{{$displayParams.updateCallback}}";
	
	{literal}
	
	SUGAR.util.doWhen(typeof(Time) != "undefined", function(){
		var combo = new Time(timeField, idname, timeFormat, tabIndex);
		//Render the remaining widget fields
		var text = combo.html(callback);
		document.getElementById(idname + "_time").innerHTML = text;	
	});
	{/literal}
{rdelim}
timeclosure_{{$idname}}();
</script>

<script type="text/javascript">
function update_{{$idname}}_available() {ldelim}
      YAHOO.util.Event.onAvailable("{{$idname}}_time_hours", this.handleOnAvailable, this);
{rdelim}

update_{{$idname}}_available.prototype.handleOnAvailable = function(me) {ldelim}
	//Call update for first time to round hours and minute values
	combo_{{$idname}}.update();
{rdelim}

var obj_{{$idname}} = new update_{{$idname}}_available();
</script>