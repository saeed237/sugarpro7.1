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

********************************************************************************/
require_once('include/utils/encryption_utils.php');

function getSystemInfo($send_usage_info=true){
	global $sugar_config;
	global $db, $timedate;
	$info=array();
	$info = getBaseSystemInfo($send_usage_info);
    if($send_usage_info){
		$info['application_key']=$sugar_config['unique_key'];
		$info['php_version']=phpversion();
		if(isset($_SERVER['SERVER_SOFTWARE'])) {
			$info['server_software'] = $_SERVER['SERVER_SOFTWARE'];
		} // if

		//get user count.
                $query = "SELECT count(id) as total from users WHERE " . User::getLicensedUsersWhere();
                $result = $db->getOne($query, false, 'fetching active users count');
                if ($result !== false) {
                    $info['users'] = $result;
                }

	    $administration = Administration::getSettings('system');
		$info['system_name'] = (!empty($administration->settings['system_name']))?substr($administration->settings['system_name'], 0 ,255):'';


		$result=$db->getOne("select count(id) count from users where status='Active' and deleted=0 and is_admin='1'", false, 'fetching admin count');
		if($result !== false) {
			$info['admin_users'] = $result;
		}


		$result=$db->getOne("select count(id) count from users", false, 'fetching all users count');
		if($result !== false) {
			$info['registered_users'] = $result;
		}

		$lastMonth = $db->convert("'". $timedate->getNow()->modify("-30 days")->asDb(false) . "'", 'datetime');
		if( !$send_usage_info) {
			$info['users_active_30_days'] = -1;
		} else {
			$info['users_active_30_days'] = $db->getOne("SELECT count( DISTINCT users.id ) user_count FROM tracker, users WHERE users.id = tracker.user_id AND  tracker.date_modified >= $lastMonth", false, 'fetching last 30 users count');
		}


            if (file_exists('modules/Administration/System.php')) {
	            require_once('modules/Administration/System.php');
	            $system = new System();
	            $info['oc_active_30_days'] = $system->getClientsActiveInLast30Days();
	            $info['oc_active'] = $system->getEnabledOfflineClients($system->create_new_list_query("",'system_id != 1'));
	            $info['oc_all'] = $system->getOfflineClientCount();
	            $info['oc_br_all'] = $system->getTotalInstallMethods('bitrock');
	            $info['oc_br_active_30_days'] = $system->getClientsActiveInLast30Days("install_method = 'bitrock'");
	            $info['oc_br_active'] = $system->getEnabledOfflineClients($system->create_new_list_query("",'system_id != 1 AND install_method = \'bitrock\''));
            }


		if(!$send_usage_info){
			$info['latest_tracker_id'] = -1;
		}else{
			$id=$db->getOne("select id from tracker order by date_modified desc", false, 'fetching most recent tracker entry');
			if ( $id !== false )
			    $info['latest_tracker_id'] = $id;
		}

		$info['db_type']=$sugar_config['dbconfig']['db_type'];
		$info['db_version']=$db->version();
	}
	if(file_exists('distro.php')){
		include('distro.php');
		if(!empty($distro_name))$info['distro_name'] = $distro_name;
	}
	$result = $db->getOne("SELECT count(*) as record_count FROM session_history WHERE is_violation =1 AND date_entered >= $lastMonth");
	if($result){
		$info['license_portal_ex'] = $result;
	}
	$result = $db->getOne("SELECT MAX(num_active_sessions) as record_max FROM session_history WHERE date_entered >= $lastMonth");
	$info['license_portal_max'] = 0;
	if($result !== false) {
		$info['license_portal_max'] = $result;
	}
	$info['os'] = php_uname('s');
	$info['os_version'] = php_uname('r');
	$info['timezone_u'] = $GLOBALS['current_user']->getPreference('timezone');
	$info['timezone'] = date('e');
	if($info['timezone'] == 'e'){
		$info['timezone'] = date('T');
	}
	return $info;

}

