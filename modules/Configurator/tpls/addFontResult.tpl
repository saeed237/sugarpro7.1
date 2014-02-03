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

<p>
{$MODULE_TITLE}
</p>
<form name="addFontResult" method="POST" action="index.php" id="addFontResult">
<input type="hidden" name="module" value="Configurator">
<input type="hidden" name="action" value="FontManager">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding-bottom: 2px;">
            <input title="{$MOD.LBL_FONTMANAGER_TITLE}" class="button"  type="submit" name="back" value="  {$MOD.LBL_FONTMANAGER_BUTTON}  " >
        </td>
    </tr>
</table>
<br>
<div>{if isset($error)}<span class='error'><b>{$MOD.LBL_STATUS_FONT_ERROR}</b></span>{else}<b>{$MOD.LBL_STATUS_FONT_SUCCESS}</b>{/if}</div>
<span class='error'><pre>{$error}</pre></span>
<pre>{$info}</pre>
</form>