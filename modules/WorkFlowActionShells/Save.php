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

$past_remove = false;


$focus = BeanFactory::getBean('WorkFlowActionShells');


if(!empty($_POST['record'])){
	$focus->retrieve($_POST['record']);
	$is_new = false;
} else {
	$is_new = true;
}

foreach($focus->column_fields as $field)
{
	if(isset($_POST[$field]))
	{
		$focus->$field = $_POST[$field];

	}
}
if(isset($_POST['rel1_type'])){
	$focus->rel_module_type = $_POST['rel1_type'];
}

$focus->save();
$parent_id = $focus->id;




	////////////////REL1 TYPE FILTER
	$rel1_list = & $focus->get_linked_beans('rel1_action_fil','Expression');

	if(!empty($rel1_list[0])){
		$rel1_filter_id = $rel1_list[0]->id;
	} else {
		$rel1_filter_id = "";
	}
	$rel1_object = BeanFactory::getBean('Expressions');

	//Checked if there is an advanced filter
	if($focus->rel_module_type!="filter"){
		//no advanced filter
		if($rel1_filter_id!=""){
			//remove existing filter;
			$rel1_object->mark_deleted($rel1_filter_id);
		}

	//end if no adv filter
	} else {
	//Rel1 Filter exists

		$rel1_object->parent_id = $parent_id;
		$rel1_object->handleSave("rel1_", "rel1_action_fil", $rel1_filter_id);

	//end if rel1 filter exists
	}
	/////////////////END REL1 TYPE FILTER


////////////////Handle the WorkFlowAction records

	$total_field_count = $_REQUEST['total_field_count'];

for ($i = 0; $i <= $total_field_count; $i++) {

	$temp_set_type = 'set_type_'.$i;

	if(!empty($_REQUEST[$temp_set_type]) && $_REQUEST[$temp_set_type]!=""){
	//this attribute is set, so lets store or update

		$action_object = BeanFactory::getBean('WorkFlowActions');
		if(!empty($_REQUEST['action_id_'.$i])){
			$action_object->retrieve($_REQUEST['action_id_'.$i]);

		//end if action id is already present
		}

		foreach($action_object->column_fields as $field){
			$action_object->populate_from_save($field, $i, $temp_set_type);
		}

		$action_object->parent_id = $focus->id;
		$action_object->save();

	} else {
	//possibility exists that this attribute is being removed
		if(!empty($_REQUEST['action_id_'.$i])){
			//delete attribute
			BeanFactory::deleteBean('WorkFlowActions', $_REQUEST['action_id_'.$i]);
		//end if to remove attribute
		}

	}


}


//Rewrite the workflow files
$workflow_object = $focus->get_workflow_object();

//  If this action_module is Meeting or Call then create a bridging object
if($is_new==true){
	$focus->check_for_invitee_bridge($workflow_object);
}

$workflow_object->write_workflow();

$workflow_id = $focus->parent_id;






$return_id = $focus->id;

if(!empty($_POST['return_module'])) $return_module = $_POST['return_module'];
else $return_module = "WorkFlowActionShells";
if(!empty($_POST['return_action'])) $return_action = $_POST['return_action'];
else $return_action = "CreateStep1";
if(!empty($_POST['return_id'])) $return_id = $_POST['return_id'];

$GLOBALS['log']->debug("Saved record with id of ".$return_id);
//exit;
header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&workflow_id=$workflow_id&special_action=refresh");
?>
