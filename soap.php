<?php
 if(!defined('sugarEntry'))define('sugarEntry', true);
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

define('ENTRY_POINT_TYPE', 'api');
require_once('include/entryPoint.php');
require_once('include/utils/file_utils.php');
ob_start();

require_once('soap/SoapError.php');
require_once('vendor/nusoap//nusoap.php');
require_once('modules/Contacts/Contact.php');
require_once('modules/Accounts/Account.php');
require_once('modules/Opportunities/Opportunity.php');
require_once('modules/Cases/Case.php');
//ignore notices
error_reporting(E_ALL ^ E_NOTICE);

checkSystemLicenseStatus();
checkSystemState();

global $HTTP_RAW_POST_DATA;

$administrator = Administration::getSettings();

$NAMESPACE = 'http://www.sugarcrm.com/sugarcrm';
$server = new soap_server;
$server->configureWSDL('sugarsoap', $NAMESPACE, $sugar_config['site_url'].'/soap.php');

//New API is in these files
if(!empty($administrator->settings['portal_on'])) {
	require_once('soap/SoapPortalUsers.php');
}

require_once('soap/SoapSugarUsers.php');
//require_once('soap/SoapSugarUsers_version2.php');
require_once('soap/SoapData.php');
require_once('soap/SoapDeprecated.php');


require_once('soap/SoapSync.php');
require_once('soap/SoapUpgradeUtils.php');

/* Begin the HTTP listener service and exit. */
ob_clean();

if (!isset($HTTP_RAW_POST_DATA)){
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
}

require_once('include/resource/ResourceManager.php');
$resourceManager = ResourceManager::getInstance();
$resourceManager->setup('Soap');
$observers = $resourceManager->getObservers();
//Call set_soap_server for SoapResourceObserver instance(s)
foreach($observers as $observer) {
   if(method_exists($observer, 'set_soap_server')) {
   	  $observer->set_soap_server($server);
   }
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
global $soap_server_object;
$soap_server_object = $server;
$server->service($HTTP_RAW_POST_DATA);

$action = substr($server->SOAPAction, strpos($server->SOAPAction, 'soap.php/') + 9);
SugarMetric_Manager::getInstance()->setTransactionName('soap_' . $action);

ob_end_flush();
flush();
sugar_cleanup(true);
