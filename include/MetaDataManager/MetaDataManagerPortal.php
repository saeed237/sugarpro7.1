<?php
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

require_once 'include/MetaDataManager/MetaDataManager.php';
require_once 'modules/MySettings/TabController.php';
require_once 'modules/ModuleBuilder/Module/SugarPortalBrowser.php';

class MetaDataManagerPortal extends MetaDataManager
{
    /**
     * Gets configs
     * 
     * @return array
     */
    protected function getConfigs() {
        $configs = array();
        $admin = new Administration();
        $admin->retrieveSettings();
        foreach($admin->settings AS $setting_name => $setting_value) {
            if(stristr($setting_name, 'portal_')) {
                $key = str_replace('portal_', '', $setting_name);
                $configs[$key] = json_decode(html_entity_decode($setting_value),true);
            }
        }
        
        return $configs;
    }


    /**
     * Fills in additional app list strings data as needed by the client
     * 
     * @param array $public Public app list strings
     * @param array $main Core app list strings
     * @return array
     */
    protected function fillInAppListStrings(Array $public, Array $main) {
        $public['countries_dom'] = $main['countries_dom'];
        $public['state_dom'] = $main['state_dom'];
        
        return $public;
    }
    
    public function getUserModuleList() {
        // Use SugarPortalBrowser to get the portal modules that would appear
        // in Studio
        $pb = new SugarPortalBrowser();
        $pb->loadModules();
        
        // Now that the portal modules are loaded, cross check them with the 
        // visible tabs array for the current user
        $controller = new TabController();
        $ret = array_intersect_key($controller->get_user_tabs($this->getCurrentUser()), $pb->modules);
        return array_keys($ret);
    }
}
