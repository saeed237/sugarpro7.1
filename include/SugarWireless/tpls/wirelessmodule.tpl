
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
<hr />
<div class="sectitle">{sugar_translate label='LBL_SEARCH' module=''} {$MODULE_NAME} {sugar_translate label='LBL_MODULE' module=''}</div>
<!--  Saved Searches -->
{$WL_SAVED_SEARCH_FORM}
<!--  Search Def Searches -->
{$WL_SEARCH_FORM}
{if $DISPLAY_CREATE}
<!--  Create New Record -->
<div class="sec">
<form action="index.php" method="POST">
	<input class="button" type="submit" value="{sugar_translate label='LBL_CREATE_BUTTON_LABEL' module=''}" />
	<input type="hidden" name="module" value="{$MODULE}" />
	<input type="hidden" name="action" value="wirelessedit" />
    <input type="hidden" name="return_module" value="{$MODULE}" />
    <input type="hidden" name="return_action" value="wirelessmodule" />
</form>
</div>
{/if}
