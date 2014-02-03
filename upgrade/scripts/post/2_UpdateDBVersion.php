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
 * Update sugar_version in the config table
 */
class SugarUpgradeUpdateDBVersion extends UpgradeScript
{
    public $order = 2000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
	    $this->log('Deleting old DB version info from config table');
	    $this->db->query("DELETE FROM config WHERE category = 'info' AND name = 'sugar_version'");

        $this->log('Inserting updated version info into config table');
    	$this->db->query("INSERT INTO config (category, name, value) VALUES ('info', 'sugar_version', '{$this->to_version}')");
    }
}
