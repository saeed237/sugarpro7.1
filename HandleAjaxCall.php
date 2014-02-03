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
 * Used to call a generic method in a dashlet
 */
// Only define entry point type if it isnt already defined
if (!defined('ENTRY_POINT_TYPE')) {
    define('ENTRY_POINT_TYPE', 'gui');
}
 require_once('include/entryPoint.php');
 require_once('ModuleInstall/PackageManager/PackageController.php');
if(!is_admin($GLOBALS['current_user'])){
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
    $requestedMethod = $_REQUEST['method'];
    $pmc = new PackageController();

    if(method_exists($pmc, $requestedMethod)) {
        echo $pmc->$requestedMethod();
    }
    else {
        echo 'no method';
    }
   // sugar_cleanup();
?>
