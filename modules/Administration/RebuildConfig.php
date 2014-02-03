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





global $mod_strings;

// the initial settings for the template variables to fill
$config_check           = '';
$config_file_ready      = false;
$lbl_rebuild_config     = $mod_strings['LBL_REBUILD_CONFIG'];
$btn_rebuild_config     = $mod_strings['BTN_REBUILD_CONFIG'];
$disable_config_rebuild = 'disabled="disabled"';

// check the status of the config file
if( is_writable('config.php') ){
    $config_check = $mod_strings['MSG_CONFIG_FILE_READY_FOR_REBUILD'];
    $disable_config_rebuild = '';
    $config_file_ready = true;
}
else {
    $config_check = $mod_strings['MSG_MAKE_CONFIG_FILE_WRITABLE'];
}

// only do the rebuild if config file checks out and user has posted back
if( !empty($_POST['perform_rebuild']) && $config_file_ready ){

    // retrieve configuration from file so that contents of config_override.php
    // is not merged (bug #54403)
    $clean_config = loadCleanConfig();
    if ( rebuildConfigFile($clean_config, $sugar_version) ) {
    	$config_check = $mod_strings['MSG_CONFIG_FILE_REBUILD_SUCCESS'];
        $disable_config_rebuild = 'disabled="disabled"';
    }
    else {
        $config_check = $mod_strings['MSG_CONFIG_FILE_REBUILD_FAILED'];
    }
    require_once 'ModuleInstall/ModuleInstaller.php';
    ModuleInstaller::handleBaseConfig();
    ModuleInstaller::handlePortalConfig();
}

/////////////////////////////////////////////////////////////////////
// TEMPLATE ASSIGNING
$xtpl = new XTemplate('modules/Administration/RebuildConfig.html');
$xtpl->assign('LBL_CONFIG_CHECK', $mod_strings['LBL_CONFIG_CHECK']);
$xtpl->assign('CONFIG_CHECK', $config_check);
$xtpl->assign('LBL_PERFORM_REBUILD', $lbl_rebuild_config);
$xtpl->assign('DISABLE_CONFIG_REBUILD', $disable_config_rebuild);
$xtpl->assign('BTN_PERFORM_REBUILD', $btn_rebuild_config);
$xtpl->parse('main');
$xtpl->out('main');
?>
