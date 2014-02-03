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

function unzip( $zip_archive, $zip_dir)
{
   return unzip_file($zip_archive, null, $zip_dir);
}

function unzip_file( $zip_archive, $archive_file, $zip_dir)
{
    if( !is_dir( $zip_dir ) ) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal("Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist.");
        	return false;
        } else {
            die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
        }
    }

    $zip = new ZipArchive;

    $res = $zip->open(UploadFile::realpath($zip_archive)); // we need realpath here for PHP streams support

    if($res !== TRUE) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
            return false;
        } else {
        	die(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
        }

    }

    if($archive_file !== null) {
        $res = $zip->extractTo(UploadFile::realpath($zip_dir), $archive_file);
    } else {
        $res = $zip->extractTo(UploadFile::realpath($zip_dir));
    }

    if($res !== TRUE) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
            return false;
        } else {
        	die(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
        }
    }
    return true;
}

function zip_dir( $zip_dir, $zip_archive )
{
    if( !is_dir( $zip_dir ) ){
        if (!defined('SUGAR_PHPUNIT_RUNNER'))
            die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
        return false;
    }
    $zip = new ZipArchive();
    // we need this for shadow path resolution to work
    $zip->open(UploadFile::realpath($zip_archive), ZIPARCHIVE::CREATE|ZIPARCHIVE::OVERWRITE); // we need realpath here for PHP streams support
    $path = UploadFile::realpath($zip_dir);
    $chop = strlen($path)+1;
    $dir = new RecursiveDirectoryIterator($path);
    $it = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::SELF_FIRST);
    foreach ($it as $k => $fileinfo) {
        // Bug # 45143
        // ensure that . and .. are not zipped up, otherwise, the
        // CENT OS and others will fail when deploying module
        $fileName = $fileinfo->getFilename();
        if ($fileName == "." || $fileName == "..")
            continue;
        $localname = str_replace("\\", "/",substr($fileinfo->getPathname(), $chop)); // ensure file
        if($fileinfo->isDir()) {
            $zip->addEmptyDir($localname."/");
        } else {
            $zip->addFile($fileinfo->getPathname(), $localname);
        }
    }
}

/**
 * Zip list of files, optionally stripping prefix
 * FIXME: check what happens with streams
 * @param string $zip_file
 * @param array $file_list
 * @param string $prefix Regular expression for the prefix to strip
 */
function zip_files_list($zip_file, $file_list, $prefix = '')
{
    $archive    = new ZipArchive();
    $res = $archive->open(UploadFile::realpath($zip_file), ZipArchive::CREATE|ZipArchive::OVERWRITE); // we need realpath here for PHP streams support
    if($res !== TRUE)
    {
        $GLOBALS['log']->fatal("Unable to open zip file, check directory permissions: $zip_file");
        return FALSE;
    }
    foreach($file_list as $file) {
        if(!empty($prefix) && preg_match($prefix, $file, $matches) > 0) {
            $zipname = substr($file, strlen($matches[0]));
        } else {
            $zipname = $file;
        }
        $archive->addFile($file, $zipname);
    }
    return TRUE;
}
