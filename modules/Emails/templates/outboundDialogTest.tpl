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
<div id="testOutbound">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
			<tr>
				<td scope="row">
					{$app_strings.LBL_EMAIL_SETTINGS_FROM_TO_EMAIL_ADDR} 
					<span class="required">
						{$app_strings.LBL_REQUIRED_SYMBOL}
					</span>
				</td>
				<td >
					<input type="text" id="outboundtest_from_address" name="outboundtest_from_address" size="35" maxlength="64" value="{$CURRENT_USER_EMAIL}">
				</td>
			</tr>
			<tr>
				<td scope="row" colspan="2">
					<input type="button" class="button" value="   {$app_strings.LBL_EMAIL_SEND}   " onclick="javascript:SUGAR.email2.accounts.testOutboundSettings();">&nbsp;
					<input type="button" class="button" value="   {$app_strings.LBL_CANCEL_BUTTON_LABEL}   " onclick="javascript:SUGAR.email2.accounts.testOutboundDialog.hide();">&nbsp;
				</td>
			</tr>

		</table>
</div>
