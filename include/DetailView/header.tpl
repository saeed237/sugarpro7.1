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
{{* Add the preForm code if it is defined (used for vcards) *}}
{{if $preForm}}
	{{$preForm}}
{{/if}}
<script type="text/javascript" src="include/EditView/Panels.js"></script>
<script language="javascript">
{literal}
SUGAR.util.doWhen(function(){
    return $("#contentTable").length == 0 && YAHOO.util.Event.DOMReady;
}, SUGAR.themes.actionMenu);
{/literal}
</script>


<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
{{if !isset($form.buttons)}}
    {{sugar_button module="$module" id="EDIT" view="$view" form_id="formDetailView" appendTo="detail_header_buttons"}}
    {{sugar_button module="$module" id="DUPLICATE" view="EditView" form_id="formDetailView" appendTo="detail_header_buttons"}}
    {{sugar_button module="$module" id="DELETE" view="$view" form_id="formDetailView" appendTo="detail_header_buttons"}}
{{else}}
    {{counter assign="num_buttons" start=0 print=false}}
    {{foreach from=$form.buttons key=val item=button}}
        {{if !is_array($button) && in_array($button, $built_in_buttons)}}
        {{counter print=false}}
        {{sugar_button module="$module" id="$button" fields="$fields" view="EditView" form_id="formDetailView" appendTo="detail_header_buttons"}}
        {{/if}}
    {{/foreach}}
    {{if count($form.buttons) > $num_buttons}}
        {{foreach from=$form.buttons key=val item=button}}
            {{if is_array($button) && $button.customCode}}
                {{sugar_button module="$module" id="$button" view="EditView" form_id="formDetailView" appendTo="detail_header_buttons"}}
            {{/if}}
        {{/foreach}}
    {{/if}}
    {{sugar_button module="$module" id="PDFVIEW" view="$view" form_id="formDetailView" appendTo="detail_header_buttons"}}
    {{sugar_button module="$module" id="PDFEMAIL" view="$view" form_id="formDetailView" appendTo="detail_header_buttons"}}
{{/if}}

{{if empty($form.hideAudit) || !$form.hideAudit}}
    {{sugar_button module="$module" id="Audit" view="EditView" form_id="formDetailView" appendTo="detail_header_buttons"}}
{{/if}}

<form action="index.php" method="post" name="DetailView" id="formDetailView">
    <input type="hidden" name="module" value="{$module}">
    <input type="hidden" name="record" value="{$fields.id.value}">
    <input type="hidden" name="return_action">
    <input type="hidden" name="return_module">
    <input type="hidden" name="return_id">
    <input type="hidden" name="module_tab">
    <input type="hidden" name="isDuplicate" value="false">
    <input type="hidden" name="offset" value="{$offset}">
    <input type="hidden" name="action" value="EditView">
    <input type="hidden" name="sugar_body_only">
{{if isset($form.hidden)}}
{{foreach from=$form.hidden item=field}}
{{$field}}
{{/foreach}}
{{/if}}
</form>
{{sugar_action_menu id="detail_header_action_menu" buttons=$detail_header_buttons class="fancymenu" }}

</div>

</td>


<td align="right" width="20%">{$ADMIN_EDIT}
	{{if $panelCount == 0}}
	    {{* Render tag for VCR control if SHOW_VCR_CONTROL is true *}}
		{{if $SHOW_VCR_CONTROL}}
			{$PAGINATION}
		{{/if}}
		{{counter name="panelCount" print=false}}
	{{/if}}
</td>
{{* Add $form.links if they are defined *}}
{{if !empty($form) && isset($form.links)}}
	<td align="right" width="10%">&nbsp;</td>
	<td align="right" width="100%" NOWRAP class="buttons">
        <div class="actionsContainer">
            {{foreach from=$form.links item=link}}
                {{$link}}&nbsp;
            {{/foreach}}
        </div>
	</td>
{{/if}}
</tr>
</table>
