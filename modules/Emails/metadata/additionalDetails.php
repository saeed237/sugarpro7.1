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

 

function additionalDetailsEmail($fields) {
	global $current_language;
	$mod_strings = return_module_language($current_language, 'Emails');
	$newLines = array("\r", "\R", "\n", "\N");
		
	$overlib_string = '';
	// From Name
	if(!empty($fields['FROM_NAME'])) {
		$overlib_string .= '<b>' . $mod_strings['LBL_FROM'] . '</b>&nbsp;';
		$overlib_string .= $fields['FROM_NAME'];
	}

	// email text
	if(!empty($fields['DESCRIPTION_HTML'])) {
		if(!empty($overlib_string)) $overlib_string .= '<br>';
		$overlib_string .= '<b>'.$mod_strings['LBL_BODY'].'</b><br>';
		$descH = strip_tags($fields['DESCRIPTION_HTML'], '<a>');
		$desc = str_replace($newLines, ' ', $descH);
		$overlib_string .= substr($desc, 0, 300);
		if(strlen($descH) > 300) $overlib_string .= '...';
	} elseif (!empty($fields['DESCRIPTION'])) {
		if(!empty($overlib_string)) $overlib_string .= '<br>';
		$overlib_string .= '<b>'.$mod_strings['LBL_BODY'].'</b><br>';
		$descH = strip_tags(nl2br($fields['DESCRIPTION']));
		$desc = str_replace($newLines, ' ', $descH);
		$overlib_string .= substr($desc, 0, 300);
		if(strlen($descH) > 300) $overlib_string .= '...';
	}
	
	$editLink = "index.php?action=EditView&module=Emails&record={$fields['ID']}"; 
	$viewLink = "index.php?action=DetailView&module=Emails&record={$fields['ID']}";	

	$return_module = empty($_REQUEST['module']) ? 'Meetings' : $_REQUEST['module'];
	$return_action = empty($_REQUEST['action']) ? 'ListView' : $_REQUEST['action'];
	$type = empty($_REQUEST['type']) ? '' : $_REQUEST['type'];
	$user_id = empty($_REQUEST['assigned_user_id']) ? '' : $_REQUEST['assigned_user_id'];
	
	$additional_params = "&return_module=$return_module&return_action=$return_action&type=$type&assigned_user_id=$user_id"; 
	
	$editLink .= $additional_params;
	$viewLink .= $additional_params;
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => $editLink, 
				 'viewLink' => $viewLink);
}
 
 ?>
 
