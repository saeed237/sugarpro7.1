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


function additionalDetailsCampaign($fields) {
	static $mod_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Campaigns');
	}
		
	$overlib_string = '';
	
	if(!empty($fields['START_DATE'])) 
		$overlib_string .= '<b>'. $mod_strings['LBL_CAMPAIGN_START_DATE'] . '</b> ' . $fields['START_DATE'] . '<br>';

	if(!empty($fields['TRACKER_TEXT'])) 
		$overlib_string .= '<b>'. $mod_strings['LBL_TRACKER_TEXT'] . '</b> ' . $fields['TRACKER_TEXT'] . '<br>';
	if(!empty($fields['REFER_URL'])) 
		$overlib_string .= '<a target=_blank href='. $fields['REFER_URL'] . '>' . $fields['REFER_URL'] . '</a><br>';
	
	if(!empty($fields['OBJECTIVE'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_CAMPAIGN_OBJECTIVE'] . '</b> ' . substr($fields['OBJECTIVE'], 0, 300);
		if(strlen($fields['OBJECTIVE']) > 300) $overlib_string .= '...';
		$overlib_string .= '<br>';
	}	
	if(!empty($fields['CONTENT'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_CAMPAIGN_CONTENT'] . '</b> ' . substr($fields['CONTENT'], 0, 300);
		if(strlen($fields['CONTENT']) > 300) $overlib_string .= '...';
	}	
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => "index.php?action=EditView&module=Campaigns&return_module=Campaigns&record={$fields['ID']}", 
				 'viewLink' => "index.php?action=DetailView&module=Campaigns&return_module=Campaigns&record={$fields['ID']}");
}
 
 ?>
 
 