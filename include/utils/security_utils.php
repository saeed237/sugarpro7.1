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


/* 
 * func: query_module_access 
 * param: $moduleName
 * 
 * returns 1 if user has access to a module, else returns 0
 * 
 */

$modules_exempt_from_availability_check['Activities']='Activities';
$modules_exempt_from_availability_check['History']='History';
$modules_exempt_from_availability_check['Calls']='Calls';
$modules_exempt_from_availability_check['Meetings']='Meetings';
$modules_exempt_from_availability_check['Tasks']='Tasks';
//$modules_exempt_from_availability_check['Notes']='Notes';

$modules_exempt_from_availability_check['CampaignLog']='CampaignLog';
$modules_exempt_from_availability_check['CampaignTrackers']='CampaignTrackers';
$modules_exempt_from_availability_check['Prospects']='Prospects';
$modules_exempt_from_availability_check['ProspectLists']='ProspectLists';
$modules_exempt_from_availability_check['EmailMarketing']='EmailMarketing';
$modules_exempt_from_availability_check['EmailMan']='EmailMan';
$modules_exempt_from_availability_check['ProjectTask']='ProjectTask';
$modules_exempt_from_availability_check['Users']='Users';
$modules_exempt_from_availability_check['Teams']='Teams';
$modules_exempt_from_availability_check['SchedulersJobs']='SchedulersJobs';
$modules_exempt_from_availability_check['DocumentRevisions']='DocumentRevisions';
function query_module_access_list(&$user)
{
	require_once('modules/MySettings/TabController.php');
	$controller = new TabController();
	$tabArray = $controller->get_tabs($user); 

	return $tabArray[0];
		
}

function query_user_has_roles($user_id)
{
	
	
	$role = BeanFactory::getBean('Roles');
	
	return $role->check_user_role_count($user_id);
}

function get_user_allowed_modules($user_id)
{
	

	$role = BeanFactory::getBean('Roles');
	
	$allowed = $role->query_user_allowed_modules($user_id);
	return $allowed;
}

function get_user_disallowed_modules($user_id, &$allowed)
{
	

	$role = BeanFactory::getBean('Roles');
	$disallowed = $role->query_user_disallowed_modules($user_id, $allowed);
	return $disallowed;
}
// grabs client ip address and returns its value
function query_client_ip()
{
	global $_SERVER;
	$clientIP = false;
	if(!empty($GLOBALS['sugar_config']['ip_variable']) && !empty($_SERVER[$GLOBALS['sugar_config']['ip_variable']])){
		$clientIP = $_SERVER[$GLOBALS['sugar_config']['ip_variable']];
	}else if(isset($_SERVER['HTTP_CLIENT_IP']))
	{
		$clientIP = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
	{
		// check for internal ips by looking at the first octet
		foreach($matches[0] AS $ip)
		{
			if(!preg_match("#^(10|172\.16|192\.168)\.#", $ip))
			{
				$clientIP = $ip;
				break;
			}
		}

	}
	elseif(isset($_SERVER['HTTP_FROM']))
	{
		$clientIP = $_SERVER['HTTP_FROM'];
	}
	else
	{
		$clientIP = $_SERVER['REMOTE_ADDR'];
	}
	return $clientIP;
}

// sets value to key value
function get_val_array($arr){
	$new = array();
	if(!empty($arr)){
	foreach($arr as $key=>$val){
		$new[$key] = $key;
	}
	}
	return $new;
}

