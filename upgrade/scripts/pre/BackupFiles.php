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
 * Backup all files that are going to be overwritten to
 *  upload/upgrades/backup/UPGRADE_NAME-restore
 */
class SugarUpgradeBackupFiles extends UpgradeScript
{
    public $order = 100;
    public $type = self::UPGRADE_CORE;

    public function run()
    {
        if(empty($this->manifest['copy_files']['from_dir'])) {
            return;
        }
        if(isset($this->context['backup']) && !$this->context['backup']) {
            // backup disabled by option
            $this->log("**** Backup disabled by config");
            return;
        }
        $zip_from_dir = $this->context['temp_dir']."/".$this->manifest['copy_files']['from_dir'];

        $files = $this->findFiles($zip_from_dir);
        $this->log("**** Backup started");
        foreach($files as $file) {
            if(!$this->backupFile($file)) {
                $this->log("FAILED to back up $file");
            }
        }

        $this->log("**** Backup complete");
    }
}
