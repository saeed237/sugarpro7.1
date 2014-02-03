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




require_once('include/utils/db_utils.php');
require_once('include/utils/zip_utils.php');

// increase the cuttoff time to 1 hour
ini_set("max_execution_time", "3600");

if( isset( $_REQUEST['view'] ) && ($_REQUEST['view'] != "") ){
    $view = $_REQUEST['view'];
    if( $view != "default" && $view != "module" ){
        throw new Exception($mod_strings['ERR_UW_INVALID_VIEW']);
    }
}
else{
    throw new Exception($mod_strings['ERR_UW_NO_VIEW']);
}
$form_action = "index.php?module=Administration&view=" . $view . "&action=UpgradeWizard";


$base_upgrade_dir       = "upload://upgrades";
$base_tmp_upgrade_dir   = sugar_cached('upgrades/temp');

$GLOBALS['subdirs'] = array('full', 'langpack', 'module', 'patch', 'theme');
// array of special scripts that are executed during (un)installation-- key is type of script, value is filename

if(!defined('SUGARCRM_PRE_INSTALL_FILE'))
{
	define('SUGARCRM_PRE_INSTALL_FILE', 'scripts/pre_install.php');
	define('SUGARCRM_POST_INSTALL_FILE', 'scripts/post_install.php');
	define('SUGARCRM_PRE_UNINSTALL_FILE', 'scripts/pre_uninstall.php');
	define('SUGARCRM_POST_UNINSTALL_FILE', 'scripts/post_uninstall.php');
}
$script_files = array(
	"pre-install" => constant('SUGARCRM_PRE_INSTALL_FILE'),
	"post-install" => constant('SUGARCRM_POST_INSTALL_FILE'),
	"pre-uninstall" => constant('SUGARCRM_PRE_UNINSTALL_FILE'),
	"post-uninstall" => constant('SUGARCRM_POST_UNINSTALL_FILE'),
);



function extractFile( $zip_file, $file_in_zip ){
    global $base_tmp_upgrade_dir;
	if(empty($base_tmp_upgrade_dir)){
    	$base_tmp_upgrade_dir   = sugar_cached("upgrades/temp");
    }
    $my_zip_dir = mk_temp_dir( $base_tmp_upgrade_dir );
    register_shutdown_function('rmdir_recursive', $my_zip_dir);
    unzip_file( $zip_file, $file_in_zip, $my_zip_dir );
    return( "$my_zip_dir/$file_in_zip" );
}

function extractManifest( $zip_file ){
    return( extractFile( $zip_file, "manifest.php" ) );
}

function getInstallType( $type_string ){
    // detect file type
    global $subdirs;

    foreach( $subdirs as $subdir ){
        if( preg_match( "#/$subdir/#", $type_string ) ){
            return( $subdir );
        }
    }
    // return empty if no match
    return( "" );
}

function getImageForType( $type ){

    $icon = "";
    switch( $type ){
        case "full":
            $icon = SugarThemeRegistry::current()->getImage("Upgrade", "",null,null,'.gif',$mod_strings['LBL_DST_UPGRADE']);
            break;
        case "langpack":
            $icon = SugarThemeRegistry::current()->getImage("LanguagePacks", "",null,null,'.gif',$mod_strings['LBL_LANGUAGE_PACKS'] );
            break;
        case "module":
            $icon = SugarThemeRegistry::current()->getImage("ModuleLoader", "",null,null,'.gif',$mod_strings['LBL_MODULE_LOADER_TITLE']);
            break;
        case "patch":
            $icon = SugarThemeRegistry::current()->getImage("PatchUpgrades", "",null,null,'.gif',$mod_strings['LBL_PATCH_UPGRADES'] );
            break;
        case "theme":
            $icon = SugarThemeRegistry::current()->getImage("Themes", "",null,null,'.gif',$mod_strings['LBL_THEME_SETTINGS'] );
            break;
        default:
            break;
    }
    return( $icon );
}

function getLanguagePackName( $the_file ){
    global $app_list_strings;
    require_once( "$the_file" );
    if( isset( $app_list_strings["language_pack_name"] ) ){
        return( $app_list_strings["language_pack_name"] );
    }
    return( "" );
}

function getUITextForType( $type ){
	$type = 'LBL_UW_TYPE_'.strtoupper($type);
	global $mod_strings;
	return $mod_strings[$type];
}

function getUITextForMode( $mode ){
    $mode = 'LBL_UW_MODE_'.strtoupper($mode);
    global $mod_strings;
    return $mod_strings[$mode];
}

