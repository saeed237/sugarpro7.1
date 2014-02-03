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


require_once('include/upload_file.php');
require_once('include/DetailView/DetailView.php');

//Old DetailView compares wrong session variable against new view.list.  Need to sync so that
//the pagination on the DetailView page will show.
if(isset($_SESSION['EMAILTEMPLATE_FROM_LIST_VIEW']))
    $_SESSION['EMAIL_TEMPLATE_FROM_LIST_VIEW'] = $_SESSION['EMAILTEMPLATE_FROM_LIST_VIEW'];

global $app_strings;
global $mod_strings;

$focus = BeanFactory::getBean('EmailTemplates');

$detailView = new DetailView();
$offset=0;
if(isset($_REQUEST['offset']) or isset($_REQUEST['record'])) {
	$result = $detailView->processSugarBean("EMAIL_TEMPLATE", $focus, $offset);
	if($result == null) {
	    sugar_die($app_strings['ERROR_NO_RECORD']);
	}
	$focus=$result;
} else {
	header("Location: index.php?module=Accounts&action=index");
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

//needed when creating a new note with default values passed in
if(isset($_REQUEST['contact_name']) && is_null($focus->contact_name)) {
	$focus->contact_name = $_REQUEST['contact_name'];
}
if(isset($_REQUEST['contact_id']) && is_null($focus->contact_id)) {
	$focus->contact_id = $_REQUEST['contact_id'];
}
if(isset($_REQUEST['opportunity_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['opportunity_name'];
}
if(isset($_REQUEST['opportunity_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['opportunity_id'];
}
if(isset($_REQUEST['account_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['account_name'];
}
if(isset($_REQUEST['account_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['account_id'];
}

$params = array();
$params[] = $focus->name;

echo getClassicModuleTitle($focus->module_dir, $params, true);


$GLOBALS['log']->info("EmailTemplate detail view");

$xtpl=new XTemplate ('modules/EmailTemplates/DetailView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$buttons = array(
    <<<EOD
            <input type="submit" class="button" id="editEmailTemplatesButton" title="{$app_strings['LBL_EDIT_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_EDIT_BUTTON_KEY']}" onclick="this.form.return_module.value='EmailTemplates'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$focus->id}'; this.form.action.value='EditView'" value="{$app_strings['LBL_EDIT_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$app_strings['LBL_DUPLICATE_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_DUPLICATE_BUTTON_KEY']}" class="button" onclick="this.form.return_module.value='EmailTemplates'; this.form.return_action.value='index'; this.form.isDuplicate.value=true; this.form.action.value='EditView'" type="submit" name="button" value="{$app_strings['LBL_DUPLICATE_BUTTON_LABEL']}">
EOD
,
    <<<EOD
            <input title="{$app_strings['LBL_DELETE_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_DELETE_BUTTON_KEY']}" class="button" onclick="check_deletable_EmailTemplate();" type="button" name="button" value="{$app_strings['LBL_DELETE_BUTTON_LABEL']}">
EOD
);
require_once('include/SugarSmarty/plugins/function.sugar_action_menu.php');
$action_button = smarty_function_sugar_action_menu(array(
    'id' => 'detail_header_action_menu',
    'buttons' => $buttons,
    'class' => 'clickMenu fancymenu',
), $xtpl);

$xtpl->assign("ACTION_BUTTON", $action_button);

if(isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if(isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if(isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("GRIDLINE", $gridline);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("CREATED_BY", $focus->created_by_name);
$xtpl->assign("MODIFIED_BY", $focus->modified_by_name);
//if text only is set to true, then make sure input is checked and value set to 1
if(isset($focus->text_only) && $focus->text_only){
    $xtpl->assign("TEXT_ONLY_CHECKED","CHECKED");
}
$xtpl->assign("NAME", $focus->name);
$xtpl->assign("DESCRIPTION", $focus->description);
$xtpl->assign("SUBJECT", $focus->subject);
$xtpl->assign("BODY", $focus->body);
$xtpl->assign("BODY_HTML", json_encode(from_html($focus->body_html)));
$xtpl->assign("DATE_MODIFIED", $focus->date_modified);
$xtpl->assign("DATE_ENTERED", $focus->date_entered);
$xtpl->assign("ASSIGNED_USER_NAME", $focus->assigned_user_name);

$xtpl->assign("TYPE", $app_list_strings['emailTemplates_type_list'][$focus->type]);

if($focus->ACLAccess('EditView')) {
	$xtpl->parse("main.edit");
	//$xtpl->out("EDIT");

}

require_once('modules/Teams/TeamSetManager.php');
$xtpl->assign('TEAM', TeamSetManager::getCommaDelimitedTeams($focus->team_set_id, $focus->team_id, true));
if(!empty($focus->body)) {
	$xtpl->assign('ALT_CHECKED', 'CHECKED');
}
else
	$xtpl->assign('ALT_CHECKED', '');
if( $focus->published == 'on')
{
$xtpl->assign("PUBLISHED","CHECKED");
}


///////////////////////////////////////////////////////////////////////////////
////	NOTES (attachements, etc.)
///////////////////////////////////////////////////////////////////////////////
$note = BeanFactory::getBean('Notes');
$where = "notes.parent_id='{$focus->id}'";
$notes_list = $note->get_full_list("notes.name", $where,true);

if(! isset($notes_list)) {
	$notes_list = array();
}

$attachments = '';
for($i=0; $i<count($notes_list); $i++) {
	$the_note = $notes_list[$i];
	$attachments .= "<a href=\"index.php?entryPoint=download&id={$the_note->id}&type=Notes\">".$the_note->name."</a><br />";
}

$xtpl->assign("ATTACHMENTS", $attachments);


global $current_user;
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])) {

	$xtpl->assign("ADMIN_EDIT","<a href='index.php?action=index&module=DynamicLayout&from_action=".$_REQUEST['action'] ."&from_module=".$_REQUEST['module'] ."&record=".$_REQUEST['record']. "'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDIT_LAYOUT'])."</a>");
}

$xtpl->assign("DESCRIPTION", $focus->description);

$detailView->processListNavigation($xtpl, "EMAIL_TEMPLATE", $offset);
// adding custom fields:
require_once('modules/DynamicFields/templates/Files/DetailView.php');


$xtpl->parse("main");

$xtpl->out("main");

?>
