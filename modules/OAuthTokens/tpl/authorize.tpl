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
<form name="OAuthAuthorize" method="POST" action="index.php" >
<input type='hidden' name='action' value='authorize'/>
<input type='hidden' name='module' value='OAuthTokens'/>
<input type='hidden' name='sid' value='{$sid}'/>
<input type='hidden' name='hash' value='{$hash}'/>
<input type='hidden' name='confirm' value='1'/>

{$consumer}<br/>
<table>
<tr>
<td>{$MOD.LBL_OAUTH_REQUEST}: </td><td><input name="token" value="{$token}"/></td>
</tr>
</table>

<input type="submit" name="authorize" value="{$MOD.LBL_OAUTH_AUTHORIZE}"/><br/>
</form>
