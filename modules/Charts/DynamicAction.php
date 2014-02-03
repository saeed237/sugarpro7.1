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


if(isset($_GET['DynamicAction']) && $_GET['DynamicAction'] == "saveImage") {
	$filename = pathinfo($_POST['filename'], PATHINFO_BASENAME);
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array(strtolower($ext), array('jpg', 'png', 'jpeg'))) {
	    return false;
	}
	$image = str_replace(" ", "+", $_POST["imageStr"]);
	$data = substr($image, strpos($image, ","));
    if(sugar_mkdir(sugar_cached("images"), 0777, true))
    {
        $filepath = sugar_cached("images/$filename");
        file_put_contents($filepath, base64_decode($data));
        if(!verify_uploaded_image($filepath)) {
            unlink($filepath);
            return false;
        }
    }
    else
    {
        return false;
    }
}