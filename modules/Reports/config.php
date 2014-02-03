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

global $sugar_config;
global $app_list_strings;
global $beanFiles;

$local_mod_strings = return_module_language($sugar_config['default_language'], 'Reports');
$default_report_type = 'Quotes';

/**
 * Helper function for this file.
 */
function getAllowedReportModules(&$local_modListHeader, $skipCache = false) {
	static $reports_mod = null;
	if(isset($reports_mod) && !$skipCache) {
		return $reports_mod;
	}

	require_once("modules/MySettings/TabController.php");
	$controller = new TabController();
	$tabs = $controller->get_tabs_system();
	$all_modules = array_merge($tabs[0],$tabs[1]);
	if(!is_array($all_modules)) {
		return array();
	}

	global $report_map, $beanList, $report_include_modules;

	if(empty($beanList)) {
		require('include/modules.php');
	}

	$report_modules = array();

	$subModuleCheckArray = array("Tasks", "Calls", "Meetings", "Notes");
	
	$subModuleProjectArray = array("ProjectTask");
 
	foreach($beanList as $key=>$value) {

		if(isset($all_modules[$key])) {
			$report_modules[$key] = $value;
		}

        //need to include subpanel only modules
        if (!empty($report_include_modules[$key])){
            $report_modules[$key] = $value;
        }

		if(in_array($key, $subModuleCheckArray) &&
			(array_key_exists("Calendar", $all_modules) || array_key_exists("Activities", $all_modules))) {
			$report_modules[$key] = $value;
		}
		
		if(in_array($key, $subModuleProjectArray) && 
			array_key_exists("Project", $all_modules)) {
			$report_modules[$key] = $value;
		}
		 
	    if($key == 'Users' || $key == 'Teams'  || $key =='EmailAddresses') {
            $report_modules[$key] = $value;
        }

		if($key=='Releases' || $key == 'CampaignLog') {
			$report_modules[$key] = $value;
		}

	}

	global $beanFiles;

	// Bug 38864 - Parse the reportmoduledefs.php file for a list of modules we should include or disclude from this list
	//             Provides contents of $exemptModules and $additionalModules arrays
	$exemptModules     = array();
	$additionalModules = array();

	foreach(SugarAutoLoader::existingCustom('modules/Reports/metadata/reportmodulesdefs.php') as $file) {
	    include $file;
	}

    foreach ( $report_modules as $module => $class_name ) {
		if ( !isset($beanFiles[$class_name]) || in_array($module, $exemptModules) ) {
			unset($report_modules[$module]);
		}
	}

	foreach ( $additionalModules as $module ) {
        if ( isset($beanList[$module]) ) {
            $report_modules[$module] = $beanList[$module];
        }
    }

	if ( should_hide_iframes() && isset($report_modules['iFrames']) ) {
	    unset($report_modules['iFrames']);
	}

	return $report_modules;
}

include('include/modules.php');
$GLOBALS['report_modules'] = getAllowedReportModules($modListHeader);
global $report_modules;

$module_map = array(
	'accounts'		=> 'Accounts',
	'bugs'			=> 'Bugs',
	'forecasts'		=> 'Forecasts',
	'leads'			=> 'Leads',
	'prospects'		=> 'Prospects',
	'quotes'		=> 'Quotes',
	'calls'			=> 'Calls',
	'cases'			=> 'Cases',
	'contacts'		=> 'Contacts',
	'emails'		=> 'Emails',
	'meetings'		=> 'Meetings',
	'opportunities'	=> 'Opportunities',
	'tasks'			=> 'Tasks',
	'contracts'		=> 'Contracts',
    'timeperiods'   => 'TimePeriods',
    'quotas'        => 'Quotas',
    'worksheet'     => 'Worksheet',

);

