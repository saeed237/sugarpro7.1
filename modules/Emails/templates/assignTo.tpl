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
<form name="Distribute" id="Distribute">
<input type="hidden" name="emailUIAction" value="doAssignmentAssign">

<input type="hidden" name="distribute_method" value="direct">
<input type="hidden" name="action" value="Distribute">


<table cellpadding="4" cellspacing="0" border="0" width="100%" class="edit view"> 
    <tr>
        <td scope="row" nowrap="nowrap" valign="top" >
        {sugar_translate label="LBL_ASSIGNED_TO"}:
        </td>
        <td nowrap="nowrap" width="37%">
        <input name="assigned_user_name" class="sqsEnabled" tabindex="2" id="assigned_user_name" size="" value="{$currentUserName}" type="text">
        <input name="assigned_user_id" id="assigned_user_id" value="{$currentUserId}" type="hidden">
        <input name="btn_assigned_user_name" tabindex="2" title="{$app_strings.LBL_SELECT_BUTTON_TITLE}" class="button" value="{$app_strings.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("Users", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"Distribute","field_to_name_array":{"id":"assigned_user_id","name":"assigned_user_name"}}{/literal}, "single", true);' type="button">
        <input name="btn_clr_assigned_user_name" tabindex="2" title="{$app_strings.LBL_CLEAR_BUTTON_TITLE}" class="button" onclick="this.form.assigned_user_name.value = ''; this.form.assigned_user_id.value = '';" value="{$app_strings.LBL_CLEAR_BUTTON_LABEL}" type="button">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	   <td scope="row" nowrap="nowrap" valign="top">{$app_strings.LBL_TEAMS}:&nbsp;</td>
    	   <td >{$TEAM_SET_FIELD_FOR_ASSIGNEDTO}</td>
    	   <td>&nbsp;</td>
    </tr>
    <tr><td>&nbsp</td><td>&nbsp</td></tr>
    <tr>
    	   <td>&nbsp;</td>
    	   <td>&nbsp;</td>
    	   <td align="right"><input type="button" class="button" style="margin-left:5px;" value="{$mod_strings.LBL_BUTTON_DISTRIBUTE}" onclick="AjaxObject.detailView.handleAssignmentDialogAssignAction();"></td>
    </tr>
</table>

</form>

