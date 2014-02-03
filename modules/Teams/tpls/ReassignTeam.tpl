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
{if !empty($ERROR_MESSAGE)}
<font color='red'>{$ERROR_MESSAGE}</font>
{else}
{$TITLE}
{/if}
<br>
<br>
<br>
<br>
<form name="reassign_team" id="reassign_team">
<input type="hidden" name="module" id="module" value="Teams">
<input type="hidden" name="action" id="action" value="ReassignTeams">
<input type="hidden" name="teams" id="teams" value="{$TEAMS}">
<table class="edit view" cellspacing="1" cellpadding="0">
<tr>
<td scope="row" width="10%" NOWRAP>
{$MOD_STRINGS.LBL_NEW_FORM_TITLE}: <span class="required">*</span>
</td>
<td width="90%">
<input autocomplete='off' class='sqsEnabled' type='text' name='team_name' id='team_name' size='30' maxlength='' value=''> 
<input type="hidden"  name='team_id' id='team_id' value=''>
<input type="button" name="btn_team_name" tabindex="" title="{$APP_STRINGS.LBL_SELECT_BUTTON_TITLE}" class="button" value="{$APP_STRINGS.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("Teams", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"reassign_team","field_to_name_array":{"id":"team_id","name":"team_name"}}{/literal}, "single", true);'>
<input type="button" name="btn_clr_team_name" tabindex="" title="{$APP_STRINGS.LBL_CLEAR_BUTTON_TITLE}" class="button" onclick="this.form.team_name.value = ''; this.form.id_team_name.value = '';" value="{$APP_STRINGS.LBL_CLEAR_BUTTON_LABEL}">
</td>
</tr>
</table>
<br>
<br>
<input type="submit" class="button"  title="{$MOD_STRINGS.LBL_REASSIGN_TEAM_BUTTON_TITLE}" value="{$MOD_STRINGS.LBL_REASSIGN_TEAM_BUTTON_LABEL}" onclick="if(check_form('reassign_team')) {ldelim} return confirm('{$MOD_STRINGS.LBL_CONFIRM_REASSIGN_TEAM_LABEL}'); {rdelim} else {ldelim} return false; {rdelim}">
<input type="submit" class="button" accesskey="{$APP_STRINGS.LBL_CANCEL_BUTTON_KEY}" title="{$APP_STRINGS.LBL_CANCEL_BUTTON_TITLE}" value="{$APP_STRINGS.LBL_CANCEL_BUTTON_LABEL}" onclick="this.form.action.value='index';">
</form>


{literal}
<script language="javascript">
if(typeof sqs_objects == 'undefined') {
   var sqs_objects = new Array();
}
   
sqs_objects['reassign_team_team_name']={"form":"reassign_team","method":"query","modules":["Teams"],"group":"or","field_list":["name","id"],"populate_list":["team_name","team_id"],"required_list":["team_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""},{"name":"name","op":"like_custom","begin":"(","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};
{/literal}
addToValidate('reassign_team', 'team_name', 'varchar', true, '{$MOD_STRINGS.LBL_NEW_FORM_TITLE}');
enableQS();
</script>