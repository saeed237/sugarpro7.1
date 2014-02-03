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


include_once('include/workflow/workflow_utils.php');
include_once('modules/WorkFlow/WorkFlowSchedule.php');

function get_time_contents($workflow_id){
	
	$contents = "";
	
	//check to see if this item already is in the schedule table
	$contents .= "\t\t check_for_schedule(\$focus, \$workflow_id, \$time_array); \n\n ";

	
	return $contents;
	
//end function get_time_contents	
}	


function check_for_schedule(& $focus, $workflow_id, $time_array){
	
	$is_update = false;
	
	//check to see if it exists;
	$wflow_schedule = new WorkFlowSchedule();
	$is_update = $wflow_schedule->check_existing_trigger($focus->id, $workflow_id);

	if(isset($time_array['parameters'])){
		$wflow_schedule->parameters = $time_array['parameters'];
	}
		
	//if this exists, then update
	if($is_update == true ){
		
		$wflow_schedule->set_time_interval($focus, $time_array, true);
		$wflow_schedule->save();
	} else {	
	//if this does not exist then create new

		$wflow_schedule->bean_id = $focus->id;
		$wflow_schedule->workflow_id = $workflow_id;
		$wflow_schedule->target_module = $focus->module_dir;
		$wflow_schedule->set_time_interval($focus, $time_array);
		$wflow_schedule->save();
	
	//end if else is update or not
	}

//end function check_for_schedule
}	

?>
