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

<span scope="row"><h5>{$mod_strings.LBL_GROUP_BY}:</h5></span>
<table width="100%" cellpadding=0 cellspacing=0>
<tr id="group_by_button">
<td align=left>
<input class=button type=button onClick='addGroupByFromButton()' name='Add Column' value='{$mod_strings.LBL_ADD_COLUMN}'>
</td>
</tr>
</table>
<input type=hidden name='group_by_def' value =""/>
<div id='group_by_div'>
<table id='group_by_table' border="0" cellpadding="0" cellspacing="0">
<tbody id='group_by_tbody'></tbody>
</table>
</div>