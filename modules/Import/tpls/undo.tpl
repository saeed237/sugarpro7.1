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
<br>
{if $UNDO_SUCCESS}
<h3>{$MOD.LBL_LAST_IMPORT_UNDONE}</h3>
{else}
<h3>{$MOD.LBL_NO_IMPORT_TO_UNDO}</h3>
{/if}
<br />
<form enctype="multipart/form-data" name="importundo" method="POST" action="index.php" id="importundo">
<input type="hidden" name="module" value="Import">
<input type="hidden" name="action" value="Step1">
<input type="hidden" name="import_module" value="{$IMPORT_MODULE}">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
    <td align="left">
       <input title="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}"  class="button" type="submit" name="button"
            value="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}">

        <input title="{$MOD.LBL_FINISHED}{$MODULENAME}"  class="button" type="button"
            name="finished" id="finished" value="{$MOD.LBL_IMPORT_COMPLETE}">
    </td>
</tr>
</table>
<br />
</form>

