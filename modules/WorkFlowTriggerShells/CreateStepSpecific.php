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

require_once('include/workflow/workflow_utils.php');
require_once('include/workflow/field_utils.php');

global $theme;
global $app_strings;
global $app_list_strings;
global $mod_strings;

global $urlPrefix;
global $currentModule;

if(!empty($_REQUEST['workflow_id'])) {
    $workflow_object = BeanFactory::retrieveBean('WorkFlow', $_REQUEST['workflow_id']);
}
if(empty($workflow_object)) {
	sugar_die("You shouldn't be here");
}

$focus = BeanFactory::getBean('WorkFlowTriggerShells');
if(!empty($_REQUEST['record']) ) {
    $focus->retrieve($_REQUEST['record']);

}

if(!empty($_REQUEST['field'])) {
   $focus->field = $_REQUEST['field'];
}

if(!empty($_REQUEST['type'])) {
   $focus->type = $_REQUEST['type'];
}

////////////////////////////////////////////////////////
// Start the output
////////////////////////////////////////////////////////
	$form =new XTemplate ('modules/WorkFlowTriggerShells/CreateStepSpecific.html');
	$GLOBALS['log']->debug("using file modules/WorkFlowTriggerShells/CreateStepSpecific.html");

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

        $the_javascript  = "<script type='text/javascript' language='JavaScript'>\n";
        $the_javascript .= "function set_return() {\n";
        $the_javascript .= "    window.opener.document.EditView.submit();";
        $the_javascript .= "}\n";
        $the_javascript .= "</script>\n";

	$form->assign("MOD", $mod_strings);
	$form->assign("APP", $app_strings);
	$form->assign("JAVASCRIPT_LANGUAGE_FILES", $javascript_language_files);
	$form->assign("MODULE_NAME", $currentModule);
	$form->assign("GRIDLINE", $gridline);
	$form->assign("SET_RETURN_JS", $the_javascript);

	$form->assign("BASE_MODULE", $workflow_object->base_module);
	$form->assign("WORKFLOW_ID", $workflow_object->id);
	$form->assign("ID", $focus->id);
	$form->assign("FIELD", $focus->field);
	$form->assign("PARENT_ID", $workflow_object->id);
	$form->assign("TRIGGER_TYPE", $workflow_object->type);
	$form->assign("TYPE", $focus->type);

	//Check multi_trigger filter conditions
	if(!empty($_REQUEST['frame_type']) && $_REQUEST['frame_type']=="Secondary"){
		$form->assign("FRAME_TYPE", $_REQUEST['frame_type']);
	} else {
		$form->assign("FRAME_TYPE", "Primary");
	}


insert_popup_header();

$form->parse("embeded");
$form->out("embeded");


////////Middle Items/////////////////////////////

	$temp_module = BeanFactory::getBean($workflow_object->base_module);
	$display_field_name = $temp_module->field_defs[$focus->field]['vname'];
	$current_module_strings = return_module_language($current_language, $workflow_object->base_module);
	$display_field_name = "<i><b>\" ".get_label($display_field_name, $current_module_strings)." \"</i></b>";
	$form->assign("SPECIFIC_FIELD", $display_field_name);

	if($workflow_object->type=="Normal"){
		//set exp_meta_type to normal_trigger
		$form->assign("EXP_META_TYPE", "normal_trigger");
	} else {
		//set exp_meta_type to time_trigger
		$form->assign("EXP_META_TYPE", "time_trigger");
	}


//SET Previous Display Text
	require_once('include/ListView/ProcessView.php');
	$ProcessView = new ProcessView($workflow_object, $focus);
	$prev_display_text = $ProcessView->get_prev_text("TriggersCreateStep1", $focus->type);

	$form->assign("PREV_DISPLAY_TEXT", $prev_display_text);



