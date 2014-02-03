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

<tr class='pagination' role='presentation'>
    <td colspan='{$colCount}'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
            <tr>
                <td  nowrap='nowrap' width='1%' align="left" class='paginationChangeButtons'>
                {if $pageData.offsets.current != 0}
                    <button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' onClick='SUGAR.IV.getTable("{$tableID}",0);'>
                        <img src='{sugar_getimagepath file='start.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                    </button>
                    {else}
                    <button type='button' id='listViewStartButton' name='listViewStartButton' title='{$navStrings.start}' class='button' disabled='disabled'>
                        <img src='{sugar_getimagepath file='start_off.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                    </button>
                {/if}
                {if $pageData.offsets.current != 0 }
                    <button type='button' id='listViewPrevButton' name='listViewPrevButton' title='{$navStrings.previous}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.previous});'>
                        <img src='{sugar_getimagepath file='previous.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                    </button>
                    {else}
                    <button type='button' id='listViewPrevButton' name='listViewPrevButton' class='button' title='{$navStrings.previous}' disabled='disabled'>
                        <img src='{sugar_getimagepath file='previous_off.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                    </button>
                {/if}
                    <span class='pageNumbers'>({if $pageData.offsets.lastOffsetOnPage == 0}0{else}{$pageData.offsets.current+1}{/if} - {$pageData.offsets.lastOffsetOnPage} {$navStrings.of} {$pageData.offsets.total})</span>
                {if $pageData.offsets.next > 0}
                    <button type='button' id='listViewNextButton' name='listViewNextButton' title='{$navStrings.next}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.next});'>
                        <img src='{sugar_getimagepath file='next.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                    </button>
                {else}
                    <button type='button' id='listViewNextButton' name='listViewNextButton' class='button' title='{$navStrings.next}' disabled='disabled'>
                        <img src='{sugar_getimagepath file='next_off.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                    </button>
                {/if}
                {if $pageData.offsets.next > 0}
                    <button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.last});' >
                        <img src='{sugar_getimagepath file='end.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                    </button>
                {else}
                    <button type='button' id='listViewEndButton' name='listViewEndButton' title='{$navStrings.end}' disabled='disabled' class='button' onClick='SUGAR.IV.getTable("{$tableID}", {$pageData.offsets.last});' >
                        <img src='{sugar_getimagepath file='end_off.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                    </button>
                {/if}
                </td>
                <td nowrap="nowrap" width='2%' class='paginationActionButtons'></td>
            </tr>
        </table>
    </td>
</tr>