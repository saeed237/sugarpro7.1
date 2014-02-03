
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
<br />
{sugar_translate label='LBL_SELECT_MODULE' module=''}<br />
<form method="post" action="index.php">
	<select name="module">
		{foreach from=$WL_MODULE_LIST item=VALUE key=KEY}
		<option value="{$KEY}" {if $MODULE == $KEY}selected{/if}>{$VALUE}</option>
		{/foreach}
	</select>
	<input type="submit" class="button" value="{sugar_translate label='LBL_GO_BUTTON_LABEL' module=''}" />
	<input type="hidden" value="wirelessmodule" name="action" />	
</form>