function getBaseSystemInfo($send_usage_info=true){
    include('sugar_version.php');
    $info=array();

    if($send_usage_info){
        $info['sugar_db_version']=$sugar_db_version;
    }
    $info['sugar_version']=$sugar_version;
    $info['sugar_flavor']=$sugar_flavor;
    $info['auth_level'] = 0;


    global $license;
    if (!empty($license->settings))  {
        $info['license_users']=$license->settings['license_users'];
        $info['license_expire_date']=$license->settings['license_expire_date'];
        $info['license_key']=$license->settings['license_key'];
        $info['license_num_lic_oc']=$license->settings['license_num_lic_oc'];
        $info['license_num_portal_users'] = (!empty($license->settings['license_num_portal_users']) ? $license->settings['license_num_portal_users'] : '');
    }
    $info['license_portal_ex'] = 0;
    $info['license_portal_max'] = 0;



    return $info;


}

function check_now($send_usage_info=true, $get_request_data=false, $response_data = false, $from_install=false ) {
	global $sugar_config, $timedate;
	global $db, $license;


	// This section of code is a portion of the code referred
	// to as Critical Control Software under the End User
	// License Agreement.  Neither the Company nor the Users
	// may modify any portion of the Critical Control Software.
	if(ocLicense()){
		return array();
	}
	// END REQUIRED CODE


	$return_array=array();
    if(!$from_install && empty($license))loadLicense(true);

	if(!$response_data){

        if($from_install){
    		$info = getBaseSystemInfo(false);

        }else{
            $info = getSystemInfo($send_usage_info);
        }

		require_once('vendor/nusoap//nusoap.php');

		$GLOBALS['log']->debug('USING HTTPS TO CONNECT TO HEARTBEAT');
		$sclient = new nusoapclient('https://updates.sugarcrm.com/heartbeat/soap.php', false, false, false, false, false, 15, 15);
		$ping = $sclient->call('sugarPing', array());
		if(empty($ping) || $sclient->getError()){
			$sclient = '';
		}

		if(empty($sclient)){
			$GLOBALS['log']->debug('USING HTTP TO CONNECT TO HEARTBEAT');
			$sclient = new nusoapclient('http://updates.sugarcrm.com/heartbeat/soap.php', false, false, false, false, false, 15, 15);
		}






		// This section of code is a portion of the code referred
		// to as Critical Control Software under the End User
		// License Agreement.  Neither the Company nor the Users
		// may modify any portion of the Critical Control Software.
		if(!empty( $license->settings['license_key'])){
			$key = $license->settings['license_key'];
		}else{
			//END REQUIRED CODE


			$key = '4829482749329';


		}



		$encoded = sugarEncode($key, serialize($info));

		if($get_request_data){
			$request_data = array('key'=>$key, 'data'=>$encoded);
			return serialize($request_data);
		}
		$encodedResult = $sclient->call('sugarHome', array('key'=>$key, 'data'=>$encoded));

	}else{
		$encodedResult = 	$response_data['data'];
		$key = $response_data['key'];

	}

	if($response_data || !$sclient->getError()){
		$serializedResultData = sugarDecode($key,$encodedResult);
		$resultData = unserialize($serializedResultData);
		if($response_data && empty($resultData))
		{
			$resultData = array();
			$resultData['validation'] = 'invalid validation key';
		}
	}else
	{
		$resultData = array();
		$resultData['versions'] = array();

	}

	if($response_data || !$sclient->getError() )
	{

		// This section of code is a portion of the code referred
		// to as Critical Control Software under the End User
		// License Agreement.  Neither the Company nor the Users
		// may modify any portion of the Critical Control Software.
		checkDownloadKey($resultData['validation']);
		//END REQUIRED CODE
		if(!empty($resultData['msg'])){
			if(!empty($resultData['msg']['admin'])){
				$license->saveSetting('license', 'msg_admin', base64_encode($resultData['msg']['admin']));
			}else{
				$license->saveSetting('license', 'msg_admin','');
			}
			if(!empty($resultData['msg']['all'])){
				$license->saveSetting('license', 'msg_all', base64_encode($resultData['msg']['all']));
			}else{
				$license->saveSetting('license', 'msg_all','');
			}
		}else{
			$license->saveSetting('license', 'msg_admin','');
			$license->saveSetting('license', 'msg_all','');
		}
		$license->saveSetting('license', 'last_validation', 'success');
		unset($_SESSION['COULD_NOT_CONNECT']);
	}
	else
	{
		$resultData = array();
		$resultData['versions'] = array();

		$license->saveSetting('license', 'last_connection_fail', TimeDate::getInstance()->nowDb());
		$license->saveSetting('license', 'last_validation', 'no_connection');

		if( empty($license->settings['license_last_validation_success']) && empty($license->settings['license_last_validation_fail']) && empty($license->settings['license_vk_end_date'])){
			$license->saveSetting('license', 'vk_end_date', TimeDate::getInstance()->nowDb());

			$license->saveSetting('license', 'validation_key', base64_encode(serialize(array('verified'=>false))));
		}
		$_SESSION['COULD_NOT_CONNECT'] =TimeDate::getInstance()->nowDb();

	}
	if(!empty($resultData['versions'])){

		$license->saveSetting('license', 'latest_versions',base64_encode(serialize($resultData['versions'])));
	}else{
		$resultData['versions'] = array();
		$license->saveSetting('license', 'latest_versions','')	;
	}




	include('sugar_version.php');

	if(sizeof($resultData) == 1 && !empty($resultData['versions'][0]['version'])
        && compareVersions($sugar_version, $resultData['versions'][0]['version']))
	{
		$resultData['versions'][0]['version'] = $sugar_version;
		$resultData['versions'][0]['description'] = "You have the latest version.";
	}


	return $resultData['versions'];
}
/*
 * returns true if $ver1 > $ver2
 */
