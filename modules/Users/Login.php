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

/** @var AuthenticationController $authController */
$authController->authController->pre_login();

global $current_language, $mod_strings, $app_strings;
if(isset($_REQUEST['login_language'])){
    $lang = $_REQUEST['login_language'];
    $_REQUEST['ck_login_language_20'] = $lang;
	$current_language = $lang;
    $_SESSION['authenticated_user_language'] = $lang;
    $mod_strings = return_module_language($lang, "Users");
    $app_strings = return_application_language($lang);
}
$sugar_smarty = new Sugar_Smarty();
echo '<link rel="stylesheet" type="text/css" media="all" href="'.getJSPath('modules/Users/login.css').'">';
echo '<script type="text/javascript" src="'.getJSPath('modules/Users/login.js').'"></script>';
// detect mobile device on login page, redirect accordingly
if ( isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == '0' ) {
    if (isset($_SESSION['isMobile'])) unset($_SESSION['isMobile']);
}
elseif (checkForMobile()){
    // set the session variable for mobile device
    $_SESSION['isMobile'] = true;
    $url = $GLOBALS['app']->getLoginRedirect()."&mobile=1";
    header( "Location: ". $url );
}
global $app_language, $sugar_config;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;

// Get the login page image
if ( SugarAutoLoader::existing('custom/include/images/sugar_md.png') ) {
    $login_image = '<IMG src="custom/include/images/sugar_md.png" alt="Sugar" width="340" height="25">';
}
else {
    $login_image = '<IMG src="include/images/sugar_md.png" alt="Sugar" width="340" height="25">';
}
$sugar_smarty->assign('LOGIN_IMAGE',$login_image);

// See if any messages were passed along to display to the user.
if(isset($_COOKIE['loginErrorMessage'])) {
    if ( !isset($_REQUEST['loginErrorMessage']) ) {
        $_REQUEST['loginErrorMessage'] = $_COOKIE['loginErrorMessage'];
    }
    SugarApplication::setCookie('loginErrorMessage', '', time()-42000, '/');
}
if(isset($_REQUEST['loginErrorMessage'])) {
    if (isset($mod_strings[$_REQUEST['loginErrorMessage']])) {
        echo "<p align='center' class='error' > ". $mod_strings[$_REQUEST['loginErrorMessage']]. "</p>";
    } else if (isset($app_strings[$_REQUEST['loginErrorMessage']])) {
        echo "<p align='center' class='error' > ". $app_strings[$_REQUEST['loginErrorMessage']]. "</p>";
    }
}

$query = "SELECT count(id) as total from users WHERE ".User::getLicensedUsersWhere();

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.
if(!isset($_SESSION['LICENSE_EXPIRES_IN'])){
	checkSystemLicenseStatus();
}

if(!ocLicense() && isset($_SESSION['LICENSE_EXPIRES_IN']) && $_SESSION['LICENSE_EXPIRES_IN'] != 'valid' && $_SESSION['LICENSE_EXPIRES_IN'] < -1 ) {
	echo  " <p align='center' class='error' >". $GLOBALS['app_strings']['ERROR_FULLY_EXPIRED']. "</p>";
} elseif(!ocLicense() && isset($_SESSION['VALIDATION_EXPIRES_IN']) && $_SESSION['VALIDATION_EXPIRES_IN'] != 'valid' && $_SESSION['VALIDATION_EXPIRES_IN'] < -1 ) {
	echo "<p align='center' class='error' > ". $GLOBALS['app_strings']['ERROR_LICENSE_EXPIRED']. "</p>";
}
//END REQUIRED CODE  DO NOT MODIFY

// BEGIN CE-OD License User Limit Enforcement
global $sugar_flavor;
if((isset($sugar_flavor) && $sugar_flavor != null) &&
	($sugar_flavor=='CE' || isset($admin->settings['license_enforce_user_limit']) && $admin->settings['license_enforce_user_limit'] == 1)){

	global $db;
	$result = $db->query($query, true, "Error filling in user array: ");
	$row = $db->fetchByAssoc($result);
   	$admin = Administration::getSettings();
    $license_users = $admin->settings['license_users'];
    $license_seats_needed = $row['total'] - $license_users;
    if( $license_seats_needed > 0 ){
		$_SESSION['EXCEEDS_MAX_USERS'] = 1;
		echo "<p align='center' class='error' > ". $GLOBALS['app_strings']['WARN_LICENSE_SEATS_MAXED']. $GLOBALS['app_strings']['WARN_ONLY_ADMINS']."</p>";
	}
}
// END CE-OD License User Limit Enforcement


$lvars = $GLOBALS['app']->getLoginVars();
$sugar_smarty->assign("LOGIN_VARS", $lvars);
foreach($lvars as $k => $v) {
    $sugar_smarty->assign(strtoupper($k), $v);
}

// Retrieve username from the session if possible.
if(isset($_SESSION["login_user_name"])) {
	if (isset($_REQUEST['default_user_name']))
		$login_user_name = $_REQUEST['default_user_name'];
	else
		$login_user_name = $_SESSION['login_user_name'];
} else {
	if(isset($_REQUEST['default_user_name'])) {
		$login_user_name = $_REQUEST['default_user_name'];
	} elseif(isset($_REQUEST['ck_login_id_20'])) {
		$login_user_name = get_user_name($_REQUEST['ck_login_id_20']);
	} else {
		$login_user_name = $sugar_config['default_user_name'];
	}
	$_SESSION['login_user_name'] = $login_user_name;
}
$sugar_smarty->assign('LOGIN_USER_NAME', $login_user_name);

