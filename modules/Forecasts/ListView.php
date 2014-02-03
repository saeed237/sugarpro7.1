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







require_once('modules/Forecasts/Common.php');


global $app_strings;
global $app_list_strings;
global $current_language;
global $current_user;
global $urlPrefix;
global $currentModule;

if (isset($_REQUEST['query'])) {
	if (isset($_REQUEST['clear_query'])) {
		$current_user->setPreference("forecast_timeperiod_id",'');
	 	$current_user->setPreference("forecast_type",'');		
	} else {		
		if (isset($_REQUEST['timeperiod_id'])) {
			$current_user->setPreference("forecast_timeperiod_id",$_REQUEST['timeperiod_id']);
		}		
		if (isset($_REQUEST['forecast_type'])){
		 	$current_user->setPreference("forecast_type",$_REQUEST['forecast_type']);
		}
	}		
}

$ws_timeperiod_id="";
$current_module_strings = return_module_language($current_language, 'Forecasts');
//get user_id, if null set to logged in user.
if (isset($_REQUEST['user_id'])) $ws_current_user_id = $_REQUEST['user_id'];
if (empty($ws_current_user_id)) {
	$ws_current_user_id = $current_user->id;
}
$comm = new Common();
$comm->set_current_user($ws_current_user_id);
$comm->setup();

//get forecast type if null, if user is manager set to rollup else direct.
if (isset($_REQUEST['forecast_type'])) $ws_forecast_type = $_REQUEST['forecast_type'];	
if (empty($ws_forecast_type)) {
	$ws_forecast_type = $current_user->getPreference("forecast_type");
}
if (empty($ws_forecast_type)) {
	if ($comm->is_user_manager()) {
		$ws_forecast_type = "Rollup";
	} else {
		$ws_forecast_type = "Direct";
	}
}
//get timperiod_id, if null do nothing.
if (isset($_REQUEST['timeperiod_id'])) $ws_timeperiod_id = $_REQUEST['timeperiod_id'];
if (empty($ws_timeperiod_id)) {
	$ws_timeperiod_id = $current_user->getPreference("forecast_timeperiod_id");
}

//get logged in users currency preference.
$Currency = BeanFactory::getBean('Currencies', $current_user->getPreference('currency'));
if( $Currency->deleted != 1)
   $CurrencySymbol= $Currency->symbol;
else
   $CurrencySymbol= $currency->getDefaultCurrencySymbol();

$seedForecast = BeanFactory::getBean('Forecasts');

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_FORECAST_HISTORY_TITLE']), false);

//START:processing the search form.
$fcst_timeperiods =  $comm->get_my_forecasted_timeperiods($ws_current_user_id);

echo get_form_header($mod_strings['LBL_DV_FORECAST_PERIOD'], "", false);
$search_form=new XTemplate ('modules/Forecasts/SearchForm.html');
$search_form->assign("MOD", $current_module_strings);
$search_form->assign("APP", $app_strings);

if ($comm->is_user_manager()) {
	if ($ws_forecast_type == "Rollup")
		$forecast_select = "<input name='forecast_type' class='radio' type='radio' value='Direct' > ".$current_module_strings['LBL_DV_MY_FORECASTS']."&nbsp;&nbsp;&nbsp;<input name='forecast_type' class='radio' type='radio' value='Rollup' checked> ".$current_module_strings['LBL_DV_MY_TEAM'];
	else
		$forecast_select = "<input name='forecast_type' class='radio' type='radio' value='Direct' checked > ".$current_module_strings['LBL_DV_MY_FORECASTS']."&nbsp;&nbsp;&nbsp;<input name='forecast_type' class='radio' type='radio' value='Rollup' > ".$current_module_strings['LBL_DV_MY_TEAM'];		
} else {
	$forecast_select = "<input type='hidden' name='forecast_type' value='Direct'/>";
}
$search_form->assign("FORECAST_TYPE", $forecast_select);

//time period selection list
$time_select_list="";
if (count($fcst_timeperiods) == 0) {
	$time_select_list="<OPTION VALUE='' SELECTED>".$app_strings['LBL_NONE']."</OPTION> ";
} else {
	$time_select_list="<OPTION VALUE=''>".$app_strings['LBL_NONE']."</OPTION> ";
	foreach ($fcst_timeperiods as $key=>$value) {
		if ($key == $ws_timeperiod_id)
			$time_select_list .= "<OPTION VALUE='$key' SELECTED>$value </OPTION> ";
		else
			$time_select_list .= "<OPTION VALUE='$key'>$value </OPTION>";
	}
}
$search_form->assign("CURRENT_TIMEPERIODS",$time_select_list);
$search_form->assign("CURRENT_USER_ID", $current_user->id);
$search_form->assign("SUBMODULE", "");

$search_form->assign("JAVASCRIPT", get_clear_form_js());

$search_form->parse("main");
$search_form->out("main");
//END: processing the search form.

$where = " forecasts.user_id='$ws_current_user_id'";
if (!empty($ws_forecast_type)) $where .= " AND forecast_type ='".$ws_forecast_type."'";  
if (!empty($ws_timeperiod_id)) $where .= " AND timeperiod_id ='".$ws_timeperiod_id."'";  	

//START: processing the list view.
$ListView = new ListView();
$ListView->initNewXTemplate('modules/Forecasts/ListView.html',$current_module_strings);
$ListView->setHeaderTitle($current_module_strings['LBL_LIST_FORM_TITLE']);
$ListView->setQuery($where, "", "", "FORECAST_LIST");
$ListView->xTemplateAssign("CURRENCY_SYMBOL",$CurrencySymbol);
$ListView->show_mass_update=false;
$ListView->show_export_button=false;
$ListView->show_delete_button=false;
$ListView->show_select_menu=false;
$ListView->processListView($seedForecast, "main", "FORECAST_LIST");
//END: processing the list view.
?>
