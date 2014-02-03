{if false}
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

{/if}
 
 <br>
 <p>{$CONFIRM_LAYOUT_DESC}</p>
 <br>
 
 <table width="100%" id="layoutSelection">
 <thead>
    <tr>
        {if $showCheckboxes}
        <th width="5%">&nbsp;</th>
        {/if}
        <th width="25%">{$APP.LBL_MODULE}</th>
        <th width="50%">{$MOD.LBL_LAYOUT_MODULE_TITLE}</th>
    </tr>
</thead>
<tbody>
{foreach from=$METADATA_DATA key=moduleKey item=data}
    <tr>
        {if $showCheckboxes}
        <td>
            <input type="checkbox" name="lm_{$moduleKey}" checked>
        </td>
        {/if}
        <td>
        {$data.moduleName}
        </td>
        <td>
            {foreach from=$data.layouts item=layout}
                    {$layout.label}
                 <br> 
            {/foreach}
        </td>
    </tr>
{/foreach}
</tbody>
</table>

<div id="upgradeDiv" style="display:none">
    <table cellspacing="0" cellpadding="0" border="0">
        <tr><td>
           <p><img src='modules/UpgradeWizard/processing.gif' alt='{$mod_strings.LBL_PROCESSING}'></p>
        </td></tr>
     </table>
 </div>