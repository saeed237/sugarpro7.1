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

/**
 * Class SugarUpgradeSearchVendors
 * This class will check the custom directory
 * for any reference of files that have moved to the vendor
 * directory.  If a reference is found it will add it to an array
 * and fail the upgrade with a message regarding the files that need fixed
 */
class SugarUpgradeSearchVendors extends UpgradeScript
{
    public $order = 50;

    public $directories = array(
        'include\/HTMLPurifier',
        'include\/HTTP_WebDAV_Server',
        'include\/Pear',
        'include\/Smarty',
        'XTemplate',
        'Zend',
        'include\/lessphp',
        'log4php',
        'include\/nusoap',
        'include\/oauth2-php',
        'include\/pclzip',
        'include\/reCaptcha',
        'include\/tcpdf',
        'include\/ytree',
        'include\/SugarSearchEngine\/Elastic\/Elastica',

    );

    protected static $excludedScanDirectories = array(
        'backup',
        'tmp',
        'temp',
    );
    public $filesToFix = array();

    /**
     * This method checks for directories that have been moved that are referenced
     * in custom code
     */
    public function checkForVendors()
    {
        $files = self::scanDir("custom/");
        $this->checkFiles($files);
    }

    public function checkFiles($files)
    {
        foreach ($files as $name => $file) {
            if (is_array($file)) {
                $this->checkFiles($file);
                continue;
            }
            // check for any occurrence of the directories and flag them
            $fileContents = file_get_contents($file);
            foreach ($this->directories AS $directory) {
                if (preg_match("/(include|require|require_once|include_once)[\s('\"]*({$directory})/",$fileContents) > 0) {
                    $this->filesToFix[] = $file;
                }
            }
        }
    }

    public function run()
    {
        $this->checkForVendors();
        if (!empty($this->filesToFix)) {
            // if there are fails to fix, fail the upgrade with a message about the files that need fixed
            $files_to_fix = implode("\r\n", $this->filesToFix);
            $this->log(
                "Files found that contain paths to directories that have been moved to vendor:\r\n{$files_to_fix}"
            );
            $this->fail();
        }
    }

    /**
     * Scan directory and build the list of files it contains
     * @param string $path
     * @return array Files data
     */
    public static function scanDir($path)
    {
        $data = array();
        $iter = new DirectoryIterator("./" . $path);
        foreach ($iter as $item) {
            if ($item->isDot()) {
                continue;
            }

            $filename = $item->getFilename();
            $fileParts = pathinfo($path . '/' . $filename);

            $extension = !empty($fileParts['extension']) ? $fileParts['extension'] : '';
            if ($item->isDir() && in_array($filename, self::$excludedScanDirectories)) {
                continue;
            } elseif ($item->isDir()) {
                $data[$filename] = self::scanDir($path . $filename . "/");
            } elseif ($extension != 'php') {
                continue;
            } else {
                $data[$filename] = $path . $filename;
            }
        }
        return $data;
    }
}
