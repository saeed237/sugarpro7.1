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
 * add language pack config information to config.php
 */
class SugarUpgradeImportLang extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if(!$this->toFlavor('pro')) return;
        if(!is_file('install/lang.config.php')){
       	    return;
       	}
		$this->log('install/lang.config.php exists, let\'s import the file/array into sugar_config/config.php');
		include('install/lang.config.php');

		foreach($config['languages'] as $k=>$v){
			$this->upgrader->config['languages'][$k] = $v;
		}
    }
}
