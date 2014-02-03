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

 ********************************************************************************/
if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);

$_REQUEST['edit']='true';
//include ("modules/TeamNotices/index.php");



$focus = BeanFactory::getBean('TeamNotices');
if(!empty($_REQUEST['record'])) $focus->retrieve($_REQUEST['record']);

$GLOBALS['log']->info("Team Notice edit view");

$params = array();
$params[] = "<a href='index.php?action=index&module=TeamNotices'>{$mod_strings['LBL_MODULE_NAME']}</a>";
if ( empty($focus->id) )
    $params[] = $GLOBALS['app_strings']['LBL_CREATE_BUTTON_LABEL'];
else {
    $params[] = $focus->name;
    $params[] = $GLOBALS['app_strings']['LBL_EDIT_BUTTON_LABEL'];
}
echo getClassicModuleTitle('TeamNotices', $params, true);

$xtpl=new XTemplate ('modules/TeamNotices/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("THEME", SugarThemeRegistry::current()->__toString());
//$xtpl->assign("IMAGE_PATH", $image_path);
$xtpl->assign("JAVASCRIPT", get_set_focus_js());
$xtpl->assign("ID", $focus->id);
$xtpl->assign('NAME', $focus->name);
$xtpl->assign('URL', $focus->url);
$xtpl->assign('URL_TITLE', $focus->url_title);
$xtpl->assign('NAME', $focus->name);
$xtpl->assign('DESCRIPTION', $focus->description);

$buttons = array(
    '<input id="btn_teamnotices_save" title="' . $app_strings['LBL_SAVE_BUTTON_TITLE'] . '" accessKey="'. $app_strings['LBL_SAVE_BUTTON_KEY'] . '" class="button primary" onclick="this.form.action.value=\'Save\'; return check_form(\'EditView\');" type="submit" name="button" value="'.$app_strings['LBL_SAVE_BUTTON_LABEL'].'">',
    '<input id="btn_teamnotices_cancel" title="' . $app_strings['LBL_CANCEL_BUTTON_TITLE']. '" accessKey="'. $app_strings['LBL_CANCEL_BUTTON_KEY'] . '" onclick="this.form.action.value=\'index\';" class="button" type="submit" name="button" value="'.$app_strings['LBL_CANCEL_BUTTON_LABEL'].'">'
);

require_once('include/SugarSmarty/plugins/function.sugar_action_menu.php');
$action_button = smarty_function_sugar_action_menu(array(
    'id' => 'teamnotices_editview_buttons',
    'buttons' => $buttons,
    'flat' => true,
), $xtpl);

$xtpl->assign('ACTION_BUTTON', $action_button);

require_once('include/SugarFields/Fields/Teamset/SugarFieldTeamset.php');
$teamSetField = new SugarFieldTeamset('Teamset');
$code = $teamSetField->getClassicView($focus->field_defs);
$xtpl->assign("TEAM_SET_FIELD", $code);

if(!isset($focus->date_start)) {
		$xtpl->assign('DATE_START', $timedate->nowDate());
	} else $xtpl->assign('DATE_START', $focus->date_start);
if(!isset($focus->date_start)) {
		$xtpl->assign('DATE_END', $timedate->asUser($timedate->getNow()->get('+1 week')));
	} else $xtpl->assign('DATE_END', $focus->date_end);
$xtpl->assign("CALENDAR_DATEFORMAT", $timedate->get_cal_date_format());
$xtpl->assign("STATUS_OPTIONS", get_select_options_with_id($mod_strings['dom_status'], $focus->status));
$xtpl->parse("main.pro");
$xtpl->parse("main");
$xtpl->out("main");


$javascript = new javascript();
$javascript->setFormName('EditView');
$javascript->setSugarBean($focus);
$javascript->addAllFields('');
$javascript->addFieldGeneric('team_name', 'varchar', $app_strings['LBL_TEAM'] ,'true');
$javascript->addToValidateBinaryDependency('team_name', 'alpha', $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_TEAM'], 'false', '', 'team_id');
echo $javascript->getScript();
?>
