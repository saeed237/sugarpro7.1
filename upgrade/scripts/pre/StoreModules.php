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
  * Store old modules list so we could use it to compare to new modules list
  * and update display tabs, etc.
  */
class SugarUpgradeStoreModules extends UpgradeScript
{
    public $order = 200;
    // DB because DB scripts may need the data
    public $type = self::UPGRADE_DB;

    public function run()
    {
        include 'include/modules.php';
        $this->upgrader->state['old_modules'] = $moduleList;
    }
}