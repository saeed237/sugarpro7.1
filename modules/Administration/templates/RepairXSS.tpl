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
<script src="{sugar_getjspath file='modules/Administration/javascript/Administration.js'}"></script>
<script src="{sugar_getjspath file='modules/Administration/javascript/Async.js'}"></script>

<div>
	{$mod.LBL_REPAIRXSS_INSTRUCTIONS}
</div>
<br>

<div id="cleanXssMain">
	{$beanDropDown} <div id="repairXssButton" style="display:none;">
		<input type="button" class="button" onclick="SUGAR.Administration.RepairXSS.executeRepair();" value="   {$mod.LBL_EXECUTE}   ">
	</div>
</div>
<br>

<div id="repairXssDisplay" style="display:none;">
	<input size='5' type="text" disabled id="repairXssCount" value="0"> {$mod.LBL_REPAIRXSS_COUNT}
</div>
<br>

<div id="repairXssResults" style="display:none;">
	<input size='5' type="text" disabled id="repairXssResultCount" value="0"> {$mod.LBL_REPAIRXSS_REPAIRED}
</div>