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




function additionalDetailsContract($fields) {
	static $mod_strings;

	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Contracts');
	}
		
	$overlib_string = '';
		
	if(!empty($fields['REFERENCE_CODE'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_REFERENCE_CODE'] . '</b> ' . substr($fields['REFERENCE_CODE'], 0, 300);
		if(strlen($fields['REFERENCE_CODE']) > 300) {
			$overlib_string .= '...';
		}
		$overlib_string .= '<br>';
	}		
	
	if(!empty($fields['DESCRIPTION'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) {
			$overlib_string .= '...';
		}
	}

	$ret_val = array (
		'fieldToAddTo' => 'NAME', 
		'string' => $overlib_string, 
		'width' => '400',
		'editLink' => "index.php?module=Contracts&action=EditView&record={$fields['ID']}&return_module=Contracts", 
		'viewLink' => "index.php?module=Contracts&action=DetailView&record={$fields['ID']}"
	);

	return $ret_val;
}
 
?>
