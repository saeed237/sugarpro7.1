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
<script language="javascript">
    {literal}
    SUGAR.util.doWhen(function(){
        return $("#contentTable").length == 0;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
<form action="index.php" method="POST" name="EditView" id="EditView" >
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
<tr>
<td class="buttons">
<input type="hidden" name="module" value="{$module}">

<input type="hidden" name="record" value="{$fields.id.value}">
<input type="hidden" name="isDuplicate" value="{$smarty.request.isDuplicate}">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="{$smarty.request.return_module}">
<input type="hidden" name="return_action" value="{$smarty.request.return_action}">
<input type="hidden" name="return_id" value="{$smarty.request.return_id}">
<input type="hidden" name="module_tab">
<input type="hidden" name="contact_role">
<input type="hidden" name="relate_to" value="{$smarty.request.return_module}">
<input type="hidden" name="relate_id" value="{$smarty.request.return_id}">
<input type="hidden" name="offset" value="1">
<input name="assigned_user_id" type="hidden" value="{$fields.assigned_user_id.value}" autocomplete="off">
{{if empty($form.button_location) || $form.button_location == 'top'}}
{{if !empty($form) && !empty($form.buttons)}}
   {{foreach from=$form.buttons key=val item=button}}
      {{sugar_button module="$module" id="$button" view="$view" appendTo="action_button"}}
   {{/foreach}}
{{else}}
{{sugar_button module="$module" id="SAVE" view="$view" appendTo="action_button"}}
{{sugar_button module="$module" id="CANCEL" view="$view" appendTo="action_button"}}
{{/if}}
{{if empty($form.hideAudit) || !$form.hideAudit}}
{{sugar_button module="$module" id="Audit" view="$view" appendTo="action_button"}}
{{/if}}
{{/if}}
{{sugar_action_menu buttons=$action_button id="EAPMActionMenu" class="fancymenu" flat=true}}
    <td align='right'>
</td>

</tr>
</table>