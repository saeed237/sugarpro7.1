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

 

function additionalDetailsOpportunity($fields) {
	global $current_language;
	$mod_strings = return_module_language($current_language, 'Opportunities');
	$overlib_string = '';
	
	if(!empty($fields['LEAD_SOURCE'])) $overlib_string .= '<b>'. $mod_strings['LBL_LEAD_SOURCE'] . '</b> ' . $fields['LEAD_SOURCE'] . '<br>';
	if(!empty($fields['PROBABILITY'])) $overlib_string .= '<b>'. $mod_strings['LBL_PROBABILITY'] . '</b> ' . $fields['PROBABILITY'] . '<br>';
	if(!empty($fields['NEXT_STEP'])) $overlib_string .= '<b>'. $mod_strings['LBL_NEXT_STEP'] . '</b> ' . $fields['NEXT_STEP'] . '<br>';
	if(!empty($fields['OPPORTUNITY_TYPE'])) $overlib_string .= '<b>'. $mod_strings['LBL_TYPE'] . '</b> ' . $fields['OPPORTUNITY_TYPE'] . '<br>';

	if(!empty($fields['DESCRIPTION'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ';
		$overlib_string .= substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
	}	
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => "index.php?action=EditView&module=Opportunities&return_module=Opportunities&record={$fields['ID']}", 
				 'viewLink' => "index.php?action=DetailView&module=Opportunities&return_module=Opportunities&record={$fields['ID']}");
}
 
 ?>
 
