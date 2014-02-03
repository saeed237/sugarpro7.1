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
	<form name="editMailingListForm" id="editMailingListForm">
		<input type="hidden" id="mailing_list_id" name="mailing_list_id" value="{$mailing_list_id}">
	<table>
		<tr>
			<td colspan="2">
				<input type="button" class="button" id="ml_save" 
					value="   {$app_strings.LBL_SAVE_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.editMailingListSave();"
				>&nbsp;
				<input type="button" class="button" id="ml_save" 
					value="   {$app_strings.LBL_EMAIL_REVERT}   "
					onclick="javascript:SUGAR.email2.addressBook.editMailingListRevert();"
				>&nbsp;
				<input type="button" class="button" id="ml_cancel" 
					value="   {$app_strings.LBL_CANCEL_BUTTON_LABEL}   "
					onclick="javascript:SUGAR.email2.addressBook.cancelEdit();"
				>
				<br>&nbsp;
			</td>
		</tr>
		<tr>
			<td scope="row">
				<b>{$app_strings.LBL_EMAIL_ML_NAME}</b>
			</td>
			<td >
				<input class="input" name="mailing_list_name" id="mailing_list_name" value="{$mailing_list_name}">
			</td>
		</tr>
		<tr>
			<td scope="row" align="top" height="200">
				<b>{$app_strings.LBL_EMAIL_ML_ADDRESSES_1}</b>
				<br />&nbsp;<br />
				<div id="ml_used" style="overflow:auto; height:90%; margin:5px; padding:2px; border:1px solid #ccc;"></div>
			</td>
			<td scope="row" align="top" height="200">
				<b>{$app_strings.LBL_EMAIL_ML_ADDRESSES_2}</b>
				<br />&nbsp;<br />
				<div id="ml_available" style="overflow:auto; height:90%; margin:5px; padding:2px; border:1px solid #ccc;"></div>
			</td>
		</tr>
	</table>
	</form>
</div>