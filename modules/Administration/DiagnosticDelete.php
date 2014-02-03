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


if (!is_admin($GLOBALS['current_user'])) {
    sugar_die("Unauthorized access to administration.");
}
if (isset($GLOBALS['sugar_config']['hide_admin_diagnostics']) && $GLOBALS['sugar_config']['hide_admin_diagnostics'])
{
    sugar_die("Unauthorized access to diagnostic tool.");
}

echo getClassicModuleTitle(
        "Administration",
        array(
            "<a href='index.php?module=Administration&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>",
           translate('LBL_DIAGNOSTIC_TITLE')
           ),
        true
        );


if(empty($_REQUEST['file']) || empty($_REQUEST['guid']))
{
	echo $mod_strings['LBL_DIAGNOSTIC_DELETE_ERROR'];
}
else
{
    // Make sure the guid and file are valid file names for security purposes
    clean_string($_REQUEST['guid'], "ALPHANUM");
    clean_string($_REQUEST['file'], "FILE");

	//Making sure someone doesn't pass a variable name as a false reference
	//  to delete a file
	if(strcmp(substr($_REQUEST['file'], 0, 10), "diagnostic") != 0)
	{
		die($mod_strings['LBL_DIAGNOSTIC_DELETE_DIE']);
	}

	if(file_exists($cachedfile = sugar_cached("diagnostic/".$_REQUEST['guid']."/".$_REQUEST['file'].".zip")))
	{
  	  unlink($cachedfile);
  	  rmdir(dirname($cachedfile));
	  echo $mod_strings['LBL_DIAGNOSTIC_DELETED']."<br><br>";
	}
	else
	  echo $mod_strings['LBL_DIAGNOSTIC_FILE'] . $_REQUEST['file'].$mod_strings['LBL_DIAGNOSTIC_ZIP'];
}

print "<a href=\"index.php?module=Administration&action=index\">" . $mod_strings['LBL_DIAGNOSTIC_DELETE_RETURN'] . "</a><br>";

?>
