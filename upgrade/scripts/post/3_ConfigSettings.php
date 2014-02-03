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
 * Update config.php settings
 */
class SugarUpgradeConfigSettings extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        $this->upgrader->config['sugar_version'] = $this->to_version;

	    if(!isset($this->upgrader->config['default_permissions'])) {
		    $this->upgrader->config['default_permissions'] = array (
				'dir_mode' => 02770,
				'file_mode' => 0660,
				'user' => '',
				'group' => '',
    		);
	    }

	    if(!isset($this->upgrader->config['logger'])){
		    $this->upgrader->config['logger'] =array (
				'level'=>'fatal',
				'file' =>
				array (
						'ext' => '.log',
						'name' => 'sugarcrm',
						'dateFormat' => '%c',
						'maxSize' => '10MB',
						'maxLogs' => 10,
						'suffix' => '', // bug51583, change default suffix to blank for backwards comptability
				),
		    );
	    }

	    if (!isset($this->upgrader->config['lead_conv_activity_opt'])) {
	        $this->upgrader->config['lead_conv_activity_opt'] = 'copy';
	    }

	    if(!isset($this->upgrader->config['resource_management'])){
	        $this->upgrader->config['resource_management'] = array (
	                'special_query_limit' => 50000,
	                'special_query_modules' =>
	                array (
	                        0 => 'Reports',
	                        1 => 'Export',
	                        2 => 'Import',
	                        3 => 'Administration',
	                        4 => 'Sync',
	                ),
	                'default_limit' => 1000,
	        );
	    }
	    if(!isset($this->upgrader->config['default_theme'])) {
	        $this->upgrader->config['default_theme'] = 'Sugar';
	    }

	    if(!isset($this->upgrader->config['default_max_tabs'])) {
	        $this->upgrader->config['default_max_tabs'] = '7';
	    }
    }
}
