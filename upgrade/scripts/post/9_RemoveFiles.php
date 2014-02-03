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
 * Remove files that were scheduled to be deleted
 * Files are backed up to custom/backup
 */
class SugarUpgradeRemoveFiles extends UpgradeScript
{
    public $order = 9000;

    // ALL since some DB-only modules may request file deletions
    public $type = self::UPGRADE_ALL;

    public function run()
    {
        if(empty($this->state['files_to_delete'])) {
            return;
        }

	    foreach($this->state['files_to_delete'] as $file) {
	        $this->backupFile($file);
	        $this->log("Removing $file");
	        if(is_dir($file)) {
	            $this->removeDir($file);
	        } else {
	            if(file_exists($file)) {
	                @unlink($file);
	            }
	        }
	    }
    }
}
