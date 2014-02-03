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

function additionaldetailscase($fields) {
    return additionalDetailsaCase($fields);
}
function additionalDetailsaCase($fields) {
	static $mod_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Cases');
	}
		
	$overlib_string = '';
		
	if(!empty($fields['DESCRIPTION'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
		$overlib_string .= '<br>';
	}
	if(!empty($fields['RESOLUTION'])) { 
		$overlib_string .= '<b>'. $mod_strings['LBL_RESOLUTION'] . '</b> ' . substr($fields['RESOLUTION'], 0, 300);
		if(strlen($fields['RESOLUTION']) > 300) $overlib_string .= '...';
	}		
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'width' => '400',
				 'editLink' => "index.php?action=EditView&module=Cases&return_module=Cases&record={$fields['ID']}", 
				 'viewLink' => "index.php?action=DetailView&module=Cases&return_module=Cases&record={$fields['ID']}");
}
 
 ?>
 
 