$my_report_titles = array(
	'Accounts'		=> $local_mod_strings['LBL_MY_ACCOUNT_REPORTS'],
	'Contacts'		=> $local_mod_strings['LBL_MY_CONTACT_REPORTS'],
	'Opportunities'	=> $local_mod_strings['LBL_MY_OPPORTUNITY_REPORTS'],

	'Bugs'			=> $local_mod_strings['LBL_MY_BUG_REPORTS'],
	'Cases'			=> $local_mod_strings['LBL_MY_CASE_REPORTS'],
	'Leads'			=> $local_mod_strings['LBL_MY_LEAD_REPORTS'],
	'Forecasts'		=> $local_mod_strings['LBL_MY_FORECAST_REPORTS'],
	'ProjectTask'	=> $local_mod_strings['LBL_MY_PROJECT_TASK_REPORTS'],
	'Prospects'		=> $local_mod_strings['LBL_MY_PROSPECT_REPORTS'],
	'Quotes'		=> $local_mod_strings['LBL_MY_QUOTE_REPORTS'],

	'Calls'			=> $local_mod_strings['LBL_MY_CALL_REPORTS'],
	'Meetings'		=> $local_mod_strings['LBL_MY_MEETING_REPORTS'],
	'Tasks'			=> $local_mod_strings['LBL_MY_TASK_REPORTS'],
	'Emails'		=> $local_mod_strings['LBL_MY_EMAIL_REPORTS'],



	'Contracts'		=> $local_mod_strings['LBL_MY_CONTRACT_REPORTS'],
);

$my_team_report_titles = array(
    'Accounts'      => $local_mod_strings['LBL_MY_TEAM_ACCOUNT_REPORTS'],
    'Contacts'      => $local_mod_strings['LBL_MY_TEAM_CONTACT_REPORTS'],
    'Opportunities' => $local_mod_strings['LBL_MY_TEAM_OPPORTUNITY_REPORTS'],

    'Leads'         => $local_mod_strings['LBL_MY_TEAM_LEAD_REPORTS'],
    'Quotes'        => $local_mod_strings['LBL_MY_TEAM_QUOTE_REPORTS'],
    'Cases'         => $local_mod_strings['LBL_MY_TEAM_CASE_REPORTS'],
    'Bugs'          => $local_mod_strings['LBL_MY_TEAM_BUG_REPORTS'],
    'Forecasts'     => $local_mod_strings['LBL_MY_TEAM_FORECAST_REPORTS'],
    'ProjectTask'   => $local_mod_strings['LBL_MY_TEAM_PROJECT_TASK_REPORTS'],
    'Prospects'     => $local_mod_strings['LBL_MY_TEAM_PROSPECT_REPORTS'],

    'Calls'         => $local_mod_strings['LBL_MY_TEAM_CALL_REPORTS'],
    'Meetings'      => $local_mod_strings['LBL_MY_TEAM_MEETING_REPORTS'],
    'Tasks'         => $local_mod_strings['LBL_MY_TEAM_TASK_REPORTS'],
    'Emails'        => $local_mod_strings['LBL_MY_TEAM_EMAIL_REPORTS'],

    'Contracts'     => $local_mod_strings['LBL_MY_TEAM_CONTRACT_REPORTS'],
);

$published_report_titles = array(
	'Accounts'		=> $local_mod_strings['LBL_PUBLISHED_ACCOUNT_REPORTS'],
	'Contacts'		=> $local_mod_strings['LBL_PUBLISHED_CONTACT_REPORTS'],
	'Opportunities'	=> $local_mod_strings['LBL_PUBLISHED_OPPORTUNITY_REPORTS'],

	'Leads'			=> $local_mod_strings['LBL_PUBLISHED_LEAD_REPORTS'],
	'Quotes'		=> $local_mod_strings['LBL_PUBLISHED_QUOTE_REPORTS'],
	'Cases'			=> $local_mod_strings['LBL_PUBLISHED_CASE_REPORTS'],
	'Bugs'			=> $local_mod_strings['LBL_PUBLISHED_BUG_REPORTS'],
	'Forecasts'		=> $local_mod_strings['LBL_PUBLISHED_FORECAST_REPORTS'],
	'ProjectTask'	=> $local_mod_strings['LBL_PUBLISHED_PROJECT_TASK_REPORTS'],
	'Prospects'		=> $local_mod_strings['LBL_PUBLISHED_PROSPECT_REPORTS'],

	'Calls'			=> $local_mod_strings['LBL_PUBLISHED_CALL_REPORTS'],
	'Meetings'		=> $local_mod_strings['LBL_PUBLISHED_MEETING_REPORTS'],
	'Tasks'			=> $local_mod_strings['LBL_PUBLISHED_TASK_REPORTS'],
	'Emails'		=> $local_mod_strings['LBL_PUBLISHED_EMAIL_REPORTS'],


	'Contracts'		=> $local_mod_strings['LBL_PUBLISHED_CONTRACT_REPORTS'],
);
?>
