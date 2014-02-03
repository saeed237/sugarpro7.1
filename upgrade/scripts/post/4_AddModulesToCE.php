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
 * Add modules to tabs for CE->PRO
 * TODO: irrelevant for 7?
 */
class SugarUpgradeAddModulesToCE extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!($this->from_flavor == 'ce' && $this->toFlavor('pro'))) return;

        //check to see if there are any new files that need to be added to systems tab
        //retrieve old modules list
        $this->log('check to see if new modules exist');
        if(empty($this->state['old_modules'])) {
            $this->log('No old modules info, skipping it');
            return;
        } else {
            $oldModuleList = $this->state['old_modules'];
        }

        $newModuleList = array();
        include('include/modules.php');
        $newModuleList = $moduleList;

        //include tab controller
        require_once('modules/MySettings/TabController.php');
        $newTB = new TabController();

        //make sure new modules list has a key we can reference directly
        $newModuleList = $newTB->get_key_array($newModuleList);
        $oldModuleList = $newTB->get_key_array($oldModuleList);

        //iterate through list and remove commonalities to get new modules
        foreach ($newModuleList as $remove_mod){
            if(in_array($remove_mod, $oldModuleList)){
                unset($newModuleList[$remove_mod]);
            }
        }

        $must_have_modules= array(
                'Activities'=>'Activities',
                'Calendar'=>'Calendar',
                'Reports' => 'Reports',
                'Quotes' => 'Quotes',
                'Products' => 'Products',
                'Forecasts' => 'Forecasts',
                'Contracts' => 'Contracts',
                'KBDocuments' => 'KBDocuments'
        );
        $newModuleList = array_merge($newModuleList,$must_have_modules);

        //new modules list now has left over modules which are new to this install, so lets add them to the system tabs
        $this->log('new modules to add are '.var_export($newModuleList,true));

        //grab the existing system tabs
        $tabs = $newTB->get_system_tabs();

        //add the new tabs to the array
        foreach($newModuleList as $nm ){
            $tabs[$nm] = $nm;
        }

        //now assign the modules to system tabs
        $newTB->set_system_tabs($tabs);
        $this->log('module tabs updated');

    }
}
