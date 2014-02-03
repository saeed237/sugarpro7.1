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

global $theme;









global $app_strings;
global $app_list_strings;
global $mod_strings;

global $urlPrefix;
global $currentModule;


$seed_object = BeanFactory::getBean('WorkFlow');

if(!empty($_REQUEST['workflow_id']) && $_REQUEST['workflow_id']!="") {
    $seed_object->retrieve($_REQUEST['workflow_id']);
} else {
	sugar_die("You shouldn't be here");
}



////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
if (!isset($_REQUEST['html'])) {
	$form =new XTemplate ('modules/WorkFlowActions/SelectFields.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActions/SelectFields.html");
}
else {
    $_REQUEST['html'] = preg_replace("/[^a-zA-Z0-9_]/", "", $_REQUEST['html']);
    $GLOBALS['log']->debug("_REQUEST['html'] is ".$_REQUEST['html']);
	$form =new XTemplate ('modules/WorkFlowActions/'.$_REQUEST['html'].'.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActions/".$_REQUEST['html'].'.html');
}

$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);

$focus = BeanFactory::getBean('WorkFlowActionShells');
//Add When Expressions Object is availabe
//$exp_object = new Expressions();

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}


if(isset($_REQUEST['action_type']) && $_REQUEST['action_type']!=""){
	$focus->action_type = $_REQUEST['action_type'];

}

if(isset($_REQUEST['action_module']) && $_REQUEST['action_module']!=""){
	$focus->action_module = $_REQUEST['action_module'];

}
if(isset($_REQUEST['rel_module']) && $_REQUEST['rel_module']!=""){
	$focus->rel_module = $_REQUEST['rel_module'];

}

	$form->assign("ID", $focus->id);
    $form->assign("WORKFLOW_ID", $_REQUEST['workflow_id']);
    $form->assign("ACTION_MODULE", $focus->action_module);
    $form->assign("ACTION_TYPE", $focus->action_type);
    $form->assign("REL_MODULE", $focus->rel_module);

   if($focus->action_type=="update"){
   	 	$temp_module = BeanFactory::getBean($seed_object->base_module);
   	 	$meta_filter = "action_filter";
	}

	if($focus->action_type=="update_rel"){
		$rel_module = $seed_object->get_rel_module($focus->rel_module);
		$temp_module = BeanFactory::getBean($rel_module);
    	$meta_filter = "action_filter";
	}

	if($focus->action_type=="new"){
		$rel_module = $seed_object->get_rel_module($focus->action_module);
		$temp_module = BeanFactory::getBean($rel_module);
   		$meta_filter = "action_filter";
	}

	if($focus->action_type=="new_rel"){
		$rel_handler = & $seed_object->call_relationship_handler("base_module", true);
		$rel_handler->set_rel_vardef_fields($focus->rel_module, $focus->action_module);
		$rel_handler->build_info(true);
		$temp_module = $rel_handler->rel2_bean;
   	 	$meta_filter = "action_filter";
	}


   	//Using VarDef Handler Object to obtain filtered array
	$temp_module->call_vardef_handler($meta_filter);
	$field_array = $temp_module->vardef_handler->get_vardef_array();

     $field_count = 0;
    	foreach($field_array as $key => $value){

   		//check to see if this record exists already
    		if(!empty($focus->id) && $focus->id!=""){
    			$action_id = $focus->get_action_id($key);
    			if($action_id!==false){
     				$selected_action = "checked";
    				$form->assign("SELECTED_ACTION", $selected_action);
     			} else {
    				$form->assign("SELECTED_ACTION", $focus->check_required_field("iframe_display", $temp_module, $key));
    			}
    		} else {
    			$form->assign("SELECTED_ACTION", $focus->check_required_field("iframe_display", $temp_module, $key));
    		}
    		$form->assign("FIELD_NUM", $field_count);
    		$form->assign("FIELD_NAME", $value.$focus->check_required_field("span_req_display", $temp_module, $key));
    		$form->assign("FIELD_VALUE", $key);
    		$form->parse("main.field");
    		++ $field_count;

    	//end foreach
    	}
    	$form->assign("TOTAL_FIELD_COUNT", $field_count);

$form->assign("MODULE_NAME", $currentModule);
//$form->assign("FORM", $_REQUEST['form']);
$form->assign("GRIDLINE", $gridline);

insert_popup_header($theme);


$form->parse("embeded");
$form->out("embeded");


$form->parse("main");
$form->out("main");

?>

<?php insert_popup_footer(); ?>