function compareVersions($ver1, $ver2)
{
    return (version_compare($ver1, $ver2) === 1);
}
function set_CheckUpdates_config_setting($value) {


	$admin = BeanFactory::getBean('Administration');
	$admin->saveSetting('Update','CheckUpdates',$value);
}
/* return's value for the 'CheckUpdates' config setting
* if the setting does not exist one gets created with a default value of automatic.
*/
function get_CheckUpdates_config_setting() {

	$checkupdates='automatic';


	$admin = Administration::getSettings('Update',true);
	if (empty($admin->settings) or empty($admin->settings['Update_CheckUpdates'])) {
		$admin->saveSetting('Update','CheckUpdates','automatic');
	} else {
		$checkupdates=$admin->settings['Update_CheckUpdates'];
	}
	return $checkupdates;
}

function set_last_check_version_config_setting($value) {


	$admin = BeanFactory::getBean('Administration');
	$admin->saveSetting('Update','last_check_version',$value);
}
function get_last_check_version_config_setting() {



	$admin = Administration::getSettings('Update');
	if (empty($admin->settings) or empty($admin->settings['Update_last_check_version'])) {
		return null;
	} else {
		return $admin->settings['Update_last_check_version'];
	}
}


function set_last_check_date_config_setting($value) {


	$admin = BeanFactory::getBean('Administration');
	$admin->saveSetting('Update','last_check_date',$value);
}
function get_last_check_date_config_setting() {



	$admin = Administration::getSettings('Update');
	if (empty($admin->settings) or empty($admin->settings['Update_last_check_date'])) {
		return 0;
	} else {
		return $admin->settings['Update_last_check_date'];
	}
}

function set_sugarbeat($value) {
	global $sugar_config;
	$_SUGARBEAT="sugarbeet";
	$sugar_config[$_SUGARBEAT] = $value;
	write_array_to_file( "sugar_config", $sugar_config, "config.php" );
}
function get_sugarbeat() {


	/*

	global $sugar_config;
	$_SUGARBEAT="sugarbeet";

	if (isset($sugar_config[$_SUGARBEAT]) && $sugar_config[$_SUGARBEAT] == false) {
	return false;
	}
	*/

	return true;

}



function shouldCheckSugar(){
	global $license, $timedate;
	if(

	(empty($license->settings['license_last_validation_fail']) ||  $license->settings['license_last_validation_fail'] < $timedate->getNow()->modify("-6 hours")->asDb(false))  &&
	get_CheckUpdates_config_setting() == 'automatic' ){
		return true;
	}

	return false;
}

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.


