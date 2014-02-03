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
<script src="{sugar_getjspath file='modules/ACLRoles/ACLRoles.js'}"></script>
<b>{$MOD.LBL_EDIT_VIEW_DIRECTIONS}</b>
<table width='100%'><tr>
<td valign='top'>
<TABLE class='edit view' border='0' cellpadding=0 cellspacing = 1  >
<tr> <td colspan="2" scope="row"><a href='javascript:void(0);' onclick='aclviewer.view("{$ROLE.id}", "All");'><b>{$MOD.LBL_ALL}</b></a></td></tr>

{foreach from=$CATEGORIES2 item="TYPES" key="CATEGORY_NAME"}
{if $APP_LIST.moduleList[$CATEGORY_NAME]!='Users'}
<TR>
<td nowrap width='1%' scope="row"><a href='javascript:void(0);' onclick='aclviewer.view("{$ROLE.id}", "{$CATEGORY_NAME}");'><b>{$APP_LIST.moduleList[$CATEGORY_NAME]}</b></a></td>
</TR>
{/if}
	{foreachelse}

         <tr> <td colspan="2">{$MOD.LBL_NO_MODULES_AVAILABLE}</td></tr>

{/foreach}
</TABLE>
</td>
<td width= '100%'  valign='top'>
<div id='category_data'>
{include file='modules/ACLRoles/EditAllBody.tpl'}
</div>
</td></tr>
</table>


