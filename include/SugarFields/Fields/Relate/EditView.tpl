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
<input type="text" name="{{$idname}}" class={{if empty($displayParams.class) }}"sqsEnabled"{{else}} "{{$displayParams.class}}" {{/if}} tabindex="{{$tabindex}}" id="{{$idname}}" size="{{$displayParams.size}}" value="{{sugarvar key='value'}}" title='{{$vardef.help}}' autocomplete="off" {{$displayParams.readOnly}} {{$displayParams.field}}	{{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}} >
<input type="hidden" name="{{if !empty($displayParams.idNameHidden)}}{{$displayParams.idNameHidden}}{{/if}}{{sugarvar key='id_name'}}" 
	id="{{if !empty($displayParams.idNameHidden)}}{{$displayParams.idNameHidden}}{{/if}}{{sugarvar key='id_name'}}" 
	{{if !empty($vardef.id_name)}}value="{{sugarvar memberName='vardef.id_name' key='value'}}"{{/if}}>
{{if empty($displayParams.hideButtons) }}
<span class="id-ff multiple">
<button type="button" name="btn_{{$idname}}" id="btn_{{$idname}}" tabindex="{{$tabindex}}" title="{sugar_translate label="{{$displayParams.accessKeySelectTitle}}"}" class="button firstChild" value="{sugar_translate label="{{$displayParams.accessKeySelectLabel}}"}"
onclick='open_popup(
    "{{sugarvar key='module'}}", 
	600, 
	400, 
	"{{$displayParams.initial_filter}}", 
	true, 
	false, 
	{{$displayParams.popupData}}, 
	"single", 
	true
);' {{if isset($displayParams.javascript.btn)}}{{$displayParams.javascript.btn}}{{/if}}><img src="{sugar_getimagepath file="id-ff-select.png"}"></button>{{if empty($displayParams.selectOnly) }}<button type="button" name="btn_clr_{{$idname}}" id="btn_clr_{{$idname}}" tabindex="{{$tabindex}}" title="{sugar_translate label="{{$displayParams.accessKeyClearTitle}}"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{{$idname}}', '{{if !empty($displayParams.idName)}}{{$displayParams.idName}}_{{/if}}{{sugarvar key='id_name'}}');"  value="{sugar_translate label="{{$displayParams.accessKeyClearLabel}}"}" {{if isset($displayParams.javascript.btn_clear)}}{{$displayParams.javascript.btn_clear}}{{/if}}><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
{{/if}}
</span>
{{/if}}
{{if !empty($displayParams.allowNewValue) }}
<input type="hidden" name="{{$idname}}_allow_new_value" id="{{$idname}}_allow_new_value" value="true">
{{/if}}
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{{$idname}}']) != 'undefined'",
		enableQS
);
</script>
