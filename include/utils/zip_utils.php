<?php
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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if(class_exists("ZipArchive")) {
    require_once 'include/utils/php_zip_utils.php';
    return;
} else {
require_once('vendor/pclzip/pclzip.lib.php');
if ( isset($GLOBALS['log']) && class_implements($GLOBALS['log'],'LoggerTemplate') ) {
    $GLOBALS['log']->deprecated('Use of PCLZip has been deprecated. Please enable the zip extension in your PHP install ( see http://www.php.net/manual/en/zip.installation.php for more details ).');
}
function unzip( $zip_archive, $zip_dir, $forceOverwrite = false ){
    if( !is_dir( $zip_dir ) ){
        if (!defined('SUGAR_PHPUNIT_RUNNER'))
            die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
        return false;
    }

    $archive = new PclZip( $zip_archive );

    if ( $forceOverwrite ) {
        if( $archive->extract( PCLZIP_OPT_PATH, $zip_dir, PCLZIP_OPT_REPLACE_NEWER ) == 0 ){
            if (!defined('SUGAR_PHPUNIT_RUNNER'))
                die( "Error: " . $archive->errorInfo(true) );
            return false;
        }
    }
    else {
        if( $archive->extract( PCLZIP_OPT_PATH, $zip_dir ) == 0 ){
            if (!defined('SUGAR_PHPUNIT_RUNNER'))
                die( "Error: " . $archive->errorInfo(true) );
            return false;
        }
    }
}

function unzip_file( $zip_archive, $archive_file, $to_dir, $forceOverwrite = false ){
    if( !is_dir( $to_dir ) ){
        if (!defined('SUGAR_PHPUNIT_RUNNER'))
            die( "Specified directory '$to_dir' for zip file '$zip_archive' extraction does not exist." );
        return false;
    }

    $archive = new PclZip($zip_archive);
    if ( $forceOverwrite ) {
        if( $archive->extract(  PCLZIP_OPT_BY_NAME, $archive_file,
                                PCLZIP_OPT_PATH,    $to_dir,
                                PCLZIP_OPT_REPLACE_NEWER ) == 0 ){
            if (!defined('SUGAR_PHPUNIT_RUNNER'))
                die( "Error: " . $archive->errorInfo(true) );
            return false;
        }
    }
    else {
        if( $archive->extract(  PCLZIP_OPT_BY_NAME, $archive_file,
                                PCLZIP_OPT_PATH,    $to_dir        ) == 0 ){
            if (!defined('SUGAR_PHPUNIT_RUNNER'))
                die( "Error: " . $archive->errorInfo(true) );
            return false;
        }
    }
}

function zip_dir( $zip_dir, $zip_archive ){
    $archive    = new PclZip( $zip_archive );
    $v_list     = $archive->create( $zip_dir );
    if( $v_list == 0 ){
        if (!defined('SUGAR_PHPUNIT_RUNNER'))
            die( "Error: " . $archive->errorInfo(true) );
        return false;
    }
}

/**
 * Zip list of files, optionally stripping prefix
 * @param string $zip_file
 * @param array $file_list
 * @param string $prefix Regular expression for the prefix to strip
 */
function zip_files_list($zip_file, $file_list, $prefix = '')
{
    $archive    = new PclZip( $zip_file );
    foreach($file_list as $file) {
        if(!empty($prefix) && preg_match($prefix, $file, $matches) > 0) {
            $remove_path = $matches[0];
            $archive->add($file, PCLZIP_OPT_REMOVE_PATH, $prefix);
        } else {
            $archive->add($file);
        }
    }
    return true;
}

} // if (ZipArchive exists)