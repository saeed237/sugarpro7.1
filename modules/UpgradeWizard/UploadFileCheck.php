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
require_once('include/upload_file.php');

//require_once('modules/UpgradeWizard/uw_utils.php');

$json = getJSONobj();
$file_name = $json->decode(html_entity_decode($_REQUEST['file_name']));
 if(isset($file_name['jsonObject']) && $file_name['jsonObject'] != null){
	$file_name = $file_name['jsonObject'];
  }

$filesize = '';
if(file_exists($file_name)){
    $filesize =filesize($file_name);
}


$response = '';

//$GLOBALS['log']->fatal('file name '.$file_name);
//$GLOBALS['log']->fatal('file size loaded '.filesize($file_name));


//if($filesize > ini_get("upload_max_filesize"))
//$GLOBALS['log']->fatal($filesize);
//$GLOBALS['log']->fatal(substr(ini_get("upload_max_filesize"), 0, strlen( ini_get("upload_max_filesize")) - 1));
//get the file size defined in php.ini
//$uploadSizeIni = substr(ini_get("upload_max_filesize"), 0, strlen( ini_get("upload_max_filesize")) - 1);
//$GLOBALS['log']->fatal('Upload php setting Size '.return_bytes(ini_get("upload_max_filesize")));
if($filesize != null){
	if(($filesize > return_bytes(ini_get("upload_max_filesize"))) || ($filesize > return_bytes(ini_get("post_max_size")))){
		$response=$filesize;
		//$response= "<script>alert('File size is bigger than the max_upload-size setting in php.ini. Upgrade attempt will fail. Increase the upload_max_size in php.ini to greater than ')</script>";
	}
}

if (!empty($response)) {
    echo $response;
}
sugar_cleanup();
exit();
?>