//Adding a comment for 6.5.5
function authenticateDownloadKey(){
	$data = array();
	if(empty($GLOBALS['license']->settings['license_validation_key']) && shouldCheckSugar()){
		check_now(get_sugarbeat());
	}
	//could not connect to server so we'll let it pass

	if(empty($GLOBALS['license']->settings['license_validation_key'])){
		return false;
	}


	if(!empty($GLOBALS['license']->settings['license_validation_key']['validation']))return true;
	$data['license_expire_date'] = $GLOBALS['license']->settings['license_expire_date'];
	$data['license_users'] =  intval($GLOBALS['license']->settings['license_users']);
	$data['license_num_lic_oc'] = intval( $GLOBALS['license']->settings['license_num_lic_oc']);
	$data['license_num_portal_users'] = intval($GLOBALS['license']->settings['license_num_portal_users']);
	$data['license_vk_end_date'] = $GLOBALS['license']->settings['license_vk_end_date'];
	$data['license_key'] = $GLOBALS['license']->settings['license_key'];
    if(isset($GLOBALS['license']->settings['license_enforce_portal_user_limit'])) {
        $data['enforce_portal_user_limit'] = intval($GLOBALS['license']->settings['license_enforce_portal_user_limit']);
    }
    if(isset($GLOBALS['license']->settings['license_enforce_user_limit'])) {
    	$data['enforce_user_limit'] = intval($GLOBALS['license']->settings['license_enforce_user_limit']);
    }

	if(empty($GLOBALS['license']->settings['license_validation_key'])) return false;
	$og = unserialize(sugarDecode('validation', $GLOBALS['license']->settings['license_validation_key']));


	foreach($og as $name=>$value){

		if(!isset($data[$name]) || $data[$name] != $value){

			return false;
		}
	}

	return true;

}

function ocLicense(){
	global $sugar_config;
	return isset( $sugar_config['disc_client']) && $sugar_config['disc_client'];
}

function checkDownloadKey($data){

	if(!isset($GLOBALS['license'])){
		loadLicense(true);
	}


	if(!is_array($data)){


		if($data == 'invalid'){
			$GLOBALS['license']->saveSetting('license', 'users', 1);
			$GLOBALS['license']->saveSetting('license', 'num_lic_oc', 0);
			$GLOBALS['license']->saveSetting('license', 'num_portal_users', 0);
			$GLOBALS['license']->saveSetting('license', 'validation_key', '');
			$GLOBALS['license']->saveSetting('license', 'vk_end_date', '2000-10-10');

			$GLOBALS['license']->saveSetting('license', 'expire_date', '2000-10-10');
			$GLOBALS['license']->saveSetting('license', 'validation_notice', 'invalid');
			$GLOBALS['license']->saveSetting('license', 'last_validation_fail', TimeDate::getInstance()->nowDb());
			return 'Invalid Download Key';
		}
		if($data == 'expired' || $data == 'closed'){
			$GLOBALS['license']->saveSetting('license', 'num_lic_oc', 0);
			$GLOBALS['license']->saveSetting('license', 'validation_notice', 'expired');
			if($data == 'closed'){
				$GLOBALS['license']->saveSetting('license', 'users', 1);
			}
			$GLOBALS['license']->saveSetting('license', 'last_validation_fail', TimeDate::getInstance()->nowDb());
			return 'Expired Download Key';
		}else if($data == 'invalid validation key'){
			$GLOBALS['license']->saveSetting('license', 'validation_notice', 'Invalid Validation Key File - please make sure you uploaded the right file');
			$GLOBALS['license']->saveSetting('license', 'last_validation_fail', TimeDate::getInstance()->nowDb());
			return 'Invalid Validation Key';

		}
		return $data;


	}


	$GLOBALS['license']->saveSetting('license', 'users', $data['license_users']);
	$GLOBALS['license']->saveSetting('license', 'num_lic_oc', (empty($data['license_num_lic_oc']) ? 0 : $data['license_num_lic_oc']));
	if(empty($data['license_num_portal_users'])) $data['license_num_portal_users'] = 0;
	$GLOBALS['license']->saveSetting('license', 'num_portal_users', $data['license_num_portal_users']);
	$GLOBALS['license']->saveSetting('license', 'validation_key', $data['license_validation_key']);
	$GLOBALS['license']->saveSetting('license', 'vk_end_date', $data['license_vk_end_date']);
	$GLOBALS['license']->saveSetting('license', 'expire_date', $data['license_expire_date']);
	$GLOBALS['license']->saveSetting('license', 'last_validation_success', TimeDate::getInstance()->nowDb());
	$GLOBALS['license']->saveSetting('license', 'validation_notice', '');
	$GLOBALS['license']->saveSetting('license', 'enforce_portal_user_limit', (isset($data['enforce_portal_user_limit'])&&$data['enforce_portal_user_limit']=='1') ? '1' : '0');

	if(isset($data['enforce_user_limit']))
		$GLOBALS['license']->saveSetting('license', 'enforce_user_limit', $data['enforce_user_limit']);

	loadLicense(true);
	return 'Validation Complete';
}



