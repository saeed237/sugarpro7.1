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


require_once('include/ListView/ProcessView.php');
global $mod_strings;



$focus = BeanFactory::getBean('WorkFlowTriggerShells');

if(!isset($_REQUEST['record']))
	sugar_die($mod_strings['ERR_DELETE_RECORD']);

	$focus->retrieve($_REQUEST['record']);
	//mark delete trigger components
	mark_delete_components($focus->get_linked_beans('future_triggers','Expression'));
	mark_delete_components($focus->get_linked_beans('past_triggers','Expression'));
	mark_delete_components($focus->get_linked_beans('expressions','Expression'));
	$focus->mark_deleted($_REQUEST['record']);

	$workflow_object = $focus->get_workflow_type();
		//rsmith
	if($focus->frame_type == "Primary")
	{
		$target_meta_array = $process_dictionary["TriggersCreateStep1"]['elements'];
		$ProcessView = new ProcessView($workflow_object, $focus);
		$found = false;
		foreach($target_meta_array as $element => $specific_array){
				if($ProcessView->build_this_type($specific_array)){
						//we have found a trigger that is compatible with the workflow
						$trigger_type = $specific_array['trigger_type'];
						//now we must find a trigger on the workflow that is of this type
						//if we find it then set this as the primary
						//else continue
						$trigger_list = $workflow_object->get_linked_beans('trigger_filters','WorkFlowTriggerShell');
						foreach($trigger_list as $trigger){

								if($trigger->type == $element){
										$trigger->frame_type = "Primary";
										$trigger->save();
										$found = true;
										break;
								}
						}
						if($found){
							break;
						}
				}
		}
		//bug 25791, In the for-loop above $target_meta_array can be empty and the $trigger->frame_type is not changed.
		//In that case, just use the first trigger as the primary.
        if(!$found) {
            $trigger_list = $workflow_object->get_linked_beans('trigger_filters','WorkFlowTriggerShell');
            if (isset($trigger_list[0])) {
            	$trigger_list[0]->frame_type = "Primary";
                $trigger_list[0]->save();
            }
        }
	}
	//rsmith
    //reload $workflow_object to make the trigger changes take effect.
	$workflow_object = $focus->get_workflow_type();
	$workflow_object->write_workflow();

header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
?>
