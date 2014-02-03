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

/*
 * Created on Jul 18, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 function get_body(&$ss, $vardef){
 	$multi = false;
    $radio = false;
 	if (isset ($vardef['type']) && $vardef['type'] == 'multienum')
 		$multi = true;
 		
 	$selected_options = "";
 	if ($multi && !empty($vardef['default'])) {
 		$selected_options = unencodeMultienum( $vardef['default']);
 	} else if (isset($vardef['default'])){
 		$selected_options = $vardef['default'];
 	}

    $edit_mod_strings = return_module_language($GLOBALS['current_language'], 'EditCustomFields');

	if(!empty($_REQUEST['type']) && $_REQUEST['type'] == 'radioenum'){
		$edit_mod_strings['LBL_DROP_DOWN_LIST'] = $edit_mod_strings['LBL_RADIO_FIELDS'];
        $radio = true;
	}
	$package_strings = array();
	if(!empty($_REQUEST['view_package'])){
		$view_package = $_REQUEST['view_package'];
		if($view_package != 'studio') {
			require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
			$mb = new ModuleBuilder();
			$module =& $mb->getPackageModule($view_package, $_REQUEST['view_module']);
			$lang = $GLOBALS['current_language'];
			//require_once($package->getPackageDir()."/include/language/$lang.lang.php");
			$module->mblanguage->generateAppStrings(false);
			$package_strings = $module->mblanguage->appListStrings[$lang.'.lang.php'];
		}
	}
	
	global $app_list_strings;
	$my_list_strings = $app_list_strings;
	$my_list_strings = array_merge($my_list_strings, $package_strings);
	foreach($my_list_strings as $key=>$value){
		if(!is_array($value)){
			unset($my_list_strings[$key]);
		}
	}
	$dropdowns = array_keys($my_list_strings);
	sort($dropdowns);
    $default_dropdowns = array();
    if(!empty($vardef['options']) && !empty($my_list_strings[$vardef['options']])){
    		$default_dropdowns = $my_list_strings[$vardef['options']];
    }else{
    	//since we do not have a default value then we should assign the first one.
    	$key = $dropdowns[0];
    	$default_dropdowns = $my_list_strings[$key];
    }
    
    $selected_dropdown = '';
    if(!empty($vardef['options'])){
    	$selected_dropdown = $vardef['options'];

    }
    $show = true;
	if(!empty($_REQUEST['refresh_dropdown']))
		$show = false;

	$ss->assign('dropdowns', $dropdowns);
	$ss->assign('default_dropdowns', $default_dropdowns);
	$ss->assign('selected_dropdown', $selected_dropdown);
	$ss->assign('show', $show);
	$ss->assign('selected_options', $selected_options);
	$ss->assign('multi', isset($multi) ? $multi: false);
    $ss->assign('radio', isset($radio) ? $radio: false);
	$ss->assign('dropdown_name',(!empty($vardef['options']) ? $vardef['options'] : ''));

	require_once('include/JSON.php');
	$json = new JSON(JSON_LOOSE_TYPE);
	$ss->assign('app_list_strings', "''");
	return $ss->fetch('modules/DynamicFields/templates/Fields/Forms/enum.tpl');
 }
?>
