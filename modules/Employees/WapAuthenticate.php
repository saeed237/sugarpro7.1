<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
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
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $mod_strings;

$focus = BeanFactory::getBean('Users');

// Add in defensive code here.
$focus->user_name = $_REQUEST['user_name'];
$user_password = $_REQUEST['user_password'];

$focus->load_user($user_password);

if ($focus->is_authenticated()) {
    // save the user information into the session
    // go to the home screen
    header("Location: ".$GLOBALS['app']->getLoginRedirect());
    unset($_SESSION['login_password']);
    unset($_SESSION['login_error']);
    unset($_SESSION['login_user_name']);

    $_SESSION['authenticated_user_id'] = $focus->id;

    // store the user's theme in the session
    if (isset($_REQUEST['login_theme'])) {
        $authenticated_user_theme = $_REQUEST['login_theme'];
    } elseif (isset($_REQUEST['ck_login_theme_20'])) {
        $authenticated_user_theme = $_REQUEST['ck_login_theme_20'];
    } else {
        $authenticated_user_theme = $sugar_config['default_theme'];
    }

    // store the user's language in the session
    if (isset($_REQUEST['login_language'])) {
        $authenticated_user_language = $_REQUEST['login_language'];
    } elseif (isset($_REQUEST['ck_login_language_20'])) {
        $authenticated_user_language = $_REQUEST['ck_login_language_20'];
    } else {
        $authenticated_user_language = $sugar_config['default_language'];
    }

    // If this is the default user and the default user theme is set to reset, reset it to the default theme value on each login
    if ($reset_theme_on_default_user && $focus->user_name == $sugar_config['default_user_name']) {
        $authenticated_user_theme = $sugar_config['default_theme'];
    }
    if (isset($reset_language_on_default_user) && $reset_language_on_default_user &&
         $focus->user_name == $sugar_config['default_user_name']) {
            $authenticated_user_language = $sugar_config['default_language'];
    }

    $_SESSION['authenticated_user_theme'] = $authenticated_user_theme;
    $_SESSION['authenticated_user_language'] = $authenticated_user_language;

    $GLOBALS['log']->debug("authenticated_user_theme is $authenticated_user_theme");
    $GLOBALS['log']->debug("authenticated_user_language is $authenticated_user_language");

    // Clear all uploaded import files for this user if it exists

    require_once('modules/Import/ImportCacheFiles.php');
    $tmp_file_name = ImportCacheFiles::getImportDir()."/IMPORT_" . $focus->id;

    if (file_exists($tmp_file_name)) {
        unlink($tmp_file_name);
    }

} else {
    $_SESSION['login_user_name'] = $focus->user_name;
    $_SESSION['login_password'] = $user_password;
    $_SESSION['login_error'] = $mod_strings['ERR_INVALID_PASSWORD'];

    // go back to the login screen.
    // create an error message for the user.
    header("Location: index.php");
}
