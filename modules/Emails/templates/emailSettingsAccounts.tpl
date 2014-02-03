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
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="view">
	<tr>
		<td NOWRAP>
			{include file="modules/Emails/templates/emailSettingsAccountDetails.tpl"}
		</td>
	</tr>
    	<tr>
                                	<td align="right">
                                	   <input type="button" class="button" style="margin-left:5px;" value="   {$app_strings.LBL_EMAIL_DONE_BUTTON_LABEL}   " onclick="javascript:SUGAR.email2.settings.saveOptionsGeneral(true);">
                                    </td>
                            	</tr>
	

</table>
