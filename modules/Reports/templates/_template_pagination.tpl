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

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
	<tr>
		<td align="right">&nbsp;&nbsp;<span class='pageNumbers'><button type='button' title='{$app_strings.LNK_LIST_START}' {if isset($start_link_onclick)} {$start_link_onclick} {/if} class='button' {if ($start_link_disabled)} disabled {/if}>{$start_link_ImagePath}</button>&nbsp;<button type='button' title='{$app_strings.LNK_LIST_PREVIOUS}' {if isset($prev_link_onclick)} {$prev_link_onclick} {/if} class='button' {if ($prev_link_disabled)} disabled {/if}>{$prev_link_ImagePath}</button>&nbsp;({$start_range} - {$end_range} {$mod_strings.LBL_OF} {$total_count})&nbsp;<button type='button' title='{$app_strings.LNK_LIST_NEXT}' {if isset($next_link_onclick)} {$next_link_onclick} {/if} class='button' {if ($next_link_disabled)} disabled {/if}>{$next_link_ImagePath}</button>&nbsp; <button type='button' title='{$app_strings.LNK_LIST_END}' {if isset($end_link_onclick)} {$end_link_onclick} {/if} class='button' {if ($end_link_disabled)} disabled {/if}>{$end_link_ImagePath}</button></span>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>		