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


// Bug 57062 ///////////////////////////////
if((!empty($_REQUEST['spriteNamespace']) && substr_count($_REQUEST['spriteNamespace'], '..') > 0) || 
	(!empty($_REQUEST['imageName']) && substr_count($_REQUEST['imageName'], '..') > 0)) {
    die();
}
// End Bug 57062 ///////////////////////////////


// try to use the user's theme if we can figure it out
if ( isset($_REQUEST['themeName']) && SugarThemeRegistry::current()->name != $_REQUEST['themeName']) {
    SugarThemeRegistry::set($_REQUEST['themeName']);
} elseif ( isset($_SESSION['authenticated_user_theme']) ) {
    SugarThemeRegistry::set($_SESSION['authenticated_user_theme']);
}

while(substr_count($_REQUEST['imageName'], '..') > 0){
	$_REQUEST['imageName'] = str_replace('..', '.', $_REQUEST['imageName']);
}

if(isset($_REQUEST['spriteNamespace'])) {
	$filename = "cache/sprites/{$_REQUEST['spriteNamespace']}/{$_REQUEST['imageName']}";
	if(! file_exists($filename)) {
		header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
		die;
	}
} else {
	$filename = SugarThemeRegistry::current()->getImageURL($_REQUEST['imageName']);
	if ( empty($filename) ) {
		header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
		die;
	}
}

$filename_arr = explode('?', $filename);
$filename = $filename_arr[0];
$file_ext = substr($filename,-3);

$extensions = SugarThemeRegistry::current()->imageExtensions;
if(!in_array($file_ext, $extensions)){
	header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
    die;
}


// try to use the content cached locally if it's the same as we have here.
if(defined('TEMPLATE_URL'))
	$last_modified_time = time();
else
	$last_modified_time = filemtime($filename);

$etag = '"'.md5_file($filename).'"';

header("Cache-Control: private");
header("Pragma: dummy=bogus");
header("Etag: $etag");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));

$ifmod = isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])
    ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time : null;
$iftag = isset($_SERVER['HTTP_IF_NONE_MATCH'])
    ? $_SERVER['HTTP_IF_NONE_MATCH'] == $etag : null;
if (($ifmod || $iftag) && ($ifmod !== false && $iftag !== false)) {
    header($_SERVER["SERVER_PROTOCOL"].' 304 Not Modified');
    die;
}

header("Last-Modified: ".gmdate('D, d M Y H:i:s \G\M\T', $last_modified_time));

// now send the content
if ( substr($filename,-3) == 'gif' )
    header("Content-Type: image/gif");
elseif ( substr($filename,-3) == 'png' )
    header("Content-Type: image/png");

if(!defined('TEMPLATE_URL')) {
    if(!file_exists($filename)) {
        sugar_touch($filename);
    }
}

readfile($filename);