/**
 * Whitelist of modules and actions that don't need redirect
 *
 * Use following standard for whitelist:
 * array(
 *		'module_name_1' => array('action_name_1', 'action_name_2', ...),	// Allow only "action_name_1" and "action_name_2" for "module_name_1"
 *		'module_name_2' => 'all',	|										// Allow ALL actions in module "module_name_2"
 *		...
 *		)
 * @param User $user
 * @return array
 */
function getModuleWhiteListForLicenseCheck(User $user) {
	$admin_white_list = array(
		'Administration'		=> array('LicenseSettings', 'Save'),
		'Configurator'			=> 'all',
		'Home'					=> array('About'),
		'Notifications'			=> array('quicklist'),
		'Users'					=> array('SetTimezone', 'SaveTimezone', 'Logout')
	);

	$not_admin_white_list	= array(
		'Users'					=> array('Logout', 'Login')
	);

	$white_list				= is_admin($user)?$admin_white_list:$not_admin_white_list;

	return $white_list;
}

/**
 * Check if $module and $action don't get into whitelist and do we need redirect
 *
 * @param string	$state	Now works only for 'LICENSE_KEY' state (TODO: do we need any other state?)
 * @param string	$module	Module to check
 * @param string	$action	(optional) Action to check. Can be omitted because some modules include all actions
 * @return boolean
 */
function isNeedRedirectDependingOnUserAndSystemState($state, $module = null, $action = null, $whiteList = array()) {
	if($module !== null) {
		if($state == 'LICENSE_KEY') {
			foreach($whiteList as $wlModule => $wlActions) {
				if($module == $wlModule && ($wlActions === 'all' || in_array($action, $wlActions))) {
					return false;
				}
			}
		}
	}

	return true;
}

/**
 * Redirect current user if current module and action isn't in whitelist
 * @global User		$current_user	User object that stores current application user
 * @param string	$state			Now works only for 'LICENSE_KEY' state  (TODO: do we need any other state?)
 */
function setSystemState($state){
	global $current_user;
	$admin_redirect_url		= 'index.php?action=LicenseSettings&module=Administration&LicState=check';
	$not_admin_redirect_url	= 'index.php?module=Users&action=Logout&LicState=check';

	if(isset($current_user) && !empty($current_user->id)){
		if(isNeedRedirectDependingOnUserAndSystemState($state, $_REQUEST['module'], $_REQUEST['action'], getModuleWhiteListForLicenseCheck($current_user))) {
			$redirect_url			= is_admin($current_user)?$admin_redirect_url:$not_admin_redirect_url;
			header('Location: '.$redirect_url);
			sugar_cleanup(true);
		}
	}
}

