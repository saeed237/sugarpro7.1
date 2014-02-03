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


/**
 * This file intialize the service class and does all the setters based on the values provided in soap/rest entry point
 * and calls serve method which takes the request and send response back to the client
 */
ob_start();
chdir(dirname(__FILE__).'/../../');
define('ENTRY_POINT_TYPE', 'api');
require('include/entryPoint.php');
require_once('soap/SoapError.php');
require_once('SoapHelperWebService.php');
require_once('SugarRestUtils.php');
require_once($webservice_path);
require_once($registry_path);
if(isset($webservice_impl_class_path))
    require_once($webservice_impl_class_path);
$url = $GLOBALS['sugar_config']['site_url'].$location;
$service = new $webservice_class($url);
$service->registerClass($registry_class);
$service->register();
$service->registerImplClass($webservice_impl_class);

SugarMetric_Manager::getInstance()->setTransactionName('soap_' . $_REQUEST['method']);

// set the service object in the global scope so that any error, if happens, can be set on this object
global $service_object;
$service_object = $service;

$service->serve();
