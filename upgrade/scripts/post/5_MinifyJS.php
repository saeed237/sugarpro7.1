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
 * Rebuild minified JS files
 */
class SugarUpgradeMinifyJS extends UpgradeScript
{
    public $order = 5000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        $_REQUEST['root_directory'] = $this->context['source_dir'];
        $_REQUEST['js_rebuild_concat'] = 'rebuild';
        require_once('jssource/minify.php');
    }
}
