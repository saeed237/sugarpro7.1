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

global $app_list_strings;
global $beanList;
global $dictionary;

global $theme;



require_once('include/utils/expression_utils.php');

require_once('include/ListView/ProcessView.php');
require_once('modules/WorkFlowTriggerShells/MetaArray.php');

global $current_user;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $sugar_version, $sugar_config;
global $selector_meta_array;



	$exp_object = BeanFactory::getBean('Expressions');



	if(isset($_REQUEST['record']) && $_REQUEST['record']!='') {
  		  $exp_object->retrieve($_REQUEST['record']);
	//end expression object
	}

	foreach($exp_object->selector_popup_fields as $field){
		if(isset($_REQUEST[$field])){
			$exp_object->$field = $_REQUEST[$field];
		}
	}

	////HANDLE META ARRAY FIELDS
	if(isset($_REQUEST['exp_meta_type']) && $_REQUEST['exp_meta_type']!='') {
  		  $exp_meta_array = $selector_meta_array[$_REQUEST['exp_meta_type']];
  		  $exp_meta_type = $_REQUEST['exp_meta_type'];
	//end expression object
	} else {
		sugar_die("You need a meta filter name to access this popup");
	}




$xtpl=new XTemplate ('modules/Expressions/Filter_Selector.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("RETURN_PREFIX", $exp_object->return_prefix);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
if(!is_file(sugar_cached('jsLanguage/') . $GLOBALS['current_language'] . '.js')) {
    require_once('include/language/jsLanguage.php');
    jsLanguage::createAppStringsCache($GLOBALS['current_language']);
}
$javascript_language_files = getVersionedScript("cache/jsLanguage/{$GLOBALS['current_language']}.js",  $GLOBALS['sugar_config']['js_lang_version']);
$xtpl->assign("JAVASCRIPT_LANGUAGE_FILES", $javascript_language_files);

insert_popup_header($theme);
$xtpl->parse("embeded");
$xtpl->out("embeded");


if(isset($exp_meta_array['select_field']) && $exp_meta_array['select_field']===true) {
	$xtpl->assign('SELECT_FIELD', "Yes");
}


$xtpl->assign('EXP_META_TYPE', $exp_meta_type);

///Show field selector if required////

	$xtpl->assign('PARENT_TYPE', $exp_object->parent_type);
$form_name = "FieldView";
if(isset($exp_meta_array['select_field']) && $exp_meta_array['select_field']===true) {
	$temp_module = BeanFactory::getBean($exp_object->lhs_module);
	$temp_module->call_vardef_handler("normal_trigger");
	$temp_module->vardef_handler->start_none = true;
	$field_array = $temp_module->vardef_handler->get_vardef_array();
	asort($field_array);

	$field_select = get_select_options_with_id($field_array, $exp_object->lhs_field);
	$xtpl->assign('FIELD_SELECT', $field_select);

	$selector_onchange = "onchange=\"update_filter_select()\";";
	$xtpl->assign('SELECTOR_ONCHANGE', $selector_onchange);

	$xtpl->assign('LHS_MODULE', $exp_object->lhs_module);
	$xtpl->assign('ID', $exp_object->id);
	$xtpl->assign('SHOW_FIELD', $exp_object->show_field);


	$xtpl->parse("field_selector");
	$xtpl->out("field_selector");

//end if field selector is true
} else {

	$form_name = "FieldViewNonSelector";
	$xtpl->assign('LHS_FIELD', $exp_object->lhs_field);

	if(isset($_REQUEST['rhs_value']) && $_REQUEST['rhs_value']!='') {
  		  $exp_object->rhs_value = $_REQUEST['rhs_value'];
	//end expression object
	}

	if(isset($_REQUEST['time_type']) && $_REQUEST['lhs_field']!='') {
  		  $exp_object->lhs_field = $_REQUEST['lhs_field'];
	//end expression object
	}


	$xtpl->parse("non_field_selector");
	$xtpl->out("non_field_selector");


//end else field selector is false
}



if($exp_object->lhs_field != ""){

	$filter_array = $exp_object->build_field_filter($exp_object->lhs_module, $exp_object->lhs_field, $exp_meta_array['enum_multi']);

	$xtpl->assign('VALUE', $filter_array['value_select']['display']);
	$xtpl->assign('OPERATOR_JAVASCRIPT', $filter_array['operator']['jscript']);
	$xtpl->assign("OPERATOR", $filter_array['operator']['display']);
	$xtpl->assign('OPERATOR_JAVASCRIPT_START', $filter_array['operator']['jscriptstart']);
	$xtpl->assign('FIELD_TYPE', $filter_array['type']);
	$xtpl->assign('REAL_FIELD_TYPE', $filter_array['real_type']);
	$xtpl->assign('FIELD_NAME', $filter_array['name']);


///////////SHOW TIME COMPONENTS if the workflow is of type "Time"
	if($exp_meta_array['time_type']===true){

		$xtpl->assign('TIME_INTERVAL', $filter_array['time_select']['display']);


//end if to show time components
}

	$xtpl->assign('FORM_NAME', $form_name);
	$xtpl->parse("main");
	$xtpl->out("main");

	//rsmith
	$temp_module = BeanFactory::getBean($exp_object->lhs_module);
	$field = $exp_object->lhs_field;

	//now build toggle js
	global $mod_strings, $current_language;
	$mod_strings = return_module_language($current_language, $temp_module->module_dir);
	$javascript = new javascript();
	$javascript->setFormName('FieldViewNonSelector');
	$javascript->setSugarBean($temp_module);
	$type = $temp_module->field_name_map[$field]['type'];
	$js = "";
    if (isset($temp_module->field_name_map[$field]['required']))
    {
	if($type == 'date' || $type == 'time'){
		$js = "<script type=\"text/javascript\">";
		$js .= "addToValidate('EditView', '".$exp_object->parent_type."__field_value', 'assigned_user_name', 1,'". $javascript->stripEndColon(translate($temp_module->field_name_map[$field]['vname'])) . "' )";
		$js .= "</script>";
	}
	else if(in_array($type, ProcessView::get_js_exception_fields()) == 1){
				$js = '';
	}
	else{
		$javascript->addField($field, true, '', $exp_object->parent_type."__field_value");
		$js = $javascript->getScript();
	}
    }
	echo $js;
	//rsmith
}

?>
