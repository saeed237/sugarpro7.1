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

<form>
	<h3>{$MOD.LBL_QUICK_REPAIR_TITLE}</h3><br/>
	<input type="hidden" name="action" value="QuickRepairAndRebuild"/>
	<input type="hidden" name="subaction" value="repairAndClearAll"/> <!--Switch based on $_REQUEST type!-->
	<input type="hidden" name="module" value="Administration"/>
	{html_options multiple ="1" size="10"  name=repair_module[] values=$values output=$output selected=$MOD.LBL_ALL_MODULES}
	<br/><br/>
	{html_checkboxes name="selected_actions" values = $checkbox_values output = $checkbox_output separator="<br />" selected=$checkbox_values }
	<br/>
	<input class="button" type="submit" value="{$MOD.LBL_REPAIR}"/>
</form>
