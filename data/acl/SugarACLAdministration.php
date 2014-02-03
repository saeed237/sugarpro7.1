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

require_once('data/SugarACLStrategy.php');

/**
 * This class is used to enforce ACLs on modules that are restricted to admins only.
 */
class SugarACLAdministration extends SugarACLStrategy
{

    /**
     * Only allow access to users with the user admin setting
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool|void
     */
    public function checkAccess($module, $view, $context)
    {
        $current_user = $this->getCurrentUser($context);
        if ( !$current_user ) {
            return false;
        }

        if($current_user->isAdmin()) {
            return true;
        }

        // if they are admin for ANY modules

        $adminForAny = $current_user->getAdminModules();

        if(!empty($adminForAny)) {
            return true;
        }

        return false;
    }

}
