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
 * Register upgrade with the system
 */
class SugarUpgradeRegisterUpgrade extends UpgradeScript
{
    public $order = 9900;
    public $type = self::UPGRADE_DB;

    public function run()
    {
	    // if error was encountered, script should have died before now
		$new_upgrade = new UpgradeHistory();
		$new_upgrade->filename = $this->context['zip'];
		$new_upgrade->md5sum = md5_file($this->context['zip']);
		$new_upgrade->name = pathinfo($this->context['zip'], PATHINFO_FILENAME);
		$new_upgrade->description = $this->manifest['description'];
		$new_upgrade->type = 'patch';
		$new_upgrade->version = $this->to_version;
		$new_upgrade->status = "installed";
		$new_upgrade->manifest = json_encode($this->manifest);
		$new_upgrade->save();
    }
}
