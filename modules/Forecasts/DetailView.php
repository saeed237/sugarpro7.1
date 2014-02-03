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

 
//require_once('vendor/XTemplate/xtpl.php');


require_once('modules/Forecasts/Common.php');



require_once ('modules/Forecasts/ForecastUtils.php');

//include tree view classes.
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/Forecasts/TreeData.php');
global $app_strings;
global $app_list_strings;
global $current_language;
global $current_user;
global $urlPrefix;
global $currentModule;
global $even_bg,$odd_bg;
global $export_module;
global $mod_strings;

$selected_timeperiod_id=null;
if (!empty($_REQUEST['timeperiod_id'])) {
	$selected_timeperiod_id=$_REQUEST['timeperiod_id'];
}
$current_module_strings = return_module_language($current_language, 'Forecasts');
$mod_strings=return_module_language($current_language, 'Forecasts');
$current_timeperiod=null;
$current_forecastype='Direct';

//output the module header.
echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_QC_WORKSHEET_BUTTON']), false);
$sugar_smarty = new Sugar_Smarty();

//get timperiods.
$focus = new Common();	
$focus->set_current_user($current_user->id);
$focus->setup();
$focus->get_my_timeperiods();
//set default forecast type.
if (count($focus->my_direct_reports)>0) {
	$current_forecastype='Rollup';
}
//time period selection list, list's all active time periods.
//sets either the requested timeperiod or first timeperiod returned as selected. 
$time_select_list=null;
if (is_array($focus->my_timeperiods)) {
	foreach ($focus->my_timeperiods as $key => $value) {
		if ((empty($time_select_list) && empty($selected_timeperiod_id)) || $key==$selected_timeperiod_id) { 
			$current_timeperiod=$key;
			$time_select_list .= "<OPTION VALUE='$key' SELECTED>$value </OPTION> ";
		} else {
			$time_select_list .= "<OPTION VALUE='$key'>$value </OPTION>";
		}
	}
}
$sugar_smarty->assign('CURRENT_TIMEPERIODS', $time_select_list);
$sugar_smarty->assign('LBL_DV_TIMEPERIODS', $mod_strings['LBL_DV_TIMEPERIODS']);

$focus->get_timeperiod_start_end_date($current_timeperiod);
$sugar_smarty->assign('TP_START_DATE', $focus->start_date);
$sugar_smarty->assign('TP_END_DATE', $focus->end_date);

if (is_array($focus->my_timeperiods) and count($focus->my_timeperiods) > 0) {

	$activeperiodstree=new Tree('activetimeperiods');
	$activeperiodstree->set_param('module','Forecasts');
	$activeperiodstree->set_param('timeperiod',$current_timeperiod);
	
	//add a top-level node for logged in user.
	$rootnode=create_node($current_user->id,true,false,false,true,true);
	
	
	$nodes=add_downline($focus,$rootnode);
	
	$activeperiodstree->add_node($rootnode);
	
	//Add node for direct 
	if ($current_forecastype=='Rollup')  {
        if (user_owns_opps(null,$current_user)) {
		  $direct=create_node($current_user->id,true,false,true,true,true);
		  $activeperiodstree->add_node($direct);
        }

        $sugar_smarty->assign('TREEHEADER', $activeperiodstree->generate_header());
        $sugar_smarty->assign('TREEINSTANCE', $activeperiodstree->generate_nodes_array());
        $sugar_smarty->assign('TREE_WIDTH', '15%');
        $sugar_smarty->assign('BORDER', 1);
        
	} else {
        $sugar_smarty->assign('TREE_WIDTH', '0');
        $sugar_smarty->assign('BORDER', 0);
	}
	
} else {
	$sugar_smarty->assign('TREEINSTANCE', $mod_strings['LBL_NO_ACTIVE_TIMEPERIOD']);
	$sugar_smarty->assign('FORECASTDATA', '');
}		

//get initial forecast
$contents=ob_get_contents();
ob_end_clean();
ob_start();
get_worksheet_defintion($current_user->id,$current_forecastype,$current_timeperiod,true);
$worksheet=ob_get_contents();
ob_end_clean();
ob_start();
echo $contents;
$sugar_smarty->assign('FORECASTDATA', $worksheet);

//set the site_url variable.
global $sugar_config;
$site_data = "<script> var site_url= {\"site_url\":\"".getJavascriptSiteURL()."\"};</script>\n";
$sugar_smarty->assign('SITEURL', $site_data);

echo $sugar_smarty->fetch('modules/Forecasts/DetailView.tpl');
?>