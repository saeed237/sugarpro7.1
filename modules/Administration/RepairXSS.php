<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

include("include/modules.php"); // provides $moduleList, $beanList, etc.

///////////////////////////////////////////////////////////////////////////////
////	UTILITIES
/**
 * Cleans all SugarBean tables of XSS - no asynchronous calls.  May take a LONG time to complete.
 * Meant to be called from a Scheduler instance or other timed or other automation.
 */
function cleanAllBeans() {
	
}
////	END UTILITIES
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////	PAGE OUTPUT
if(isset($runSilent) && $runSilent == true) {
	// if called from Scheduler
	cleanAllBeans();
} else {
	$hide = array('Activities', 'Home', 'iFrames', 'Calendar', 'Dashboard');

	sort($moduleList);
	$options = array();
	$options[] = $app_strings['LBL_NONE'];
	$options['all'] = "--{$app_strings['LBL_TABGROUP_ALL']}--";
	
	foreach($moduleList as $module) {
		if(!in_array($module, $hide)) {
			$options[$module] = $module;
		}
	}
	
	$options = get_select_options_with_id($options, '');
	$beanDropDown = "<select onchange='SUGAR.Administration.RepairXSS.refreshEstimate(this);' id='repairXssDropdown'>{$options}</select>";
	
	echo getClassicModuleTitle('Administration', array($mod_strings['LBL_REPAIRXSS_TITLE']), false);
	echo "<script>var done = '{$mod_strings['LBL_DONE']}';</script>";
	
	$smarty = new Sugar_Smarty(); 
	$smarty->assign("mod", $mod_strings);
	$smarty->assign("beanDropDown", $beanDropDown);
	$smarty->display("modules/Administration/templates/RepairXSS.tpl");
} // end else