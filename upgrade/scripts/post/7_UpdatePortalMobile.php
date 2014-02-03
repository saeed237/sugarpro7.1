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

if(!file_exists('modules/UpgradeWizard/SidecarUpdate/SidecarMetaDataUpgrader.php')) return;

require_once 'modules/UpgradeWizard/SidecarUpdate/SidecarMetaDataUpgrader.php';
/**
 * Upgrade sidecar portal metadata
 */
class SugarUpgradeUpdatePortalMobile extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if(version_compare($this->from_version, '7.0', '>=')) {
            // right now there's no need to run this on 7
            return;
        }

        if(!file_exists('modules/UpgradeWizard/SidecarUpdate/SidecarMetaDataUpgrader.php')) return;
        // TODO: fix uw_utils references in SidecarMetaDataUpgrader
        $smdUpgrader = new SidecarMetaDataUpgrader2($this);
        $smdUpgrader->upgrade();

        // Log failures if any
        $failures = $smdUpgrader->getFailures();
        if (!empty($failures)) {
            $this->log('Sidecar Upgrade: ' . count($failures) . ' metadata files failed to upgrade through the silent upgrader:');
            $this->log(print_r($failures, true));
        } else {
            $this->log('Sidecar Upgrade: Mobile/portal metadata upgrade ran with no failures:');
            $this->log($smdUpgrader->getCountOfFilesForUpgrade() . ' files were upgraded.');
        }
        $this->fileToDelete(SidecarMetaDataUpgrader::getFilesForRemoval());
    }
}

/**
 * Decorator class to override logging behavior of SidecarMetaDataUpgrader
 */
class SidecarMetaDataUpgrader2 extends SidecarMetaDataUpgrader
{
    public function __construct($upgrade)
    {
        $this->upgrade = $upgrade;
    }

    public function logUpgradeStatus($msg)
    {
        $this->upgrade->log($msg);
    }

    public function getMBModules()
    {
        if(!empty($this->upgrade->state['MBModules'])) {
            return $this->upgrade->state['MBModules'];
        }
        return array();
    }
}
