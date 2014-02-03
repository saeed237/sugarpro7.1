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


require_once('include/vCard.php');

if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != ''){
	$current_language = $_SESSION['authenticated_user_language'];
}
else{
	$current_language = $sugar_config['default_language'];
}

//set module and application string arrays based upon selected language
$app_strings = return_application_language($current_language);
$app_list_strings = return_app_list_strings_language($current_language);

$vcard = new vCard();
$module = 'Contacts';
if(isset($_REQUEST['module']))
	$module = clean_string($_REQUEST['module']);

$vcard->loadContact($_REQUEST['contact_id'], $module);

$vcard->saveVCard();

?>
