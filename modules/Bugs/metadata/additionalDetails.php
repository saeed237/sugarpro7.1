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

 


function additionalDetailsBug($fields) {
	static $mod_strings;
	global $app_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Bugs');
	}
		
	$overlib_string = '';

	if(!empty($fields['DATE_ENTERED'])) 
		$overlib_string .= '<b>'. $app_strings['LBL_DATE_ENTERED'] . '</b> ' . $fields['DATE_ENTERED'] . '<br>';
	if(!empty($fields['SOURCE'])) 
		$overlib_string .= '<b>'. $mod_strings['LBL_SOURCE'] . '</b> ' . $fields['SOURCE'] . '<br>';
	if(!empty($fields['PRODUCT_CATEGORY'])) 
		$overlib_string .= '<b>'. $mod_strings['LBL_PRODUCT_CATEGORY'] . '</b> ' . $fields['PRODUCT_CATEGORY'] . '<br>';
	if(!empty($fields['RESOLUTION'])) 
		$overlib_string .= '<b>'. $mod_strings['LBL_RESOLUTION'] . '</b> ' . $fields['RESOLUTION'] . '<br>';
				
	if(!empty($fields['DESCRIPTION'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
		$overlib_string .= '<br>';
	}
		
	if(!empty($fields['WORK_LOG'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_WORK_LOG'] . '</b> ' . substr($fields['WORK_LOG'], 0, 300);
		if(strlen($fields['WORK_LOG']) > 300) $overlib_string .= '...';
	}	

	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => "index.php?action=EditView&module=Bugs&return_module=Bugs&record={$fields['ID']}", 
				 'viewLink' => "index.php?action=DetailView&module=Bugs&return_module=Bugs&record={$fields['ID']}");

}
 
 ?>
 
 