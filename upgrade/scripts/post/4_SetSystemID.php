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
 * Update entry in systems table
 */
class SugarUpgradeSetSystemID extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!($this->from_flavor == 'ce' && $this->toFlavor('pro'))) return;
        $system = new System();
        $system->system_key = $this->config['unique_key'];
        $system->user_id = '1';
        $system->last_connect_date = TimeDate::getInstance()->nowDb();
        $system_id = $system->retrieveNextKey(false, true);
        $this->db->query( "INSERT INTO config (category, name, value) VALUES ( 'system', 'system_id', '" . $system_id . "')" );
    }
}
