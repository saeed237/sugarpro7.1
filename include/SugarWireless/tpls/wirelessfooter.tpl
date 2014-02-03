
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
<!-- Logout -->
<hr />
<div id="footerlinks">
{if $VIEW != 'wirelessmain'}
<small><a href="index.php?module=Users&action=wirelessmain">{sugar_translate label='LBL_TABGROUP_HOME' module=''}</a></small> | 
{/if}
<small><a href="javascript:history.back();">{sugar_translate label='LBL_BACK' module=''}</a></small> |
{if $display_employees}
<small><a href="index.php?module=Employees&action=wirelessmodule">{sugar_translate label='LBL_EMPLOYEES' module=''}</a></small> |
{/if}
<small><a href="index.php?module=Users&action=Logout">{sugar_translate label='LBL_LOGOUT' module=''}</a></small>
</div>

</body>
</html>