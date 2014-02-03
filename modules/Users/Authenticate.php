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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright(C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
if (!defined('SUGAR_PHPUNIT_RUNNER')) {
    session_regenerate_id(false);
}
global $mod_strings;
$res = $GLOBALS['sugar_config']['passwordsetting'];
$login_vars = $GLOBALS['app']->getLoginVars(false);

$user_name = isset($_REQUEST['user_name'])
    ? $_REQUEST['user_name'] : '';

$password = isset($_REQUEST['user_password'])
    ? $_REQUEST['user_password'] : '';

$authController->login($user_name, $password);
// authController will set the authenticated_user_id session variable
if(isset($_SESSION['authenticated_user_id'])) {
	// Login is successful
	if ( $_SESSION['hasExpiredPassword'] == '1' && $_REQUEST['action'] != 'Save') {
		$GLOBALS['module'] = 'Users';
        $GLOBALS['action'] = 'ChangePassword';
        ob_clean();
        header("Location: index.php?module=Users&action=ChangePassword");
        sugar_cleanup(true);
    }
    global $record;
    global $current_user;
    global $sugar_config;

    if ( isset($_SESSION['isMobile'])
            && ( empty($_REQUEST['login_module']) || $_REQUEST['login_module'] == 'Users' )
            && ( empty($_REQUEST['login_action']) || $_REQUEST['login_action'] == 'wirelessmain' ) ) {
        $last_module = $current_user->getPreference('wireless_last_module');
        if ( !empty($last_module) ) {
            $login_vars['login_module'] = $_REQUEST['login_module'] = $last_module;
            $login_vars['login_action'] = $_REQUEST['login_action'] = 'wirelessmodule';
        }
    }
    global $current_user;

    if(isset($current_user)  && empty($login_vars)) {
        if(!empty($GLOBALS['sugar_config']['default_module']) && !empty($GLOBALS['sugar_config']['default_action'])) {
            $url = "index.php?module={$GLOBALS['sugar_config']['default_module']}&action={$GLOBALS['sugar_config']['default_action']}";
        } else {
    	    $modListHeader = query_module_access_list($current_user);
    	    //try to get the user's tabs
    	    $tempList = $modListHeader;
    	    $idx = array_shift($tempList);
    	    if(!empty($modListHeader[$idx])){
    	    	$url = "index.php?module={$modListHeader[$idx]}&action=index";
    	    }
        }
    } else {
        $url = $GLOBALS['app']->getLoginRedirect();
    }
} else {
	// Login has failed
	$url ="index.php?module=Users&action=Login";
    if(!empty($login_vars))
    {
        $url .= '&' . http_build_query($login_vars);
    }
}

// construct redirect url
$url = 'Location: '.$url;
// check for presence of a mobile device, redirect accordingly
//if(isset($_SESSION['isMobile'])){
//    $url = $url . '&mobile=1';
//}

//adding this for bug: 21712.
if(!empty($GLOBALS['app'])) {
    $GLOBALS['app']->headerDisplayed = true;
}
if (!defined('SUGAR_PHPUNIT_RUNNER')) {
    sugar_cleanup();
//    header($url);
}
