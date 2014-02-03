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

$_REQUEST['edit']='true';

require_once('include/SugarFolders/SugarFolders.php');

// GLOBALS
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $sugar_config;

$ie = BeanFactory::getBean('InboundEmail');
$focus = new SugarFolder();
$javascript = new Javascript();
/* Start standard EditView setup logic */

if(isset($_REQUEST['record'])) {
	$GLOBALS['log']->debug("In EditGroupFolder view, about to retrieve record: ".$_REQUEST['record']);
	$result = $focus->retrieve($_REQUEST['record']);
    if($result == null)
    {
    	sugar_die($app_strings['ERROR_NO_RECORD']);
    }
}

$GLOBALS['log']->info("SugarFolder Edit View");
/* End standard EditView setup logic */

// TEMPLATE ASSIGNMENTS
$smarty = new Sugar_Smarty();
// standard assigns
$smarty->assign('mod_strings', $mod_strings);
$smarty->assign('app_strings', $app_strings);
$smarty->assign('theme', $theme);
$smarty->assign('sugar_version', $sugar_version);
$smarty->assign('GRIDLINE', $gridline);
$smarty->assign('MODULE', 'InboundEmail');
$smarty->assign('RETURN_MODULE', 'InboundEmail');
$smarty->assign('RETURN_ID', $focus->id);
$smarty->assign('RETURN_ACTION', "");
$smarty->assign('ID', $focus->id);
// module specific

$ret = $focus->getFoldersForSettings($current_user);
$groupFolders = Array();
$groupFoldersOrig = array();
foreach($ret['groupFolders'] as $key => $value) {
	if(!empty($focus->id)) {
		if ($value['id'] == $focus->id) {
			continue;
		}
	} // if
	$groupFolders[$value['id']] = $value['name'];
	$groupFoldersOrig[] = $value['origName'];
} // foreach
$groupFolderName = "";
$addToGroupFolder = "";
$createGroupFolderStyle = "display:''";
$editGroupFolderStyle = "display:''";
if(!empty($focus->id)) {
	$groupFolderName = 	$focus->name;
}
if(!empty($focus->id)) {
	$addToGroupFolder = $focus->parent_folder;
}
if(!empty($focus->id)) {
	$createGroupFolderStyle = "display:none;";
} else {
	$editGroupFolderStyle = "display:none;";
} // else
$smarty->assign('createGroupFolderStyle', $createGroupFolderStyle);
$smarty->assign('editGroupFolderStyle', $editGroupFolderStyle);

$smarty->assign('groupFolderName', $groupFolderName);
$json = getJSONobj();
$smarty->assign('group_folder_array', $json->encode($groupFoldersOrig));
$smarty->assign('group_folder_options', get_select_options_with_id($groupFolders, $addToGroupFolder));

$groupFolderTeamId = "";
if(!empty($focus->id)) {
	$groupFolderTeamId = $focus->team_id;
}


require_once('include/SugarFields/Fields/Teamset/EmailSugarFieldTeamsetCollection.php');
$teamSetField = new EmailSugarFieldTeamsetCollection($focus, $ie->field_defs, "get_non_private_teams_array");
//$teamSetField = new EmailSugarFieldTeamset($focus->module_dir, $focus->id);
$code = $teamSetField->get_code();
$sqs_objects = $teamSetField->createQuickSearchCode(false);

$quicksearch_js = '<script type="text/javascript" language="javascript">sqs_objects = ' . $json->encode($sqs_objects) . '</script>';
/*
require_once('include/SugarFields/Fields/Teamset/SugarFieldTeamset.php');
$teamSetField = new SugarFieldTeamset('Teamset');
$teamSetField->add_user_private_team = false;
$teamSetField->objectBean = $focus;
$teamSetField->initClassicView($ie->field_defs);
$code = $teamSetField->getClassicView();
*/
$smarty->assign('JAVASCRIPT', $quicksearch_js);
$smarty->assign("TEAM_SET_FIELD", $code);
$smarty->assign("langHeader", get_language_header());

$smarty->assign('CSS',SugarThemeRegistry::current()->getCSS());


$smarty->assign('languageStrings', getVersionedScript("cache/jsLanguage/{$GLOBALS['current_language']}.js",  $GLOBALS['sugar_config']['js_lang_version']));
echo $smarty->fetch("modules/Emails/templates/_createGroupFolder.tpl");
?>