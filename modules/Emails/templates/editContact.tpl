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
<div class="ydlg-bd">
	<form name="editContactForm" id="editContactForm">
		<input type="hidden" id="contact_id" name="contact_id" value="{$contact.id}">
	<table>
		<tr>
			<td colspan="4">
				<input type="button" class="button" id="contact_save" 
					value="   {$app_strings.LBL_SAVE_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.saveContact();"
				>&nbsp;
				<input type="button" class="button" id="contact_full_form" 
					value="   {$app_strings.LBL_FULL_FORM_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.fullForm('{$contact.id}', '{$contact.module}');"
				>&nbsp;
				<input type="button" class="button" id="contact_cancel" 
					value="   {$app_strings.LBL_CANCEL_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.cancelEdit();"
				>
				<br>&nbsp;
			</td>
		</tr>
		<tr>
			<td scope="row">
				<b>{$contact_strings.LBL_FIRST_NAME}</b>
			</td>
			<td >
				<input class="input" name="contact_first_name" id="contact_first_name" value="{$contact.first_name}">
			</td>
			<td scope="row">
				<b>{$contact_strings.LBL_LAST_NAME}</b> <span class="error">*</span>
			</td>
			<td >
				<input class="input" name="contact_last_name" id="contact_last_name" value="{$contact.last_name}">
			</td>
		</tr>
		<tr>
			<td scope="row" colspan="4">
				<b>{$contact_strings.LBL_EMAIL_ADDRESSES}</b>
			</td>
		</tr>
		<tr>
			<td  colspan="4">
				{$emailWidget}
			</td>
		</tr>
		<tr>
			<td scope="row" colspan="4">
				<i>{$app_strings.LBL_EMAIL_EDIT_CONTACT_WARN}</i>
			</td>
		</tr>
	</table>
	</form>
</div>