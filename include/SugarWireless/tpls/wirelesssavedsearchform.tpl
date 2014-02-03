
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
{if $WL_SAVED_SEARCH_OPTIONS != null}
<div class="sec">
<div class="search_sec">{sugar_translate label='LBL_SAVED_SEARCH_SHORTCUT' module=''}</div><br />
<form method="post" action="index.php">
<select name="wl_saved_search_select">
	{$WL_SAVED_SEARCH_OPTIONS}
</select>
<input class="button" type="submit" value="{sugar_translate label='LBL_SEARCH' module=''}" />
<input type="hidden" name="module" value="{$MODULE}" />
<input type="hidden" name="action" value="wirelesslist" />
<input type="hidden" name="query" value="true" />
<input type="hidden" name="searchFormTab" value="advanced_search" />
</form>
</div>
{/if}