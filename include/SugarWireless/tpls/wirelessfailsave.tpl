
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
<p>{$MESSAGE}</p>
<form action="index.php" method="POST">
{foreach from=$REQUEST_VALS key=name item=value}
<input type='hidden' name='{$name}' value='{$value}'>
{/foreach}
<input type='hidden' name="action" value="wirelessedit">
<input type='hidden' name="failsave" value="1">
<input type="submit" value="{sugar_translate label='LBL_BACK' module=''}" />
</form>