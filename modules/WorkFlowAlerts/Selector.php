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
$focus = BeanFactory::getBean('WorkFlowAlerts');

if(!empty($_REQUEST['base_module']) && $_REQUEST['base_module']!="") {
    $seed_object->base_module = $_REQUEST['base_module'];
} else {
	sugar_die("You shouldn't be here");	
}	



////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
	$form =new XTemplate ('modules/WorkFlowAlerts/Selector.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowAlerts/Selector.html");


$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);
$form->assign("BASE_MODULE", $_REQUEST['base_module']);
$form->assign("USER_TYPE", $_REQUEST['user_type']);

if($_REQUEST['user_type']=='rel_user' || $_REQUEST['user_type']=='rel_user_custom' || $_REQUEST['user_type']=='assigned_team_relate' ) {

	$temp_module = BeanFactory::getBean($seed_object->base_module);
	$temp_module->call_vardef_handler("alert_rel_filter");
	$temp_module->vardef_handler->start_none=true;
	$temp_module->vardef_handler->start_none_lbl =  $mod_strings['LBL_PLEASE_SELECT'];

	$form->assign("SELECTOR_JSCRIPT_RETURN", "'href_".$_REQUEST['user_type']."'");
	$form->assign("SELECTOR_TAG", $mod_strings['LBL_ALERT_REL1']);
	$form->assign("SELECTOR_DROPDOWN", get_select_options_with_id($temp_module->vardef_handler->get_vardef_array(true, '', true, true),$_REQUEST['rel_module1']));
	
	if(!empty($_REQUEST['rel_module1']) && $_REQUEST['rel_module1']!=''){
	$rel_module_name = $_REQUEST['rel_module1'];
	$rel_module = $focus->get_rel_module($seed_object->base_module, $rel_module_name);
		if(!empty($_REQUEST['rel_module2']) && $_REQUEST['rel_module2']!=""){
			$rel_module2 = $_REQUEST['rel_module2'];
		} else {
			$rel_module2 = "";	
		}	
		
		$temp_module2 = BeanFactory::getBean($rel_module);
		$temp_module2->call_vardef_handler("alert_rel_filter");
		$temp_module2->vardef_handler->start_none=true;
		$temp_module2->vardef_handler->start_none_lbl = $mod_strings['LBL_PLEASE_SELECT'];
		
		$rel_select2 = get_select_options_with_id($temp_module2->vardef_handler->get_vardef_array(true, '', true, true),$rel_module2);	
	
		$form->assign("SELECTOR_TAG2", $mod_strings['LBL_ALERT_REL2']);
		$form->assign("SELECTOR_DROPDOWN2", $rel_select2);
	
	//end if we should show second related
	}
	
	
//end if action type is set  
}

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
