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

 


function additionalDetailsAccount($fields) {
	static $mod_strings;
	global $app_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Accounts');
	}
	$overlib_string = '';
	
	if(!empty($fields['BILLING_ADDRESS_STREET']) || !empty($fields['BILLING_ADDRESS_CITY']) ||
		!empty($fields['BILLING_ADDRESS_STATE']) || !empty($fields['BILLING_ADDRESS_POSTALCODE']) ||
		!empty($fields['BILLING_ADDRESS_COUNTRY']))
			$overlib_string .= '<b>' . $mod_strings['LBL_BILLING_ADDRESS'] . '</b><br>';
	if(!empty($fields['BILLING_ADDRESS_STREET'])) $overlib_string .= $fields['BILLING_ADDRESS_STREET'] . '<br>';
	if(!empty($fields['BILLING_ADDRESS_STREET_2'])) $overlib_string .= $fields['BILLING_ADDRESS_STREET_2'] . '<br>';
	if(!empty($fields['BILLING_ADDRESS_STREET_3'])) $overlib_string .= $fields['BILLING_ADDRESS_STREET_3'] . '<br>';
	if(!empty($fields['BILLING_ADDRESS_STREET_4'])) $overlib_string .= $fields['BILLING_ADDRESS_STREET_4'] . '<br>';
	if(!empty($fields['BILLING_ADDRESS_CITY'])) $overlib_string .= $fields['BILLING_ADDRESS_CITY'] . ', ';
	if(!empty($fields['BILLING_ADDRESS_STATE'])) $overlib_string .= $fields['BILLING_ADDRESS_STATE'] . ' ';
	if(!empty($fields['BILLING_ADDRESS_POSTALCODE'])) $overlib_string .= $fields['BILLING_ADDRESS_POSTALCODE'] . ' ';
	if(!empty($fields['BILLING_ADDRESS_COUNTRY'])) $overlib_string .= $fields['BILLING_ADDRESS_COUNTRY'] . '<br>';
	
	if(strlen($overlib_string) > 0 && !(strrpos($overlib_string, '<br>') == strlen($overlib_string) - 4)) 
		$overlib_string .= '<br>';  
	
	if(!empty($fields['PHONE_FAX'])) $overlib_string .= '<b>'. $mod_strings['LBL_FAX'] . '</b> <span class="phone">' . $fields['PHONE_FAX'] . '</span><br>';
	if(!empty($fields['PHONE_ALTERNATE'])) $overlib_string .= '<b>'. $mod_strings['LBL_OTHER_PHONE'] . '</b> <span class="phone">' . $fields['PHONE_ALTERNATE'] . '</span><br>';
	if(!empty($fields['WEBSITE'])) 
		$overlib_string .= '<a target=_blank href=http://'. $fields['WEBSITE'] . '>' . $fields['WEBSITE'] . '</a><br>';
	if(!empty($fields['INDUSTRY'])) $overlib_string .= '<b>'. $mod_strings['LBL_INDUSTRY'] . '</b> ' . $fields['INDUSTRY'] . '<br>';
	if(!empty($fields['DESCRIPTION'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
	}	

	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => "index.php?action=EditView&module=Accounts&return_module=Accounts&record={$fields['ID']}", 
				 'viewLink' => "index.php?action=DetailView&module=Accounts&return_module=Accounts&record={$fields['ID']}");
}
 
 ?>
 
 