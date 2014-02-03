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
 * Merge viewdefs files between old and new code
 */
class SugarUpgradeMergeTemplates extends UpgradeScript
{
    public $order = 200;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if(empty($this->context['new_source_dir'])) {
            $this->log("**** Merge skipped - no new source dir");
            return;
        }
        $this->log("**** Merge started ");
        require_once('modules/UpgradeWizard/SugarMerge/SugarMerge.php');
        $merger = new SugarMerge($this->context['new_source_dir']);
        $merger->mergeAll();
        $this->log("**** Merge finished ");
    }
}