//////////////////BEGIN Future Object	/////////////////////////////////

		$future_object = BeanFactory::getBean('Expressions');
		$future_list = $focus->get_linked_beans('future_triggers','Expression');
		if(!empty($future_list[0])) {
			$future_id = $future_list[0]->id;
		}

		if(!empty($future_id)) {
  		  $future_object->retrieve($future_id);

		$display_array = $future_object->get_display_array($temp_module);


		if($workflow_object->type=="Time"){
			$form->assign("FUTURE_TRIGGER_TIME_INT", $future_object->ext1);

			if($future_object->exp_type=="datetime" || $future_object->exp_type=="date" || $future_object->exp_type=="datetimecombo"){

				if($future_object->operator=="More Than"){
					$special_text = "was more than";
					$special_text2 = "ago";
				} else {
					$special_text = "is less than";
					$special_text2 = "from now";
				}

				$filter_expression_text = $special_text." '<i>".$app_list_strings['tselect_type_dom'][$future_object->ext1]."</i>' ".$special_text2;

			} else {

				$filter_expression_text = $display_array['operator']." '<i>".$display_array['rhs_value']."</i>' for at least  ".$app_list_strings['tselect_type_dom'][$future_object->ext1];
			}


		} else {
			$filter_expression_text = $display_array['operator']." ".$display_array['rhs_value'];
		}


		$form->assign("FUTURE_TRIGGER_EXP_ID", $future_object->id);
		$form->assign("FUTURE_TRIGGER_RHS_VALUE", $future_object->rhs_value);
		$form->assign("FUTURE_TRIGGER_TEXT", $filter_expression_text);
		$form->assign("FUTURE_TRIGGER_OPERATOR", $future_object->operator);
		$form->assign("FUTURE_TRIGGER_EXP_TYPE", $future_object->exp_type);

		//past only


	//if future object already exists
	} else {
	//expression future object not exist
		$form->assign("FUTURE_TRIGGER_TEXT",$mod_strings['LBL_VALUE']);
	}

	$form->assign("FUTURE_TRIGGER_LHS_FIELD", $focus->field);
	$form->assign("FUTURE_TRIGGER_LHS_MODULE", $workflow_object->base_module);

/////////////////END Future Object/////////////////////////////////




//////////////////BEGIN past Object	/////////////////////////////////
if($workflow_object->type=="Normal"){
	//only show past if workflow object is of type normal


		//PAST SPECIFIC
		if($focus->show_past==1){
			$form->assign("PAST_CHECKED", "checked");
		}


		$past_object = BeanFactory::getBean('Expressions');
		$past_list = $focus->get_linked_beans('past_triggers','Expression');
		if(isset($past_list[0]) && $past_list[0]!='') {
			$past_id = $past_list[0]->id;
		}

		if(isset($past_id) && $past_id!="") {
  		  $past_object->retrieve($past_id);
		$display_array = $past_object->get_display_array($temp_module);
  		$filter_expression_text = $display_array['operator']." ".$display_array['rhs_value'];

		$form->assign("PAST_TRIGGER_EXP_ID", $past_object->id);
		$form->assign("PAST_TRIGGER_RHS_VALUE", $past_object->rhs_value);
		$form->assign("PAST_TRIGGER_TEXT", $filter_expression_text);
		$form->assign("PAST_TRIGGER_OPERATOR", $past_object->operator);
		$form->assign("PAST_TRIGGER_EXP_TYPE", $past_object->exp_type);

		//past only


	//if past object already exists
	} else {
	//expression past object not exist
		$form->assign("PAST_TRIGGER_TEXT",$mod_strings['LBL_VALUE']);
	}

	$form->assign("PAST_TRIGGER_LHS_FIELD", $focus->field);
	$form->assign("PAST_TRIGGER_LHS_MODULE", $workflow_object->base_module);


//end only show past if workflow type is of type normal
} else {

	$form->assign("PAST_HIDDEN", "style='display:none'");
}

/////////////////END past Object/////////////////////////////////


		$form->parse("main.rel_custom_frame_top");
		$form->parse("main.rel_custom_frame_bottom");

/////////////////End Items 	//////////////////////

//close window and refresh parent if needed

if(!empty($_REQUEST['special_action']) && $_REQUEST['special_action'] == "refresh"){

	$special_javascript = "window.opener.document.DetailView.action.value = 'DetailView'; \n";
	$special_javascript .= "window.opener.document.DetailView.submit(); \n";
	$special_javascript .= "window.close();";
	$form->assign("SPECIAL_JAVASCRIPT", $special_javascript);

}

$form->parse("main");
$form->out("main");

?>

<?php insert_popup_footer(); ?>
