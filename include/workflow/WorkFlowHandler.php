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


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/workflow/workflow_utils.php');

/**
 * Workflow manager class
 * @api
 */
class WorkFlowHandler {

    function WorkFlowHandler(&$focus, $event){

    	//Confirm we are not running populating seed data
    	if(isset($_SESSION['disable_workflow'])) return;

        //Now just include the modules workflow from this bean
    	global $triggeredWorkflows;
    	//Ensure that the array is set, but don't reset it if it is not empty.
    	if (empty($triggeredWorkflows))
    	{
    		$triggeredWorkflows = array();
    	}

    	if($event=="before_save") {
    		foreach(SugarAutoLoader::existing("custom/modules/".$focus->module_dir."/workflow/workflow.php") as $workflow_path) {
    			include_once($workflow_path);
    			$target_class = $focus->module_dir."_workflow";
    			$workflow_class = new $target_class();
                $workflow_class->process_wflow_triggers($focus);
    		}
    	}
    	//Reset the infinit loop check for workflows
    	$triggeredWorkflows = array();
    }


    /**
     * Process all of the workflow alerts in the session for this bean
     * @param focus - the bean to use in the alert
     * @param alerts - the alerts that were saved in the session
     *
     */
    function process_alerts(&$focus, $alerts){

    	//Confirm we are not running populating seed data
    	if(isset($_SESSION['disable_workflow'])) return;

        //Now just include the modules workflow from this bean
        foreach(SugarAutoLoader::existing("custom/modules/".$focus->module_dir."/workflow/workflow.php") as $workflow_path) {
            include_once($workflow_path);

            $target_class = $focus->module_dir."_workflow";
            $workflow_class = new $target_class();

            if(!empty($focus->emailAddress) && isset($focus->emailAddress->addresses)) {//addresses maybe cleared
                    $old_addresses = $focus->emailAddress->addresses;
            }
            $focus->retrieve($focus->id);//This will lose all changes to emailaddress
            if(!empty($focus->emailAddress) && isset($old_addresses)) {
                $focus->emailAddress->addresses = $old_addresses;
                $focus->emailAddress->populateLegacyFields($focus);
            }

            // Bug 45142 - dates need to be converted to DB format for
            // workflow alerts to work properly in Alerts then Actions
            // situations - rgonzalez
            $focus->fixUpFormatting();
            // End Bug 45142

            foreach(SugarAutoLoader::existing("custom/modules/".$focus->module_dir."/workflow/workflow_alerts.php") as $file) {
                include_once($file);
                foreach($alerts as $alert){
                    $alert_target_class = $focus->module_dir."_alerts";
                    if(class_exists($alert_target_class)){
                        $alert_class = new $alert_target_class();
                        $function_name = "process_wflow_".$alert;
                        $alert_class->$function_name($focus);
                    }
                }
            }
        }
    }
}
