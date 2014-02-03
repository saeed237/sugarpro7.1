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


global $current_user;


if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");
if (isset($GLOBALS['sugar_config']['hide_admin_diagnostics']) && $GLOBALS['sugar_config']['hide_admin_diagnostics'])
{
    sugar_die("Unauthorized access to diagnostic tool.");
}

if(!isset($_REQUEST['guid']) || !isset($_REQUEST['time']))
{
	die('Did not receive a filename to download');
}
$time = str_replace(array('.', '/', '\\'), '', $_REQUEST['time']);
$guid = str_replace(array('.', '/', '\\'), '', $_REQUEST['guid']);
$path = sugar_cached("diagnostic/{$guid}/diagnostic{$time}.zip");
$filesize = filesize($path);
ob_clean();
header('Content-Description: File Transfer');
header('Content-type: application/octet-stream');
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=$guid.zip");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $filesize");
readfile($path);



?>
