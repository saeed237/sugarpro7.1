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
 * move blowfish dir from cache to custom
 */
class SugarUpgradeMoveBlowfish extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if(file_exists($this->cacheDir("blowfish")) && !file_exists("custom/blowfish")) {
           $this->log('Renaming cache/blowfish');
           rename($this->cacheDir("blowfish"), "custom/blowfish");
           $this->log('Renamed cache/blowfish to custom/blowfish');
        }
    }
}
