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

{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
{literal}
<script language="Javascript">
	function timeValueUpdate(){
		var fieldname = 'defaultTime';
		var timeseparator = ':';
		var newtime = '';
		
		id = fieldname + '_hours';
		h = window.document.getElementById(id).value;
		id = fieldname + '_minutes';
		m = window.document.getElementById(id).value;
		
		id = fieldname + '_meridiem';
		ampm = '';
		if(document.getElementById(id)) {
		   ampm = document.getElementById(id).value;
		}
		newtime = h + timeseparator + m + ampm;
		document.getElementById(fieldname).value = newtime;
		
	}
</script>
{/literal}
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
	<td>
	{if $hideLevel < 5}
		{html_options name='defaultDate' id='defaultDate_date' options=$default_values selected=$default_date}
	{else}
		<input type='hidden' name='defaultDate' value='{$default_date}'>{$default_date}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'></td>
	<td>
	{if $hideLevel < 5}
		  <div>
			{html_options name='defaultHours'  size='1' id='defaultTime_hours' options=$default_hours_values onchange="timeValueUpdate();"  selected=$default_hours}
		   :
		 {html_options  name='defaultMinutes'   size='1'  id='defaultTime_minutes' options=$default_minutes_values onchange="timeValueUpdate();"  selected=$default_minutes}
		 {if $show_meridiem === true}
		 {html_options  name='defaultMeridiem'  size='1'  id='defaultTime_meridiem' options=$default_meridiem_values onchange="timeValueUpdate();"  selected=$default_meridiem}
		 {/if}
		</div>
		<input type='hidden' name='defaultTime' id='defaultTime' value="{$defaultTime}">
	{else}
		<input type='hidden' name='defaultTime' id='defaultTime' value='{$defaultTime}'>{$defaultTime}
	{/if}
	</td>
</tr>
<tr>
	<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MASS_UPDATE"}:</td>
	<td>
	{if $hideLevel < 5}
		<input type="checkbox" id="massupdate" name="massupdate" value="1" {if !empty($vardef.massupdate)}checked{/if}/>
	{else}
		<input type="checkbox" id="massupdate" name="massupdate" value="1" disabled {if !empty($vardef.massupdate)}checked{/if}/>
	{/if}
	</td>
</tr>
{if $range_search_option_enabled}
<tr>	
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_ENABLE_RANGE_SEARCH"}:</td>
    <td>
        <input type='checkbox' name='enable_range_search' value=1 {if !empty($vardef.enable_range_search) }checked{/if} {if $hideLevel > 5}disabled{/if} />
        {if $hideLevel > 5}<input type='hidden' name='enable_range_search' value='{$vardef.enable_range_search}'>{/if}
    </td>	
</tr>
{/if}
<script>
addToValidateBinaryDependency('popup_form',"defaultDate_date", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_DATE} {$APP.LBL_OR} {$APP.LBL_HOURS}" ,"defaultTime_hours");
addToValidateBinaryDependency('popup_form',"defaultTime_hours", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_HOURS} {$APP.LBL_OR} {$APP.LBL_MINUTES}" ,"defaultTime_minutes");
addToValidateBinaryDependency('popup_form', "defaultTime_minutes", 'alpha', false, "{$APP.ERR_MISSING_REQUIRED_FIELDS} {$APP.LBL_MINUTES} {$APP.LBL_OR} {$APP.LBL_MERIDIEM}","defaultTime_meridiem");
</script>
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}