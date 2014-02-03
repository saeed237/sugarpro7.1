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

//////////////////////////////////////////////
// TEMPLATE:
//
//////////////////////////////////////////////
global $report_modules;
function template_reports_request_vars_js(&$smarty, &$reporter,&$args) {
	$field_defs = $reporter->focus->field_defs;

	$table_columns = array();
	$hidden_columns = array();


	if (!isset($reporter->report_def['report_type'])) {
		$report_type = 'tabular';
	} else {
		$report_type = $reporter->report_def['report_type'];
	} // else
	$allowed_modules_arr = array();
	global $report_modules;
	foreach($report_modules as $module=>$name) {
		array_push($allowed_modules_arr ,"\"$module\":1");
	} // foreach
	$allowed_modules_js = implode(",",$allowed_modules_arr);
	$smarty->assign('allowed_modules_js', "{".$allowed_modules_js."}");
	$smarty->assign('reporter_report_def_str1', $reporter->report_def_str);
	if (isset($reporter->report_def['goto_anchor'])) {
		$goto_anchor = $reporter->report_def['goto_anchor'];
	} else {
		$goto_anchor = "\"\"";
	} // else
	$smarty->assign('goto_anchor', $goto_anchor);
	$user_array = get_user_array(FALSE);
	$smarty->assign('user_array', $user_array);
} // fn
