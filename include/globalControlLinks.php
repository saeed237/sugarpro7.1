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

/*********************************************************************************

 * Description:  controls which link show up in the upper right hand corner of the app
 ********************************************************************************/

global $app_strings, $current_user;
global $sugar_config, $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action;

 if(!isset($global_control_links)){
 	$global_control_links = array();
	$sub_menu = array();
 }
if(isset( $sugar_config['disc_client']) && $sugar_config['disc_client']){
	require_once('modules/Sync/headermenu.php');
}

if(SugarThemeRegistry::current()->name != 'Classic')
$global_control_links['profile'] = array(
'linkinfo' => array($app_strings['LBL_PROFILE'] => 'index.php?module=Users&action=EditView&record='.$GLOBALS['current_user']->id),
'submenu' => ''
);

$global_control_links['employees'] = array(
'linkinfo' => array($app_strings['LBL_EMPLOYEES']=> 'index.php?module=Employees&action=index&query=true'),
'submenu' => ''
);
if (
        is_admin($current_user)
		|| $current_user->isDeveloperForAnyModule()

        ) $global_control_links['admin'] = array(

'linkinfo' => array($app_strings['LBL_ADMIN'] => 'index.php?module=Administration&action=index'),
'submenu' => ''
);
$global_control_links['training'] = array(
'linkinfo' => array($app_strings['LBL_TRAINING'] => 'javascript:void(window.open(\'http://support.sugarcrm.com\'))'),
'submenu' => ''
 );

/* no longer goes in the menubar - now implemented in the bottom bar.
$global_control_links['help'] = array(
    'linkinfo' => array($app_strings['LNK_HELP'] => ' javascript:void window.open(\'index.php?module=Administration&action=SupportPortal&view=documentation&version='.$sugar_version.'&edition='.$sugar_flavor.'&lang='.$current_language.'&help_module='.$GLOBALS['module'].'&help_action='.$action.'&key='.$server_unique_key.'\')'),
    'submenu' => ''
 );
*/

$global_control_links['users'] = array(
'linkinfo' => array($app_strings['LBL_LOGOUT'] => 'index.php?module=Users&action=Logout'),
'submenu' => ''
);

$global_control_links['about'] = array('linkinfo' => array($app_strings['LNK_ABOUT'] => 'index.php?module=Home&action=About'),
'submenu' => ''
);

foreach(SugarAutoLoader::existing('custom/include/globalControlLinks.php', SugarAutoLoader::loadExtension("links")) as $file) {
    include $file;
}
