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

 
function additionalDetailsTask($fields) {
	static $mod_strings;
	global $app_list_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Tasks');
	}
		
	$overlib_string = '';
    if(!empty($fields['DATE_START'])) $overlib_string .= '<b>'. $mod_strings['LBL_START_DATE_AND_TIME'] . '</b> ' . $fields['DATE_START'] .  '<br>';
	if(!empty($fields['DATE_DUE'])) $overlib_string .= '<b>'. $mod_strings['LBL_DUE_DATE_AND_TIME'] . '</b> ' . $fields['DATE_DUE'] .  '<br>';
	if(!empty($fields['PRIORITY'])) $overlib_string .= '<b>'. $mod_strings['LBL_PRIORITY'] . '</b> ' . 
$app_list_strings['task_priority_dom'][$fields['PRIORITY']] . '<br>';
	if(!empty($fields['STATUS'])) $overlib_string .= '<b>'. $mod_strings['LBL_STATUS'] . '</b> ' . $app_list_strings['task_status_dom'][$fields['STATUS']] . '<br>';
		
	if(!empty($fields['DESCRIPTION'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
	}	
	
		$editLink = "index.php?action=EditView&module=Tasks&record={$fields['ID']}"; 
	$viewLink = "index.php?action=DetailView&module=Tasks&record={$fields['ID']}";	
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => $editLink, 
				 'viewLink' => $viewLink);

}
 
?>
