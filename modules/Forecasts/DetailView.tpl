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

{$SITEURL}
{$TREEHEADER}
<SCRIPT type='text/javascript' src="{sugar_getjspath file='modules/Forecasts/forecast.js'}"></SCRIPT>
	<form action="index.php" method="post"  id="form">
		<input type="hidden" name="module" value="Forecasts">
		<input type="hidden" name="action" value="index">
		<input type="hidden" name="isDuplicate" value="0">
		<input type="hidden" name="timeperiod_id" >
			 {$LBL_DV_TIMEPERIODS}&nbsp;<select name="timeperiod_id" onchange="this.form.timeperiod_id.value=this.value;this.form.submit();" class="dataField">{$CURRENT_TIMEPERIODS}</select>&nbsp;
			 {$TP_START_DATE}&nbsp;{$TP_END_DATE}
	</form>
<br/>
<table width="100%" cellpadding="0" cellspacing="0" border="{$BORDER}" id="forecastsWorksheet">
<tr>
	<td width="{$TREE_WIDTH}" valign="top"  >
		<div id="activetimeperiods">
			{$TREEINSTANCE}
		</div>
	</td>
	<td id="activetimeperiodsworksheet" valign="top">
		{$FORECASTDATA}
	</td>
</tr>
</table>
