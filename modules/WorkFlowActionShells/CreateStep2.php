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

require_once('include/workflow/field_utils.php');

global $theme;
global $app_strings;
global $app_list_strings;
global $mod_strings;

global $urlPrefix;
global $currentModule;

if(!empty($_REQUEST['workflow_id'])) {
    $seed_object = BeanFactory::retrieveBean('WorkFlow', $_REQUEST['workflow_id']);
} else {
	sugar_die("You shouldn't be here");
}



////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
if (!isset($_REQUEST['html'])) {
	$form =new XTemplate ('modules/WorkFlowActionShells/CreateStep2.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActionShells/CreateStep2.html");
}
else {
    $_REQUEST['html'] = preg_replace("/[^a-zA-Z0-9_]/", "", $_REQUEST['html']);
    $GLOBALS['log']->debug("_REQUEST['html'] is ".$_REQUEST['html']);
	$form =new XTemplate ('modules/WorkFlowActionShells/'.$_REQUEST['html'].'.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowActionShells/".$_REQUEST['html'].'.html');
}

$form->assign("MOD", $mod_strings);
$form->assign("APP", $app_strings);

$focus = BeanFactory::getBean('WorkFlowActionShells');
//Add When Expressions Object is availabe
//$exp_object = new Expressions();

if(!empty($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);

}
		//Bug 12335: We need to include the javascript language file first. And also the language file in WorkFlow is needed.
        if(!is_file(sugar_cached('jsLanguage/') . $GLOBALS['current_language'] . '.js')) {
            require_once('include/language/jsLanguage.php');
            jsLanguage::createAppStringsCache($GLOBALS['current_language']);
        }
        $javascript_language_files = getVersionedScript("cache/jsLanguage/{$GLOBALS['current_language']}.js",  $GLOBALS['sugar_config']['js_lang_version']);
        if(!is_file(sugar_cached('jsLanguage/') . $this->module . '/' . $GLOBALS['current_language'] . '.js')) {
                require_once('include/language/jsLanguage.php');
                jsLanguage::createModuleStringsCache($this->module, $GLOBALS['current_language']);
        }
        $javascript_language_files .= getVersionedScript("cache/jsLanguage/{$this->module}/{$GLOBALS['current_language']}.js", $GLOBALS['sugar_config']['js_lang_version']);
        if(!is_file(sugar_cached('jsLanguage/WorkFlow/') . $GLOBALS['current_language'] . '.js')) {
            require_once('include/language/jsLanguage.php');
            jsLanguage::createModuleStringsCache('WorkFlow', $GLOBALS['current_language']);
        }
        $javascript_language_files .= getVersionedScript("cache/jsLanguage/WorkFlow/{$GLOBALS['current_language']}.js", $GLOBALS['sugar_config']['js_lang_version']);

if(isset($_REQUEST['action_type']) && $_REQUEST['action_type']!=""){
	$focus->action_type = $_REQUEST['action_type'];
}

if(isset($_REQUEST['action_module']) && $_REQUEST['action_module']!=""){
	$focus->action_module = $_REQUEST['action_module'];
}
if(isset($_REQUEST['rel_module']) && $_REQUEST['rel_module']!=""){
	$focus->rel_module = $_REQUEST['rel_module'];
}
//set the parent id
$focus->parent_id = $_REQUEST['workflow_id'];

	$form->assign("ID", $focus->id);
    $form->assign("WORKFLOW_ID", $_REQUEST['workflow_id']);
    $form->assign("ACTION_MODULE", $focus->action_module);
    $form->assign("ACTION_TYPE", $focus->action_type);
    $form->assign("REL_MODULE", $focus->rel_module);


	$form->assign("JAVASCRIPT_LANGUAGE_FILES", $javascript_language_files);
	$form->assign("MODULE_NAME", $currentModule);
	//$form->assign("FORM", $_REQUEST['form']);
	$form->assign("GRIDLINE", $gridline);

	insert_popup_header($theme);


	$form->parse("embeded");
	$form->out("embeded");

    	//rsmith
    	require_once('include/ListView/ProcessView.php');
		$ProcessView = new ProcessView($seed_object, $focus);
		$results = $ProcessView->get_action_shell_display_text($focus, true);
		$result = $results["RESULT_ARRAY"];
		$field_count = 0;
		foreach($result as $value)
		{
			if (isset($value['FIELD_NAME']))
            {
                foreach($value as $aKey=>$aVal)
                {
                    $form->assign($aKey, $aVal);
                }
                $form->parse("main.lang_field");
                ++ $field_count;
            }
		}
    	//rsmith

    	$form->assign("TARGET_MODULE", $results["TEMP_MODULE_DIR"]);
    	$form->assign("TOTAL_FIELD_COUNT", $field_count);



//SET Previous Display Text

	$prev_display_text = $ProcessView->get_prev_text("ActionsCreateStep1", $focus->action_type);

	$form->assign("PREV_DISPLAY_TEXT", $prev_display_text);

	$adv_related_array = $ProcessView->get_adv_related("ActionsCreateStep1", $focus->action_type, "action");

		$form->assign("ADVANCED_SEARCH_PNG", SugarThemeRegistry::current()->getImage('advanced_search','border="0"',null,null,'.gif',$app_strings['LNK_ADVANCED_SEARCH']));
		$form->assign("BASIC_SEARCH_PNG", SugarThemeRegistry::current()->getImage('basic_search','border="0"',null,null,'.gif',$app_strings['LNK_BASIC_SEARCH']));

	if($adv_related_array!=""){
		$form->assign("ADV_RELATED_BLOCK", $adv_related_array['block']);
		if($focus->rel_module_type=="all" || $focus->rel_module_type==""){
			$form->assign("REL_SET_TYPE", "Basic");
		} else {
			$form->assign("REL_SET_TYPE", "Advanced");
		}

		$form->assign("SET_DISABLED", "No");
	} else {
		$form->assign("REL_SET_TYPE", "Basic");
		$form->assign("SET_DISABLED", "Yes");
	}

$form->parse("main");
$form->out("main");

?>

<?php insert_popup_footer(); ?>
