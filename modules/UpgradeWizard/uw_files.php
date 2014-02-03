<?php
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




global $sugar_version;
if(!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

///////////////////////////////////////////////////////////////////////////////
////	DYNAMICALLY GENERATE UPGRADEWIZARD MODULE FILE LIST
$uwFilesCurrent = findAllFiles('modules/UpgradeWizard/', array());

// handle 4.x to 4.5.x+ (no UpgradeWizard module)
if(count($uwFilesCurrent) < 5) {
	$uwFiles = array(
		'modules/UpgradeWizard/language/en_us.lang.php',
		'modules/UpgradeWizard/cancel.php',
		'modules/UpgradeWizard/commit.php',
		'modules/UpgradeWizard/commitJson.php',
		'modules/UpgradeWizard/end.php',
		'modules/UpgradeWizard/Forms.php',
		'modules/UpgradeWizard/index.php',
		'modules/UpgradeWizard/Menu.php',
		'modules/UpgradeWizard/preflight.php',
		'modules/UpgradeWizard/preflightJson.php',
		'modules/UpgradeWizard/start.php',
		'modules/UpgradeWizard/su_utils.php',
		'modules/UpgradeWizard/su.php',
		'modules/UpgradeWizard/systemCheck.php',
		'modules/UpgradeWizard/systemCheckJson.php',
		'modules/UpgradeWizard/upgradeWizard.js',
		'modules/UpgradeWizard/upload.php',
		'modules/UpgradeWizard/uw_ajax.php',
		'modules/UpgradeWizard/uw_files.php',
		'modules/UpgradeWizard/uw_main.tpl',
		'modules/UpgradeWizard/uw_utils.php',
	);
} else {
	$uwFilesCurrent = findAllFiles('ModuleInstall', $uwFilesCurrent);
	$uwFilesCurrent = findAllFiles('include/javascript/yui', $uwFilesCurrent);
	$uwFilesCurrent[] = 'HandleAjaxCall.php';

	$uwFiles = array();
	foreach($uwFilesCurrent as $file) {
		$uwFiles[] = str_replace("./", "", clean_path($file));
	}
}
////	END DYNAMICALLY GENERATE UPGRADEWIZARD MODULE FILE LIST
///////////////////////////////////////////////////////////////////////////////

$uw_files = array(
    // standard files we steamroll with no warning
    'log4php.properties',
    'include/utils/encryption_utils.php',
    'vendor/Pear/Crypt_Blowfish/Blowfish.php',
    'vendor/Pear/Crypt_Blowfish/Blowfish/DefaultKey.php',
    'include/utils.php',
    'include/language/en_us.lang.php',
    'include/modules.php',
    'include/Localization/Localization.php',
    'install/language/en_us.lang.php',
    'vendor/XTemplate/xtpl.php',
    'include/database/DBHelper.php',
    'include/database/DBManager.php',
    'include/database/DBManagerFactory.php',
    'include/database/MssqlHelper.php',
    'include/database/MssqlManager.php',
    'include/database/MysqlHelper.php',
    'include/database/MysqlManager.php',
    'include/database/DBManagerFactory.php',
);

$uw_files = array_merge($uw_files, $uwFiles);

