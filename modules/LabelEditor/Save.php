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

global $current_language;
$module_name = $_REQUEST['module_name'];
if(isset($_REQUEST['multi_edit'])){
	unset($_REQUEST['action']);
	unset($_REQUEST['module_name']);
	unset($_REQUEST['module']);
	$the_strings = return_module_language($current_language, $module_name);
	foreach($_REQUEST as $key=>$value){
		if(isset($the_strings[$key])){
			create_field_label($module_name, $current_language, $key, $value, true);
		}
	}
	$location = "index.php?action=LabelList&module=LabelEditor&refreshparent=1&sugar_body_only=1";
	header("Location:$location" );
}else{
	create_field_label($module_name, $current_language, $_REQUEST['record'], $_REQUEST['value'], true);
		$location = "index.php?action=". $_REQUEST['return_action']."&module=". $_REQUEST['return_module'];
	if(isset($_REQUEST['module_name'])){
		$location .= "&module_name=" . $_REQUEST['module_name'];
	}
	if(isset($_REQUEST['sugar_body_only'])){
		$location .= "&sugar_body_only=" . $_REQUEST['sugar_body_only'];
	}
	if(isset($_REQUEST['style']) && $_REQUEST['style'] == 'popup'){
		$location .= '&refreshparent=1';	
	}
	header("Location:$location" );
}


?>