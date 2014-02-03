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

require_once 'install/install_utils.php';
global $mod_strings;
global $sugar_config;

$ignoreCase = (substr_count(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache/2') > 0)?'(?i)':'';
$htaccess_file   = getcwd() . "/.htaccess";
$contents = getHtaccessData($htaccess_file);

$status =  file_put_contents($htaccess_file, $contents);
if( !$status ){
    echo '<p>' . $mod_strings['LBL_HT_NO_WRITE'] . "<span class=stop>{$htaccess_file}</span></p>\n";
    echo '<p>' . $mod_strings['LBL_HT_NO_WRITE_2'] . "</p>\n";
    echo "{$contents}\n";
}


// cn: bug 9365 - security for filesystem
$uploadDir='';
$uploadHta='';

if (empty($GLOBALS['sugar_config']['upload_dir'])) {
    $GLOBALS['sugar_config']['upload_dir']='upload/';
}

$uploadHta = "upload://.htaccess";

$denyAll =<<<eoq
	Order Deny,Allow
	Deny from all
eoq;

if(file_exists($uploadHta) && filesize($uploadHta)) {
	// file exists, parse to make sure it is current
	if(is_writable($uploadHta)) {
		$oldHtaccess = file_get_contents($uploadHta);
		// use a different regex boundary b/c .htaccess uses the typicals
		if(strstr($oldHtaccess, $denyAll) === false) {
		    $oldHtaccess .= "\n";
			$oldHtaccess .= $denyAll;
		}
		if(!file_put_contents($uploadHta, $oldHtaccess)) {
		    $htaccess_failed = true;
		}
	} else {
		$htaccess_failed = true;
	}
} else {
	// no .htaccess yet, create a fill
	if(!file_put_contents($uploadHta, $denyAll)) {
		$htaccess_failed = true;
	}
}

include('modules/Versions/ExpectedVersions.php');

global $expect_versions;

if (isset($expect_versions['htaccess'])) {
        $version = BeanFactory::getBean('Versions');
        $version->retrieve_by_string_fields(array('name'=>'htaccess'));

        $version->name = $expect_versions['htaccess']['name'];
        $version->file_version = $expect_versions['htaccess']['file_version'];
        $version->db_version = $expect_versions['htaccess']['db_version'];
        $version->save();
}

/* Commenting out as this shows on upgrade screen
 * echo "\n" . $mod_strings['LBL_HT_DONE']. "<br />\n";
*/

?>