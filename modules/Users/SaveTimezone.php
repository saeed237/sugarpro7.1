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

global $current_user;
global $sugar_config;

if(isset($_POST['timezone']) || isset($_GET['timezone'])) {
    if(isset($_POST['timezone'])) { 
    	$timezone = $_POST['timezone'];
    } else {
    	$timezone = $_GET['timezone'];
    }

	$current_user->setPreference('timezone', $timezone);
	$current_user->setPreference('ut', 1);
	$current_user->savePreferencesToDB();
	session_write_close();
	require_once('modules/Users/password_utils.php');
	if((($GLOBALS['sugar_config']['passwordsetting']['userexpiration'] > 0) &&
        	$_SESSION['hasExpiredPassword'] == '1'))
        header('Location: index.php?module=Users&action=ChangePassword');
    else
	   header('Location: index.php?action=index&module=Home');
   exit();
}
?>
