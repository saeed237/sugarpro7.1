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
	$form =new XTemplate ('modules/WorkFlowActionShells/Selector.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActionShells/Selector.html");
}
else {
	$GLOBALS['log']->debug("_REQUEST['html'] is ".$_REQUEST['html']);
	$form =new XTemplate ('modules/WorkFlowActionShells/'.$_REQUEST['html'].'.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActionShells/".$_REQUEST['html'].'.html');
}

$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);

$focus = BeanFactory::getBean('WorkFlowActionShells');  


if(isset($_REQUEST['action_type']) && ($_REQUEST['action_type'])=='action_update_rel') {
	
	$temp_module = BeanFactory::getBean($seed_object->base_module);
	$temp_module->call_vardef_handler("rel_filter");
	$temp_module->vardef_handler->start_none=true;
	$temp_module->vardef_handler->start_none_lbl = "Please Select";

	$form->assign("SELECTOR_JSCRIPT_RETURN", "'href_action_update_rel', 'rel_module'");
	$form->assign("SELECTOR_TAG", $mod_strings['LBL_ACTION_UPDATE_REL']);
	$form->assign("SELECTOR_DROPDOWN", get_select_options_with_id($temp_module->vardef_handler->get_vardef_array(true),$_REQUEST['rel_module']));
//end if action type is set  
}
if(isset($_REQUEST['action_type']) && ($_REQUEST['action_type'])=='action_new') {
	
	$form->assign("SELECTOR_JSCRIPT_RETURN", "'href_action_new', 'action_module'");
	$form->assign("SELECTOR_TAG", $mod_strings['LBL_ACTION_NEW']);
	
	
	
	$form->assign("SELECTOR_DROPDOWN", get_select_options_with_id($seed_object->get_module_array(true, true),$_REQUEST['rel_module']));
}

$form->assign("MODULE_NAME", $currentModule);

$form->assign("GRIDLINE", $gridline);

insert_popup_header($theme);

$form->parse("embeded");
$form->out("embeded");


$form->parse("main");
$form->out("main");

?>

<?php insert_popup_footer(); ?>
