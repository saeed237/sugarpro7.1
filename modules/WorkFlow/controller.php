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


require_once('include/MVC/Controller/SugarController.php');

class WorkflowController extends SugarController
{
    public function preProcess()
    {
        global $current_user;
        
        $workflow_modules = get_workflow_admin_modules_for_user($current_user);
        if (!is_admin($current_user) && empty($workflow_modules))
            sugar_die("Unauthorized access to WorkFlow.");
    }
}
