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
require_once 'clients/mobile/api/CurrentUserMobileApi.php';

class MetaDataManagerMobile extends MetaDataManager
{
    protected function getModules() {
        // Get the current user module list
        $modules = $this->getUserModuleList();
        
        // add in Users [Bug59548] since it is forcefully removed for the 
        // CurrentUserApi
        if(!array_search('Users', $modules)) {
            $modules[] = 'Users';
        }
        
        return $modules;
    }

    /**
     * Gets the list of mobile modules. Used by getModules and the CurrentUserApi
     * to get the module list for a user.
     * 
     * @return array
     */
    public function getUserModuleList() {
        // replicate the essential part of the behavior of the private loadMapping() method in SugarController
        foreach(SugarAutoLoader::existingCustom('include/MVC/Controller/wireless_module_registry.php') as $file){
            require $file;
        }

        // Forcibly remove the Users module
        // So if they have added it, remove it here
        if ( isset($wireless_module_registry['Users']) ) {
            unset($wireless_module_registry['Users']);
        }

        // $wireless_module_registry is defined in the file loaded above
        return isset($wireless_module_registry) && is_array($wireless_module_registry) ?
            array_keys($wireless_module_registry) :
            array();
    }
}
