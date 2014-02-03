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
 * Schedule jssource directories for removal
 */
class SugarUpgradeRemoveJssource extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_CORE;

    public function run()
    {
        $jssource_dirs = array('jssource/src_files/include/javascript/ext-2.0',
    					   'jssource/src_files/include/javascript/ext-1.1.1',
    					   'jssource/src_files/include/javascript/yui'
                          );
        foreach($jssource_dirs as $js_dir)
        {
	        if(file_exists($js_dir))
	        {
	           $this->log("Removing directory: $js_dir");
	           $this->removeDir($js_dir);
	           $this->log("Finished removing $js_dir");
	        }
        }
    }
}
