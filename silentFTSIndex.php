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
    sugar_die("silentFTSIndex.php is CLI only.\n");
}

if(empty($current_language)) {
	$current_language = $sugar_config['default_language'];
}

$app_list_strings = return_app_list_strings_language($current_language);
$app_strings = return_application_language($current_language);

global $current_user;
$current_user = BeanFactory::getBean('Users');
$current_user->getSystemUser();

$modules = ($argc > 1) ?  array($argv[1]) : array();
$clearData = ($argc == 2) ?  $argv[2] : TRUE;
require_once('include/SugarSearchEngine/SugarSearchEngineFullIndexer.php');
require_once('include/SugarSearchEngine/SugarSearchEngineAbstractBase.php');
try {
    SugarSearchEngineAbstractBase::markSearchEngineStatus(false); // set search engine to "up"
    $indexer = new SugarSearchEngineFullIndexer();
    if(!$indexer->performFullSystemIndex($modules, $clearData)) {
        echo "FTS index failed. Please check the sugarcrm.log for more details.\n";
        exit(1);
    }
} catch(Exception $e) {
    echo "Exception: ".$e->getMessage()."\n";
    exit(1);
}
exit(0);
