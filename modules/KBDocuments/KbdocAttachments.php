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

$json = getJSONobj();
$not_a_file = 0;

$divAndEl = explode(",", $_REQUEST['div_name_and_El']);
$div_name = $divAndEl[0];
$element_name = $divAndEl[1];

$ret = array();

if(!isset($_FILES[$element_name])|| ($_FILES[$element_name]['error']==4) || !file_exists($_FILES[$element_name]['tmp_name'])
|| ($_FILES[$element_name]['size']==0)){
      $not_a_file = 1;
}

$currGuid = create_guid();
$is_file_image = 0;

if($not_a_file == 0){
    $upload = new UploadFile($element_name);
    if(!$upload->confirm_upload()) {
        $not_a_file = 1;
    } else {
        $currGuid .= preg_replace('/[^-a-z0-9_]/i', '_', $_FILES[$element_name]['name']);
        $file_name = "upload://$currGuid";
        if(!$upload->final_move($file_name)) {
            $not_a_file = 1;
        } else {
            $is_file_image = verify_uploaded_image($file_name);
        }
    }
}

if($not_a_file == 1){
	$response=array('status'=>'failed','div_name'=>$div_name);
}
else{
	$response=array('status'=>'success','div_name'=>$div_name,'new_file_name'=>$currGuid,'is_file_image'=>$is_file_image);
}
if (!empty($response)) {
	$json = getJSONobj();
	print $json->encode($response);
}
sugar_cleanup();
exit();
?>
