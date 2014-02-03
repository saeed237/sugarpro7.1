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


if(!isset( $sugar_config['disc_client']) || !$sugar_config['disc_client']){
	die('Please convert this instance to a client');
}
global $soapclient, $soap_server;
if(isset($_GET['check_available'])){

		$start_time = $soapclient->call('get_gmt_time',array());

		if($start_time){
			 header("Location: index.php?action=index&module=Sync&go_online=1");
		}else{
			$_SESSION['soap_server_available'] = false;
			echo '<b><font color="red">'. translate('LBL_SERVER_UNAVAILABLE','Sync' ) .'</font></b>';
			die();
		}


}
if(isset($_REQUEST['go_online'])){
	session_start();
	global $current_user;

	if(!isset($current_user)){

		$current_user = BeanFactory::getBean('Users');
		if(isset($_SESSION['authenticated_user_id']))
		{
			$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
			if($result == null)
			{
				session_destroy();
			    header("Location: index.php?action=Login&module=Users");
			}
		}
	}

	require_once('modules/Sync/SyncHelper.php');
	$soapclient = new nusoapclient($soap_server);  //define the SOAP Client an
	$result = $soapclient->call('login',array('user_auth'=>sync_get_user_auth_data(), 'application_name'=>'MobileClient'));

	if(!has_error($result)){
		$canlogin = $soapclient->call('seamless_login',array('session'=>$result['id']));
		if($canlogin == 1){
			header('Location:' . $sugar_config['sync_site_url'] . '/index.php?MSID='. $result['id']);
		}else{
			sugar_die('Could not do seamless login');
		}
	}
}

?>