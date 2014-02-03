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

//change directories to where this file is located.
chdir(dirname(__FILE__));
define('ENTRY_POINT_TYPE', 'api');
require_once('include/entryPoint.php');

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    sugar_die("cron.php is CLI only.");
}

SugarMetric_Manager::getInstance()->setMetricClass('background')->setTransactionName('cron');

if(empty($current_language)) {
	$current_language = $sugar_config['default_language'];
}

$app_list_strings = return_app_list_strings_language($current_language);
$app_strings = return_application_language($current_language);

global $current_user;
$current_user = BeanFactory::getBean('Users');
$current_user->getSystemUser();

$GLOBALS['log']->debug('--------------------------------------------> at cron.php <--------------------------------------------');
$cron_driver = !empty($sugar_config['cron_class'])?$sugar_config['cron_class']:'SugarCronJobs';
$GLOBALS['log']->debug("Using $cron_driver as CRON driver");

SugarAutoLoader::requireWithCustom("include/SugarQueue/$cron_driver.php");

$jobq = new $cron_driver();
$jobq->runCycle();

$exit_on_cleanup = true;

sugar_cleanup(false);
// some jobs have annoying habit of calling sugar_cleanup(), and it can be called only once
// but job results can be written to DB after job is finished, so we have to disconnect here again
// just in case we couldn't call cleanup
if(class_exists('DBManagerFactory')) {
	$db = DBManagerFactory::getInstance();
	$db->disconnect();
}

// If we have a session left over, destroy it
if(session_id()) {
    session_destroy();
}

if($exit_on_cleanup) exit($jobq->runOk()?0:1);
