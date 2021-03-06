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
 * Set up PDF manager templates
 */
class SugarUpgradePDFManager extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_DB;
    public $version = '6.6.0';

    public function run()
    {
        if(!$this->toFlavor('pro')) return;
        if(version_compare($this->from_version, "6.6.0", '<')) {
            // starting with 6.6.0, PDF manager templates are installed
            include 'install/seed_data/PdfManager_SeedData.php';
        }
    }
}
