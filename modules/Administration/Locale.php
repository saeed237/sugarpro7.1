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

global $current_user, $sugar_config;
if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

require_once('modules/Configurator/Configurator.php');


echo getClassicModuleTitle(
        "Administration",
        array(
            "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
           $mod_strings['LBL_MANAGE_LOCALE'],
           ),
        false
        );

$cfg			= new Configurator();
$sugar_smarty	= new Sugar_Smarty();
$errors			= array();

///////////////////////////////////////////////////////////////////////////////
////	HANDLE CHANGES
if(isset($_REQUEST['process']) && $_REQUEST['process'] == 'true') {
	if(isset($_REQUEST['collation']) && !empty($_REQUEST['collation'])) {
		//kbrill Bug #14922
		if(array_key_exists('collation', $sugar_config['dbconfigoption']) && $_REQUEST['collation'] != $sugar_config['dbconfigoption']['collation']) {
			$GLOBALS['db']->disconnect();
			$GLOBALS['db']->connect();
		}

		$cfg->config['dbconfigoption']['collation'] = $_REQUEST['collation'];
	}
	$cfg->populateFromPost();
	$cfg->handleOverride();
    if ($locale->invalidLocaleNameFormatUpgrade()) {
        $locale->removeInvalidLocaleNameFormatUpgradeNotice();
    }
	header('Location: index.php?module=Administration&action=index');
}

///////////////////////////////////////////////////////////////////////////////
////	DB COLLATION
$collationOptions = $GLOBALS['db']->getCollationList();
if(!empty($collationOptions)) {
	if(!isset($sugar_config['dbconfigoption']['collation'])) {
		$sugar_config['dbconfigoption']['collation'] = $GLOBALS['db']->getDefaultCollation();
	}
	$sugar_smarty->assign('collationOptions', get_select_options_with_id(array_combine($collationOptions, $collationOptions), $sugar_config['dbconfigoption']['collation']));
}
////	END DB COLLATION
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
////	PAGE OUTPUT
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("JAVASCRIPT",get_set_focus_js());
$sugar_smarty->assign('config', $sugar_config);
$sugar_smarty->assign('error', $errors);
$sugar_smarty->assign("exportCharsets", get_select_options_with_id($locale->getCharsetSelect(), $sugar_config['default_export_charset']));
//$sugar_smarty->assign('salutation', 'Mr.');
//$sugar_smarty->assign('first_name', 'John');
//$sugar_smarty->assign('last_name', 'Doe');
$sugar_smarty->assign('NAMEFORMATS', $locale->getUsableLocaleNameOptions($sugar_config['name_formats']));

if ($locale->invalidLocaleNameFormatUpgrade()) {
    $sugar_smarty->assign('upgradeInvalidLocaleNameFormat', 'bad name format upgrade');
} else {
    $sugar_smarty->clear_assign('upgradeInvalidLocaleNameFormat');
}

$sugar_smarty->assign('getNameJs', $locale->getNameJs());

$sugar_smarty->display('modules/Administration/Locale.tpl');

?>