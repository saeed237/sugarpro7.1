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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

 /**Check captcha validation here.
 *
 */
require_once('vendor/reCaptcha/recaptchalib.php');

$admin = Administration::getSettings('captcha');
if($admin->settings['captcha_on']=='1' && !empty($admin->settings['captcha_private_key'])){
	$privatekey = $admin->settings['captcha_private_key'];
}else
	die("Captcha settings not found");
$response = recaptcha_check_answer($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_REQUEST["recaptcha_challenge_field"],
									$_REQUEST["recaptcha_response_field"]);
if(!$response->is_valid){
	die("Invalid captcha entry, go back and fix. ". $response->error. " ");
}
else echo("Success");

?>
