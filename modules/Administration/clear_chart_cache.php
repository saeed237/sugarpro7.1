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




global $sugar_config, $mod_strings;

print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_FINDING'] . "<br>" );

$search_dir=sugar_cached("");
$all_src_files  = findAllFiles($search_dir.'/xml', array() );

print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_DELETING1'] . "<br>" );
foreach( $all_src_files as $src_file ){
	if (preg_match('/\.xml$/',$src_file))
	{
   		print( $mod_strings['LBL_CLEAR_CHART_DATA_CACHE_DELETING2'] . " $src_file<BR>" ) ;
		unlink( "$src_file" );
	}
}

include('modules/Versions/ExpectedVersions.php');


global $expect_versions;

if (isset($expect_versions['Chart Data Cache'])) {
	$version = BeanFactory::getBean('Versions');
	$version->retrieve_by_string_fields(array('name'=>'Chart Data Cache'));

	$version->name = $expect_versions['Chart Data Cache']['name'];
	$version->file_version = $expect_versions['Chart Data Cache']['file_version'];
	$version->db_version = $expect_versions['Chart Data Cache']['db_version'];
	$version->save();
}

echo "\n--- " . $mod_strings['LBL_DONE'] . "---<br />\n";
?>