function checkSystemState(){
	if(ocLicense())return;
	if($_SESSION['LICENSE_EXPIRES_IN'] === 'REQUIRED'){
		die('LICENSE INFORMATION IS REQUIRED PLEASE CONTACT A SYSTEM ADMIN ');
	}
	if($_SESSION['VALIDATION_EXPIRES_IN'] === 'REQUIRED'){
		die('LICENSE INFORMATION IS REQUIRED PLEASE CONTACT A SYSTEM ADMIN ');
	}
	if($_SESSION['LICENSE_EXPIRES_IN'] != 'valid' && $_SESSION['LICENSE_EXPIRES_IN'] < -30){
		die('LICENSE EXPIRED ' . abs( $_SESSION['LICENSE_EXPIRES_IN']) .' day(s) ago - PLEASE CONTACT A SYSTEM ADMIN');
	}
	if($_SESSION['VALIDATION_EXPIRES_IN'] != 'valid' && $_SESSION['VALIDATION_EXPIRES_IN'] < -30){
		die('VALIDATION KEY FOR LICENSE EXPIRED ' . abs( $_SESSION['VALIDATION_EXPIRES_IN']) .' day(s) ago - PLEASE CONTACT A SYSTEM ADMIN');
	}
}
function checkSystemLicenseStatus(){

	global $license;

	loadLicense(true);

	if(ocLicense())return;

	if(!empty($license->settings)){


		if(isset($license->settings['license_vk_end_date'])){

			$_SESSION['VALIDATION_EXPIRES_IN'] = isAboutToExpire($license->settings['license_vk_end_date']);

		}else{
			$_SESSION['VALIDATION_EXPIRES_IN'] = 'REQUIRED';
		}

		if(!empty($license->settings['license_expire_date'])){
			$_SESSION['LICENSE_EXPIRES_IN'] = isAboutToExpire($license->settings['license_expire_date']);
		}else{
			$_SESSION['VALIDATION_EXPIRES_IN'] = 'REQUIRED';
		}

        if(isset($license->settings['license_num_lic_oc'])){
            $_SESSION['EXCEEDING_OC_LICENSES'] = hasExceededOfflineClientLicenses($license->settings['license_num_lic_oc']);
        }else{
            $_SESSION['EXCEEDING_OC_LICENSES'] = false;
        }
	}else{
		$_SESSION['INVALID_LICENSE'] = true;
	}

}

function apiCheckSystemStatus($forceReload = false)
{
    global $sugar_config, $sugar_flavor, $db;

    if (!isset($sugar_config['installer_locked']) || $sugar_config['installer_locked'] == false ){
        return array(
            'level'  =>'admin_only',
            'message'=>'WARN_INSTALLER_LOCKED',
            'url'    =>'install.php',
        );
    }
    
    // If they are missing session variables force a reload
    $sessionCheckNotExists = array(
        'VALIDATION_EXPIRES_IN',
        'LICENSE_EXPIRES_IN',
        'EXCEEDING_OC_LICENSES',
    );
    $sessionCheckExists = array(
        'HomeOnly',
        'INVALID_LICENSE',
    );
    foreach ($sessionCheckNotExists as $key) {
        if (!isset($_SESSION[$key])) {
            $forceReload = true;
        }
    }
    foreach ($sessionCheckExists as $key) {
        if (!empty($_SESSION[$key])) {
            $forceReload = true;
        }
    }

    $systemStatus = apiLoadSystemStatus($forceReload);

    // Don't allow maintenanceMode to override license failures
    if ($systemStatus === true
        && !empty($GLOBALS['sugar_config']['maintenanceMode'])) {
        $url = 'maintenance.php';
        if ($GLOBALS['sugar_config']['maintenanceMode'] !== true) {
            $url = $GLOBALS['sugar_config']['maintenanceMode'];
        }

        return array(
            'level'  =>'maintenance',
            'message'=>'EXCEPTION_MAINTENANCE',
            'url'    =>$url,
        );
        
    }

    return $systemStatus;
}

function apiLoadSystemStatus($forceReload = false)
{
    $systemStatus = null;
    $oldSystemStatus = null;
    // First try from SugarCache
    $systemStatus = sugar_cache_retrieve('api_system_status');
    if (empty($systemStatus)) {
        // No luck, try the database
	    $administration = Administration::getSettings('system');
        if (!empty($administration->settings['api_system_status'])) {
            $systemStatus = unserialize(base64_decode($administration->settings));
        }
    }

    if (!empty($systemStatus)) {
        // Save the old system status, so if the new one is the same
        // even on a force reload, we don't update it.
        $oldSystemStatus = $systemStatus;
    }
    if ($forceReload) {
        $systemStatus = null;
    }
    
    if (empty($systemStatus)) {
        $systemStatus = apiActualLoadSystemStatus();
    }

    if (serialize($systemStatus) != serialize($oldSystemStatus)) {
        sugar_cache_put('api_system_status',$systemStatus);
        if (!isset($administration)) {
            $administration = Administration::getSettings('system');            
        }
        $administration->saveSetting('system','api_system_status',base64_encode(serialize($systemStatus)));
    }

    return $systemStatus;
}

