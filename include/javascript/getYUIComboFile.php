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

if (empty($_REQUEST)) die();

$yui_path = array(
    "2.9.0" => "include/javascript/yui",
	"2_9_0" => "include/javascript/yui",
	"3.3.0" => "include/javascript/yui3",
	"3_3_0" => "include/javascript/yui3"
);
$types = array(
    "js" => "application/javascript",
	"css" => "text/css",
);
$out = "";

$contentType = "";
$allpath = "";

foreach ($_REQUEST as $param => $val)
{
	//No backtracking in the path
	if (strpos($param, "..") !== false)
        continue;

	$version = explode("/", $param);
	$version = $version[0];
    if (empty($yui_path[$version])) continue;

    $path = $yui_path[$version] . substr($param, strlen($version));

	$extension = substr($path, strrpos($path, "_") + 1);

	//Only allowed file extensions
	if (empty($types[$extension]))
	   continue;

	if (empty($contentType))
    {
        $contentType = $types[$extension];
    }
	//Put together the final filepath
	$path = substr($path, 0, strrpos($path, "_")) . "." . $extension;
	$contents = '';
	if (is_file($path)) {
	   $out .= "/*" . $path . "*/\n";
	   $contents =  file_get_contents($path);
	   $out .= $contents . "\n";
	}
	$path = empty($contents) ? $path : $contents;
	$allpath .= md5($path);
}

$etag = '"'.md5($allpath).'"';

// try to use the content cached locally if it's the same as we have here.
header("Cache-Control: private");
header("Pragma: dummy=bogus");
header("Etag: $etag");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
header("Content-Type: $contentType");
echo ($out);