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

 //Request object must have these property values:
 //		Module: module name, this module should have a file called TreeData.php
 //		Function: name of the function to be called in TreeData.php, the function will be called statically.
 //		PARAM prefixed properties: array of these property/values will be passed to the function as parameter.

require_once('include/JSON.php');

//require_once('modules/UpgradeWizard/uw_utils.php');

$json = getJSONobj();

//Clean modules from cache
$cachedir = sugar_cached("modules");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
       	if(file_exists($file)){
			unlink($file);
       	}
   }
}
//Clean jsLanguage from cache
$cachedir = sugar_cached("jsLanguage");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
	   	if(file_exists($file)){
			unlink($file);
	   	}
	}
}
//Clean smarty from cache
$cachedir = sugar_cached("smarty");
if(is_dir($cachedir)){
	$allModFiles = array();
	$allModFiles = findAllFiles($cachedir,$allModFiles);
   foreach($allModFiles as $file){
       	if(file_exists($file)){
			unlink($file);
       	}
   }
}

$response = '';
//$GLOBALS['log']->fatal('file name '.$file_name);
//$GLOBALS['log']->fatal('file size loaded '.filesize($file_name));
/*
if($allModFiles != null){
	foreach($allModFiles as $f){
		$GLOBALS['log']->fatal('file name '.$f);
		$response .= $f;
	}
}
*/
if (!empty($response)) {
    echo $response;
}
sugar_cleanup();
exit();
?>
