
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
{if $login_error}<br /><div class="error"><small>{$error_message}</small></div><br />{/if}
<!-- LOGIN FORM -->
<div class="sec">
<form method="post" action="index.php">
	<small>{$LBL_USER_NAME}:</small><br />
	<input type="text" name="user_name" value="" autocorrect="off" autocapitalize="off" /><br/>
	<small>{$LBL_PASSWORD}:</small><br />
	<input type="password" value="" name="user_password" /><br/>
	<input type="submit" value="{$LBL_LOGIN_BUTTON_LABEL}" />
	<input type="hidden" value="Users" name="module" />
	<input type="hidden" value="Authenticate" name="action" />
	<input type="hidden" value="Users" name="return_module" />
	{foreach from=$LOGIN_VARS key=key item=var}
		<input type="hidden" name="{$key}" value="{$var}">
	{/foreach}
</form>
<p>
<a href="index.php?module=Users&action=Login&mobile=0">{$LBL_NORMAL_LOGIN}</a>
</p>
</div>