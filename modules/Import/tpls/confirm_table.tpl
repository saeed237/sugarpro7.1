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
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="importTable" class="detail view noBorder" style="box-shadow: none; -moz-box-shadow: none. -webkit-box-shadow: none;">
    <tbody>
        {foreach from=$SAMPLE_ROWS item=row name=row}
            <tr>
                {foreach from=$row item=value}
                    {if $smarty.foreach.row.first}
                        {if $HAS_HEADER}
                            <td scope="col" style="text-align: left;">{$value}</td>
                        {else}
                            <td scope="col" style="text-align: left;" colspan="{$column_count}">{$MOD.LBL_MISSING_HEADER_ROW}</td>
                        {/if}
                     {else}
                        <td class="impSample">{$value}</td>
                     {/if}
                {/foreach}
            </tr>
        {/foreach}
    </tbody>
</table>
