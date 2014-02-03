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
		<th colspan="4">
			<h4>{$app_strings.LBL_EMAIL_FOLDERS_TITLE}</h4>
		</th>
	</tr>
    <tr>
		<td NOWRAP style="padding: 8px;" valign="top" scope="row">
			<div>
				{$app_strings.LBL_EMAIL_SETTINGS_USER_FOLDERS}:
				<div id="rollover">
                    <a href="#" class="rollover">{sugar_getimage alt=$mod_strings.LBL_HELP name="helpInline" ext=".gif" other_attributes='border="0" '}<span>{$app_strings.LBL_EMAIL_MULTISELECT}</span></a>
                </div>
			</div>
			<br/>
			<div>
				<select multiple size="8" STYLE="width: 140px" name="userFolders[]" id="userFolders" onchange="SUGAR.email2.folders.updateSubscriptions();"></select>
			</div>
		</td>

	</tr>
	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td align="right">
    	   <input type="button" class="button" style="margin-left:5px;" value="   {$app_strings.LBL_EMAIL_DONE_BUTTON_LABEL}   " onclick="javascript:SUGAR.email2.settings.saveOptionsGeneral(true);">
        </td>
	</tr>
</table>
