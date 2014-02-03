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

<div id="filters_tab" style="display: none">
<span scope="row"><h5>{$mod_strings.LBL_FILTERS}:</h5></span>
{$mod_strings.LBL_FILTER_CONDITIONS}
 <select name='filters_combiner' id='filters_combiner'>
   <option value='AND' {$selectedAnd}>{$mod_strings.LBL_FILTER_AND}</option>
   <option value='OR' {$selectedOR}>{$mod_strings.LBL_FILTER_OR}</option>
</select>
{$mod_strings.LBL_FILTERS_END}
<br><br>
<input class=button type=button onClick='window.addFilter()' name='{$mod_strings.LBL_ADD_NEW_FILTER}' value='{$mod_strings.LBL_ADD_NEW_FILTER}'>
&nbsp;&nbsp;{$mod_strings.LBL_DATE_BASED_FILTERS}
<input type=hidden name='filters_def' value ="">
<table id='filters_top' border=0 cellpadding="0" cellspacing="0">
<tbody id='filters'></tbody>
</table>
</div>