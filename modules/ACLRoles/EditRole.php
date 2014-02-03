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





global $app_list_strings;// $modInvisList

$sugar_smarty = new Sugar_Smarty();

$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
//mass localization
/*foreach($modInvisList as $modinvisname){
    $app_list_strings['moduleList'][$modinvisname] = $modinvisname;
}*/
$sugar_smarty->assign('APP_LIST', $app_list_strings);
/*foreach($modInvisList as $modinvisname){
    unset($app_list_strings['moduleList'][$modinvisname]);
}*/
$role = BeanFactory::getBean('ACLRoles');
$role_name = '';
$return= array('module'=>'ACLRoles', 'action'=>'index', 'record'=>'');
if(!empty($_REQUEST['record'])){
	$role->retrieve($_REQUEST['record']);
	$categories = ACLRole::getRoleActions($_REQUEST['record']);
	
	$role_name =  $role->name;
	if(!empty($_REQUEST['isDuplicate'])){
		//role id is stripped here in duplicate so anything using role id after this will not have it
		$role->id = '';
	}else{
		$return['record']= $role->id;
		$return['action']='DetailView';
	}
	
}else{
	$categories = ACLRole::getRoleActions('');
}
$sugar_smarty->assign('ROLE', $role->toArray());
$tdwidth = 10;

if(isset($_REQUEST['return_module'])){
	$return['module']=$_REQUEST['return_module'];
	if(isset($_REQUEST['return_action']))$return['action']=$_REQUEST['return_action'];
	if(isset($_REQUEST['return_record']))$return['record']=$_REQUEST['return_record'];
}

$sugar_smarty->assign('RETURN', $return);
$names = ACLAction::setupCategoriesMatrix($categories);
if(!empty($names))$tdwidth = 100 / sizeof($names);
$sugar_smarty->assign('CATEGORIES', $categories);
$sugar_smarty->assign('CATEGORY_NAME', $_REQUEST['category_name']);
$sugar_smarty->assign('TDWIDTH', $tdwidth);
$sugar_smarty->assign('ACTION_NAMES', $names);
$actions = $categories[$_REQUEST['category_name']]['module'];
$sugar_smarty->assign('ACTIONS', $actions);
ob_clean();

if($_REQUEST['category_name'] == 'All'){
	echo $sugar_smarty->fetch('modules/ACLRoles/EditAllBody.tpl');	
}else{
//WDong Bug 23195: Strings not localized in Role Management.
echo getClassicModuleTitle($_REQUEST['category_name'],array($app_list_strings['moduleList'][$_REQUEST['category_name']]), false);
echo $sugar_smarty->fetch('modules/ACLRoles/EditRole.tpl');
require_once('modules/ACLFields/EditView.php');
echo ACLFieldsEditView::getView($_REQUEST['category_name'],  $role->id);
echo '</form>';
}
sugar_cleanup(true);