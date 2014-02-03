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




if(!empty($_REQUEST['parent_id']) ) {
    $seed_object = BeanFactory::retrieveBean('WorkFlowAlertShells', $_REQUEST['parent_id']);
}
if(empty($seed_object)) {
	sugar_die("You shouldn't be here");
}
$workflow_object = $seed_object->get_workflow_object();

////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
if (!isset($_REQUEST['html'])) {
	$form =new XTemplate ('modules/WorkFlowAlerts/Popup_picker.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowAlerts/Popup_picker.html");
}
else {
    $_REQUEST['html'] = preg_replace("/[^a-zA-Z0-9_]/", "", $_REQUEST['html']);
    $GLOBALS['log']->debug("_REQUEST['html'] is ".$_REQUEST['html']);
	$form =new XTemplate ('modules/WorkFlowAlerts/'.$_REQUEST['html'].'.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowAlerts/".$_REQUEST['html'].'.html');
}

$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);

$focus = BeanFactory::getBean('WorkFlowAlerts');
//Add When Expressions Object is availabe
//$exp_object = new Expressions();

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);

}

        $the_javascript  = "<script type='text/javascript' language='JavaScript'>\n";
        $the_javascript .= "function set_return() {\n";
        $the_javascript .= "    window.opener.document.EditView.submit();";
        $the_javascript .= "}\n";
        $the_javascript .= "</script>\n";

	$form->assign("ID", $focus->id);
    $form->assign("PARENT_ID", $_REQUEST['parent_id']);
    $form->assign("ADDRESS_TYPE", get_select_options_with_id($app_list_strings['wflow_address_type_dom'],$focus->address_type));
	$form->assign("USER_TYPE", get_select_options_with_id($app_list_strings['wflow_user_type_dom'],$focus->user_type));

	$form->assign("REL_MODULE1", get_select_options_with_id($focus->get_rel_module_array($workflow_object->base_module),$focus->rel_module1));
	$form->assign("ARRAY_TYPE", get_select_options_with_id($app_list_strings['wflow_array_type_dom'],$focus->array_type));
	$form->assign("RELATE_TYPE", get_select_options_with_id($app_list_strings['wflow_relate_type_dom'],$focus->relate_type));
	$form->assign("FIELD_VALUE", get_select_options_with_id($focus->get_field_value_array($workflow_object->base_module, "User"),$focus->field_value));

if($focus->user_type=="Related"){

	if(!empty($focus->rel_email_value) && $focus->rel_email_value!=""){
		$form->assign("CUSTOM_USER", "checked");
		$form->assign("REL_FIELD_VALUE", $focus->field_value);
		$form->assign("REL_EMAIL_VALUE", $focus->rel_email_value);
	} else {
	}

	$form->assign("REL_MODULE2", $focus->rel_module2);


//end if else Current or Related
}

//close window and refresh parent if needed

if(!empty($_REQUEST['special_action']) && $_REQUEST['special_action'] == "refresh"){

	$special_javascript = "window.opener.document.DetailView.action.value = 'DetailView'; \n";
	$special_javascript .= "window.opener.document.DetailView.submit(); \n";
	$special_javascript .= "window.close();";
	$form->assign("SPECIAL_JAVASCRIPT", $special_javascript);

}

$form->assign("MODULE_NAME", $currentModule);
//$form->assign("FORM", $_REQUEST['form']);
$form->assign("GRIDLINE", $gridline);
$form->assign("SET_RETURN_JS", $the_javascript);

insert_popup_header($theme);


$form->parse("embeded");
$form->out("embeded");


$form->parse("main");
$form->out("main");

?>

<?php insert_popup_footer(); ?>