// No caching, just check the system status
function apiActualLoadSystemStatus()
{
    checkSystemLicenseStatus();
    if (!isset($_SESSION['LICENSE_EXPIRES_IN'])) {
        // BEGIN CE-OD License User Limit Enforcement
        if (isset($sugar_flavor) 
            && ($sugar_flavor=='CE' || !empty($admin->settings['license_enforce_user_limit']))) {
            
            $query = "SELECT count(id) as total from users WHERE ".User::getLicensedUsersWhere();
            $result = $db->query($query, true, "Error filling in user array: ");
            $row = $db->fetchByAssoc($result);
            $admin = Administration::getSettings();
            $license_users = $admin->settings['license_users'];
            $license_seats_needed = $row['total'] - $license_users;
            if( $license_seats_needed > 0 ){
                $_SESSION['EXCEEDS_MAX_USERS'] = 1;
                return array(
                    'level'  =>'admin_only',
                    'message'=>'WARN_LICENSE_SEATS_MAXED',
                    'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
                );
            }
        }
        // END CE-OD License User Limit Enforcement
    }
    
    if (!empty($_SESSION['HomeOnly'])) {
        return array(
            'level'  =>'admin_only',
            'message'=>'FATAL_LICENSE_ALTERED',
            'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
        );
    }

    if (!ocLicense()) {
        if (!empty($_SESSION['INVALID_LICENSE'])) {
            return array(
                'level'  =>'admin_only',
                'message'=>'ERROR_LICENSE_VALIDATION',
                'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
            );
        }
        if (isset($_SESSION['LICENSE_EXPIRES_IN']) 
            && $_SESSION['LICENSE_EXPIRES_IN'] != 'valid') {
            if ($_SESSION['LICENSE_EXPIRES_IN'] < -1) {
                return array(
                    'level'  =>'admin_only',
                    'message'=>'ERROR_LICENSE_EXPIRED',
                    'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
                    );
            } else if (isset($GLOBALS['current_user']->id)
                       && $GLOBALS['current_user']->isAdmin()) {
                // Not yet expired, but soon enough to warn                
                return array(
                    'level'  =>'warning',
                    'message'=>'WARN_LICENSE_EXPIRED',
                    'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
                    );
            }
        } elseif (isset($_SESSION['VALIDATION_EXPIRES_IN']) 
                  && $_SESSION['VALIDATION_EXPIRES_IN'] != 'valid') {
            if ($_SESSION['VALIDATION_EXPIRES_IN'] < -1 ) {
                return array(
                    'level'  =>'admin_only',
                    'message'=>'ERROR_LICENSE_VALIDATION',
                    'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
                );
            } else if (isset($GLOBALS['current_user']->id)
                       && $GLOBALS['current_user']->isAdmin()) {
                // Not yet expired, but soon enough to warn                
                return array(
                    'level'  =>'warning',
                    'message'=>'WARN_LICENSE_VALIDATION',
                    'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
                );
            }
        }
    }

    if (!empty($_SESSION['EXCEEDING_OC_LICENSES'])) {
        return array(
            'level'  =>'admin_only',
            'message'=>'ERROR_EXCEEDING_OC_LICENSES',
            'url'    =>'#bwc/index.php?module=Administration&action=ListViewOfflineClient',
        );
    }
    
    return true;
}

function apiCheckLoginStatus()
{
    unset($GLOBALS['login_error']);

    // Run loginLicense()
    loginLicense();

    // The other license check codes are handled by apiCheckSystemLicenseStatus
    if (!empty($GLOBALS['login_error'])) {
        return array(
            'level'  =>'admin_only',
            'message'=>'ERROR_LICENSE_VALIDATION',
            'url'    =>'#bwc/index.php?action=LicenseSettings&module=Administration',
        );
    }

    // Force it to recheck the system license on login
    unset($_SESSION['LICENSE_EXPIRES_IN']);
    return apiCheckSystemStatus();
}