$mod_strings['VLD_ERROR'] = $GLOBALS['app_strings']["\x4c\x4f\x47\x49\x4e\x5f\x4c\x4f\x47\x4f\x5f\x45\x52\x52\x4f\x52"];

// Retrieve password from the session if possible.
if(isset($_SESSION["login_password"])) {
	$login_password = $_SESSION['login_password'];
} else {
	$login_password = $sugar_config['default_password'];
	$_SESSION['login_password'] = $login_password;
}
$sugar_smarty->assign('LOGIN_PASSWORD', $login_password);

if(isset($_SESSION["login_error"])) {
	$sugar_smarty->assign('LOGIN_ERROR', $_SESSION['login_error']);
}
if(isset($_SESSION["waiting_error"])) {
    $sugar_smarty->assign('WAITING_ERROR', $_SESSION['waiting_error']);
}

if (isset($_REQUEST['ck_login_language_20'])) {
	$display_language = $_REQUEST['ck_login_language_20'];
} else {
	$display_language = $sugar_config['default_language'];
}

if (empty($GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON']))
	$sugar_smarty->assign('DISPLAY_FORGOT_PASSWORD_FEATURE','none');

$the_languages = get_languages();
if ( count($the_languages) > 1 )
    $sugar_smarty->assign('SELECT_LANGUAGE', get_select_options_with_id($the_languages, $display_language));
$the_themes = SugarThemeRegistry::availableThemes();
if ( !empty($logindisplay) )
	$sugar_smarty->assign('LOGIN_DISPLAY', $logindisplay);;

// RECAPTCHA

	$admin = Administration::getSettings('captcha');
	$captcha_privatekey = "";
	$captcha_publickey="";
	$captcha_js = "";
	$Captcha='';

	// if the admin set the captcha stuff, assign javascript and div
	if(isset($admin->settings['captcha_on'])&& $admin->settings['captcha_on']=='1' && !empty($admin->settings['captcha_private_key']) && !empty($admin->settings['captcha_public_key'])){

			$captcha_privatekey = $admin->settings['captcha_private_key'];
			$captcha_publickey = $admin->settings['captcha_public_key'];
			$captcha_js .="<script type='text/javascript' src='" . getJSPath('cache/include/javascript/sugar_grp1_yui.js') . "'></script><script type='text/javascript' src='" . getJSPath('cache/include/javascript/sugar_grp_yui2.js') . "'></script>
			<script type='text/javascript' src='http://api.recaptcha.net/js/recaptcha_ajax.js'></script>
			<script>
			function initCaptcha(){
			Recaptcha.create('$captcha_publickey' ,'captchaImage',{theme:'custom'});
			}
			window.onload=initCaptcha;

			var handleFailure=handleSuccess;
			var handleSuccess = function(o){
				if(o.responseText!==undefined && o.responseText =='Success'){
					generatepwd();
					Recaptcha.reload();
				}
				else{
					if(o.responseText!='')
						document.getElementById('generate_success').innerHTML =o.responseText;
					Recaptcha.reload();
				}
			}
			var callback2 ={ success:handleSuccess, failure: handleFailure };

			function validateAndSubmit(){
					var form = document.getElementById('form');
					var url = '&to_pdf=1&module=Home&action=index&entryPoint=Changenewpassword&recaptcha_challenge_field='+Recaptcha.get_challenge()+'&recaptcha_response_field='+ Recaptcha.get_response();
					YAHOO.util.Connect.asyncRequest('POST','index.php',callback2,url);
			}</script>";
		$Captcha.="<tr>
			<td scope='row' width='20%'>".$mod_strings['LBL_RECAPTCHA_INSTRUCTION'].":</td>
		    <td width='70%'><input type='text' size='26' id='recaptcha_response_field' value=''></td>

		</tr>
		<tr>

		 	<td colspan='2'><div style='margin-left:2px'class='x-sqs-list' id='recaptcha_image'></div></td>
		</tr>
		<tr>
			<td colspan='2' align='right'><a href='javascript:Recaptcha.reload()'>".$mod_strings['LBL_RECAPTCHA_NEW_CAPTCHA']."</a>&nbsp;&nbsp;
			 		<a class='recaptcha_only_if_image' href='javascript:Recaptcha.switch_type(\"audio\")'>".$mod_strings['LBL_RECAPTCHA_SOUND']."</a>
			 		<a class='recaptcha_only_if_audio' href='javascript:Recaptcha.switch_type(\"image\")'> ".$mod_strings['LBL_RECAPTCHA_IMAGE']."</a>
		 	</td>
		</tr>";
		$sugar_smarty->assign('CAPTCHA', $Captcha);
		echo $captcha_js;

	}else{
		echo "<script>
		function validateAndSubmit(){generatepwd();}
		</script>";
	}

$sugar_smarty->display('modules/Users/login.tpl'); ?>
