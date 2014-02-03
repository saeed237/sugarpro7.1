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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




require_once('modules/Teams/Forms.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;

$GLOBALS['log']->info("Team edit view");

if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('Teams');

if (isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}


echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->get_summary_text()), true);

$xtpl = new XTemplate("modules/Teams/EditView.html");
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$return_id = isset($_REQUEST['return_id']) ?  $_REQUEST['return_id'] : '';
$return_module = isset($_REQUEST['return_module']) ?  $_REQUEST['return_module'] : '';
$return_action= isset($_REQUEST['return_action']) ?  $_REQUEST['return_action'] : '';
    if (empty($return_id)) {
        $return_action = 'index';
    }
if (isset($_REQUEST['error_string'])) $xtpl->assign("ERROR_STRING", "<span class='error'>Error: ".$_REQUEST['error_string']."</span>");
$xtpl->assign("RETURN_MODULE",$return_module);
$xtpl->assign("RETURN_ID", $return_id);
$xtpl->assign("RETURN_ACTION", $return_action);

if (isset($_REQUEST['isDuplicate'])) $xtpl->assign("IS_DUPLICATE", $_REQUEST['isDuplicate']);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("NAME", Team::getDisplayName($focus->name, $focus->name_2));
$xtpl->assign("DESCRIPTION", $focus->description);

global $current_user;
if($current_user->isAdminForModule('Users') && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){
	$record = '';
	if(!empty($_REQUEST['record'])){
		$record = 	$_REQUEST['record'];
	}
	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$record. "'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>");
}


$javascript = new javascript();
$javascript->setFormName("EditView");

$javascript->addFieldGeneric("name", "varchar", $mod_strings['LBL_NAME'], TRUE, "");


$xtpl->parse("main");
$xtpl->out("main");



echo $javascript->getScript();
?>