function validate_manifest( $manifest ){
    // takes a manifest.php manifest array and validates contents
    global $subdirs;
    global $sugar_version;
    global $sugar_flavor;
	global $mod_strings;

    if( !isset($manifest['type']) ){
        throw new Exception($mod_strings['ERROR_MANIFEST_TYPE']);
    }
    $type = $manifest['type'];
    if( getInstallType( "/$type/" ) == "" ){
        throw new Exception($mod_strings['ERROR_PACKAGE_TYPE']. ": '" . $type . "'." );
    }

    $acceptable_sugar_versions = getAcceptableSugarVersions($manifest);
    if (!$acceptable_sugar_versions) {
        throw new Exception($mod_strings['ERROR_VERSION_MISSING']);
    }

    $version_ok = false;
    $matches_empty = true;

    // For cases in which the manifest was written incorrectly we need to create
    // a comparator. For now we will assume that major and minor version
    // matches are acceptable. -rgonzalez
    if (!isset($acceptable_sugar_versions['exact_matches']) && !isset($acceptable_sugar_versions['regex_matches'])) {
        $acceptable_sugar_versions = addAcceptableVersionRegex($acceptable_sugar_versions);
        if(empty($acceptable_sugar_versions['regex_matches']) && !empty($manifest['built_in_version'])) {
            $built_version = explode('.', $manifest['built_in_version']);
            $acceptable_sugar_versions['regex_matches'] = array("{$built_version[0]}\.([0-9]+)\.([0-9]+)");
        }
    }

    if( isset($acceptable_sugar_versions['exact_matches']) ){
        $matches_empty = false;
        foreach( $acceptable_sugar_versions['exact_matches'] as $match ){
            if( $match == $sugar_version ){
                $version_ok = true;
            }
        }
    }
    if( !$version_ok && isset($acceptable_sugar_versions['regex_matches']) ){
        $matches_empty = false;
        foreach( $acceptable_sugar_versions['regex_matches'] as $match ){
            if( preg_match( "/$match/", $sugar_version ) ){
                $version_ok = true;
            }
        }
    }

    if( !$matches_empty && !$version_ok ){
        throw new Exception( $mod_strings['ERROR_VERSION_INCOMPATIBLE'] . $sugar_version );
    }

    $acceptable_sugar_flavors = getAcceptableSugarFlavors($manifest);
    if( $acceptable_sugar_flavors && sizeof($acceptable_sugar_flavors) > 0 ){
        $flavor_ok = false;
        foreach( $acceptable_sugar_flavors as $match ){
            if( $match == $sugar_flavor ){
                $flavor_ok = true;
            }
        }
        if( !$flavor_ok ){
            throw new Exception( $mod_strings['ERROR_FLAVOR_INCOMPATIBLE'] . $sugar_flavor );
        }
    }
}

function getDiffFiles($unzip_dir, $install_file, $is_install = true, $previous_version = ''){
	//require_once($unzip_dir . '/manifest.php');
	global $installdefs;
	if(!empty($previous_version)){
		//check if the upgrade path exists
		if(!empty($upgrade_manifest)){
			if(!empty($upgrade_manifest['upgrade_paths'])){
				if(!empty($upgrade_manifest['upgrade_paths'][$previous_version])){
					$installdefs = 	$upgrade_manifest['upgrade_paths'][$previous_version];
				}
			}//fi
		}//fi
	}//fi
	$modified_files = array();
	if(!empty($installdefs['copy'])){
		foreach($installdefs['copy'] as $cp){
			$cp['to'] = clean_path(str_replace('<basepath>', $unzip_dir, $cp['to']));
			$restore_path = remove_file_extension(urldecode($install_file))."-restore/";
			$backup_path = clean_path($restore_path.$cp['to'] );
			//check if this file exists in the -restore directory
			if(file_exists($backup_path)){
				//since the file exists, then we want do an md5 of the install version and the file system version
				$from = $backup_path;
				$needle = $restore_path;
				if(!$is_install){
					$from = str_replace('<basepath>', $unzip_dir, $cp['from']);
					$needle = $unzip_dir;
				}
				$files_found = md5DirCompare($from.'/', $cp['to'].'/', array('.svn'), false);
				if(count($files_found > 0)){
					foreach($files_found as $key=>$value){
						$modified_files[] = str_replace($needle, '', $key);
					}
				}
			}//fi
		}//rof
	}//fi
	return $modified_files;
}

/**
 * Accessor function that gets acceptable sugar versions from a manifest. Addresses
 * an issue since 6.7 in which manifests were written incorrectly.
 *
 * @param array $manifest Array of details for a package
 * @return Array
 */
function getAcceptableSugarVersions($manifest)
{
    return getAcceptableSugarValues($manifest, 'acceptable_sugar_versions');
}

/**
 * Accessor function that gets acceptable sugar flavors from a manifest. Addresses
 * an issue since 6.7 in which manifests were written incorrectly.
 *
 * @param array $manifest Array of details for a package
 * @return Array
 */
function getAcceptableSugarFlavors($manifest)
{
    return getAcceptableSugarValues($manifest, 'acceptable_sugar_flavors');
}

/**
 * Accessor function that gets acceptable sugar properties from a manifest. Addresses
 * an issue since 6.7 in which manifests were written incorrectly.
 *
 * @param array $manifest Array of details for a package
 * @return Array
 */
function getAcceptableSugarValues($manifest, $property)
{
    if (isset($manifest[$property])) {
        return $manifest[$property];
    }

    foreach ($manifest as $key => $val) {
        if (is_array($val) && isset($val[$property])) {
            return $val[$property];
        }
    }

    return array();
}

/**
 * Adds version regex strings to the acceptable sugar versions array when needed
 *
 * @param array $versions The versions array that was passed in
 */
function addAcceptableVersionRegex($versions)
{
    $regex = array();
    foreach ($versions as $index => $version) {
        // Empty versions are not allowed for Sugar7
        if (empty($version)) {
            unset($versions[$index]);
            continue;
        }

        $version_parts = explode('.', $version);
        if (isset($version_parts[1])) {
            // Major and minor matching
            $regex[$index] = "{$version_parts[0]}\.{$version_parts[1]}\.([0-9]+)";
        } elseif (isset($version_parts[0])) {
            // Major only
            $regex[$index] = "{$version_parts[0]}\.([0-9]+)\.([0-9]+)";
        } else {
            // Full match
            $regex[$index] = $version;
        }
    }

    $versions['regex_matches'] = $regex;

    return $versions;
}
