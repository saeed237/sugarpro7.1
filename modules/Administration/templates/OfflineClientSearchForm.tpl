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

/*********************************************************************************

 ********************************************************************************/
*}

{$JAVASCRIPT}
<form class="search_form" id="search_form">
<div class="edit view search basic">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
    <td scope="row" width="1%" nowrap="nowrap"><slot>{$MOD.LBL_USER_NAME}</slot></td>
    <td width="1%"><slot><input type="text" size="10" name="user_name" value="{$USER_NAME}"></slot></td>
    <td style="padding-left: 10px ! important;">
        <input type="hidden" name="action" value="ViewOfflineClients"/>
        <input type="hidden" name="query" value="true"/>
        <input type="hidden" name="module" value="Administration" />
        <input title="{$APP.LBL_SEARCH_BUTTON_TITLE}" id="search_form_submit" class="button" type="submit" name="button" value="{$APP.LBL_SEARCH_BUTTON_LABEL}"/>
        <input title="{$APP.LBL_CLEAR_BUTTON_TITLE}" id="search_form_clear" onclick="clear_form(this.form);" class="button" type="button" name="clear" value=" {$APP.LBL_CLEAR_BUTTON_LABEL} "/>
    </td>
</tr>
</table>
</div>
</form>
