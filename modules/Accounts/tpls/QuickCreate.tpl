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
<form action="index.php" method="POST" name="{$form_name}" id="{$form_id}" {$enctype}>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<input type="hidden" name="module" value="{$module}">
{if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}
<input type="hidden" name="record" value="">
{else}
<input type="hidden" name="record" value="{$fields.id.value}">
{/if}
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="{$smarty.request.return_module}">
<input type="hidden" name="return_action" value="{$smarty.request.return_action}">
<input type="hidden" name="return_id" value="{$smarty.request.return_id}">
<input type="hidden" name="contact_role">
{if !empty($smarty.request.return_module)}
<input type="hidden" name="relate_to" value="{if $smarty.request.return_relationship}{$smarty.request.return_relationship}{elseif empty($isDCForm)}{$smarty.request.return_module}{/if}">
<input type="hidden" name="relate_id" value="{$smarty.request.return_id}">
{/if}
<input type="hidden" name="offset" value="{$offset}">
{{if isset($form.hidden)}}
{{foreach from=$form.hidden item=field}}
{{$field}}   
{{/foreach}}
{{/if}}

{* -- Begin QuickCreate Specific -- *}
{if $smarty.request.action != 'SubpanelEdits'}
<input type="hidden" name="primary_address_street" value="{$smarty.request.primary_address_street}">
<input type="hidden" name="primary_address_city" value="{$smarty.request.primary_address_city}">
<input type="hidden" name="primary_address_state" value="{$smarty.request.primary_address_state}">
<input type="hidden" name="primary_address_country" value="{$smarty.request.primary_address_country}">
<input type="hidden" name="primary_address_postalcode" value="{$smarty.request.primary_address_postalcode}">
{/if}
<input type="hidden" name="is_ajax_call" value="1">
<input type="hidden" name="to_pdf" value="1">
{* -- End QuickCreate Specific -- *}

{{if empty($form.button_location) || $form.button_location == 'top'}}
{{if !empty($form) && !empty($form.buttons)}}
   {{foreach from=$form.buttons key=val item=button}}
      {{sugar_button module="$module" id="$button" view="$view"}}
   {{/foreach}}
{{else}}
{{sugar_button module="$module" id="SAVE" view="$view"}}
{{sugar_button module="$module" id="CANCEL" view="$view"}}
{{/if}}
{{if empty($form.hideAudit) || !$form.hideAudit}}
{{sugar_button module="$module" id="Audit" view="$view"}}
{{/if}}
{{/if}}
</td>
<td align='right'>{{$ADMIN_EDIT}}</td>
</tr>
</table>