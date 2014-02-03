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

$style='embeded';
if(isset($_REQUEST['style'])){
	$style = $_REQUEST['style'];	
}
if(isset($_REQUEST['module_name'])){
	$the_strings = return_module_language($current_language, $_REQUEST['module_name']);
	
	

	global $app_strings;
	global $app_list_strings;
	global $mod_strings;
	global $current_user;
	
    echo SugarThemeRegistry::current()->getCSS();
	echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$_REQUEST['module_name']), true);
	
		





	$xtpl=new XTemplate ('modules/LabelEditor/EditView.html');
	$xtpl->assign("MOD", $mod_strings);
	$xtpl->assign("APP", $app_strings);
	$xtpl->assign("MODULE_NAME", $_REQUEST['module_name']);
	$xtpl->assign("STYLE",$style);
	if(isset($_REQUEST['sugar_body_only'])){
		$xtpl->assign("SUGAR_BODY_ONLY",$_REQUEST['sugar_body_only']);
	}
	
	if(isset($_REQUEST['record']) ){
		$xtpl->assign("NO_EDIT", "readonly");
		$xtpl->assign("KEY", $_REQUEST['record']);
		if(isset($the_strings[$_REQUEST['record']])){
			$xtpl->assign("VALUE",$the_strings[$_REQUEST['record']]);
		}else{
			if(isset($_REQUEST['value']) )$xtpl->assign("VALUE", $_REQUEST['value']);	
		}
	}
	if($style == 'popup'){
		$xtpl->parse("main.popup");
	}
	$xtpl->parse("main");
	$xtpl->out("main");

}
else{
	echo 'No Module Selected';
}	



?>