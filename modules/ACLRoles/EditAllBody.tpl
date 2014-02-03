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
<form method='POST' name='EditView' id='ACLEditView'>
<input type='hidden' name='record' value='{$ROLE.id}'>
<input type='hidden' name='module' value='ACLRoles'>
<input type='hidden' name='action' value='Save'>
<input type='hidden' name='return_record' value='{$RETURN.record}'>
<input type='hidden' name='return_action' value='{$RETURN.action}'>
<input type='hidden' name='return_module' value='{$RETURN.module}'> 
<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value='Save';aclviewer.save('ACLEditView');return false;" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " id="SAVE_HEADER"> &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" type='button' name='save' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button' onclick='aclviewer.view("{$ROLE.id}", "All");'>
</p>
<p>
</p>
<TABLE width='100%' class='detail view' border='0' cellpadding=0 cellspacing = 1  >
<TR id="ACLEditView_Access_Header">
<td id="ACLEditView_Access_Header_category"></td>

{foreach from=$ACTION_NAMES item="ACTION_LABEL" key="ACTION_NAME"}
	<td align='center' id="ACLEditView_Access_Header_{$ACTION_NAME}"><div align='center'><b>{$ACTION_LABEL}</b></div></td>
{foreachelse}

          <td colspan="2">&nbsp;</td>

{/foreach}
</TR>
{literal}

	{/literal}
{foreach from=$CATEGORIES item="TYPES" key="CATEGORY_NAME"}


	<TR id="ACLEditView_Access_{$CATEGORY_NAME}">
	<td nowrap width='1%' id="ACLEditView_Access_{$CATEGORY_NAME}_category"><b>
	{if $APP_LIST.moduleList[$CATEGORY_NAME]=='Users'}
	   {$MOD.LBL_USER_NAME_FOR_ROLE}
	{elseif !empty($APP_LIST.moduleList[$CATEGORY_NAME])}
	   {$APP_LIST.moduleList[$CATEGORY_NAME]}
	{else}
        {$CATEGORY_NAME}
	{/if}
	</b></td>
	{foreach from=$ACTION_NAMES item="ACTION_LABEL" key="ACTION_NAME"}
		{assign var='ACTION_FIND' value='false'}
		{foreach from=$TYPES item="ACTIONS"}
			{foreach from=$ACTIONS item="ACTION" key="ACTION_NAME_ACTIVE"}
				{if $ACTION_NAME==$ACTION_NAME_ACTIVE}
					<td nowrap width='{$TDWIDTH}%' style="text-align: center;" id="ACLEditView_Access_{$CATEGORY_NAME}_{$ACTION_NAME}">
					<div  style="display: none" id="{$ACTION.id}">
					{if $APP_LIST.moduleList[$CATEGORY_NAME]==$APP_LIST.moduleList.Users && $ACTION_LABEL != $MOD.LBL_ACTION_ADMIN}
					<select DISABLED name='act_guid{$ACTION.id}' id = 'act_guid{$ACTION.id}' onblur="document.getElementById('{$ACTION.id}link').innerHTML=this.options[this.selectedIndex].text; aclviewer.toggleDisplay('{$ACTION.id}');" >
                    {html_options options=$ACTION.accessOptions selected=$ACTION.aclaccess }
                    </select>
					{else}
					<select name='act_guid{$ACTION.id}' id = 'act_guid{$ACTION.id}' onblur="document.getElementById('{$ACTION.id}link').innerHTML=this.options[this.selectedIndex].text; aclviewer.toggleDisplay('{$ACTION.id}');" >
					{html_options options=$ACTION.accessOptions selected=$ACTION.aclaccess }
					</select>
					{/if}
					</div>
					{if $ACTION.accessLabel == 'dev' || $ACTION.accessLabel == 'admin_dev'}
					   <div class="aclAdmin"  id="{$ACTION.id}link" onclick="aclviewer.toggleDisplay('{$ACTION.id}')">{$ACTION.accessName}</div>
					{else}
                       <div class="acl{$ACTION.accessName}"  id="{$ACTION.id}link" onclick="aclviewer.toggleDisplay('{$ACTION.id}')">{$ACTION.accessName}</div>
                    {/if}
					</td>
					{assign var='ACTION_FIND' value='true'}
				{/if}
			{/foreach}
		{/foreach}
		{if $ACTION_FIND=='false'}
			<td nowrap width='{$TDWIDTH}%' style="text-align: center;" id="ACLEditView_Access_{$CATEGORY_NAME}_{$ACTION_NAME}">
			<div><font color='red'>N/A</font></div>
			</td>
		{/if}
	{/foreach}
	</TR>


{foreachelse}
    <tr> <td colspan="2">No Actions Defined</td></tr>
{/foreach}
</TABLE>
<div style="padding-top:10px;">
&nbsp;<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button" onclick="this.form.action.value='Save';aclviewer.save('ACLEditView');return false;" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " id="SAVE_FOOTER"> &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' type='button' name='save' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button' onclick='aclviewer.view("{$ROLE.id}", "All");'>
</div>
</form>