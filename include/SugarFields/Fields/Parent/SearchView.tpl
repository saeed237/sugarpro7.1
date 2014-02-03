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
<select name='{{$vardef.type_name}}' {{if !empty($tabindex)}} tabindex="{{$tabindex}}" {{/if}}  id='{{$vardef.type_name}}' title='{{$vardef.help}}'
onchange='document.{{$form_name}}.{{sugarvar key='name'}}.value="";document.{{$form_name}}.parent_id.value=""; 
        changeParentQSSearchView("{{sugarvar key='name'}}"); checkParentType(document.{{$form_name}}.{{$vardef.type_name}}.value, document.{{$form_name}}.btn_{{sugarvar key='name'}});'>
{html_options options={{sugarvar key='options' string=true}} selected=$fields.{{$vardef.type_name}}.value}
</select>
<br>
{if empty({{sugarvar key='options' string=true}}[$fields.{{$vardef.type_name}}.value])}
	{assign var="keepParent" value = 0}
{else}
	{assign var="keepParent value = 1}
{/if}
<input type="text" name="{{sugarvar key='name'}}" id="{{sugarvar key='name'}}" class="sqsEnabled" {{if !empty($tabindex)}} tabindex="{{$tabindex}}" {{/if}}  size="{{$displayParams.size}}" value="{{sugarvar key='value'}}" autocomplete="off"><input type="hidden" name="{{$vardef.id_name}}" id="{{$vardef.id_name}}"  {if $keepParent}value="{{sugarvar memberName='vardef.id_name' key='value'}}"{/if}>
<span class="id-ff multiple">
<button type="button" name="btn_{{sugarvar key='name'}}" {{if !empty($tabindex)}} tabindex="{{$tabindex}}" {{/if}}  title="{$APP.LBL_SELECT_BUTTON_TITLE}"
	   class="button{{if empty($displayParams.selectOnly)}} firstChild{{/if}}" value="{$APP.LBL_SELECT_BUTTON_LABEL}"
	   onclick='if(document.{{$form_name}}.{{$vardef.type_name}}.value != "") open_popup(document.{{$form_name}}.{{$vardef.type_name}}.value, 600, 400, "", true, false, {{$displayParams.popupData}}, "single", true);'>{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button>
{{if empty($displayParams.selectOnly)}}
<button type="button" name="btn_clr_{{sugarvar key='name'}}" {{if !empty($tabindex)}} tabindex="{{$tabindex}}" {{/if}}  title="{$APP.LBL_CLEAR_BUTTON_TITLE}"  class="button lastChild" onclick="this.form.{{sugarvar key='name'}}.value = ''; this.form.{{sugarvar key='id_name'}}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">
{sugar_getimage alt=$app_strings.LBL_ID_FF_CLEAR name="id-ff-clear" ext=".png" other_attributes=''}
</button>
{{/if}}
</span>
{literal}
<script type="text/javascript">
if (typeof(changeParentQSSearchView) == 'undefined'){
function changeParentQSSearchView(field) {
	field = YAHOO.util.Dom.get(field);
    var form = field.form;
    var sqsId = form.id + "_" + field.id;
    var typeField =  form.elements["{{$vardef.type_name}}"];
    var new_module = typeField.value;
    if(typeof(disabledModules[new_module]) != 'undefined') {
		sqs_objects[sqsId]["disable"] = true;
		field.readOnly = true;
	} else {
		sqs_objects[sqsId]["disable"] = false;
		field.readOnly = false;
    }
	//Update the SQS globals to reflect the new module choice
    sqs_objects[sqsId]["modules"] = new Array(new_module);
    if (typeof(QSFieldsArray[sqsId]) != 'undefined')
    {
        QSFieldsArray[sqsId].sqs.modules = new Array(new_module);
    }
	if(typeof QSProcessedFieldsArray != 'undefined')
    {
	   QSProcessedFieldsArray[sqsId] = false;
    }
    enableQS(false);
}}
YAHOO.util.Event.onContentReady(
{/literal}
"{{sugarvar key='name'}}"
{literal}
, function() {
    changeParentQSSearchView(
{/literal}
"{{sugarvar key='name'}}"
{literal}
    );
});
</script>
{{$displayParams.disabled_parent_types}}
{/literal}