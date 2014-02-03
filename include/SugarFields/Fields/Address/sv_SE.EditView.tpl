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
<script src="include/SugarFields/Fields/Address/SugarFieldAddress.js" language="javascript"></script>
{{assign var="key" value=$displayParams.key|upper}}
{{assign var="street" value=$displayParams.key|cat:'_address_street'}}
{{assign var="city" value=$displayParams.key|cat:'_address_city'}}
{{assign var="country" value=$displayParams.key|cat:'_address_country'}}
{{assign var="postalcode" value=$displayParams.key|cat:'_address_postalcode'}}
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' class="dataLabel" NOWRAP>
{sugar_translate label='LBL_{{$key}}_ADDRESS' module='{{$module}}'}:
{{if $street|lower|in_array:$displayParams.required}}
<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
{{/if}}
</td>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' class='tabEditViewDF' >
{{if $displayParams.maxlength}}
<textarea id="{{$street}}" name="{{$street}}" maxlength="{{$displayParams.maxlength}}" rows="{{$displayParams.rows|default:4}}" cols="{{$displayParams.cols|default:60}}" tabindex="{{$tabindex}}">{$fields.{{$street}}.value}</textarea>
{{else}}
<textarea id="{{$street}}" name="{{$street}}" rows="{{$displayParams.rows|default:4}}" cols="{{$displayParams.cols|default:60}}" tabindex="{{$tabindex}}">{$fields.{{$street}}.value}</textarea>
{{/if}}
</td>
</tr>


<tr>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' class="dataLabel" NOWRAP>
{sugar_translate label='LBL_POSTAL_CODE' module='{{$module}}'}:
{{if $postalcode|lower|in_array:$displayParams.required}}
<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
{{/if}}
</td>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' class='tabEditViewDF' >
<input type="text" name="{{$postalcode}}" id="{{$postalcode}}" size="{{$displayParams.size|default:30}}" {{if !empty($vardef.len)}}maxlength='{{$vardef.len}}'{{/if}} value='{$fields.{{$postalcode}}.value}' tabindex="{{$tabindex}}">
</td>
</tr>

<tr>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' class="dataLabel" NOWRAP>
{sugar_translate label='LBL_CITY' module='{{$module}}'}:
{{if $city|lower|in_array:$displayParams.required}}
<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
{{/if}}
</td>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' class='tabEditViewDF' >
<input type="text" name="{{$city}}" id="{{$city}}" size="{{$displayParams.size|default:30}}" {{if !empty($vardef.len)}}maxlength='{{$vardef.len}}'{{/if}} value='{$fields.{{$city}}.value}' tabindex="{{$tabindex}}">
</td>
</tr>

<tr>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' class="dataLabel" NOWRAP>
{sugar_translate label='LBL_COUNTRY' module='{{$module}}'}:
{{if $country|lower|in_array:$displayParams.required}}
<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
{{/if}}
</td>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' class='tabEditViewDF' >
<input type="text" name="{{$country}}" id="{{$country}}" size="{{$displayParams.size|default:30}}" {{if !empty($vardef.len)}}maxlength='{{$vardef.len}}'{{/if}} value='{$fields.{{$country}}.value}' tabindex="{{$tabindex}}">
</td>
</tr>

{{if $displayParams.copy}}
<tr>
<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' class="dataLabel" NOWRAP>
{sugar_translate label='LBL_COPY_ADDRESS_FROM_LEFT' module=''}:
<input id="{{$displayParams.key}}_checkbox" name="{{$displayParams.key}}_checkbox" type="checkbox" onclick="syncFields('{{$displayParams.copy}}', '{{$displayParams.key}}');">
</td>
</tr>
{{else}}
<tr>
<td colspan="2">&nbsp;</td>
</tr>
{{/if}}
</table>
<script type="text/javascript" language="javascript">
    var fromKey = '{{$displayParams.copy}}';
    var toKey = '{{$displayParams.key}}';
    var checkbox = toKey + "_checkbox";
    var obj = new TestCheckboxReady(checkbox);
</script>
