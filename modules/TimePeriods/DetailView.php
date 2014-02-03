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


global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//exit if the logged in user does not have admin rights.
if (!is_admin($current_user) && !is_admin_for_module($current_user,'Forecasts')&& !is_admin_for_module($current_user,'ForecastSchedule')) sugar_die("Unauthorized access to administration.");

global $focus;
$focus = BeanFactory::getBean('TimePeriods');

$GLOBALS['log']->info("in detail view");

if (!empty($_REQUEST['record'])) {

	$GLOBALS['log']->info("record to be fetched".$_REQUEST['record']);
	
    $result = $focus->retrieve($_REQUEST['record']);  
    if($result == null)
    {
    	sugar_die($app_strings['ERROR_NO_RECORD']);
    }
}
else {
	header("Location: index.php?module=TimePeriods&action=ListView");
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->get_summary_text()), true);

$GLOBALS['log']->info("Time Period detail view");

$xtpl=new XTemplate ('modules/TimePeriods/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("RETURN_MODULE", "TimePeriods");
$xtpl->assign("RETURN_ACTION", "DetailView");
$xtpl->assign("ACTION", "EditView");

if ($focus->is_fiscal_year == 1) {
	$xtpl->assign("FISCAL_YEAR_CHECKED", "checked");
}
$xtpl->assign("NAME", $focus->name);
$xtpl->assign("START_DATE", $focus->start_date);
$xtpl->assign("END_DATE", $focus->end_date);
$xtpl->assign("FISCAL_YEAR", $focus->fiscal_year);

global $current_user;
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
	
	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "&mod_lang=Teams'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>");
}
$xtpl->parse("main");
$xtpl->out("main");


/*
echo "<BR>\n";
$sub_xtpl = $xtpl;

$old_contents = ob_get_contents();
ob_end_clean();
if($sub_xtpl->var_exists('subpanel', 'FORECASTSCHEDULE')){

ob_start();

include('modules/ForecastSchedule/SubPanelViewForecastSchedule.php');

$forecastschedulepanel = ob_get_contents();
ob_end_clean();
}
ob_start();

echo $old_contents;
if(!empty($forecastschedulepanel))$sub_xtpl->assign('FORECASTSCHEDULE', $forecastschedulepanel);

$sub_xtpl->parse("subpanel");
$sub_xtpl->out("subpanel");
*/
?>