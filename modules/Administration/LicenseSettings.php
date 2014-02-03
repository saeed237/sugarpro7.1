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
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/







global $timedate;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;


if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

    if (isset($GLOBALS['sugar_config']['hide_admin_licensing']) && $GLOBALS['sugar_config']['hide_admin_licensing']) {
        sugar_die(translate('LBL_LICENSE_UNAUTHORIZED_ACCESS', 'Administration'));

    }


if(isset($_REQUEST['validate'])){
	checkDownloadKey();
}
$focus = Administration::getSettings();
if(!empty( $_FILES['VKFile']) ){

	$response_data = array();
	$response_data['key'] =  $focus->settings['license_key'];
	$response_data['data'] = file_get_contents($_FILES['VKFile']['tmp_name']);
	check_now(false, true, $response_data );
	$focus->retrieveSettings(false, true);
}
if(!empty( $_REQUEST['exportKey']) ){


	$content = check_now(get_sugarbeat(), true);
	header("Content-Disposition: attachment; filename=sugarkey.lic");
	header("Content-Type: text/plain; charset={$app_strings['LBL_CHARSET']}");
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: " . TimeDate::httpTime() );
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Content-Length: ".strlen($content));
	echo $content;
	die();
}

echo getClassicModuleTitle(
        "Administration",
        array(
            "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
           $mod_strings['LBL_MANAGE_LICENSE_TITLE'],
           ),
        false
        );
global $currentModule;







$GLOBALS['log']->info("Administration LicenseSettings view");

$xtpl=new XTemplate ('modules/Administration/LicenseSettings.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$xtpl->assign("RETURN_MODULE", "Administration");
$xtpl->assign("RETURN_ACTION", "index");

$xtpl->assign("MODULE", $currentModule);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("HEADER", getClassicModuleTitle("Administration", array("{MOD.LBL_MANAGE_LICENSE}"), true));

if(!empty($focus->settings['license_users']))$xtpl->assign("LICENSE_USERS",          $focus->settings['license_users']);
if(!empty($focus->settings['license_expire_date'])) $xtpl->assign("LICENSE_EXPIRE_DATE",    $timedate->to_display_date( $focus->settings['license_expire_date'], false) );
if(!empty($focus->settings['license_key']))$xtpl->assign("LICENSE_KEY",            $focus->settings['license_key']);
if(!empty($focus->settings['license_validation_key']))$xtpl->assign("LICENSE_VALIDATION_KEY",          md5($focus->settings['license_validation_key']));
if(!empty($focus->settings['license_validation_notice'])){
	$xtpl->assign("LICENSE_VALIDATION_NOTICE",           base64_decode($license->settings['license_msg_admin']));
}else{
}
if(!empty($focus->settings['license_vk_end_date']))$xtpl->assign("LICENSE_VALIDATION_EXPIRE_DATE",    $timedate->to_display_date( $focus->settings['license_vk_end_date'], false) );
if(empty($focus->settings['license_key'])){
	$xtpl->assign("NO_LICENSE"	, 'disabled');
}
$status = translate('LBL_VALIDATION_SUCCESS_DATE', 'Administration');
if(empty($focus->settings['license_last_validation_success'])){
	$status .= translate('LBL_NEVER', 'Administration');
}else{
	$status .= $timedate->to_display_date_time($focus->settings['license_last_validation_success']);
}
$status .='<br>';
$status .= translate('LBL_VALIDATION_FAIL_DATE', 'Administration');
if(empty($focus->settings['license_last_validation_fail'])){
	$status .= translate('LBL_NEVER', 'Administration');
}else{
	$status .=  $timedate->to_display_date_time($focus->settings['license_last_validation_fail']);
}
if(!empty($focus->settings['license_last_validation']) && $focus->settings['license_last_validation'] == 'no_connection'){
	$status .= '<br><span class="error" >' . translate('LBL_FAILED_CONNECTION', 'Administration') . ' ' . $timedate->to_display_date_time($focus->settings['license_last_connection_fail']) . '</span>';


}
$xtpl->assign("LICENSE_VALIDATION_STATUS"	, $status);

$xtpl->assign("CALENDAR_DATEFORMAT", "(" . $timedate->get_user_date_format() . ")");

$xtpl->parse("main");

$xtpl->out("main");

if(!empty($focus->settings['license_validation_notice']))
{
echo '<script type="text/javascript">YAHOO.util.Event.onAvailable("edit_view_div", function() { toggleDisplay("detail_view_div"); toggleDisplay("edit_view_div"); });</script>';
}

$javascript = new javascript();
$javascript->setFormName("LicenseSettings");
echo $javascript->getScript();

?>
