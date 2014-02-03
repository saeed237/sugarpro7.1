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


require_once 'clients/base/api/CurrentUserApi.php';

class CurrentUserMobileApi extends CurrentUserApi {
    public function getModuleList() {
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
            $this->list2Array($wireless_module_registry) :
            array();
    }
}