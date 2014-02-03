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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




require_once('modules/TimePeriods/Forms.php');


$admin = Administration::getSettings("notify");

global $app_strings;
global $app_list_strings;
global $mod_strings;

$focus = BeanFactory::getBean('TimePeriods');

if (!isset($_REQUEST['record'])) $_REQUEST['record'] = "";

if (!is_admin($current_user) && !is_admin_for_module($current_user,'Forecasts')&& !is_admin_for_module($current_user,'ForecastSchedule') && $_REQUEST['record'] != $current_user->id) sugar_die("Unauthorized access to administration.");

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}

//if duplicate record request then clear the Primary key(id) value.
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == '1') {
	$focus->id = "";
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->name), true);

$GLOBALS['log']->info("Time Period edit view");
$xtpl=new XTemplate ('modules/TimePeriods/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['error_string'])) $xtpl->assign("ERROR_STRING", "<span class='error'>Error: ".$_REQUEST['error_string']."</span>");
if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
// handle Create $module then Cancel
//if (empty($_REQUEST['return_id'])) {
	//$xtpl->assign("RETURN_ACTION", 'index');
//}
$xtpl->assign("JAVASCRIPT", get_set_focus_js().get_validate_record_js().get_chooser_js());
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("NAME", $focus->name);
$xtpl->assign("START_DATE", $focus->start_date);
$xtpl->assign("END_DATE", $focus->end_date);

if ($focus->is_fiscal_year == 1) {
	$xtpl->assign("FISCAL_YEAR_CHECKED", "checked");
	$xtpl->assign("FISCAL_OPTIONS_DISABLED", "disabled");
}

global $timedate;
$xtpl->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
$xtpl->assign("USER_DATEFORMAT", '('. $timedate->get_user_date_format().')');

$fiscal_year_dom = TimePeriod::get_fiscal_year_dom();
array_unshift($fiscal_year_dom, '');
if (isset($focus->parent_id)) $xtpl->assign("FISCAL_OPTIONS", get_select_options_with_id($fiscal_year_dom,$focus->parent_id));
else $xtpl->assign("FISCAL_OPTIONS", get_select_options_with_id($fiscal_year_dom, ''));


$xtpl->assign("THEME", SugarThemeRegistry::current()->__toString());

$xtpl->parse("main");
$xtpl->out("main");

?>