function isAboutToExpire($expire_date, $days_before_warning = 7){
	$seconds_before_warning = $days_before_warning * 24 * 60 * 60;
	$seconds_to_expire = 0;
	if(!empty($expire_date))
	{
		$seconds_to_expire = strtotime( $expire_date ) - time();
	}

	if( $seconds_to_expire < $seconds_before_warning ){
		$days_to_expire =  intval($seconds_to_expire / (60 * 60 * 24 ));
		return $days_to_expire;
	}
	else {
		return 'valid';
	}
}

function hasExceededOfflineClientLicenses($num_oc_lic){
	if (file_exists('modules/Administration/System.php')) {
	    require_once('modules/Administration/System.php');
	    $system = new System();
	    $where = "systems.system_id != 1 AND systems.deleted = 0";
	    $GLOBALS['log']->debug("CHECKING SYSTEMS TABLE");
	    $system_count = $system->getEnabledOfflineClients($system->create_new_list_query("",$where));
	    if(isset($system_count) && isset($num_oc_lic) && !empty($num_oc_lic) && $system_count > $num_oc_lic){
	        return true;
	    }
	}
	return false;
}
//END REQUIRED CODE


function loadLicense($firstLogin=false){

	$GLOBALS['license'] = Administration::getSettings('license', $firstLogin);

}

function loginLicense(){
	global $current_user, $license;
	loadLicense(true);

	if((isset($_SESSION['EXCEEDS_MAX_USERS']) && $_SESSION['EXCEEDS_MAX_USERS'] == 1 ) || empty($license->settings['license_key']) || (!empty($license->settings['license_last_validation']) && $license->settings['license_last_validation'] == 'failed' &&  !empty($license->settings['license_last_validation_fail']) && (empty($license->settings['license_last_validation_success']) || $license->settings['license_last_validation_fail'] > $license->settings['license_last_validation_success']))){

		if(!is_admin($current_user)){
		   $GLOBALS['login_error'] = $GLOBALS['app_strings']['ERROR_LICENSE_VALIDATION'];
		   $_SESSION['login_error'] =  $GLOBALS['login_error'];
		}else{
			if(empty($license->settings['license_key'])){
				$_SESSION['VALIDATION_EXPIRES_IN'] = 'REQUIRED';
			}else{
				$_SESSION['COULD_NOT_CONNECT'] = $license->settings['license_last_validation_fail'];
			}
		}

	}


	if (shouldCheckSugar()) {


		$last_check_date=get_last_check_date_config_setting();
		$current_date_time=time();
		$time_period=3*23*3600 ;
		if (($current_date_time - $last_check_date) > $time_period
		|| empty($license->settings['license_last_validation_success'])
		) {
			$version = check_now(get_sugarbeat());

			unset($_SESSION['license_seats_needed']);

			unset($_SESSION['LICENSE_EXPIRES_IN']);
			unset($_SESSION['VALIDATION_EXPIRES_IN']);
			unset($_SESSION['HomeOnly']);
			loadLicense();
			set_last_check_date_config_setting("$current_date_time");
			include('sugar_version.php');

            $newVersion = '';
            if (!empty($version) && count($version) == 1)
            {
                $newVersion = $version[0]['version'];
            }

            if (version_compare($newVersion, $sugar_version, '>') && is_admin($current_user))
			{
				//set session variables.
				$_SESSION['available_version']=$version[0]['version'];
				$_SESSION['available_version_description']=$version[0]['description'];
				set_last_check_version_config_setting($version[0]['version']);
			}
		}
	}

	// This section of code is a portion of the code referred
	// to as Critical Control Software under the End User
	// License Agreement.  Neither the Company nor the Users
	// may modify any portion of the Critical Control Software.

	if(!authenticateDownloadKey() && !ocLicense()){

	   if(is_admin($current_user)){
		  $_SESSION['HomeOnly'] = true;
	    }else{
	         $_SESSION['login_error'] = $GLOBALS['app_strings']['ERROR_LICENSE_VALIDATION'];
        $GLOBALS['login_error'] =  $GLOBALS['app_strings']['ERROR_LICENSE_VALIDATION'];
	    }
	}
	//END REQUIRED CODE DO NOT MODIFY

}
