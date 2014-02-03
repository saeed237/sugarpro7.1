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

if (!is_dir($cachedir = sugar_cached('images/')))
    mkdir_recursive($cachedir);

// cn: bug 11012 - fixed some MIME types not getting picked up.  Also changed array iterator.
$imgType = array('image/gif', 'image/png', 'image/x-png', 'image/bmp', 'image/jpeg', 'image/jpg', 'image/pjpeg');

$ret = array();

foreach($_FILES as $k => $file) {
	if(in_array(strtolower($_FILES[$k]['type']), $imgType) && $_FILES[$k]['size'] > 0) {
	    $upload_file = new UploadFile($k);
		// check the file
		if($upload_file->confirm_upload()) {
		    $dest = $cachedir.basename($upload_file->get_stored_file_name()); // target name
		    $guid = create_guid();
		    if($upload_file->final_move($guid)) { // move to uploads
		        $path = $upload_file->get_upload_path($guid);
		        // if file is OK, copy to cache
		        if(verify_uploaded_image($path) && copy($path, $dest)) {
		            $ret[] = $dest;
		        }
		        // remove temp file
		        unlink($path);
		    }
		}
	}
}

if (!empty($ret)) {
	$json = getJSONobj();
	echo $json->encode($ret);
	//return the parameters
}
