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

require_once 'modules/ModuleBuilder/Module/StudioModule.php' ;

class EmployeesStudioModule extends StudioModule {
    function getProvidedSubpanels ()
    {
        // Much like pointy haired bosses, other modules should not be able to relate to Employees.
        return false;
    }

    function getModule ()
    {
        $normalModules = parent::getModule();
        
        if(isset($normalModules[translate('LBL_RELATIONSHIPS')])) {
            unset($normalModules[translate('LBL_RELATIONSHIPS')]);
        }

        return $normalModules;
    }

}