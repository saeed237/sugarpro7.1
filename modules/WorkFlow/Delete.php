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

/*********************************************************************************

 * Description:  
 ********************************************************************************/


require_once('include/controller/Controller.php');
global $mod_strings;



$focus = BeanFactory::getBean('WorkFlow');

if(!isset($_REQUEST['record']))
	sugar_die($mod_strings['ERR_DELETE_RECORD']);

	
	$focus->retrieve($_REQUEST['record']);
	
    $focus->mark_deleted($_REQUEST['record']);
	/*
	//Completely remove the trigger components////////////////////////
		$trigger_object_list = $focus->get_linked_beans('triggers','WorkFlowTriggerShell');
		if(!empty($trigger_object_list)){
		
			foreach($trigger_object_list as $trigger_object){
		
				//mark delete trigger components and sub expression components
				mark_delete_components($trigger_object->get_linked_beans('future_triggers','Expression'));
				mark_delete_components($trigger_object->get_linked_beans('past_triggers','Expression'));
				$trigger_object->mark_deleted($trigger_object->id);
			//end the foreach loop on trigger objects
			}
	
		//end if any alert objects exist
		}
		
	//Completely remove the trigger filter components////////////////////////
		$trigger_object_list = $focus->get_linked_beans('trigger_filters','WorkFlowTriggerShell');
		if(!empty($trigger_object_list)){
		
			foreach($trigger_object_list as $trigger_object){
		
				//mark delete trigger filter components and sub expression components
				mark_delete_components($trigger_object->get_linked_beans('expressions','Expression'));
				$trigger_object->mark_deleted($trigger_object->id);
			//end the foreach loop on trigger filter objects
			}
	
		//end if any alert objects exist
		}		
		
		
		
	//Completely remove the alert components/////////////////////////
		$alert_object_list = $focus->get_linked_beans('alerts','WorkFlowAlertShell');
		if(!empty($alert_object_list)){
		
			foreach($alert_object_list as $alert_object){
		
				//mark delete alert components and sub expression components

				//Alert recipient Object///////				
					$alert_object_list2 = $alert_object->get_linked_beans('alert_components','WorkFlowAlert');
	
					foreach($alert_object_list2 as $alert_object2){
						mark_delete_components($alert_object2->get_linked_beans('expressions','Expression'));
						mark_delete_components($alert_object2->get_linked_beans('rel1_alert_fil','Expression'));
						mark_delete_components($alert_object2->get_linked_beans('rel2_alert_fil','Expression'));
						$alert_object2->mark_deleted($alert_object2->id);	
		
					//end foreach alert_object2
					}	
	
				//End Alert recipient Object/////			
				
				$alert_object->mark_deleted($alert_object->id);
			//end the forloop on the alert objects
			}
	
		//end if any alert objects exist
		}
	
	
	//Completely remove the action components////////////////////////
		//mark delete actionshell components, action components and sub expression components
		$action_shell_list = $focus->get_linked_beans('actions','WorkFlowActionShell');
	
		foreach($action_shell_list as $action_shell_object){
		//mark delete actionshell sub components and actionshell
			mark_delete_components($action_shell_object->get_linked_beans('actions','WorkFlowAction'));
			mark_delete_components($action_shell_object->get_linked_beans('rel1_action_fil','Expression'));
			$action_shell_object->mark_deleted($action_shell_object->id);
		}

		
	//Handle re-processing orders
		$controller = new Controller();
		$controller->init($focus, "Delete");
		$controller->delete_adjust_order($focus->base_module);	
		
	//mark deleted the workflow object
	$focus->mark_deleted($_REQUEST['record']);
	*/
	//Re-write workflow
	$focus->write_workflow();

header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
?>
